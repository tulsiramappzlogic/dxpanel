<?php
/**
 * Email Configuration for Philippines Module
 * SMTP Settings for Gmail
 */

// Load central configuration
require_once __DIR__ . '/../config.php';

// Get email configuration from environment variables
$emailConfig = getEmailConfig('PH');

// SMTP Configuration
define('SMTP_HOST', $emailConfig['host']);
define('SMTP_PORT', $emailConfig['port']); // TLS port
define('SMTP_ENCRYPTION', $emailConfig['encryption']);
define('SMTP_AUTH', $emailConfig['auth']);

// Gmail credentials
define('SMTP_USERNAME', $emailConfig['username']);
define('SMTP_PASSWORD', $emailConfig['password']);

// Email settings
define('FROM_EMAIL', $emailConfig['from_email']);
define('FROM_NAME', $emailConfig['from_name']);
define('EMAIL_SUBJECT', $emailConfig['subject']);

