<?php
/**
 * PHPMailer Autoloader
 * Fixed version to prevent duplicate class declarations
 */

spl_autoload_register(function ($class) {
    // Project namespace prefix
    $prefix = 'PHPMailer\\PHPMailer\\';
    
    // Base directory for the namespace prefix
    $base_dir = __DIR__ . '/src/';
    
    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Check for legacy class names (without namespace)
        $legacy_classes = ['SMTP', 'PHPMailer', 'Exception'];
        if (in_array($class, $legacy_classes)) {
            // Only load if not already defined
            if (!class_exists($class) && !interface_exists($class)) {
                $file = __DIR__ . '/src/' . $class . '.php';
                if (file_exists($file)) {
                    require $file;
                }
            }
        }
        return;
    }
    
    // Get the relative class name
    $relative_class = substr($class, $len);
    
    // Replace namespace separators with directory separators
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // If the file exists, require it (check if not already defined)
    if (file_exists($file) && !class_exists($class) && !interface_exists($class)) {
        require $file;
    }
});

