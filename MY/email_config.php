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
define('SMTP_USERNAME', 'panel.malaysiapolls@gmail.com');
define('SMTP_PASSWORD', 'DXpanels08@#$'); // 16-character app password

// Email settings
define('FROM_EMAIL', 'panel.malaysiapolls@gmail.com');
define('FROM_NAME', 'MalaysiaPolls Support');
define('EMAIL_SUBJECT', 'Your OTP for MalaysiaPolls Registration');

