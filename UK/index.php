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
  <?php
  include 'header.php';
  ?>
  <main>
    <section class="my-5 mx-5">
      <div class="container-fluid">
        <div class="row align-items-center g-3 g-lg-4">
          <div class="col-12 col-lg-6">
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

          <div class="col-12 col-lg-6 ps-0 ps-lg-4">
            <div class="hero-text mb-4">
              <h1>
                <span class="font-family-expletus color-blue-1 fw-400">Hello</span><br /><span
                  class="font-family-expletus color-red-1 fw-400 d-flex align-items-center gap-3">UK<img src="./image/icons/curveIcon.png" alt="curve" /></span>
              </h1>
              <p class="lead fw-normal font-family-mulish">
                Welcome to the UK's newest, coolest<br />
                and most rewarding community!
              </p>
            </div>
            <div class="d-none" id="sigup-form-container">
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
                       <select class="form-control" name="country" id="country" onchange="checkFormCompletion();" required>
                        <option value="">Select Country</option>
                        <option value="England">England</option>
                        <option value="Scotland">Scotland</option>
                        <option value="Wales">Wales</option>
                        <option value="Northern Ireland">Northern Ireland</option>
                      </select>                  
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
      </div>
    </section>
    <section id="benefit-container" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div id="heading-container">
              <h2 id="heading" class="text-center">We want to know what you think, so that you can</h2>
              <img src="./image/icons/curveIcon-white.png" />
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 col-md-4">
            <div class="benefit-option text-center">
              <img src="./image/benefit-images/benefit-image-1.svg" alt="benefit image 1" />
              <p>Earn money!</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="benefit-option text-center">
              <img src="./image/benefit-images/benefit-image-2.svg" alt="benefit image 2" />
              <p>Inﬂuence decisions about brands and policies!</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="benefit-option text-center">
              <img src="./image/benefit-images/benefit-image-3.svg" alt="benefit image 3" />
              <p>Have fun online!</p>
            </div>
          </div>

        </div>
        <div class="row mt-2">
          <div class="col-12 text-center">
            <a id="join-now-btn">Join Now <img src="./image/icons/join-icon.svg" alt="Join now icon" /></a>
          </div>
        </div>
      </div>
    </section>
    <section id="quiz-container" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div id="quiz-banner">
              <img id="quiz-logo" src="./image/quiz-images/quiz-logo.svg" alt="quiz logo" />
              <div id="banner-content">
                <h2>screensense<br><span>audience pulse</span></h2>
              </div>
              <img class="w-100" src="./image/quiz-images/quiz-image-1.svg" alt="quiz image" />
              <p class="text-center">
                Question of the week for chance to win<br>£50
              </p>
            </div>
          </div>
          <div class="col-lg-6">
            <div id="quiz-block">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6">
                    <img class="w-100" src="./image/quiz-images/movie-image.svg" alt="movie image" />
                  </div>
                  <div class="col-lg-6">
                    <form>
                      <p>28 Years Later:<br />The Bone Temple is a ___</p>
                      <div>
                        <label class="custom-radio">
                          <input type="radio" name="answer-option" value="hit">
                          <span class="radio-mark"></span>
                          <span class="radio-label">Hit</span>
                        </label>
                      </div>
                      <div>
                        <label class="custom-radio">
                          <input type="radio" name="answer-option" value="average">
                          <span class="radio-mark"></span>
                          <span class="radio-label">Average</span>
                        </label>
                      </div>
                      <div>
                        <label class="custom-radio">
                          <input type="radio" name="answer-option" value="flop">
                          <span class="radio-mark"></span>
                          <span class="radio-label">Flop</span>
                        </label>
                      </div>
                      <div>
                        <label class="custom-radio">
                          <input type="radio" name="answer-option" value="dont-know">
                          <span class="radio-mark"></span>
                          <span class="radio-label">Don't Know</span>
                        </label>
                      </div>
                      <button type="submit">Submit <span><img src="./image/icons/curveIcon-white.png" alt="submit icon" /></span></button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="steps-container" class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div id="heading-container">
              <h2 id="heading" class="text-center">3 simple steps</h2>
              <img src="./image/icons/curveIcon-grey.png" />
            </div>
          </div>
        </div>
        <!-- for tablet and above -->
        <div class="row mt-5 d-none d-md-flex">
          <div class="col-12">
            <div id="steps-container-desktop" class="mb-3">
              <img src="./image/step-images/step-image-desktop.svg" alt="step illustration desktop" />
              <div id="step-container-1" class="step-content-container">
                <h3>Sign Up</h3>
                <p>and complete your proﬁle for free</p>
              </div>
              <div id="step-container-2" class="step-content-container">
                <h3>Take Surveys</h3>
                <p>and earn i-Points while having fun</p>
              </div>
              <div id="step-container-3" class="step-content-container">
                <h3>Get Paid</h3>
                <p>use i-Points to shop or put in wallet</p>
              </div>
            </div>
          </div>
        </div>
        <!-- for mobile -->
        <div class="row mt-5 d-flex d-md-none">
          <div class="col-12 col-sm-4">
            <div class="step-container text-center mb-5">
              <img class="w-75" src="./image/step-images/step-image-1.svg" alt="step 1 image" />
              <div class="step-content-container text-center">
                <h3 class="mt-3">Sign Up</h3>
                <p>and complete your proﬁle for free</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="step-container text-center mb-5">
              <div class="step-content-container text-center">
                <img class="w-75" src="./image/step-images/step-image-2.svg" alt="step 2 image" />
                <h3 class="mt-3">Take Surveys</h3>
                <p>and earn i-Points while having fun</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="step-container text-center mb-5">
              <div class="step-content-container text-center">
                <img class="w-75" src="./image/step-images/step-image-3.svg" alt="step 3 image" />
                <h3 class="mt-3">Get Paid</h3>
                <p>use i-Points to shop or put in wallet</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="earning-container" class="py-5">
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
              <img src="./image/earning-images/earning-image-1.svg" alt="earning image 1" />
              <h3 class="mt-3">Take Surveys</h3>
              <p>Earn i-Points for each survey you complete</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="earning-option text-center">
              <img src="./image/earning-images/earning-image-2.svg" alt="earning image 2" />
              <h3 class="mt-3">SCREENSENSE Weekly Poll</h3>
              <p>Answer just one question each week for a chance to win £50</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="earning-option text-center">
              <img src="./image/earning-images/earning-image-3.svg" alt="earning image 3" />
              <h3 class="mt-3">Send-a-friend!</h3>
              <p>Earn i-Points for each referral who joins UKPolls</p>
            </div>
          </div>

        </div>
      </div>
    </section>
    <section id="activity-container" class="py-5">
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
            <div class="activity-option left red p-4 text-start">
              <div class="image-container left">
                <img src="./image/activity-images/activity-image-1.svg" alt="activity image 1" />
              </div>
              <h3>Online surveys</h3>
              <p>on shopping, sports, food, technology and more!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option right white p-4 text-end">
              <div class="image-container right">
                <img src="./image/activity-images/activity-image-2.svg" alt="activity image 2" />
              </div>
              <h3>Watch ads and movies</h3>
              <p>and give feedback before they are launched!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option left white p-4 text-start">
              <div class="image-container left">
                <img src="./image/activity-images/activity-image-3.svg" alt="activity image 3" />
              </div>
              <h3>Video call/ group discussions</h3>
              <p>with other interesting members!</p>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="activity-option right red p-4 text-end">
              <div class="image-container right">
                <img src="./image/activity-images/activity-image-4.svg" alt="activity image 4" />
              </div>
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
              <img src="./image/icons/curveIcon-blue.png" />
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-1.svg" alt="redemption option 1" />
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-2.svg" alt="redemption option 2" />
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-3.svg" alt="redemption option 3" />
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-4.svg" alt="redemption option 4" />
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-5.svg" alt="redemption option 5" />
          </div>
          <div class="col-12 col-sm-6 col-md-4 text-center">
            <img src="./image/redemption-option-6.svg" alt="redemption option 6" />
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
  <?php
  include 'footer.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./script/script.js"></script>
</body>

</html>