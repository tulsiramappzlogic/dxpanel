-- Database Schema for Polls Tables
-- Database: dxpanel

-- UK Polls Table
CREATE TABLE IF NOT EXISTS uk_polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    postcode VARCHAR(50) NOT NULL,
    otp VARCHAR(20) NOT NULL,
    otp_verified TINYINT(1) DEFAULT 0,
    status ENUM('pending', 'verified') DEFAULT 'pending',
    otp_created_at DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Philippines Polls Table
CREATE TABLE IF NOT EXISTS ph_polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    barangay VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    postcode VARCHAR(50) NOT NULL,
    otp VARCHAR(20) NOT NULL,
    otp_verified TINYINT(1) DEFAULT 0,
    status ENUM('pending', 'verified') DEFAULT 'pending',
    otp_created_at DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Singapore Polls Table
CREATE TABLE IF NOT EXISTS sg_polls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(255)  NULL,
    country VARCHAR(255)  NULL,
    postcode VARCHAR(50) NOT NULL,
    otp VARCHAR(20) NOT NULL,
    otp_verified TINYINT(1) DEFAULT 0,
    status ENUM('pending', 'verified') DEFAULT 'pending',
    otp_created_at DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Malaysia Polls Table
CREATE TABLE IF NOT EXISTS my_polls (
     id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    postcode VARCHAR(50) NOT NULL,
    otp VARCHAR(20) NOT NULL,
    otp_verified TINYINT(1) DEFAULT 0,
    status ENUM('pending', 'verified') DEFAULT 'pending',
    otp_created_at DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

