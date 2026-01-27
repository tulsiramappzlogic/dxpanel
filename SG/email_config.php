<?php
/**
 * Email Configuration for UK Module
 * SMTP Settings for Gmail
 */

// SMTP Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587); // TLS port
define('SMTP_ENCRYPTION', 'tls');
define('SMTP_AUTH', true);

// Gmail credentials
define('SMTP_USERNAME', 'panel.singaporepolls@gmail.com');
define('SMTP_PASSWORD', 'alot phft dwcj ttjn'); // 16-character app password

// Email settings
define('FROM_EMAIL', 'panel.singaporepolls@gmail.com');
define('FROM_NAME', 'SGPolls');
define('EMAIL_SUBJECT', 'Your OTP for SingaporePolls Registration');

