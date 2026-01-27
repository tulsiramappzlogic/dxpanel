<?php
/**
 * Central Configuration Loader
 * Loads environment variables from .env file
 */

// Define the path to the .env file
$envFile = __DIR__ . '/.env';

// Check if .env file exists
if (!file_exists($envFile)) {
    throw new Exception('.env file not found at: ' . $envFile);
}

// Read and parse the .env file
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    // Skip comments
    if (strpos(trim($line), '#') === 0) {
        continue;
    }
    
    // Parse KEY=VALUE pairs
    if (strpos($line, '=') !== false) {
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Set as environment variable
        $_ENV[$name] = $value;
        
        // Also define as constant for backward compatibility
        if (!defined($name)) {
            define($name, $value);
        }
    }
}

/**
 * Get environment variable
 * @param string $key The environment variable key
 * @param mixed $default Default value if key not found
 * @return mixed The environment variable value or default
 */
function getEnvValue($key, $default = null) {
    $value = $_ENV[$key] ?? $default;
    
    // Handle special values
    if ($value === 'true') return true;
    if ($value === 'false') return false;
    if ($value === 'null') return null;
    if ($value === '') return $default;
    
    return $value;
}

/**
 * Get database configuration
 * @return array Database configuration array
 */
function getDbConfig() {
    return [
        'host' => DB_HOST,
        'database' => DB_DATABASE,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'charset' => DB_CHARSET
    ];
}

/**
 * Get email configuration for a specific country
 * @param string $country Country code (MY, PH, SG, UK)
 * @return array Email configuration array
 */
function getEmailConfig($country) {
    $prefix = strtoupper($country);
    
    return [
        'host' => getEnvValue("{$prefix}_SMTP_HOST"),
        'port' => getEnvValue("{$prefix}_SMTP_PORT"),
        'encryption' => getEnvValue("{$prefix}_SMTP_ENCRYPTION"),
        'auth' => (bool)getEnvValue("{$prefix}_SMTP_AUTH"),
        'username' => getEnvValue("{$prefix}_SMTP_USERNAME"),
        'password' => getEnvValue("{$prefix}_SMTP_PASSWORD"),
        'from_email' => getEnvValue("{$prefix}_FROM_EMAIL"),
        'from_name' => getEnvValue("{$prefix}_FROM_NAME"),
        'subject' => getEnvValue("{$prefix}_EMAIL_SUBJECT")
    ];
}

