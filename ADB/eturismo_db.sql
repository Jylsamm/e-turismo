-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 09:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eturismo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tourist_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `visit_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `decline_reason` text DEFAULT NULL,
  `decided_by_staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gcash_reference_number` varchar(255) DEFAULT NULL,
  `payment_screenshot_path` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `payment_submitted_at` timestamp NULL DEFAULT NULL,
  `payment_reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `qr_generated_at` timestamp NULL DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_in_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_ins`
--

CREATE TABLE `check_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `arrival_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_by_staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occupancy_updated` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `initials` varchar(10) NOT NULL,
  `location` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `photos` text DEFAULT NULL,
  `availability_status` varchar(255) NOT NULL DEFAULT 'Available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `initials`, `location`, `capacity`, `description`, `photos`, `availability_status`, `created_at`, `updated_at`) VALUES
(5, 'Lake Maragang', 'LM', 'Limas, Tigbao, Zamboanga del Sur', 100, NULL, NULL, 'Available', '2026-07-06 00:18:42', '2026-07-06 00:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_03_144207_create_destinations_table', 1),
(5, '2026_07_03_144211_create_bookings_table', 1),
(6, '2026_07_03_144214_create_check_ins_table', 1),
(7, '2026_07_03_144217_create_tickets_table', 1),
(8, '2026_07_03_144220_create_reports_table', 1),
(9, '2026_07_03_144224_create_notifications_table', 1),
(10, '2026_07_04_000001_add_verification_fields_to_users_table', 2),
(11, '2026_07_04_000002_add_ready_to_complete_requirements_to_users_table', 3),
(12, '2026_07_05_000001_add_dob_to_users_table', 4),
(13, '2026_07_06_000001_add_is_manually_verified_to_users_table', 5),
(14, '2026_07_09_175237_add_gcash_and_qr_fields_to_bookings_table', 6),
(15, '2026_07_09_183710_add_contact_and_name_fields_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_type` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `related_booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `generated_by_admin_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('daily','weekly','monthly') NOT NULL DEFAULT 'monthly',
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `total_visitors` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_bookings` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `confirmed_bookings` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `declined_bookings` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `scanned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_initial` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'tourist',
  `contact` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `id_photo` varchar(255) DEFAULT NULL,
  `is_manually_verified` tinyint(1) NOT NULL DEFAULT 0,
  `id_verification_status` enum('unverified','pending','verified','rejected') NOT NULL DEFAULT 'unverified',
  `ready_to_complete_requirements` tinyint(1) NOT NULL DEFAULT 0,
  `id_verification_score` decimal(5,2) DEFAULT NULL,
  `id_verification_notes` text DEFAULT NULL,
  `id_verified_at` timestamp NULL DEFAULT NULL,
  `assigned_destination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `middle_initial`, `dob`, `email`, `email_verified_at`, `password`, `role`, `contact`, `classification`, `id_type`, `id_number`, `id_photo`, `is_manually_verified`, `id_verification_status`, `ready_to_complete_requirements`, `id_verification_score`, `id_verification_notes`, `id_verified_at`, `assigned_destination_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, NULL, NULL, 'admin2@eturismo.gov', '2026-07-05 01:50:56', '$2y$12$lYVgCSi48kAQPVW9ax4w1eqIU7R3mXqnwS2pHTUVx8Ld7sXTxiDsi', 'admin', NULL, NULL, NULL, NULL, NULL, 0, 'verified', 0, NULL, NULL, '2026-07-05 01:53:24', NULL, NULL, '2026-07-05 01:49:29', '2026-07-05 01:53:24'),
(2, 'jylsam M. quirog', 'quirog', 'M.', '2004-12-10', 'jylsam123@gmail.com', '2026-07-05 04:50:47', '$2y$12$sXrf8ia6DKfHaswMeD3hBuPIkJUFcWXCYF9.8QPMTCgipeKeWgbtm', 'tourist', NULL, 'Local', 'School ID', '2022-041633', 'id_photos/1783245704_2d6ed43b-f01e-47ce-b616-8910397fa53c.jpg', 0, 'verified', 1, 100.00, 'Name match: 100% (found) | ID Number: 100% (found) | DOB: Skipped — this ID type does not print a date of birth', '2026-07-05 05:23:04', NULL, NULL, '2026-07-05 02:01:46', '2026-07-05 05:23:04'),
(4, 'Glowen Tanaman', 'Tanaman', NULL, '2005-09-22', 'glowentanamanmil08@gmail.com', '2026-07-05 23:46:06', '$2y$12$4zFMvfaGSg5/CU.xrG/Rj.abtHM3Nax0kzd0dXqyGjmaUrefV.sna', 'tourist', NULL, 'Local', 'Driver\'s License', 'J03-22-301233', 'id_photos/1783323689_id_composite_1783323641703.jpg', 0, 'verified', 1, 100.00, 'Name match: 100% (found) | ID Number: 100% (found) | DOB: Found', '2026-07-05 23:41:44', NULL, '4aQi1tEX9AlwLxpUmnDrvvhASbckp24ZM67bcwlLWvN9Xyz93yjxYLnDC7Du', '2026-07-05 23:41:31', '2026-07-05 23:46:06'),
(5, 'Glowen Tanaman', 'Tanaman', NULL, '1992-11-06', 'boncalesdanryljames@gmail.com', '2026-07-06 00:05:14', '$2y$12$K0VGFrOwOZEVaNxheKexwu/7w6tH6gUbjwi/VLILxxzAlMV2KCf16', 'tourist', NULL, 'Local', 'Driver\'s License', 'J03-22-44472', 'id_photos/1783324327_id_composite_1783324281097.jpg', 0, 'rejected', 1, 0.00, 'Name match: 0% (not found) | ID Number: 0% (not found) | DOB: Not Found', NULL, NULL, NULL, '2026-07-05 23:52:09', '2026-07-06 00:05:14'),
(6, 'Danryl James B. Usa', 'James', 'B.', '2000-03-03', 'danrylboncales@gmail.com', '2026-07-06 00:13:46', '$2y$12$RGIFzF733qEbs3chewbBBu2.mWCmTNxnCv7WLNQ0gH6MRjzVDO7xq', 'tourist', NULL, 'Local', 'School ID', 'J.H. Cerilles State College', 'id_photos/1783325566_id_composite_1783325552302.jpg', 0, 'rejected', 1, 0.00, 'OCR_READ_ERROR: Photo is too blurry, dark, or unsupported format.', NULL, NULL, NULL, '2026-07-06 00:12:47', '2026-07-06 00:15:26'),
(7, 'jylsam quirog', 'quirog', NULL, NULL, 'staff1@eturismo.gov', '2026-07-09 18:44:01', '$2y$12$uFeKOW4ZUwyjtFcQPx7bWeJg3hFeWRVfKUtc6DwO.KkjAFywlaZ0y', 'staff', '09854754736', NULL, NULL, NULL, NULL, 1, 'verified', 0, 100.00, 'Status manually updated by Admin.', '2026-07-09 10:39:55', 5, NULL, '2026-07-09 10:38:11', '2026-07-09 10:39:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_qr_token_unique` (`qr_token`),
  ADD KEY `bookings_tourist_fk` (`tourist_id`),
  ADD KEY `bookings_destination_fk` (`destination_id`),
  ADD KEY `bookings_staff_fk` (`decided_by_staff_id`),
  ADD KEY `bookings_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `bookings_checked_in_by_foreign` (`checked_in_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkins_booking_fk` (`booking_id`),
  ADD KEY `checkins_staff_fk` (`verified_by_staff_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_recipient_fk` (`recipient_id`),
  ADD KEY `notifications_booking_fk` (`related_booking_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_admin_fk` (`generated_by_admin_id`),
  ADD KEY `reports_destination_fk` (`destination_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_qr_code_unique` (`qr_code`),
  ADD KEY `tickets_booking_fk` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_destination_fk` (`assigned_destination_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_checked_in_by_foreign` FOREIGN KEY (`checked_in_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_destination_fk` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_staff_fk` FOREIGN KEY (`decided_by_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_tourist_fk` FOREIGN KEY (`tourist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `checkins_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkins_staff_fk` FOREIGN KEY (`verified_by_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_booking_fk` FOREIGN KEY (`related_booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_recipient_fk` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_admin_fk` FOREIGN KEY (`generated_by_admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_destination_fk` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_destination_fk` FOREIGN KEY (`assigned_destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
