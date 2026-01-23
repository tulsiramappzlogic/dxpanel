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
  <title>UKPolls - Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Expletus+Sans:ital,wght@0,400..700;1,400..700&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./style/commonStyle.css" />
  <link rel="stylesheet" href="./style/index.css" />
</head>

<body>
  <header class="bg-white border-bottom py-2 py-md-3 box-shadow-1">
    <div class="container">
      <!-- Top row: Social icons, Logo, Auth buttons -->
      <div class="row align-items-center g-2 g-md-3">
        <!-- Social Icons - Left Column -->
        <div class="col-4 col-lg-3 text-start">
          <div class="social-icons d-flex flex-wrap">
            <a href="https://www.facebook.com/people/UKPolls/61586555893038/" class="me-2 me-md-3" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://in.linkedin.com/company/dataxing-digital" class="me-2 me-md-3" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>

        <!-- Logo - Center Column -->
        <div class="col-4 col-lg-6 text-center py-2 py-sm-0">
          <img
            src="./image/UKPolls Logo.png"
            alt="UKPolls Logo"
            class="brand-logo"
            style="max-width: 100%; height: auto;" />
        </div>

        <!-- Auth Buttons - Right Column (Desktop) -->
        <div class="col-4 col-lg-3 text-center text-end d-none d-md-block">
          <div class="d-flex justify-content-end align-items-center gap-2">
            <a href="#" class="btn-auth">
              Login
              <span class="icon-circle bg-uk-blue">
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

        <!-- Mobile/Tablet Menu Button -->
        <div class="col-4 col-lg-3 text-center text-end d-md-none">
          <button class="btn btn-outline-secondary rounded-pill" type="button" id="authMenuToggle" style="border: 1px solid rgba(88, 89, 91, 1); padding: 6px 16px;">
            <i class="fas fa-bars"></i> Menu
          </button>
        </div>
      </div>

      <!-- Mobile/Tablet Menu (Hidden by default) -->
      <div class="row d-md-none mt-2" id="authMenuDropdown" style="display: none;">
        <div class="col-12">
          <div class="bg-light rounded p-3 d-flex flex-column gap-2">
            <a href="#" class="btn-auth w-100 text-start">
              <i class="fas fa-sign-in-alt me-2"></i>Login
              <span class="icon-circle bg-uk-blue ms-auto">
                <i class="fas fa-angle-double-right"></i>
              </span>
            </a>
            <a href="#" class="btn-auth w-100 text-start">
              <i class="fas fa-user-plus me-2"></i>Sign Up
              <span class="icon-circle bg-uk-red ms-auto">
                <i class="fas fa-angle-double-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="my-5 mx-5">
    <div class="container-fluid">
      <div class="row align-items-center g-3 g-lg-4">
        <div class="col-12 col-lg-5">
          <div class="photo-grid">
            <div class="box blue"></div>
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

        <div class="col-12 col-lg-7 ps-0 ps-lg-4">
          <div class="hero-text mb-4">
            <h1>
              <span class="font-family-expletus color-blue-1 fw-400">Hello</span><br /><span
                class="font-family-expletus color-red-1 fw-400 d-flex align-items-center gap-3">UK<img src="./image/icons/curveIcon.png" alt="curve" /></span>
            </h1>
            <p class="lead fw-normal font-family-mulish">
              Welcome to UK's newest, coolest<br />
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
                    placeholder="Date Of Birth" onchange="validateAge(); checkFormCompletion();" required />
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
                  <input type="text" name="city" id="city" class="form-control" placeholder="City / Town"
                    oninput="checkFormCompletion();" required />
                </div>
                <div class="col-md-4">
                  <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="UK"
                    oninput="checkFormCompletion();" required />
                </div>
                <div class="col-md-4">
                  <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode (e.g., EH1 1AB)"
                    oninput="onPostcodeInput(); validateUKPostcode(); checkFormCompletion();" required />
                  <small class="text-muted" id="postcodeHint" style="font-size: 0.7em;">Format: AA9A 9AA, A9 9AA, A99 9AA, etc.</small>
                </div>
              </div>
             
          </form>

      <!-- OTP Section (hidden initially) -->
          <div class="row mt-4 align-items-center" id="otpRow" >
            <div class="col-md-auto">
              <small class="text-muted font-family-mulish">*Please ENTER the OTP sent to your Email and Submit</small>
            </div>
            <div class="col-md-5 d-flex gap-2">
              <input type="text" name="otp" id="otp" class="form-control" placeholder="Email OTP" maxlength="6" />
              <button type="button" id="verifyBtn" class="btn btn-submit">
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
                <strong class="text-primary me-2">Sending OTP...</strong>
                <div class="spinner-border spinner-border-sm text-primary" role="status">
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
  <script src="./script/script.js"></script>
</body>

</html>