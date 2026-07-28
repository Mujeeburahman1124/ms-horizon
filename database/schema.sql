-- ============================================================================
-- MS HORIZON GROUP - ENTERPRISE MYSQL 8 DATABASE SCHEMA
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `ms_horizon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ms_horizon`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- 1. ROLES & PERMISSIONS
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `permissions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE `role_permissions` (
  `role_id` INT UNSIGNED NOT NULL,
  `permission_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`),
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 2. USERS (AUTH & SYSTEM USERS)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `role_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(30) NULL,
  `avatar` VARCHAR(255) DEFAULT 'default-avatar.png',
  `is_active` TINYINT(1) DEFAULT 1,
  `last_login_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 3. DIVISIONS & SERVICES
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `divisions`;

CREATE TABLE `divisions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `icon` VARCHAR(100) NOT NULL,
  `short_description` TEXT NOT NULL,
  `full_description` LONGTEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `division_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `short_desc` TEXT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `features_json` JSON NULL,
  `icon` VARCHAR(100) DEFAULT 'fa-cog',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 4. TRAVEL & VISA MANAGEMENT DIVISION
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `visa_documents`;
DROP TABLE IF EXISTS `visa_applications`;
DROP TABLE IF EXISTS `visas`;
DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `code` VARCHAR(10) NOT NULL UNIQUE,
  `flag_icon` VARCHAR(255) NULL,
  `visa_available` TINYINT(1) DEFAULT 1,
  `popularity_rank` INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE `visas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `country_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `visa_type` ENUM('Tourist', 'Visit', 'Business', 'Transit', 'Residence', 'Work') DEFAULT 'Tourist',
  `price` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'AED',
  `processing_time` VARCHAR(100) NOT NULL,
  `eligibility` TEXT NOT NULL,
  `required_docs_json` JSON NOT NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `visa_applications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `app_reference` VARCHAR(50) NOT NULL UNIQUE,
  `user_id` INT UNSIGNED NULL,
  `visa_id` INT UNSIGNED NOT NULL,
  `applicant_name` VARCHAR(150) NOT NULL,
  `passport_number` VARCHAR(50) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `status` ENUM('Submitted', 'Under Review', 'Documents Required', 'Approved', 'Rejected') DEFAULT 'Submitted',
  `admin_notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`visa_id`) REFERENCES `visas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `visa_documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT UNSIGNED NOT NULL,
  `doc_type` VARCHAR(100) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `original_name` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`application_id`) REFERENCES `visa_applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 5. RESERVATIONS MANAGEMENT DIVISION
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `reservations`;

CREATE TABLE `reservations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_ref` VARCHAR(50) NOT NULL UNIQUE,
  `user_id` INT UNSIGNED NULL,
  `service_type` ENUM('Airline Ticket', 'Hotel Booking', 'Airport Transfer', 'Tour Package', 'Travel Insurance', 'Corporate Travel', 'Appointment') NOT NULL,
  `customer_name` VARCHAR(150) NOT NULL,
  `customer_email` VARCHAR(150) NOT NULL,
  `customer_phone` VARCHAR(30) NOT NULL,
  `travel_date` DATE NOT NULL,
  `return_date` DATE NULL,
  `passenger_count` INT DEFAULT 1,
  `details` TEXT NOT NULL,
  `status` ENUM('Pending Quote', 'Quoted', 'Confirmed', 'Voucher Issued', 'Cancelled') DEFAULT 'Pending Quote',
  `assigned_staff_id` INT UNSIGNED NULL,
  `voucher_file` VARCHAR(255) NULL,
  `ticket_file` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`assigned_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `invoices` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `invoice_number` VARCHAR(50) NOT NULL UNIQUE,
  `reservation_id` INT UNSIGNED NULL,
  `customer_name` VARCHAR(150) NOT NULL,
  `customer_email` VARCHAR(150) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `payment_status` ENUM('Unpaid', 'Partially Paid', 'Paid', 'Refunded') DEFAULT 'Unpaid',
  `due_date` DATE NOT NULL,
  `pdf_path` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 6. HR CONSULTANCY DIVISION
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `job_applications`;
DROP TABLE IF EXISTS `interviews`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `candidates`;
DROP TABLE IF EXISTS `employers`;

CREATE TABLE `candidates` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `nationality` VARCHAR(100) NOT NULL,
  `experience_years` INT DEFAULT 0,
  `current_title` VARCHAR(150) NULL,
  `cv_path` VARCHAR(255) NOT NULL,
  `passport_path` VARCHAR(255) NULL,
  `certificates_json` JSON NULL,
  `is_contact_unlocked` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `employers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `company_name` VARCHAR(200) NOT NULL,
  `trade_license` VARCHAR(100) NOT NULL,
  `contact_person` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `industry` VARCHAR(100) NOT NULL,
  `is_verified` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `jobs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `employer_id` INT UNSIGNED NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `job_type` ENUM('Full-time', 'Part-time', 'Contract', 'Remote') DEFAULT 'Full-time',
  `experience_level` VARCHAR(100) NOT NULL,
  `salary_range` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `requirements` LONGTEXT NOT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `job_applications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `job_id` INT UNSIGNED NOT NULL,
  `candidate_id` INT UNSIGNED NOT NULL,
  `cover_letter` TEXT NULL,
  `status` ENUM('Applied', 'Shortlisted', 'Interview Scheduled', 'Selected', 'Rejected') DEFAULT 'Applied',
  `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 7. BUSINESS CONSULTANCY DIVISION
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `business_leads`;
DROP TABLE IF EXISTS `business_packages`;

CREATE TABLE `business_packages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `jurisdiction` ENUM('Mainland', 'Free Zone', 'Offshore') NOT NULL,
  `price_starting` DECIMAL(10,2) NOT NULL,
  `features_json` JSON NOT NULL,
  `is_popular` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `business_leads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `lead_ref` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `setup_type` ENUM('Mainland', 'Free Zone', 'Offshore', 'PRO Services', 'VAT & Accounting', 'Bank Account') NOT NULL,
  `estimated_budget` VARCHAR(100) NULL,
  `status` ENUM('New', 'Contacted', 'Proposal Sent', 'Closed Won', 'Closed Lost') DEFAULT 'New',
  `notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 8. SOFTWARE DEVELOPMENT DIVISION
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `software_projects`;
DROP TABLE IF EXISTS `software_portfolio`;

CREATE TABLE `software_portfolio` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `category` ENUM('Web Application', 'Mobile App', 'E-commerce', 'CRM/ERP Systems', 'Cloud Automation') NOT NULL,
  `client_name` VARCHAR(150) NOT NULL,
  `technologies_json` JSON NOT NULL,
  `duration` VARCHAR(50) NOT NULL,
  `main_image` VARCHAR(255) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `featured` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `software_projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_ref` VARCHAR(50) NOT NULL UNIQUE,
  `client_name` VARCHAR(150) NOT NULL,
  `client_email` VARCHAR(150) NOT NULL,
  `client_phone` VARCHAR(30) NOT NULL,
  `project_type` VARCHAR(100) NOT NULL,
  `budget_range` VARCHAR(100) NOT NULL,
  `timeline` VARCHAR(100) NOT NULL,
  `requirements` LONGTEXT NOT NULL,
  `attachment_path` VARCHAR(255) NULL,
  `status` ENUM('Pending Review', 'Scoping', 'In Progress', 'Delivered', 'Cancelled') DEFAULT 'Pending Review',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- 9. OFFERS, BLOGS, FAQS, CONTACT & AUDIT LOGS
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `offers`;
DROP TABLE IF EXISTS `blogs`;
DROP TABLE IF EXISTS `contact_enquiries`;
DROP TABLE IF EXISTS `audit_logs`;

CREATE TABLE `offers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `division_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `original_price` DECIMAL(10,2) NOT NULL,
  `offer_price` DECIMAL(10,2) NOT NULL,
  `promotional_image` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `expiry_date` DATE NOT NULL,
  `terms` TEXT NOT NULL,
  `is_archived` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `blogs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `author` VARCHAR(100) NOT NULL DEFAULT 'MS Horizon Editorial',
  `category` VARCHAR(100) NOT NULL,
  `featured_image` VARCHAR(255) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `is_published` TINYINT(1) DEFAULT 1,
  `published_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `contact_enquiries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `department` VARCHAR(100) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `audit_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `user_email` VARCHAR(150) NULL,
  `action` VARCHAR(100) NOT NULL,
  `details` TEXT NULL,
  `ip_address` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
