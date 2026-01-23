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

  // UK Postcode Validation - Min 5 characters
  function validatePostcode() {
    var postcode = $("#postcode").val().trim();
    var postcodeHint = $("#postcodeHint");
    var minLength = 5;

    if (postcode.length >= minLength) {
      // Also validate UK postcode format
      var ukPostcodeRegex = /^(?:[A-Z]{1,2}[0-9][0-9A-Z]?)[ ]?[0-9][A-Z]{2}$/i;

      if (ukPostcodeRegex.test(postcode)) {
        if (postcodeHint.length) {
          postcodeHint
            .removeClass("text-danger")
            .addClass("text-success")
            .text("✓ Valid UK postcode format");
        }
        // Valid - trigger checkFormCompletion
        checkFormCompletion();
        return true;
      } else {
        if (postcodeHint.length) {
          postcodeHint
            .removeClass("text-success")
            .addClass("text-danger")
            .text("✗ Invalid UK postcode format");
        }
        if (postcode.length > 0) {
          showMessage(
            "Please enter a valid UK postcode format (e.g., EH1 1AA).",
            "error",
          );
        }
        return false;
      }
    } else {
      if (postcodeHint.length) {
        postcodeHint
          .removeClass("text-success text-danger")
          .addClass("text-muted")
          .text("Format: AA9A 9AA, A9 9AA, A99 9AA, etc. (min 5 characters)");
      }
      return false;
    }
  }

  // Make validatePostcode globally available
  window.validatePostcode = validatePostcode;

  // Check if all form fields are filled and valid
  function checkFormCompletion() {
    if (isOtpSent || isFormSubmitting) return;

    var full_name = $("#full_name").val().trim();
    var email = $("#email").val().trim();
    var date_of_birth = $("#date_of_birth").val();
    var gender = $("#gender").val();
    var address = $("#address").val().trim();
    var city = $("#city").val().trim();
    var country = $("#country").val().trim();
    var postcode = $("#postcode").val().trim();

    // Validate full name (min 3 characters)
    if (full_name.length < 3) {
      return;
    }

    // Validate address (min 15 characters)
    if (address.length < 15) {
      return;
    }

    // Validate city (min 3 characters)
    if (city.length < 3) {
      return;
    }

    if (postcode.length < 5) {
      return;
    }

    // Check all fields are filled
    var allFilled =
      full_name &&
      email &&
      date_of_birth &&
      gender &&
      address &&
      city &&
      country &&
      postcode;

    if (allFilled) {
      // Validate email format
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailPattern.test(email)) {
        // Auto-send OTP
        sendOTP();
      }
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
        city: $("#city").val(),
        country: $("#country").val(),
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
          $("#ukPollsForm")[0].reset();
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
      }, 5000);
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

  // Postcode input handler - triggers lookup when 6-7 characters entered
  function onPostcodeInput() {
    var postcode = $("#postcode").val().trim();

    // UK postcodes are typically 5-8 characters (with spaces)
    // Format: AN NAA, ANN NAA, AAN NAA, AANN NAA, ANA NAA, AANA NAA
    var postcodeClean = postcode.replace(/\s+/g, "");

    if (postcodeClean.length >= 5 && postcodeClean.length <= 8) {
      lookupPostcode(postcodeClean);
    }
  }

  // Make onPostcodeInput globally available
  window.onPostcodeInput = onPostcodeInput;

  // UK Postcode Validation Function
  function validateUKPostcode() {
    var postcode = $("#postcode").val().trim();
    var postcodeHint = $("#postcodeHint");

    // UK Postcode regex patterns
    // Outward code: 1 or 2 letters + 1 or 2 digits
    // Inward code: 1 digit + 2 letters
    var ukPostcodeRegex = /^(?:[A-Z]{1,2}[0-9][0-9A-Z]?)[ ]?[0-9][A-Z]{2}$/i;

    if (postcode.length > 0) {
      if (ukPostcodeRegex.test(postcode)) {
        postcodeHint
          .removeClass("text-danger")
          .addClass("text-success")
          .text("✓ Valid UK postcode format");
        return true;
      } else {
        postcodeHint
          .removeClass("text-success")
          .addClass("text-danger")
          .text("✗ Invalid UK postcode format");
        return false;
      }
    } else {
      postcodeHint
        .removeClass("text-success text-danger")
        .addClass("text-muted")
        .text("Format: AA9A 9AA, A9 9AA, A99 9AA, etc.");
      return false;
    }
  }

  // Make validateUKPostcode globally available
  window.validateUKPostcode = validateUKPostcode;

  // UK Postcode Lookup Function using postcodes.io API
  function lookupPostcode(postcode) {
    var postcodeInput = $("#postcode");
    var cityInput = $("#city");

    // Clear city when postcode changes
    cityInput.val("");

    // Make API call to postcodes.io
    $.ajax({
      url: "https://api.postcodes.io/postcodes/" + postcode,
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === 200 && response.result) {
          var result = response.result;

          // Auto-fill city/town from API response
          if (result.admin_district || result.postcode_town) {
            var cityValue = result.admin_district || result.postcode_town;
            cityInput.val(cityValue);

            // Trigger checkFormCompletion after filling city
            setTimeout(function () {
              checkFormCompletion();
            }, 100);
          }
        } else {
          // API returned error - user can still proceed manually
          console.log(
            "Postcode not found in API. Please enter city/town manually.",
          );
        }
      },
      error: function (xhr, status, error) {
        // API call failed - user can still proceed manually
        console.log(
          "Postcode lookup API unavailable. Please enter city/town manually.",
        );
      },
    });
  }
});
