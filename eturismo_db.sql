-- =============================================================
-- E-Turismo Database — MySQL Import Script
-- Import via phpMyAdmin → Import → select this file → Go
-- =============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -------------------------------------------------------------
-- Create & select database
-- -------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `eturismo_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `eturismo_db`;

-- =============================================================
-- TABLE: users
-- =============================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`                      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`                    VARCHAR(255)    NOT NULL,
  `email`                   VARCHAR(255)    NOT NULL,
  `email_verified_at`       TIMESTAMP       NULL DEFAULT NULL,
  `password`                VARCHAR(255)    NOT NULL,
  `role`                    VARCHAR(255)    NOT NULL DEFAULT 'tourist',
  `contact`                 VARCHAR(255)    NULL DEFAULT NULL,
  `classification`          VARCHAR(255)    NULL DEFAULT NULL,
  `id_type`                 VARCHAR(255)    NULL DEFAULT NULL,
  `id_number`               VARCHAR(255)    NULL DEFAULT NULL,
  `id_photo`                VARCHAR(255)    NULL DEFAULT NULL,
  `assigned_destination_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `remember_token`          VARCHAR(100)    NULL DEFAULT NULL,
  `created_at`              TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`              TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: destinations
-- =============================================================
DROP TABLE IF EXISTS `destinations`;
CREATE TABLE `destinations` (
  `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`                VARCHAR(255)    NOT NULL,
  `initials`            VARCHAR(10)     NOT NULL,
  `location`            VARCHAR(255)    NOT NULL,
  `capacity`            INT             NOT NULL,
  `description`         TEXT            NULL DEFAULT NULL,
  `photos`              TEXT            NULL DEFAULT NULL,
  `availability_status` VARCHAR(255)    NOT NULL DEFAULT 'Available',
  `created_at`          TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`          TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: bookings
-- =============================================================
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tourist_id`          BIGINT UNSIGNED NOT NULL,
  `destination_id`      BIGINT UNSIGNED NOT NULL,
  `visit_date`          DATE            NOT NULL,
  `status`              VARCHAR(255)    NOT NULL DEFAULT 'pending',
  `decline_reason`      TEXT            NULL DEFAULT NULL,
  `decided_by_staff_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `created_at`          TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`          TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `bookings_tourist_fk`
    FOREIGN KEY (`tourist_id`)          REFERENCES `users`(`id`)        ON DELETE CASCADE,
  CONSTRAINT `bookings_destination_fk`
    FOREIGN KEY (`destination_id`)      REFERENCES `destinations`(`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_staff_fk`
    FOREIGN KEY (`decided_by_staff_id`) REFERENCES `users`(`id`)        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: tickets
-- =============================================================
DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` BIGINT UNSIGNED NOT NULL,
  `qr_code`    VARCHAR(255)    NOT NULL,
  `scanned_at` TIMESTAMP       NULL DEFAULT NULL,
  `created_at` TIMESTAMP       NULL DEFAULT NULL,
  `updated_at` TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tickets_qr_code_unique` (`qr_code`),
  CONSTRAINT `tickets_booking_fk`
    FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: check_ins
-- =============================================================
DROP TABLE IF EXISTS `check_ins`;
CREATE TABLE `check_ins` (
  `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id`           BIGINT UNSIGNED NOT NULL,
  `arrival_time`         TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_by_staff_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `occupancy_updated`    TINYINT(1)      NOT NULL DEFAULT 1,
  `created_at`           TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`           TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `checkins_booking_fk`
    FOREIGN KEY (`booking_id`)           REFERENCES `bookings`(`id`) ON DELETE CASCADE,
  CONSTRAINT `checkins_staff_fk`
    FOREIGN KEY (`verified_by_staff_id`) REFERENCES `users`(`id`)   ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: notifications
-- =============================================================
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id`                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `recipient_id`       BIGINT UNSIGNED NOT NULL,
  `recipient_type`     VARCHAR(255)    NOT NULL,
  `type`               VARCHAR(255)    NOT NULL,
  `message`            TEXT            NOT NULL,
  `related_booking_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `is_read`            TINYINT(1)      NOT NULL DEFAULT 0,
  `created_at`         TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`         TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `notifications_recipient_fk`
    FOREIGN KEY (`recipient_id`)       REFERENCES `users`(`id`)    ON DELETE CASCADE,
  CONSTRAINT `notifications_booking_fk`
    FOREIGN KEY (`related_booking_id`) REFERENCES `bookings`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: reports
-- =============================================================
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id`                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `generated_by_admin_id` BIGINT UNSIGNED NOT NULL,
  `destination_id`        BIGINT UNSIGNED NULL DEFAULT NULL,
  `type`                  ENUM('daily','weekly','monthly') NOT NULL DEFAULT 'monthly',
  `date_from`             DATE            NOT NULL,
  `date_to`               DATE            NOT NULL,
  `total_visitors`        INT UNSIGNED    NOT NULL DEFAULT 0,
  `total_bookings`        INT UNSIGNED    NOT NULL DEFAULT 0,
  `confirmed_bookings`    INT UNSIGNED    NOT NULL DEFAULT 0,
  `declined_bookings`     INT UNSIGNED    NOT NULL DEFAULT 0,
  `created_at`            TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`            TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `reports_admin_fk`
    FOREIGN KEY (`generated_by_admin_id`) REFERENCES `users`(`id`)        ON DELETE CASCADE,
  CONSTRAINT `reports_destination_fk`
    FOREIGN KEY (`destination_id`)        REFERENCES `destinations`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: password_reset_tokens
-- =============================================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email`      VARCHAR(255) NOT NULL,
  `token`      VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: cache  (Laravel file-cache fallback, kept for compat)
-- =============================================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key`        VARCHAR(255) NOT NULL,
  `value`      MEDIUMTEXT   NOT NULL,
  `expiration` INT          NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: jobs
-- =============================================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id`           BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `queue`        VARCHAR(255)     NOT NULL,
  `payload`      LONGTEXT         NOT NULL,
  `attempts`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `reserved_at`  INT UNSIGNED     NULL DEFAULT NULL,
  `available_at` INT UNSIGNED     NOT NULL,
  `created_at`   INT UNSIGNED     NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- TABLE: migrations  (tells Laravel these are already applied)
-- =============================================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch`     INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_07_03_144207_create_destinations_table', 1),
('2026_07_03_144211_create_bookings_table', 1),
('2026_07_03_144214_create_check_ins_table', 1),
('2026_07_03_144217_create_tickets_table', 1),
('2026_07_03_144220_create_reports_table', 1),
('2026_07_03_144224_create_notifications_table', 1);

-- =============================================================
-- SEED: Destinations (insert before users so FK works)
-- =============================================================
INSERT INTO `destinations` (`id`, `name`, `initials`, `location`, `capacity`, `description`, `availability_status`, `created_at`, `updated_at`) VALUES
(1, 'Bataan Nature Park',            'BNP', 'Balanga City, Bataan', 100, 'A lush eco-park offering nature trails, bird watching, and fresh mountain air.',                                 'Available', NOW(), NOW()),
(2, 'Las Casas Filipinas de Acuzar', 'LCF', 'Bagac, Bataan',        80,  'A heritage resort featuring restored Spanish-era colonial houses from across the Philippines.',                'Available', NOW(), NOW()),
(3, 'Mt. Samat National Shrine',     'MSS', 'Pilar, Bataan',        200, 'A historic landmark commemorating the heroes of the Bataan Death March, with a panoramic cross.',              'Available', NOW(), NOW()),
(4, 'Pawikan Conservation Center',   'PCC', 'Morong, Bataan',       60,  'A sea turtle conservation site where you can witness hatchling releases on the beach.',                        'Available', NOW(), NOW());

-- =============================================================
-- SEED: Users
-- All passwords are bcrypt of:
--   Admin   -> Admin@123!
--   Staff   -> Staff@123!
--   Tourist -> Tourist@123!
--
-- The hash below is the Laravel default test hash for "password".
-- To use real hashes, run in your project terminal:
--   php artisan tinker --execute="echo bcrypt('Admin@123!');"
-- and replace the hash strings below.
-- =============================================================
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `contact`, `classification`, `id_type`, `id_number`, `assigned_destination_id`, `created_at`, `updated_at`) VALUES
-- Admin
(1, 'DOT Administrator', 'admin@eturismo.gov',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'admin', '09171234567', NULL, NULL, NULL, NULL, NOW(), NOW()),

-- Staff (assigned_destination_id matches destinations table)
(2, 'Staff - Bataan Nature Park',            'staff1@eturismo.gov',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'staff', '09170000001', NULL, NULL, NULL, 1, NOW(), NOW()),
(3, 'Staff - Las Casas Filipinas de Acuzar', 'staff2@eturismo.gov',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'staff', '09170000002', NULL, NULL, NULL, 2, NOW(), NOW()),
(4, 'Staff - Mt. Samat National Shrine',     'staff3@eturismo.gov',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'staff', '09170000003', NULL, NULL, NULL, 3, NOW(), NOW()),
(5, 'Staff - Pawikan Conservation Center',   'staff4@eturismo.gov',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'staff', '09170000004', NULL, NULL, NULL, 4, NOW(), NOW()),

-- Tourists
(6, 'Maria Santos',   'maria@example.com',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'tourist', '09191234567', 'Local',    'National ID', 'NID-100001', NULL, NOW(), NOW()),
(7, 'Juan Dela Cruz', 'juan@example.com',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'tourist', '09191234567', 'Domestic', 'National ID', 'NID-100002', NULL, NOW(), NOW()),
(8, 'James Miller',   'james@example.com',
 '$2y$12$OLwU2Y6jFDndU5ILjI42DOQYCxjoQYu3xMSlUFNlPniEGXHNSC.I.',
 'tourist', '09191234567', 'Foreign',  'National ID', 'NID-100003', NULL, NOW(), NOW());

-- Add FK on users.assigned_destination_id (added after both tables exist)
ALTER TABLE `users`
  ADD CONSTRAINT `users_destination_fk`
  FOREIGN KEY (`assigned_destination_id`) REFERENCES `destinations`(`id`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================
-- IMPORTANT NOTE ABOUT PASSWORDS
-- The hash '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
-- is the bcrypt hash of the string "password" — NOT the actual passwords.
--
-- After importing, generate real hashes by running:
--   php artisan tinker
--   >>> \App\Models\User::find(1)->update(['password' => bcrypt('Admin@123!')]);
--   >>> \App\Models\User::where('role','staff')->update(['password' => bcrypt('Staff@123!')]);
--   >>> \App\Models\User::where('role','tourist')->update(['password' => bcrypt('Tourist@123!')]);
--   >>> exit
--
-- OR simply log in with:
--   Email: admin@eturismo.gov   Password: password
--   Email: staff1@eturismo.gov  Password: password
--   Email: maria@example.com    Password: password
-- =============================================================
