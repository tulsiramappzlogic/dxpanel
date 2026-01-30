// Mobile menu toggle
$(document).ready(function () {
  $('#authMenuToggle').on('click', function (e) {
    e.preventDefault();
    $('#authMenuDropdown').slideToggle(300);
  });

  // Close menu when clicking on a link
  $('#authMenuDropdown a').on('click', function () {
    $('#authMenuDropdown').slideUp(300);
  });

  // Close menu when clicking outside
  $(document).on('click', function (e) {
    if (!$(e.target).closest('#authMenuToggle, #authMenuDropdown').length) {
      $('#authMenuDropdown').slideUp(300);
    }
  });

  let otpTimerInterval;
  let isOtpSent = false;
  let isFormSubmitting = false;

  // Full Name Validation - Min 3 characters
  function validateFullName() {
    var fullName = $('#full_name').val().trim();
    var minLength = 3;

    if (fullName.length >= minLength) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (fullName.length > 0) {
        showMessage(
          'Full name must be at least ' + minLength + ' characters long.',
          'error',
        );
      }
      return false;
    }
  }

  // Make validateFullName globally available
  window.validateFullName = validateFullName;

  // Email Validation
  function validateEmail() {
    var email = $('#email').val().trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailPattern.test(email)) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (email.length > 0) {
        showMessage('Please enter a valid email address.', 'error');
      }
      return false;
    }
  }

  // Make validateEmail globally available
  window.validateEmail = validateEmail;

  // City Validation - Min 3 characters
  function validateCity() {
    var city = $('#city').val().trim();
    var minLength = 3;

    if (city.length >= minLength) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (city.length > 0) {
        showMessage(
          'City must be at least ' + minLength + ' characters long.',
          'error',
        );
      }
      return false;
    }
  }

  // Make validateCity globally available
  window.validateCity = validateCity;

  // Address Validation - Min 15 characters
  function validateAddress() {
    var address = $('#address').val().trim();
    var minLength = 5;

    if (address.length >= minLength) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (address.length > 0) {
        showMessage(
          'Address must be at least ' + minLength + ' characters long.',
          'error',
        );
      }
      return false;
    }
  }

  // Make validateAddress globally available
  window.validateAddress = validateAddress;

  // Malaysia Postcode Validation - Exactly 5 digits
  function validatePostcode() {
    var postcode = $('#postcode').val().trim();
    // Malaysia postcodes are exactly 5 digits
    var postcodeRegex = /^[0-9]{5}$/;

    if (postcodeRegex.test(postcode)) {
      // Valid - trigger checkFormCompletion
      checkFormCompletion();
      return true;
    } else {
      // Show error message if user has started typing
      if (postcode.length > 0) {
        showMessage(
          'Malaysia postcode must be exactly 5 digits (e.g., 50000).',
          'error',
        );
      }
      return false;
    }
  }

  // Make validatePostcode globally available
  window.validatePostcode = validatePostcode;

  // Check if all form fields are filled and valid
  function checkFormCompletion() {
    if (isOtpSent || isFormSubmitting) return;

    var full_name = $('#full_name').val().trim();
    var email = $('#email').val().trim();
    var date_of_birth = $('#date_of_birth').val();
    var gender = $('#gender').val();
    var address = $('#address').val().trim();
    var city = $('#city').val().trim();
    var country = $('#country').val().trim();
    var postcode = $('#postcode').val().trim();
    $('#messageContainer').html('');
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
      if (!emailPattern.test(email)) {
        showMessage('Please enter a valid email address.', 'error');
        return;
      }
      // Auto-send OTP
      sendOTP();
    }
  }

  // Send OTP function
  function sendOTP() {
    isFormSubmitting = true;

    // Show loading indicator
    $('#autoSendIndicator').fadeIn();

    // Make AJAX request to send OTP
    $.ajax({
      url: 'otp_verify.php',
      type: 'POST',
      data: {
        action: 'send_otp',
        full_name: $('#full_name').val(),
        email: $('#email').val(),
        date_of_birth: $('#date_of_birth').val(),
        gender: $('#gender').val(),
        address: $('#address').val(),
        city: $('#city').val(),
        country: $('#country').val(),
        postcode: $('#postcode').val(),
      },
      dataType: 'json',
      success: function (response) {
        $('#autoSendIndicator').fadeOut();
        showMessage(response.message, response.success ? 'success' : 'error');

        if (response.success) {
          isOtpSent = true;
          // Show OTP input row
          $('#otpRow').slideDown();

          // Focus on OTP input
          $('#otp').focus();

          // Show timer
          $('#otpTimerContainer').slideDown();

          // Start OTP timer
          startOtpTimer();
        } else {
          isFormSubmitting = false;
        }
      },
      error: function (xhr, status, error) {
        $('#autoSendIndicator').fadeOut();
        showMessage('An error occurred. Please try again.', 'error');
        console.error('AJAX Error:', status, error);
        isFormSubmitting = false;
      },
    });
  }

  // Verify OTP Button Click
  $('#verifyBtn').on('click', function () {
    var otp = $('#otp').val();
    var email = $('#email').val();

    if (!otp || otp.length !== 6) {
      showMessage('Please enter the 6-digit OTP sent to your email.', 'error');
      return;
    }

    // Disable button and show loading
    $('#verifyBtn')
      .prop('disabled', true)
      .html(
        '<span class="spinner-border spinner-border-sm"></span> Verifying...',
      );

    // Make AJAX request to verify OTP
    $.ajax({
      url: 'otp_verify.php',
      type: 'POST',
      data: {
        action: 'verify_otp',
        otp: otp,
        email: email,
      },
      dataType: 'json',
      success: function (response) {
        showMessage(response.message, response.success ? 'success' : 'error');

        if (response.success) {
          // Stop timer
          clearInterval(otpTimerInterval);

          // Hide resend button
          $('#resendBtn').hide();
          $('#verifyBtn').show();

          // Clear form and reset
          $('#myPollsForm')[0].reset();
          // $('#otpRow').slideUp();
          $('#otpTimerContainer').slideUp();
          $('#otp').val('');

          // Reset flags
          isOtpSent = false;
          isFormSubmitting = false;
        } else if (response.message.indexOf('expired') !== -1) {
          // OTP has expired, show resend button
          $('#verifyBtn').hide();
          $('#resendBtn').show();
        }
      },
      error: function (xhr, status, error) {
        showMessage('An error occurred. Please try again.', 'error');
        console.error('AJAX Error:', status, error);
      },
      complete: function () {
        $('#verifyBtn').prop('disabled', false).text('Submit');
      },
    });
  });

  // Resend OTP Button Click
  $('#resendBtn').on('click', function () {
    var email = $('#email').val();

    if (!email) {
      showMessage('Email not found. Please refresh and try again.', 'error');
      return;
    }

    // Disable button and show loading
    $('#resendBtn')
      .prop('disabled', true)
      .html(
        '<span class="spinner-border spinner-border-sm"></span> Sending...',
      );

    // Make AJAX request to resend OTP
    $.ajax({
      url: 'otp_verify.php',
      type: 'POST',
      data: {
        action: 'resend_otp',
        email: email,
      },
      dataType: 'json',
      success: function (response) {
        showMessage(response.message, response.success ? 'success' : 'error');

        if (response.success) {
          // OTP resent successfully
          $('#otp').val(''); // Clear OTP input
          $('#otp').focus();

          // Hide resend button, show verify button
          $('#resendBtn').hide();
          $('#verifyBtn').show();

          // Restart timer
          startOtpTimer();

          // Hide any previous expiry message
          $('#otpTimer').removeClass('text-danger').addClass('text-muted');
        }
      },
      error: function (xhr, status, error) {
        showMessage('An error occurred. Please try again.', 'error');
        console.error('AJAX Error:', status, error);
      },
      complete: function () {
        $('#resendBtn').prop('disabled', false).text('Resend OTP');
      },
    });
  });

  // Start OTP Timer
  function startOtpTimer() {
    var duration = 30; // 30 seconds

    clearInterval(otpTimerInterval);

    otpTimerInterval = setInterval(function () {
      var minutes = Math.floor(duration / 60);
      var seconds = duration % 60;

      $('#otpTimer').text('OTP expires in: ' + seconds + ' seconds');

      if (duration <= 0) {
        clearInterval(otpTimerInterval);
        $('#otpTimer').text('OTP has expired. Please click Resend OTP to get a new one.');
        $('#otpTimer').addClass('text-danger');
        
        // Disable verify button and show resend button
        $('#verifyBtn').hide();
        $('#resendBtn').show();
        $('#resendBtn').prop('disabled', false);
      }

      duration--;
    }, 1000);
  }

  // Show Message Function
  function showMessage(message, type) {
    var html =
      '<div class="' +
      (type === 'success'
        ? 'success-message alert alert-success m-2 p-2'
        : 'error-message alert alert-danger m-2 p-2') +
      '">' +
      message +
      '</div>';
    $('#messageContainer').html(html);

    // Auto-hide after 5 seconds for success messages
    if (type === 'success') {
      setTimeout(function () {
        $('#messageContainer').fadeOut(function () {
          $(this).empty().show();
        });
      }, 5000);
    }
  }

  // Make checkFormCompletion globally available
  window.checkFormCompletion = checkFormCompletion;

  // Age Validation Function (16 years and above)
  function validateAge() {
    var dobInput = $('#date_of_birth');
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
      showMessage('You must be 16 years or older to register.', 'error');
      dobInput.val(''); // Clear invalid date
      return false;
    }

    // Clear any previous error messages when valid age is entered
    $('#messageContainer').empty();
    return true;
  }

  // Make validateAge globally available
  window.validateAge = validateAge;

  // Trigger validateAge when date of birth changes
  $('#date_of_birth').on('change', function () {
    validateAge();
  });

  // Postcode input handler - triggers lookup when 5 characters entered
  function onPostcodeInput() {
    var postcode = $('#postcode').val().trim();

    // Malaysian postcodes are exactly 5 digits
    // Trigger lookup when 5 characters entered
    if (postcode.length === 5) {
      lookupPostcode(postcode);
    }
  }

  // Make onPostcodeInput globally available
  window.onPostcodeInput = onPostcodeInput;

  // Trigger onPostcodeInput when postcode changes
  $('#postcode').on('input', function () {
    onPostcodeInput();
  });

  // Malaysia Postcode Validation Function
  function validateMalaysiaPostcode() {
    var postcode = $('#postcode').val().trim();
    var postcodeHint = $('#postcodeHint');

    // Malaysia postcode regex - must be exactly 5 digits
    var malaysiaPostcodeRegex = /^[0-9]{5}$/;

    if (postcode.length > 0) {
      if (malaysiaPostcodeRegex.test(postcode)) {
        if (postcodeHint.length) {
          postcodeHint
            .removeClass('text-danger')
            .addClass('text-success')
            .text('✓ Valid Malaysia postcode format');
        }
        return true;
      } else {
        if (postcodeHint.length) {
          postcodeHint
            .removeClass('text-success')
            .addClass('text-danger')
            .text('✗ Invalid Malaysia postcode format (must be 5 digits)');
        }
        return false;
      }
    } else {
      if (postcodeHint.length) {
        postcodeHint
          .removeClass('text-success text-danger')
          .addClass('text-muted')
          .text('Format: 5 digits (e.g., 50000)');
      }
      return false;
    }
  }

  // Make validateMalaysiaPostcode globally available
  window.validateMalaysiaPostcode = validateMalaysiaPostcode;

  // Malaysia Postcode Lookup Function
  // Uses local postcode database via get_city_by_postcode.php
  function lookupPostcode(postcode) {
    var cityInput = $('#city');
    var stateInput = $('#province');

    // Clear city and state when postcode changes
    cityInput.val('');
    stateInput.val('');

    // Make API call to lookup postcode
    $.ajax({
      url: 'get_city_by_postcode.php',
      type: 'GET',
      data: {
        postcode: postcode,
      },
      dataType: 'json',
      success: function (response) {
        if (response.success && response.city) {
          // Auto-fill city from response
          cityInput.val(response.city).trigger('change');

          // Auto-fill state from response if available
          if (response.state) {
            stateInput.val(response.state).trigger('change');
          }

          // Trigger checkFormCompletion after filling fields
          setTimeout(function () {
            checkFormCompletion();
          }, 100);
        } else {
          // Postcode not found in database - show message to user
          showMessage(
            'City not found in our record, you need to add it manually',
            'error'
          );
        }
      },
      error: function (xhr, status, error) {
        // API call failed - user can still proceed manually
        console.log(
          'Postcode lookup unavailable. Please enter city and state manually.',
        );
      },
    });
  }
});