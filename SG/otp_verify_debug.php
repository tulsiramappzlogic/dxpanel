<?php
/**
 * DEBUG VERSION - UK Polls OTP Verification API
 * Copy this over otp_verify.php to see detailed errors
 */

// Start session at the very beginning
session_start();

// Error reporting - show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

$debugLog = [];
function debugLog($msg) {
    global $debugLog;
    $debugLog[] = $msg;
    echo "<br>> $msg" . PHP_EOL;
}

echo "<h2>OTP Verification Debug</h2>";
echo "<pre>";

debugLog("Starting OTP verification debug...");

// Include common database connection
debugLog("Including db.php...");
require_once 'db.php';
if ($pdo === null) {
    debugLog("ERROR: Database connection is NULL!");
} else {
    debugLog("Database connection OK");
}

// Include email configuration
debugLog("Including email_config.php...");
require_once 'email_config.php';
debugLog("Email config loaded");

// Check SMTP constants
debugLog("SMTP_HOST = " . (defined('SMTP_HOST') ? SMTP_HOST : 'NOT DEFINED'));

// Handle form submission and send OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_otp') {
    echo "</pre>";
    echo "<h3>Processing send_otp action...</h3>";
    
    $response = ['success' => false, 'message' => ''];
    
    // Generate OTP
    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    debugLog("Generated OTP: $otp");
    
    // Get form data
    $full_name = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ''));
    $address = htmlspecialchars(trim($_POST['address'] ?? ''));
    $city = htmlspecialchars(trim($_POST['city'] ?? ''));
    $country = htmlspecialchars(trim($_POST['country'] ?? ''));
    $postcode = htmlspecialchars(trim($_POST['postcode'] ?? ''));
    
    debugLog("Full Name: $full_name");
    debugLog("Email: $email");
    debugLog("Date of Birth: $date_of_birth");
    debugLog("Gender: $gender");
    debugLog("Address: $address");
    debugLog("City: $city");
    debugLog("Country: $country");
    debugLog("Postcode: $postcode");
    
    // Basic validation
    if (empty($full_name) || empty($email) || empty($date_of_birth) ||
        empty($gender) || empty($address) || empty($city) ||
        empty($country) || empty($postcode)) {
        $response['message'] = "All fields are required!";
        debugLog("Validation failed: Missing fields");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format!";
        debugLog("Validation failed: Invalid email");
    } else {
        // Try to insert data
        debugLog("Attempting to insert data into database...");
        try {
            $sql = "INSERT INTO sg_polls (
                      full_name, email, date_of_birth, gender, address, city, 
                      country, postcode, otp, otp_verified, status, otp_created_at, created_at
                    ) VALUES (
                      :full_name, :email, :date_of_birth, :gender, :address, :city,
                      :country, :postcode, :otp, 0, 'pending', NOW(), NOW()
                    )";
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
              ':full_name' => $full_name,
              ':email' => $email,
              ':date_of_birth' => $date_of_birth,
              ':gender' => $gender,
              ':address' => $address,
              ':city' => $city,
              ':country' => $country,
              ':postcode' => $postcode,
              ':otp' => $otp
            ]);
            
            if ($result) {
                $user_id = (int) $pdo->lastInsertId();
                debugLog("Data inserted successfully! User ID: $user_id");
                
                // Try to send email
                debugLog("Attempting to send email...");
                
                // Include PHPMailer
                $autoloadFile = __DIR__ . '/lib/PHPMailer/autoload.php';
                if (file_exists($autoloadFile)) {
                    debugLog("PHPMailer autoload found");
                    require_once $autoloadFile;
                    
                    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
                        debugLog("PHPMailer class found");
                        
                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = SMTP_HOST;
                        $mail->SMTPAuth = true;
                        $mail->Username = SMTP_USERNAME;
                        $mail->Password = SMTP_PASSWORD;
                        $mail->SMTPSecure = SMTP_ENCRYPTION;
                        $mail->Port = SMTP_PORT;

                        $mail->setFrom(FROM_EMAIL, FROM_NAME);
                        $mail->addAddress($email, $full_name);
                        $mail->isHTML(true);
                        $mail->Subject = 'Your OTP for UKPolls Registration';
                        $mail->Body = "<h3>Your OTP is: $otp</h3>";
                        $mail->AltBody = "Your OTP is: $otp";

                        if ($mail->send()) {
                            debugLog("Email sent successfully!");
                            $response['success'] = true;
                            $response['message'] = "OTP sent successfully to: $email";
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['otp_email'] = $email;
                            $_SESSION['otp_time'] = time();
                        } else {
                            debugLog("Email send failed: " . $mail->ErrorInfo);
                            $response['message'] = "Failed to send OTP.";
                        }
                    } else {
                        debugLog("PHPMailer class NOT found after autoload");
                        $response['message'] = "PHPMailer not available.";
                    }
                } else {
                    debugLog("PHPMailer autoload NOT found at: $autoloadFile");
                    $response['message'] = "PHPMailer files not found.";
                }
            } else {
                debugLog("Insert failed");
                $response['message'] = "Failed to save form data.";
            }
        } catch (PDOException $e) {
            debugLog("Database error: " . $e->getMessage());
            $response['message'] = "Database error: " . $e->getMessage();
        }
    }
    
    echo "<h3>Response:</h3>";
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify_otp') {
    echo "</pre>";
    echo "<h3>Processing verify_otp action...</h3>";
    
    $user_otp = htmlspecialchars(trim($_POST['otp'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    
    debugLog("Email: $email");
    debugLog("OTP: $user_otp");
    
    if (empty($user_otp)) {
        echo json_encode(['success' => false, 'message' => 'Please enter the OTP.']);
        exit;
    }
    
    // Verify OTP from database
    try {
        $sql = "SELECT id, otp, otp_created_at FROM sg_polls 
                WHERE email = :email AND otp = :otp AND status = 'pending' AND otp_verified = 0";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':otp' => $user_otp]);
        $user = $stmt->fetch();
        
        if ($user) {
            debugLog("Record found with ID: " . $user['id']);
            
            // Check expiry
            $otpTime = strtotime($user['otp_created_at']);
            $timeDiff = time() - $otpTime;
            debugLog("Time since OTP: $timeDiff seconds");
            
            if ($timeDiff > 60) {
                echo json_encode(['success' => false, 'message' => 'OTP has expired.']);
            } else {
                // Update record
                $updateSql = "UPDATE sg_polls SET otp_verified = 1, status = 'verified', updated_at = NOW() WHERE id = :id";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([':id' => $user['id']]);
                
                debugLog("OTP verified successfully!");
                echo json_encode(['success' => true, 'message' => 'OTP verified successfully! Form submitted.']);
            }
        } else {
            debugLog("No matching record found");
            echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
        }
    } catch (PDOException $e) {
        debugLog("Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

echo "</pre>";
echo "<h3>No action specified</h3>";
echo "<p>Send a POST request with action=send_otp or action=verify_otp</p>";

