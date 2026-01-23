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

          // Clear form and reset
          $('#ukPollsForm')[0].reset();
          $('#otpRow').slideUp();
          $('#otpTimerContainer').slideUp();
          $('#otp').val('');

          // Reset flags
          isOtpSent = false;
          isFormSubmitting = false;
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

  // Start OTP Timer
  function startOtpTimer() {
    var duration = 60; // 1 minute in seconds

    clearInterval(otpTimerInterval);

    otpTimerInterval = setInterval(function () {
      var minutes = Math.floor(duration / 60);
      var seconds = duration % 60;

      $('#otpTimer').text('OTP expires in: ' + seconds + ' seconds');

      if (duration <= 0) {
        clearInterval(otpTimerInterval);
        $('#otpTimer').text('OTP has expired. Please refresh and try again.');
        $('#verifyBtn').prop('disabled', true);
      }

      duration--;
    }, 1000);
  }

  // Show Message Function
  function showMessage(message, type) {
    var html =
      '<div class="' +
      (type === 'success' ? 'success-message' : 'error-message') +
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
});
