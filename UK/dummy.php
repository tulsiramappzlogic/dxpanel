<?php
/**
 * Test Email Script for UK Polls
 * Uses centralized email configuration
 */

// Include email configuration
require_once 'email_config.php';

// Directly include PHPMailer classes
$phpmailer_src = __DIR__ . '/lib/PHPMailer/src';

// Include Exception first
$exceptionFile = $phpmailer_src . '/Exception.php';
if (file_exists($exceptionFile)) {
    require_once $exceptionFile;
}

// Include SMTP
$smtpFile = $phpmailer_src . '/SMTP.php';
if (file_exists($smtpFile)) {
    require_once $smtpFile;
}

// Include PHPMailer
$mailerFile = $phpmailer_src . '/PHPMailer.php';
if (!file_exists($mailerFile)) {
    die("PHPMailer.php not found at: $mailerFile\n");
}

require_once $mailerFile;

try {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    // Server settings
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_ENCRYPTION;
    $mail->Port = SMTP_PORT;
    $mail->Timeout = 30;
    
    // Debug settings
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'echo';

    // Recipients
    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addAddress('john.doe33@yopmail.com'); // Test recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email - UK Polls';
    $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="font-family: Arial, sans-serif;">
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px;">
            <h2 style="color: #2c366a;">Test Email</h2>
            <p>This is a test email from UK Polls system.</p>
            <p>If you received this email, the SMTP configuration is working correctly.</p>
        </div>
    </body>
    </html>
    ';
    $mail->AltBody = "Test Email from UK Polls.\n\nIf you received this, the SMTP configuration is working.";

    $mail->send();
    echo "\n✅ Email sent successfully!\n";
    
} catch (Exception $e) {
    echo "\n❌ Email failed to send:\n";
    echo "Error: " . $e->getMessage() . "\n";
    if (isset($mail)) {
        echo "PHPMailer Error: " . $mail->ErrorInfo . "\n";
    }
}

?>

