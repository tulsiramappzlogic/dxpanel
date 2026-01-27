<?php
/**
 * Common Database Connection File
 * This file provides a unified database connection for all country forms
 */

// Load central configuration
include '../config.php';

// Get database configuration from environment variables
$db_config = getDbConfig();

// Create PDO connection with error handling
try {
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['database']};charset={$db_config['charset']}";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch(PDOException $e) {
    // Log error but don't expose details in production
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
}

/**
 * Get database connection
 * @return PDO|null Returns PDO object or null on failure
 */
function getDbConnection() {
    global $pdo;
    return $pdo;
}

/**
 * Insert poll data into database
 * @param string $table Table name (uk_polls, ph_polls, sg_polls, my_polls)
 * @param array $data Associative array of column => value pairs
 * @return bool True on success, false on failure
 */
function insertPollData($table, $data) {
    global $pdo;
    
    if ($pdo === null) {
        return false;
    }
    
    try {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}, created_at) VALUES ({$placeholders}, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($data);
    } catch(PDOException $e) {
        error_log("Insert failed for {$table}: " . $e->getMessage());
        return false;
    }
}

/**
 * Validate email format
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
if (!function_exists('validateEmail')) {
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

/**
 * Sanitize string input
 * @param string $input String to sanitize
 * @return string Sanitized string
 */
if (!function_exists('sanitizeString')) {
    function sanitizeString($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

