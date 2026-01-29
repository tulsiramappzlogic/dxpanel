<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - SingaporePolls</title>
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
                    <div class="col-12 col-lg-5">
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

                    <div class="col-12 col-lg-7 ps-0 ps-lg-4">
                        <div class="hero-text mb-5">
                            <h1>
                                <span class="font-family-expletus color-red-1 fw-400">Sign</span><span
                                    class="font-family-expletus color-black fw-400 d-inline-flex align-items-center gap-3">Up<img
                                        src="./image/icons/curveIcon.png" alt="curve" /></span>
                            </h1>
                        </div>
                        <div id="sigup-form-container">
                            <!-- Message Display -->
                            <div id="messageContainer"></div>

                            <form id="sgPollsForm">
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
                                            <textarea name="address" id="address" class="form-control" placeholder="Address line" required
                                                rows="1" onblur="validateAddress();"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="postcode" id="postcode" class="form-control" placeholder="Postcode"
                                                pattern="[0-9]{6}" oninput="validatePostcode();" onblur="validatePostcode();" required />
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
                                    <button type="button" id="resendBtn" class="btn btn-submit" style="display: none;">
                                        Resend OTP
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