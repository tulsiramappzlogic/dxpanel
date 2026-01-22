<?php

/**
 * UK Polls Registration Form with OTP Verification
 * Frontend form that submits to otp_verify.php for processing
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SG - Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Expletus+Sans:ital,wght@0,400..700;1,400..700&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./style/commonStyle.css" />
  <style>
    :root {
      --uk-blue: #2c366a;
      --uk-red: #d62128;
    }

    body {
      font-family: 'Arial', sans-serif;
      background-color: #fff;
    }

    /* Header Styling */
    .navbar-brand img {
      height: 50px;
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #ed2436;
      margin-right: 10px;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .social-icons a:hover {
      background-color: #ed2436;
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(214, 33, 40, 0.3);
    }

    .social-icons i {
      font-size: 22px;
      color: white;
    }

    /* .btn-auth {
        border-radius: 20px;
        padding: 2px 20px;
        border: 1px solid #ccc;
        font-size: 0.9rem;
        color: #555;
        text-decoration: none;
      } */

    /* Updated Auth Button Styling */
    .btn-auth {
      display: inline-flex;
      align-items: center;
      border-radius: 50px;
      /* Makes it pill-shaped */
      padding: 2px 5px 2px 20px;
      /* Extra padding on the left for text */
      border: 1px solid rgba(88, 89, 91, 1);
      font-size: 1rem;
      font-weight: 500;
      color: #555;
      text-decoration: none;
      background-color: #fff;
      transition: all 0.3s ease;
      font-family: 'Mulish', sans-serif;
      font-optical-sizing: auto;
      font-style: normal;
    }

    .btn-auth:hover {
      background-color: #f0f0f0;
      color: #333;
    }

    /* The circular background for the chevron */
    .icon-circle {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      margin-left: 10px;
      /* Space between text and icon */
      color: white;
      font-size: 15px;
    }

    .icon-circle i {
      font-size: 12px;
    }

    .bg-uk-blue {
      background-color: var(--uk-blue);
    }

    .bg-uk-red {
      background-color: var(--uk-red);
    }

    /* Image Grid Styling */
    .photo-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .photo-grid .box {
      aspect-ratio: 1 / 1;
      border-radius: 15px;
      overflow: hidden;
      background-color: #eee;
    }

    .box.blue {
      background-color: var(--uk-blue);
    }

    .box.red {
      background-color: var(--uk-red);
    }

    .box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Form Styling */
    .hero-text h1 {
      font-size: 4rem;
      font-weight: bold;
      /* color: var(--uk-blue); */
      line-height: 1;
    }

    .form-control {
      border-radius: 20px;
      border: 1px solid #000;
      color: #dc3545;
    }

    .form-control::placeholder {
      color: #dc3545;
      opacity: 0.6;
    }

    .otp-section {
      background: #fff;
      padding: 10px;
      border-radius: 10px;
    }

    .btn-submit {
      background-color: rgba(210, 29, 44, 1);
      color: #fff;
      border-radius: 20px;
      padding: 5px 30px;
    }

    .btn-submit:hover {
      background-color: #fff;
      color: rgba(210, 29, 44, 1);
      border: 1px solid rgba(210, 29, 44, 1);
    }
  </style>
</head>

<body>
  <header class="bg-white border-bottom py-3 box-shadow-1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col text-start">
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col text-center">
          <img
            src="./image/SingaporePolls Logo.png"
            alt="UKPolls Logo"
            class="brand-logo" />
        </div>
        <div class="col text-end">
          <div class="auth-buttons d-flex justify-content-end">
            <div class="auth-buttons d-flex align-items-center">
              <a href="#" class="btn-auth me-3">
                Login
                <span class="icon-circle bg-uk-red">
                  <i class="fas fa-angle-double-right"></i>
                </span>
              </a>

              <a href="#" class="btn-auth">
                Sign Up
                <span class="icon-circle bg-uk-red">
                  <i class="fas fa-angle-double-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center">
        <h2 class="mb-0 fw-bold"></h2>
      </div>
    </div>
  </header>

  <main class="my-5 mx-5">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <div class="photo-grid">
            <div class="box red"></div>
            <div class="box"><img src="./image/1.png" alt="Worker" /></div>
            <div class="box"><img src="./image/2.png" alt="Doctor" /></div>
            <div class="box"><img src="./image/3.png" alt="Delivery" /></div>
            <div class="box"></div>
            <div class="box"><img src="./image/4.png" alt="Professional" /></div>
            <div class="box"><img src="./image/5.png" alt="Couple" /></div>
            <div class="box"><img src="./image/6.png" alt="Student" /></div>
            <div class="box red"></div>
          </div>
        </div>

        <div class="col-lg-7 ps-lg-4">
          <div class="hero-text mb-4">
            <h1>
              <span class="font-family-expletus color-red-1 fw-400">Hello</span><br /><span
                class="font-family-expletus color-black fw-400 d-flex align-items-center gap-3">Singapore<img width="40px" src="./image/icons/curveIcon.png" /></span>
            </h1>
            <p class="lead fw-normal font-family-mulish">
              Welcome to Singapore's newest, coolest<br />
              and most rewarding community!
            </p>
          </div>

          <!-- Message Display -->
          <div id="messageContainer"></div>

          <form id="ukPollsForm">
            <!-- Form Fields Section -->
            <div class="form-section" id="formSection">
              <div class="row g-3">
                <div class="col-md-4">
                  <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name"
                    pattern="[a-zA-Z\s]+"
                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); checkFormCompletion();" required />
                </div>
                <div class="col-md-4">
                  <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                    oninput="checkFormCompletion();" required />
                </div>
                <div class="col-md-4">
                  <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                    placeholder="Date Of Birth" onchange="checkFormCompletion();" required />
                </div>
                <div class="col-md-4">
                  <select class="form-control" name="gender" id="gender" onchange="checkFormCompletion();" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <textarea name="address" id="address" class="form-control" placeholder="Address line" required rows="1"
                    oninput="checkFormCompletion();"></textarea>
                </div>
                <div class="col-md-4">
                  <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode"
                    oninput="checkFormCompletion();" required />
                </div>
              </div>
              <div class="row mt-4 align-items-center">
                <div class="col-md-auto">
                  <small class="text-muted font-family-mulish">*Please ENTER the OTP sent to your Email and Submit</small>
                </div>
                <div class="col-md-5 d-flex gap-2">
                  <input
                    type="text"
                    id="otp"
                    name="otp"
                    class="form-control"
                    placeholder="Email OTP"
                    maxlength="6" />
                  <button type="button" id="submitBtn" class="btn btn-submit">
                    Submit
                  </button>
                </div>
              </div>
          </form>

          <!-- OTP Section (hidden initially) -->
          <div class="row mt-4 align-items-center" id="otpRow" style="display: none;">
            <div class="col-md-7">
              <small class="text-muted fw-bolder" style="font-size: .850em;">*OTP sent to your Email. Enter OTP and
                Verify</small>
            </div>
            <div class="col-md-4">
              <input type="text" name="otp" id="otp" class="form-control" placeholder="Email OTP" maxlength="6" />
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-verify" id="verifyBtn">
                Submit
              </button>
            </div>
          </div>

          <!-- OTP Timer Display -->
          <div class="row mt-2" id="otpTimerContainer" style="display: none;">
            <div class="col-md-12">
              <small class="otp-timer" id="otpTimer"></small>
            </div>
          </div>

          <!-- Loading indicator for auto-send -->
          <div class="row mt-3" id="autoSendIndicator" style="display: none;">
            <div class="col-md-12">
              <div class="d-flex align-items-center">
                <strong class="text-danger me-2">Sending OTP...</strong>
                <div class="spinner-border spinner-border-sm text-danger" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
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
        // var city = $('#city').val().trim();
        // var country = $('#country').val().trim();
        var postcode = $('#postcode').val().trim();

        // Check all fields are filled
        var allFilled = full_name && email && date_of_birth && gender &&
          address && postcode;

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
            // city: $('#city').val(),
            // country: $('#country').val(),
            postcode: $('#postcode').val()
          },
          dataType: 'json',
          success: function(response) {
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
          error: function(xhr, status, error) {
            $('#autoSendIndicator').fadeOut();
            showMessage('An error occurred. Please try again.', 'error');
            console.error('AJAX Error:', status, error);
            isFormSubmitting = false;
          }
        });
      }

      // Verify OTP Button Click
      $('#verifyBtn').on('click', function() {
        var otp = $('#otp').val();
        var email = $('#email').val();

        if (!otp || otp.length !== 6) {
          showMessage('Please enter the 6-digit OTP sent to your email.', 'error');
          return;
        }

        // Disable button and show loading
        $('#verifyBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Verifying...');

        // Make AJAX request to verify OTP
        $.ajax({
          url: 'otp_verify.php',
          type: 'POST',
          data: {
            action: 'verify_otp',
            otp: otp,
            email: email
          },
          dataType: 'json',
          success: function(response) {
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
          error: function(xhr, status, error) {
            showMessage('An error occurred. Please try again.', 'error');
            console.error('AJAX Error:', status, error);
          },
          complete: function() {
            $('#verifyBtn').prop('disabled', false).text('Submit');
          }
        });
      });

      // Start OTP Timer
      function startOtpTimer() {
        var duration = 60; // 1 minute in seconds

        clearInterval(otpTimerInterval);

        otpTimerInterval = setInterval(function() {
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
        var html = '<div class="' + (type === 'success' ? 'success-message' : 'error-message') + '">' + message + '</div>';
        $('#messageContainer').html(html);

        // Auto-hide after 5 seconds for success messages
        if (type === 'success') {
          setTimeout(function() {
            $('#messageContainer').fadeOut(function() {
              $(this).empty().show();
            });
          }, 9000);
        }
      }

      // Make checkFormCompletion globally available
      window.checkFormCompletion = checkFormCompletion;
    });
  </script>
</body>

</html>