<?php
/**
 * MY Polls OTP Verification API
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
// Include unified email helper
require_once dirname(__DIR__) . '/email_helper.php';

header('Content-Type: application/json');

// Helper function to log errors
function logError($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL);
}

$response = ['success' => false, 'message' => ''];

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
                return 'invalid'; // OTP doesn't match
            } else {
                logError("No pending record found for email: $email");
                return 'not_found'; // No pending record
            }
        }

        // Debug logging
        logError("OTP verification successful for email: $email");

        // Check if OTP is still valid (60 seconds)
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
                $email_sent = \sendOTPEmail('MY', $email, $full_name, $otp);

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
        } elseif ($result === 'invalid') {
            $response['message'] = "Incorrect OTP. Please try again.";
        } elseif ($result === 'expired') {
            $response['message'] = "OTP has expired. Please request a new OTP.";
        } elseif ($result === true) {
            $response['success'] = true;
            $response['message'] = "Thank you for signing up! We'll notify you once your account is ready.";

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
        echo json_encode($response);
        exit;
    }

    if ($pdo === null) {
        $response['message'] = "Database connection failed. Please try again later.";
        echo json_encode($response);
        exit;
    }

    // Get user's name from database for the email template
    $email = $_SESSION['otp_email'];
    $user_name = '';

    try {
        $nameSql = "SELECT full_name FROM my_polls WHERE email = :email AND status = 'pending' LIMIT 1";
        $nameStmt = $pdo->prepare($nameSql);
        $nameStmt->execute([':email' => $email]);
        $userData = $nameStmt->fetch();
        if ($userData) {
            $user_name = $userData['full_name'];
        }
    } catch (PDOException $e) {
        logError("Failed to get user name: " . $e->getMessage());
    }

    // Check if 60 seconds have passed since last OTP (cooldown period)
    if (isset($_SESSION['otp_time']) && (time() - $_SESSION['otp_time']) < 60) {
        $remaining = 60 - (time() - $_SESSION['otp_time']);
        $response['message'] = "Please wait $remaining seconds before requesting a new OTP.";
        echo json_encode($response);
        exit;
    }

    // Generate new OTP
    $otp = generateOTP();

    // Update OTP in database (allow even if expired)
    try {
        $sql = "UPDATE my_polls SET otp = :otp, otp_created_at = NOW(), otp_verified = 0, status = 'pending' 
                WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $otp_updated = $stmt->execute([':otp' => $otp, ':email' => $email]);
    } catch (PDOException $e) {
        logError("OTP update failed: " . $e->getMessage());
        $otp_updated = false;
    }

    if ($otp_updated) {
        // Send new OTP email
                $email_sent = \sendOTPEmail('MY', $email, $user_name, $otp);

        if ($email_sent) {
            $_SESSION['otp_time'] = time();

            $response['success'] = true;
            $response['message'] = "New OTP sent successfully to: " . $email;
            $response['resent'] = true;
        } else {
            $response['message'] = "Failed to send OTP. Please try again.";
        }
    } else {
        $response['message'] = "Failed to update OTP. Please try again.";
    }

    echo json_encode($response);
    exit;
}

// Invalid request
$response['message'] = "Invalid request.";
echo json_encode($response);
exit;

