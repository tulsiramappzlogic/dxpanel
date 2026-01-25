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

  <main>
    <section class="my-5 mx-5">
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
                      onblur="this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); validateFullName();" required />
                  </div>
                  <div class="col-md-4">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                      onblur="this.value = this.value.replace(/[^a-zA-Z0-9._%+-@]/g, ''); validateEmail();" required />
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
                      onblur="validateAddress();"></textarea>
                  </div>
                  <div class="col-md-4">
                    <input type="text" name="city" id="city" class="form-control" placeholder="City / Town"
                      pattern="[a-zA-Z\s]+" onblur="this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); validateCity();" required />
                  </div>
                  <div class="col-md-4">
                    <input type="text" name="country" id="country" readonly value="UK" class="form-control" placeholder="Country" value="UK"
                      pattern="[a-zA-Z\s]+" onblur="this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); checkFormCompletion();" required />
                  </div>
                  <div class="col-md-4">
                    <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode (e.g., EH1 1AB)"
                      oninput="validatePostcode();" onblur="validatePostcode();" required />
                    <small class="text-muted" id="postcodeHint" style="font-size: 0.7em;">Format: AA9A 9AA, A9 9AA, A99 9AA, etc. (min 5 characters)</small>
                  </div>
                </div>

            </form>

            <!-- OTP Section (hidden initially) -->
            <div class="row mt-4 align-items-center" id="otpRow">
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
    </section>
    <section id="earning-container" class="py-4">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div id="heading-container">
              <h2 id="heading" class="text-center">3 ways to earn!</h2>
              <img src="./image/icons/curveIcon-white.png" />
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 col-md-4">
            <div class="earning-option text-center">
              <img src="./image/earning-images/earning-image-1.png" alt="earning image 1"/>
              <h3 class="mt-3">Take Surveys</h3>
              <p>Earn i-Points for each survey you complete</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="earning-option text-center">
              <img src="./image/earning-images/earning-image-2.png" alt="earning image 2"/>
              <h3 class="mt-3">SCREENSENSE Weekly Poll</h3>
              <p>Answer just one question each week for a chance to win £50</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="earning-option text-center">
              <img src="./image/earning-images/earning-image-3.png" alt="earning image 3"/>
              <h3 class="mt-3">Send-a-friend!</h3>
              <p>Earn i-Points for each referral who joins UKPolls</p>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <section id="activity-container" class="py-4">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div id="heading-container">
              <h2 id="heading" class="text-center">Fun and interesting activities!</h2>
              <img src="./image/icons/curveIcon-white.png" />
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 col-md-6">
            <div class="activity-option red p-4 text-start">
              <!-- <img src="./image/activity-images/activity-image-1" alt="activity image 1"/> -->
              <h3>Online surveys</h3>
              <p>on shopping, sports, food, technology and more!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option white p-4 text-end">
              <!-- <img src="./image/activity-images/activity-image-2" alt="activity image 2"/> -->
              <h3>Watch ads and movies</h3>
              <p>and give feedback before they are launched!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option white p-4 text-start">
              <!-- <img src="./image/activity-images/activity-image-3" alt="activity image 3"/> -->
              <h3>Video call/ group discussions</h3>
              <p>with other interesting members!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option red p-4 text-end">
              <!-- <img src="./image/activity-images/activity-image-4" alt="activity image 4"/> -->
              <h3>Receive free samples</h3>
              <p>at home to test and give feedback!</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="redemption-section" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div id="heading-container">
              <p id="heading" class="text-center">Many options to redeem points </p>
              <img src="./image/icons/curveIcon-blue.png"/>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-1.png" alt="redemption option 1"/>
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-2.png" alt="redemption option 2"/>
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-3.png" alt="redemption option 3"/>
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-4.png" alt="redemption option 4"/>
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-5.png" alt="redemption option 5"/>
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-6.png" alt="redemption option 6"/>
          </div>
        </div>
      </div>
    </section>
    <section id="made-section" class="py-5">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-10 col-sm-8 col-lg-6">
            <div class="container-fluid border-white p-3">
              <div class="row gap-3 gap-lg-0 align-items-center">
                <div class="col-lg-4 flag-container">
                  <div class="text-center text-lg-start">
                    <img src="./image/flag-image.png" alt="Made for UK with flag" />
                  </div>
                </div>
                <div class="col-lg-8">
                  <p class="text-center para-text">
                    UKPolls is the
                    only dedicated
                    community for collecting opinions
                    in UK, and made ONLY FOR
                    UK
                  </p>
                  <hr />
                  <p class="text-center para-text">UK works with some of the biggest brands in UK and the world, and they want YOUR opinions!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <a class="join-btn mt-5">join now
              <span class="icon-circle bg-uk-red">
                <img src="./image/icons/curveIcon.png" />
              </span>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-12 mt-5">
            <div class="appstore-options">
              <a>
                <img src="./image/icons/goglepaybutton.png" alt="Google Playstore Button" />
              </a>
              <a>
                <img src="./image/icons/palaystorelogo.png" alt="Apple Playstore Button" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="background-grey-1">
    <div class="container-fluid px-5 py-3">
      <div class="row gap-3 gap-lg-0 align-items-center">
        <div class="col-12 col-lg-4 col-xxl-5">
          <div class="text-center text-lg-start">
            <a href="#" class="border-right-except-last footer-link px-2">About Us</a>
            <a href="#" class="border-right-except-last footer-link px-2">Privacy Policy</a>
            <a href="#" class="border-right-except-last footer-link px-2">Terms &
              Conditions</a>
            <a href="#"
              class="border-right-except-last footer-link px-2">For
              Clients</a>
            <a href="contact-us.html" class="border-right-except-last footer-link px-2">Contact Us</a>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-2">
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-5">
          <div class="text-center text-lg-end">
            <p style="font-size: 14px;" class="text-light">
              @2026 UKPolls. All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./script/script.js"></script>
</body>

</html>