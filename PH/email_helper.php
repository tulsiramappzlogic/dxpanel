<?php
/**
 * Unified Email Helper Function for All Countries (MY, PH, SG, UK)
 * Sends emails using country-specific configurations
 * Supports both PHPMailer SMTP and Brevo API methods
 * 
 * Usage Examples:
 *   // Send OTP email
 *   sendOTPEmail('MY', $email, $name, $otp);
 *   
 *   // Send custom email
 *   sendEmail('MY', $email, $name, $subject, $htmlBody);
 *   
 *   // Generate OTP
 *   $otp = generateOTP();
 */

// Load central configuration if not already loaded
if (!function_exists('getEmailConfig')) {
    require_once dirname(__DIR__) . '/config.php';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Generate a random 6-digit OTP
 * 
 * @return string 6-digit OTP
 */
function generateOTP()
{
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

/**
 * Get country display name for email templates
 * 
 * @param string $country Country code
 * @return string Country display name
 */
function getCountryDisplayName($country)
{
    $countryNames = [
        'MY' => 'MalaysiaPolls',
        'PH' => 'PhilippinesPolls',
        'SG' => 'SingaporePolls',
        'UK' => 'UKPolls'
    ];
    return $countryNames[strtoupper($country)] ?? strtoupper($country) . 'Polls';
}

/**
 * Send email using PHPMailer for a specific country
 * 
 * @param string $country Country code (MY, PH, SG, UK)
 * @param string $toEmail Recipient email address
 * @param string $toName Recipient name
 * @param string $subject Email subject
 * @param string $htmlBody HTML formatted email body
 * @param string|null $textBody Plain text email body (optional)
 * @return bool True if email sent successfully, false otherwise
 */
function sendEmail($country, $toEmail, $toName, $subject, $htmlBody, $textBody = null)
{
    // Get country-specific email configuration
    $emailConfig = getEmailConfig(strtoupper($country));
    
    // Load PHPMailer classes - use local path for current country
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
    if (file_exists($mailerFile) && !class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        require_once $mailerFile;
    }
    
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = $emailConfig['host'];
        $mail->SMTPAuth = $emailConfig['auth'];
        $mail->Username = $emailConfig['username'];
        $mail->Password = $emailConfig['password'];
        $mail->SMTPSecure = $emailConfig['encryption'];
        $mail->Port = $emailConfig['port'];
        
        // Debug settings (disable in production - set to 0)
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'error_log';
        
        // Recipients
        $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
        $mail->addAddress($toEmail, $toName);
        $mail->addReplyTo($emailConfig['from_email'], $emailConfig['from_name']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        
        // Set text body if provided
        if ($textBody !== null) {
            $mail->AltBody = $textBody;
        } else {
            // Strip HTML tags for plain text version
            $mail->AltBody = html_entity_decode(strip_tags($htmlBody));
        }
        
        return $mail->send();
    } catch (Exception $e) {
        error_log("Email sending failed for $country: " . $e->getMessage());
        error_log("PHPMailer Error Info: " . (isset($mail) ? $mail->ErrorInfo : 'N/A'));
        return false;
    }
}

/**
 * Send OTP email for a specific country
 * 
 * Usage:
 *   $result = sendOTPEmail('MY', 'user@example.com', 'User Name', '123456');
 *   $result = sendOTPEmail('MY', 'user@example.com', 'User Name', '123456', 2); // 2 minutes expiry
 * 
 * @param string $country Country code (MY, PH, SG, UK)
 * @param string $toEmail Recipient email address
 * @param string $toName Recipient name
 * @param string $otp One-Time Password
 * @param int $otpExpiryMinutes OTP validity in minutes (default: 1)
 * @return bool True if email sent successfully, false otherwise
 */
function sendOTPEmail($country, $toEmail, $toName, $otp, $otpExpiryMinutes = 1)
{
    // Get country-specific configuration
    $emailConfig = getEmailConfig(strtoupper($country));
    
    // Get country display name for the email template
    $countryName = getCountryDisplayName($country);
    
    // Get subject from config
    $subject = $emailConfig['subject'] ?? "OTP Verification - $countryName";
    
    // Create HTML email body
    $htmlBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>OTP Verification</title>
        </head>
        <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 10px;'>
                <h2 style='color: #2c366a; text-align: center;'>Hello " . htmlspecialchars($toName) . ",</h2>
                <p style='text-align: center;'>Thank you for registering with $countryName!</p>
                
                <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; text-align: center; margin: 20px 0; border: 2px solid #2c366a;'>
                    <p style='font-size: 14px; margin-bottom: 15px; color: #666;'>Your One-Time Password (OTP) is:</p>
                    <h1 style='color: #d62128; font-size: 42px; letter-spacing: 8px; margin: 10px 0; font-weight: bold;'>" . htmlspecialchars($otp) . "</h1>
                </div>
                
                <p style='color: #666; font-size: 12px; text-align: center;'>
                    This OTP is valid for <strong>$otpExpiryMinutes minute" . ($otpExpiryMinutes > 1 ? 's' : '') . "</strong>. Please do not share this OTP with anyone.
                </p>
                <p style='color: #999; font-size: 11px; text-align: center; margin-top: 20px;'>
                    If you did not request this OTP, please ignore this email.
                </p>
            </div>
            
            <div style='text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;'>
                <p style='color: #999; font-size: 11px;'>
                    &copy; " . date('Y') . " $countryName. All rights reserved.
                </p>
            </div>
        </body>
        </html>
    ";
    
    // Create plain text email body
    $textBody = "Hello " . $toName . ",\n\n";
    $textBody .= "Thank you for registering with $countryName!\n\n";
    $textBody .= "Your One-Time Password (OTP) is: " . $otp . "\n\n";
    $textBody .= "This OTP is valid for $otpExpiryMinutes minute" . ($otpExpiryMinutes > 1 ? 's' : '') . ".\n\n";
    $textBody .= "If you did not request this, please ignore this email.\n\n";
    $textBody .= "&copy; " . date('Y') . " $countryName. All rights reserved.";
    
    // Send the email
    return sendEmail($country, $toEmail, $toName, $subject, $htmlBody, $textBody);
}

// ============================================
// Brevo API Email Functions (Alternative Method)
// ============================================

/**
 * Get Brevo API configuration for a specific country
 * 
 * @param string $country Country code (MY, PH, SG, UK)
 * @return array Brevo configuration array
 */
function getBrevoConfig($country)
{
    $prefix = strtoupper($country);
    
    return [
        'api_key' => getEnvValue("{$prefix}_BREVO_API_KEY"),
        'sender_name' => getEnvValue("{$prefix}_BREVO_SENDER_NAME"),
        'sender_email' => getEnvValue("{$prefix}_BREVO_SENDER_EMAIL"),
        'api_url' => 'https://api.brevo.com/v3/smtp/email'
    ];
}

/**
 * Send email using Brevo API for a specific country
 * 
 * Usage:
 *   $result = sendBrevoEmail('MY', 'user@example.com', 'User Name', 'Subject', $htmlBody, $textBody);
 *   $result = sendBrevoEmail('MY', 'user@example.com', 'User Name', 'Subject', $htmlBody);
 * 
 * @param string $country Country code (MY, PH, SG, UK)
 * @param string $toEmail Recipient email address
 * @param string $toName Recipient name
 * @param string $subject Email subject
 * @param string $htmlBody HTML formatted email body
 * @param string|null $textBody Plain text email body (optional)
 * @return array Response with 'success' (bool) and 'message' (string)
 */
function sendBrevoEmail($country, $toEmail, $toName, $subject, $htmlBody, $textBody = null)
{
    // Get Brevo configuration for the country
    $config = getBrevoConfig(strtoupper($country));
    
    // Validate API key
    if (empty($config['api_key'])) {
        error_log("Brevo API key not configured for country: $country");
        return [
            'success' => false,
            'message' => 'Email configuration error: API key not set'
        ];
    }
    
    // Prepare text body if not provided
    if ($textBody === null) {
        $textBody = strip_tags($htmlBody);
    }
    
    // Prepare the data payload
    $data = [
        'sender' => [
            'name' => $config['sender_name'],
            'email' => $config['sender_email']
        ],
        'to' => [
            [
                'email' => $toEmail,
                'name' => $toName
            ]
        ],
        'htmlContent' => $htmlBody,
        'textContent' => $textBody,
        'subject' => $subject
    ];
    
    // Initialize cURL
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => $config['api_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'accept: application/json',
            'api-key: ' . $config['api_key'],
            'content-type: application/json'
        ]
    ]);
    
    // Execute the request
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);
    
    // Handle cURL errors
    if ($err) {
        error_log("Brevo cURL Error for $country: " . $err);
        return [
            'success' => false,
            'message' => 'cURL Error: ' . $err
        ];
    }
    
    // Parse response
    $responseData = json_decode($response, true);
    
    // Check for success (Brevo returns 201 or 200 on success)
    if ($httpCode >= 200 && $httpCode < 300) {
        error_log("Brevo email sent successfully for $country to $toEmail");
        return [
            'success' => true,
            'message' => 'Email sent successfully',
            'message_id' => $responseData['messageId'] ?? null
        ];
    } else {
        error_log("Brevo API Error for $country: HTTP $httpCode - " . $response);
        return [
            'success' => false,
            'message' => 'Failed to send email: ' . ($responseData['message'] ?? 'Unknown error')
        ];
    }
}

/**
 * Send OTP email using Brevo API for a specific country
 * 
 * Usage:
 *   $result = sendBrevoOTPEmail('MY', 'user@example.com', 'User Name', '123456');
 *   $result = sendBrevoOTPEmail('MY', 'user@example.com', 'User Name', '123456');
 * 
 * @param string $country Country code (MY, PH, SG, UK)
 * @param string $toEmail Recipient email address
 * @param string $toName Recipient name
 * @param string $otp One-Time Password
 * @param int $otpExpiryMinutes OTP validity in minutes (default: 1)
 * @return array Response with 'success' (bool) and 'message' (string)
 */
function sendBrevoOTPEmail($country, $toEmail, $toName, $otp, $otpExpiryMinutes = 1)
{
    // Get country display name for the email template
    $countryName = getCountryDisplayName($country);
    
    // Get subject from config
    $emailConfig = getEmailConfig(strtoupper($country));
    $subject = $emailConfig['subject'] ?? "OTP Verification - $countryName";
    
    // Create HTML email body
    $htmlBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>OTP Verification</title>
        </head>
        <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 10px;'>
                <h2 style='color: #2c366a; text-align: center;'>Hello " . htmlspecialchars($toName) . ",</h2>
                <p style='text-align: center;'>Thank you for registering with $countryName!</p>
                
                <div style='background-color: #ffffff; padding: 30px; border-radius: 10px; text-align: center; margin: 20px 0; border: 2px solid #2c366a;'>
                    <p style='font-size: 14px; margin-bottom: 15px; color: #666;'>Your One-Time Password (OTP) is:</p>
                    <h1 style='color: #d62128; font-size: 42px; letter-spacing: 8px; margin: 10px 0; font-weight: bold;'>" . htmlspecialchars($otp) . "</h1>
                </div>
                
                <p style='color: #666; font-size: 12px; text-align: center;'>
                    This OTP is valid for <strong>$otpExpiryMinutes minute" . ($otpExpiryMinutes > 1 ? 's' : '') . "</strong>. Please do not share this OTP with anyone.
                </p>
                <p style='color: #999; font-size: 11px; text-align: center; margin-top: 20px;'>
                    If you did not request this OTP, please ignore this email.
                </p>
            </div>
            
            <div style='text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;'>
                <p style='color: #999; font-size: 11px;'>
                    &copy; " . date('Y') . " $countryName. All rights reserved.
                </p>
            </div>
        </body>
        </html>
    ";
    
    // Create plain text email body
    $textBody = "Hello " . $toName . ",\n\n";
    $textBody .= "Thank you for registering with $countryName!\n\n";
    $textBody .= "Your One-Time Password (OTP) is: " . $otp . "\n\n";
    $textBody .= "This OTP is valid for $otpExpiryMinutes minute" . ($otpExpiryMinutes > 1 ? 's' : '') . ".\n\n";
    $textBody .= "If you did not request this, please ignore this email.\n\n";
    $textBody .= "&copy; " . date('Y') . " $countryName. All rights reserved.";
    
    // Send the email using Brevo API
    return sendBrevoEmail($country, $toEmail, $toName, $subject, $htmlBody, $textBody);
}

