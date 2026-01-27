<?php
/**
 * UK Polls OTP Verification API
 * Separate file for OTP verification to handle form submission and OTP verification
 */

// Start session at the very beginning
session_start();

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Log all errors to a file for later review
ini_set('error_log', __DIR__ . '/error.log');

// Include common database connection
require_once 'db.php';
// Include email configuration
require_once 'email_config.php';

header('Content-Type: application/json');

// Helper function to log errors
function logError($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL);
}

$response = ['success' => false, 'message' => ''];

/**
 * Generate a random 6-digit OTP
 */
function generateOTP()
{
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

/**
 * Send OTP via email using PHPMailer
 */
function sendOTPEmail($email, $otp, $name)
{
    logError("Attempting to send OTP email to: $email");

    // Directly include PHPMailer classes without autoloader to avoid conflicts
    $phpmailer_src = __DIR__ . '/lib/PHPMailer/src';

    // Include Exception first
    $exceptionFile = $phpmailer_src . '/Exception.php';
    if (file_exists($exceptionFile) && !class_exists('PHPMailer\PHPMailer\Exception')) {
        require_once $exceptionFile;
    }

    // Include SMTP
    $smtpFile = $phpmailer_src . '/SMTP.php';
    if (file_exists($smtpFile) && !class_exists('PHPMailer\PHPMailer\SMTP')) {
        require_once $smtpFile;
    }

    // Include PHPMailer
    $mailerFile = $phpmailer_src . '/PHPMailer.php';
    if (!file_exists($mailerFile)) {
        logError("PHPMailer.php not found at: $mailerFile");
        return false;
    }

    // Only include if class doesn't exist
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        require_once $mailerFile;
    }

    logError("PHPMailer classes loaded successfully");

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        logError("PHPMailer object created successfully");

        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;

        // Debug settings
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'error_log';

        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($email, $name);
        $mail->addReplyTo(FROM_EMAIL, FROM_NAME);

        $mail->isHTML(true);
        $mail->Subject = EMAIL_SUBJECT;

        $message_body = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>OTP Verification</title>
            </head>
            <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                <div style='background-color: #f8f9fa; padding: 20px; border-radius: 10px;'>
                    <h2 style='color: #2c366a; text-align: center;'>Hello $name,</h2>
                    <p style='text-align: center;'>Thank you for registering with MalaysiaPolls!</p>
                    
                    <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; text-align: center; margin: 20px 0; border: 2px solid #2c366a;'>
                        <p style='font-size: 14px; margin-bottom: 15px; color: #666;'>Your One-Time Password (OTP) is:</p>
                        <h1 style='color: #d62128; font-size: 42px; letter-spacing: 8px; margin: 10px 0; font-weight: bold;'>$otp</h1>
                    </div>
                    
                    <p style='color: #666; font-size: 12px; text-align: center;'>
                        This OTP is valid for <strong>1 minute</strong>. Please do not share this OTP with anyone.
                    </p>
                    <p style='color: #999; font-size: 11px; text-align: center; margin-top: 20px;'>
                        If you did not request this OTP, please ignore this email.
                    </p>
                </div>
                
                <div style='text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;'>
                    <p style='color: #999; font-size: 11px;'>
                        © " . date('Y') . " MalaysiaPolls. All rights reserved.
                    </p>
                </div>
            </body>
            </html>
        ";

        $mail->Body = $message_body;
        $mail->AltBody = "Hello $name,\n\nYour OTP for MalaysiaPolls Registration is: $otp\n\nThis OTP is valid for 1 minute.\n\nIf you did not request this, please ignore this email.";

        logError("Attempting to send email...");
        $mail->send();
        logError("Email sent successfully!");
        return true;
    } catch (Exception $e) {
        logError("Email sending failed: " . $e->getMessage());
        logError("PHPMailer Error Info: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Sanitize string input (only define if not already defined)
 */
if (!function_exists('sanitizeString')) {
    function sanitizeString($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Validate email format (only define if not already defined)
 */
if (!function_exists('validateEmail')) {
    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

/**
 * Save form data to database with pending OTP status
 */
function saveFormDataWithOTP($pdo, $data, $otp)
{
    try {
        $sql = "INSERT INTO my_polls (
                  full_name, email, date_of_birth, gender, address, city, 
                  country, postcode, otp, otp_verified, status, otp_created_at, created_at
                ) VALUES (
                  :full_name, :email, :date_of_birth, :gender, :address, :city,
                  :country, :postcode, :otp, 0, 'pending', NOW(), NOW()
                )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':date_of_birth' => $data['date_of_birth'],
            ':gender' => $data['gender'],
            ':address' => $data['address'],
            ':city' => $data['city'],
            ':country' => $data['country'],
            ':postcode' => $data['postcode'],
            ':otp' => $otp
        ]);

        return (int) $pdo->lastInsertId();
    } catch (PDOException $e) {
        logError("Insert failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Verify OTP from database
 */
function verifyOTPFromDB($pdo, $email, $otp)
{
    try {
        // Match both email and OTP in a single query
        $sql = "SELECT id, otp, otp_created_at FROM my_polls 
                WHERE email = :email AND otp = :otp AND status = 'pending' AND otp_verified = 0";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':otp' => $otp]);
        $user = $stmt->fetch();

        if (!$user) {
            // Check if there's a pending record but with different OTP
            $checkSql = "SELECT id, otp, otp_created_at FROM my_polls 
                        WHERE email = :email AND status = 'pending' AND otp_verified = 0";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([':email' => $email]);
            $existingUser = $checkStmt->fetch();

            if ($existingUser) {
                logError("OTP mismatch for email $email. Stored: " . $existingUser['otp'] . ", Submitted: $otp");
            } else {
                logError("No pending record found for email: $email");
            }
            return 'not_found';
        }

        // Debug logging
        logError("OTP verification successful for email: $email");

        // Check if OTP is still valid (1 minute = 60 seconds)
        $otpTime = strtotime($user['otp_created_at']);
        $timeDiff = time() - $otpTime;

        if ($timeDiff > 60) {
            return 'expired';
        }

        // Update record as verified
        $updateSql = "UPDATE my_polls SET otp_verified = 1, status = 'verified', updated_at = NOW() WHERE id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([':id' => $user['id']]);

        return true;
    } catch (PDOException $e) {
        logError("OTP verification failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Update OTP in database
 */
function updateOTPInDB($pdo, $email, $newOTP)
{
    try {
        $sql = "UPDATE my_polls SET otp = :otp, otp_created_at = NOW(), otp_verified = 0, status = 'pending' 
                WHERE email = :email AND status = 'pending'";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':otp' => $newOTP, ':email' => $email]);
    } catch (PDOException $e) {
        logError("OTP update failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Check if email already exists with verified status
 */
function checkEmailExists($pdo, $email)
{
    try {
        $sql = "SELECT id FROM my_polls WHERE email = :email AND status = 'verified' LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    } catch (PDOException $e) {
        return false;
    }
}

// Handle form submission and send OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_otp') {
    logError("Received send_otp request");

    if ($pdo === null) {
        logError("Database connection is null");
        $response['message'] = "Database connection failed. Please try again later.";
    } else {
        $full_name = sanitizeString($_POST['full_name'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $gender = sanitizeString($_POST['gender'] ?? '');
        $address = sanitizeString($_POST['address'] ?? '');
        $city = sanitizeString($_POST['city'] ?? '');
        $country = sanitizeString($_POST['country'] ?? '');
        $postcode = sanitizeString($_POST['postcode'] ?? '');

        logError("Form data received: name=$full_name, email=$email");

        // Basic validation
        if (
            empty($full_name) || empty($email) || empty($date_of_birth) ||
            empty($gender) || empty($address) || empty($city) ||
            empty($country) || empty($postcode)
        ) {
            logError("Validation failed: Missing fields");
            $response['message'] = "All fields are required!";
        } elseif (!validateEmail($email)) {
            logError("Validation failed: Invalid email format");
            $response['message'] = "Invalid email format!";
        } elseif (checkEmailExists($pdo, $email)) {
            logError("Validation failed: Email already exists and verified");
            $response['message'] = "This email is already registered and verified!";
        } else {
            // Generate OTP
            $otp = generateOTP();
            logError("Generated OTP: $otp");

            // Prepare data array
            $data = [
                'full_name' => $full_name,
                'email' => $email,
                'date_of_birth' => $date_of_birth,
                'gender' => $gender,
                'address' => $address,
                'city' => $city,
                'country' => $country,
                'postcode' => $postcode
            ];

            // Save form data to database first
            logError("Attempting to save form data to database...");
            $user_id = saveFormDataWithOTP($pdo, $data, $otp);
            logError("Database save result: user_id=$user_id");

            if ($user_id) {
                // Data saved successfully, now send OTP email
                logError("Sending OTP email to $email...");
                $email_sent = sendOTPEmail($email, $otp, $full_name);

                if ($email_sent) {
                    logError("OTP email sent successfully!");
                    // Store user_id in session for verification
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['otp_email'] = $email;
                    $_SESSION['otp_time'] = time();

                    $response['success'] = true;
                    $response['message'] = "OTP sent successfully to: $email";
                    $response['user_id'] = $user_id;
                } else {
                    // Email failed, delete the record
                    logError("Email sending failed, deleting record...");
                    $deleteSql = "DELETE FROM my_polls WHERE id = :id";
                    $deleteStmt = $pdo->prepare($deleteSql);
                    $deleteStmt->execute([':id' => $user_id]);

                    $response['message'] = "Failed to send OTP. Please try again.";
                }
            } else {
                logError("Failed to save form data to database");
                $response['message'] = "Failed to save form data. Please try again.";
            }
        }
    }

    logError("Sending response: " . json_encode($response));
    echo json_encode($response);
    exit;
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    $user_otp = sanitizeString($_POST['otp'] ?? '');
    $email = sanitizeString($_POST['email'] ?? '');

    if (empty($user_otp)) {
        $response['message'] = "Please enter the OTP.";
    } elseif ($pdo === null) {
        $response['message'] = "Database connection failed. Please try again later.";
    } else {
        // Verify OTP from database
        $result = verifyOTPFromDB($pdo, $email, $user_otp);

        if ($result === 'not_found') {
            $response['message'] = "No pending verification found. Please fill the form again.";
        } elseif ($result === 'expired') {
            $response['message'] = "OTP has expired. Please request a new OTP.";
        } elseif ($result === true) {
            $response['success'] = true;
            $response['message'] = "Welcome aboard! 🚀 You've successfully joined our early access waitlist. We’ll notify you as soon as onboarding opens for you. Thanks for showing interest in being part of our panel community!";


            // Clear session
            unset($_SESSION['user_id'], $_SESSION['otp_email'], $_SESSION['otp_time']);
        } else {
            $response['message'] = "Invalid OTP. Please try again.";
        }
    }

    echo json_encode($response);
    exit;
}

// Handle resend OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'resend_otp') {
    if (!isset($_SESSION['otp_email'])) {
        $response['message'] = "Session expired. Please fill the form again.";
    } elseif ($pdo === null) {
        $response['message'] = "Database connection failed. Please try again later.";
    } else {
        // Check if 1 minute has passed since last OTP
        if (isset($_SESSION['otp_time']) && (time() - $_SESSION['otp_time']) < 60) {
            $remaining = 60 - (time() - $_SESSION['otp_time']);
            $response['message'] = "Please wait $remaining seconds before requesting a new OTP.";
        } else {
            // Generate new OTP
            $otp = generateOTP();
            $email = $_SESSION['otp_email'];

            // Update OTP in database
            $otp_updated = updateOTPInDB($pdo, $email, $otp);

            if ($otp_updated) {
                // Send new OTP email
                $email_sent = sendOTPEmail($email, $otp, '');

                if ($email_sent) {
                    $_SESSION['otp_time'] = time();

                    $response['success'] = true;
                    $response['message'] = "New OTP sent successfully to: " . $email;
                } else {
                    $response['message'] = "Failed to send OTP. Please try again.";
                }
            } else {
                $response['message'] = "Failed to update OTP. Please try again.";
            }
        }
    }

    echo json_encode($response);
    exit;
}

// Invalid request
$response['message'] = "Invalid request.";
echo json_encode($response);
exit;

