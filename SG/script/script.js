// Mobile menu toggle
$(document).ready(function () {
  $("#authMenuToggle").on("click", function (e) {
    e.preventDefault();
    $("#authMenuDropdown").slideToggle(300);
  });

  // Close menu when clicking on a link
  $("#authMenuDropdown a").on("click", function () {
    $("#authMenuDropdown").slideUp(300);
  });

  // Close menu when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#authMenuToggle, #authMenuDropdown").length) {
      $("#authMenuDropdown").slideUp(300);
    }
  });

  let otpTimerInterval;
  let isOtpSent = false;
  let isFormSubmitting = false;

  // Full Name Validation - Min 3 characters
  function validateFullName() {
    var fullName = $("#full_name").val().trim();
    var minLength = 3;

    if (fullName.length >= minLength) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (fullName.length > 0) {
        showMessage(
          "Full name must be at least " + minLength + " characters long.",
          "error",
        );
      }
      return false;
    }
  }

  // Make validateFullName globally available
  window.validateFullName = validateFullName;

  // Address Validation - Min 15 characters
  function validateAddress() {
    var address = $("#address").val().trim();
    var minLength = 15;

    if (address.length >= minLength) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (address.length > 0) {
        showMessage(
          "Address must be at least " + minLength + " characters long.",
          "error",
        );
      }
      return false;
    }
  }

  // Make validateAddress globally available
  window.validateAddress = validateAddress;

  // Validate Postal Code (6 digits only) and trigger checkFormCompletion
  function validatePostcode() {
    var postcodeInput = $("#postcode");
    var postcodeValue = postcodeInput.val().trim();

    if (!postcodeValue) return true;

    // Check if postal code is exactly 6 digits
    var postcodePattern = /^\d{6}$/;

    if (!postcodePattern.test(postcodeValue)) {
      if (postcodeValue.length > 0) {
        showMessage("Singapore postcode must be exactly 6 digits.", "error");
      }
      return false;
    }

    // Valid - trigger checkFormCompletion
    checkFormCompletion();
    return true;
  }

  // Make validatePostcode globally available
  window.validatePostcode = validatePostcode;

  // Trigger validatePostcode when postcode changes
  $("#postcode").on("input", function () {
    // Remove non-digit characters
    var value = $(this).val().replace(/\D/g, "");

    // Limit to 6 digits
    if (value.length > 6) {
      value = value.substring(0, 6);
    }

    $(this).val(value);

    // Validate if 6 digits entered
    if (value.length === 6) {
      validatePostalCode();
    }
  });

  // Check if all form fields are filled and valid
  function checkFormCompletion() {
    if (isOtpSent || isFormSubmitting) return;

    var full_name = $("#full_name").val().trim();
    var email = $("#email").val().trim();
    var date_of_birth = $("#date_of_birth").val();
    var gender = $("#gender").val();
    var address = $("#address").val().trim();
    var postcode = $("#postcode").val().trim();
    $("#messageContainer").html("");
    // Validate full name (min 3 characters)
    if (full_name.length < 3) {
      return;
    }

    if (postcode.length < 6) {
      return;
    }

    // Validate address (min 15 characters)
    if (address.length < 15) {
      return;
    }

    // Check all fields are filled
    var allFilled =
      full_name && email && date_of_birth && gender && address && postcode;

    if (allFilled) {
      // Validate email format
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        showMessage("Please enter a valid email address.", "error");
        return;
      }

      // Validate postal code (6 digits)
      if (!validatePostcode()) {
        return;
      }

      // Validate age (16+)
      if (!validateAge()) {
        return;
      }

      // All validations passed - auto-send OTP
      sendOTP();
    }
  }

  // Send OTP function
  function sendOTP() {
    isFormSubmitting = true;

    // Show loading indicator
    $("#autoSendIndicator").fadeIn();

    // Make AJAX request to send OTP
    $.ajax({
      url: "otp_verify.php",
      type: "POST",
      data: {
        action: "send_otp",
        full_name: $("#full_name").val(),
        email: $("#email").val(),
        date_of_birth: $("#date_of_birth").val(),
        gender: $("#gender").val(),
        address: $("#address").val(),
        postcode: $("#postcode").val(),
      },
      dataType: "json",
      success: function (response) {
        $("#autoSendIndicator").fadeOut();
        showMessage(response.message, response.success ? "success" : "error");

        if (response.success) {
          isOtpSent = true;
          // Show OTP input row
          $("#otpRow").slideDown();

          // Focus on OTP input
          $("#otp").focus();

          // Show timer
          $("#otpTimerContainer").slideDown();

          // Start OTP timer
          startOtpTimer();
        } else {
          isFormSubmitting = false;
        }
      },
      error: function (xhr, status, error) {
        $("#autoSendIndicator").fadeOut();
        showMessage("An error occurred. Please try again.", "error");
        console.error("AJAX Error:", status, error);
        isFormSubmitting = false;
      },
    });
  }

  // Verify OTP Button Click
  $("#verifyBtn").on("click", function () {
    var otp = $("#otp").val();
    var email = $("#email").val();

    if (!otp || otp.length !== 6) {
      showMessage("Please enter the 6-digit OTP sent to your email.", "error");
      return;
    }

    // Disable button and show loading
    $("#verifyBtn")
      .prop("disabled", true)
      .html(
        '<span class="spinner-border spinner-border-sm"></span> Verifying...',
      );

    // Make AJAX request to verify OTP
    $.ajax({
      url: "otp_verify.php",
      type: "POST",
      data: {
        action: "verify_otp",
        otp: otp,
        email: email,
      },
      dataType: "json",
      success: function (response) {
        showMessage(response.message, response.success ? "success" : "error");

        if (response.success) {
          // Stop timer
          clearInterval(otpTimerInterval);

          // Clear form and reset
          $("#sgPollsForm")[0].reset();
          // $('#otpRow').slideUp();
          $("#otpTimerContainer").slideUp();
          $("#otp").val("");

          // Reset flags
          isOtpSent = false;
          isFormSubmitting = false;
        }
      },
      error: function (xhr, status, error) {
        showMessage("An error occurred. Please try again.", "error");
        console.error("AJAX Error:", status, error);
      },
      complete: function () {
        $("#verifyBtn").prop("disabled", false).text("Submit");
      },
    });
  });

  // Start OTP Timer
  function startOtpTimer() {
    var duration = 60; // 1 minute in seconds

    clearInterval(otpTimerInterval);

    otpTimerInterval = setInterval(function () {
      var minutes = Math.floor(duration / 60);
      var seconds = duration % 60;

      $("#otpTimer").text("OTP expires in: " + seconds + " seconds");

      if (duration <= 0) {
        clearInterval(otpTimerInterval);
        $("#otpTimer").text("OTP has expired. Please refresh and try again.");
        $("#verifyBtn").prop("disabled", true);
      }

      duration--;
    }, 1000);
  }

  // Show Message Function
  function showMessage(message, type) {
    var html =
      '<div class="' +
      (type === "success"
        ? "success-message alert alert-success m-2 p-2"
        : "error-message alert alert-danger m-2 p-2") +
      '">' +
      message +
      "</div>";
    $("#messageContainer").html(html);

    // Auto-hide after 5 seconds for success messages
    if (type === "success") {
      setTimeout(function () {
        $("#messageContainer").fadeOut(function () {
          $(this).empty().show();
        });
      }, 9000);
    }
  }

  // Make checkFormCompletion globally available
  window.checkFormCompletion = checkFormCompletion;

  // Age Validation Function (16 years and above)
  function validateAge() {
    var dobInput = $("#date_of_birth");
    var dobValue = dobInput.val();

    if (!dobValue) return true;

    var dob = new Date(dobValue);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    var monthDiff = today.getMonth() - dob.getMonth();

    // Adjust age if birthday hasn't occurred yet this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
      age--;
    }

    // Check if under 16
    if (age < 16) {
      showMessage("You must be 16 years or older to register.", "error");
      dobInput.val(""); // Clear invalid date
      return false;
    }

    // Clear any previous error messages when valid age is entered
    $("#messageContainer").empty();
    return true;
  }

  // Make validateAge globally available
  window.validateAge = validateAge;

  // Trigger validateAge when date of birth changes
  $("#date_of_birth").on("change", function () {
    validateAge();
  });
});
