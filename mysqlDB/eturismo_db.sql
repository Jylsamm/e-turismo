-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2026 at 07:12 AM
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

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `tourist_id`, `destination_id`, `visit_date`, `status`, `decline_reason`, `decided_by_staff_id`, `created_at`, `updated_at`, `gcash_reference_number`, `payment_screenshot_path`, `payment_status`, `rejection_reason`, `payment_submitted_at`, `payment_reviewed_at`, `reviewed_by`, `qr_token`, `qr_generated_at`, `checked_in_at`, `checked_in_by`) VALUES
(61, 1, 5, '2026-07-15', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-15 03:54:00', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000001', '2026-07-14 15:32:36', '2026-07-15 03:54:00', 7),
(62, 2, 5, '2026-07-18', 'declined', 'Payment issue', 7, '2026-07-14 15:32:36', '2026-07-16 00:01:43', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 3, 5, '2026-07-20', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000003', '2026-07-14 15:32:36', NULL, NULL),
(64, 4, 5, '2026-07-23', 'cancelled', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'rejected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 5, 5, '2026-07-17', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000005', '2026-07-14 15:32:36', NULL, NULL),
(66, 6, 5, '2026-07-21', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000006', '2026-07-14 15:32:36', NULL, NULL),
(67, 7, 5, '2026-07-25', 'confirmed', NULL, 7, '2026-07-14 15:32:36', '2026-07-14 08:34:19', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 8, 5, '2026-07-16', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000008', '2026-07-14 15:32:36', NULL, NULL),
(69, 9, 5, '2026-07-27', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000009', '2026-07-14 15:32:36', NULL, NULL),
(70, 10, 5, '2026-07-29', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000010', '2026-07-14 15:32:36', NULL, NULL),
(72, 12, 5, '2026-08-03', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000012', '2026-07-14 15:32:36', NULL, NULL),
(73, 13, 5, '2026-08-05', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000013', '2026-07-14 15:32:36', NULL, NULL),
(74, 14, 5, '2026-08-07', 'cancelled', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'rejected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 15, 5, '2026-08-09', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000015', '2026-07-14 15:32:36', NULL, NULL),
(76, 16, 5, '2026-08-10', 'pending', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 17, 5, '2026-08-12', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000017', '2026-07-14 15:32:36', NULL, NULL),
(78, 18, 5, '2026-08-14', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000018', '2026-07-14 15:32:36', NULL, NULL),
(79, 19, 5, '2026-08-16', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000019', '2026-07-14 15:32:36', NULL, NULL),
(80, 20, 5, '2026-08-18', 'pending', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 21, 5, '2026-08-20', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000021', '2026-07-14 15:32:36', NULL, NULL),
(82, 22, 5, '2026-08-22', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000022', '2026-07-14 15:32:36', NULL, NULL),
(83, 23, 5, '2026-08-24', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000023', '2026-07-14 15:32:36', NULL, NULL),
(84, 24, 5, '2026-08-26', 'cancelled', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'rejected', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 25, 5, '2026-08-28', 'pending', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 26, 5, '2026-08-30', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000026', '2026-07-14 15:32:36', NULL, NULL),
(87, 27, 5, '2026-09-02', 'completed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000027', '2026-07-14 15:32:36', NULL, NULL),
(88, 28, 5, '2026-09-04', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000028', '2026-07-14 15:32:36', NULL, NULL),
(89, 29, 5, '2026-09-06', 'pending', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 30, 5, '2026-09-08', 'confirmed', NULL, NULL, '2026-07-14 15:32:36', '2026-07-14 15:32:36', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'QR000030', '2026-07-14 15:32:36', NULL, NULL),
(91, 2, 5, '2026-07-21', 'confirmed', NULL, 7, '2026-07-14 08:16:24', '2026-07-14 08:19:20', '8042132002937', 'payment_screenshots/TnJzGHnPBicLbPX17N83F8WHAAYb6jueqSKfTxLy.jpg', 'pending_verification', NULL, '2026-07-14 08:19:20', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 10, 5, '2026-07-18', 'confirmed', NULL, 7, '2026-07-16 01:11:55', '2026-07-23 01:12:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LMIFB5R2', '2026-07-23 01:12:02', NULL, NULL),
(93, 10, 5, '2026-07-19', 'confirmed', NULL, 7, '2026-07-16 01:14:40', '2026-07-23 01:02:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LMPRROV7', '2026-07-23 01:02:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('e-turismo-cache-admin_kpis_today', 'a:7:{s:14:\"activeTourists\";i:3;s:15:\"pendingRequests\";i:4;s:14:\"capacityHealth\";d:0;s:7:\"qrScans\";i:0;s:14:\"bookingsHalted\";b:0;s:8:\"pipeline\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:10:{i:0;a:6:{s:2:\"id\";i:93;s:9:\"reference\";s:9:\"#TRB-0093\";s:12:\"tourist_name\";s:22:\"ARNEL L. GABATO GABATO\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-19\";s:6:\"status\";s:9:\"confirmed\";}i:1;a:6:{s:2:\"id\";i:92;s:9:\"reference\";s:9:\"#TRB-0092\";s:12:\"tourist_name\";s:22:\"ARNEL L. GABATO GABATO\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-18\";s:6:\"status\";s:9:\"confirmed\";}i:2;a:6:{s:2:\"id\";i:61;s:9:\"reference\";s:9:\"#TRB-0061\";s:12:\"tourist_name\";s:17:\"TOURISM PERSONNEL\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-15\";s:6:\"status\";s:9:\"completed\";}i:3;a:6:{s:2:\"id\";i:62;s:9:\"reference\";s:9:\"#TRB-0062\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-18\";s:6:\"status\";s:8:\"declined\";}i:4;a:6:{s:2:\"id\";i:63;s:9:\"reference\";s:9:\"#TRB-0063\";s:12:\"tourist_name\";s:7:\"Unknown\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-20\";s:6:\"status\";s:9:\"confirmed\";}i:5;a:6:{s:2:\"id\";i:64;s:9:\"reference\";s:9:\"#TRB-0064\";s:12:\"tourist_name\";s:7:\"Unknown\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-23\";s:6:\"status\";s:9:\"cancelled\";}i:6;a:6:{s:2:\"id\";i:65;s:9:\"reference\";s:9:\"#TRB-0065\";s:12:\"tourist_name\";s:7:\"Unknown\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-17\";s:6:\"status\";s:9:\"completed\";}i:7;a:6:{s:2:\"id\";i:66;s:9:\"reference\";s:9:\"#TRB-0066\";s:12:\"tourist_name\";s:7:\"Unknown\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-21\";s:6:\"status\";s:9:\"confirmed\";}i:8;a:6:{s:2:\"id\";i:67;s:9:\"reference\";s:9:\"#TRB-0067\";s:12:\"tourist_name\";s:8:\"LM Staff\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-25\";s:6:\"status\";s:9:\"confirmed\";}i:9;a:6:{s:2:\"id\";i:68;s:9:\"reference\";s:9:\"#TRB-0068\";s:12:\"tourist_name\";s:7:\"Unknown\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-07-16\";s:6:\"status\";s:9:\"confirmed\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"sparklines\";a:4:{s:14:\"activeTourists\";a:7:{i:0;i:3;i:1;i:3;i:2;i:3;i:3;i:3;i:4;i:3;i:5;i:3;i:6;i:3;}s:15:\"pendingRequests\";a:7:{i:0;i:4;i:1;i:4;i:2;i:4;i:3;i:4;i:4;i:4;i:5;i:4;i:6;i:4;}s:14:\"capacityHealth\";a:7:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:0;i:4;d:0;i:5;d:0;i:6;d:0;}s:7:\"qrScans\";a:7:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;}}}', 1784870184),
('e-turismo-cache-admin_trends_today', 'a:3:{s:6:\"trends\";a:3:{s:10:\"categories\";a:12:{i:0;s:5:\"18:00\";i:1;s:5:\"19:00\";i:2;s:5:\"20:00\";i:3;s:5:\"21:00\";i:4;s:5:\"22:00\";i:5;s:5:\"23:00\";i:6;s:5:\"00:00\";i:7;s:5:\"01:00\";i:8;s:5:\"02:00\";i:9;s:5:\"03:00\";i:10;s:5:\"04:00\";i:11;s:5:\"05:00\";}s:8:\"bookings\";a:12:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;i:9;i:0;i:10;i:0;i:11;i:0;}s:8:\"checkins\";a:12:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;i:9;i:0;i:10;i:0;i:11;i:0;}}s:12:\"demographics\";a:2:{s:6:\"labels\";a:4:{i:0;s:5:\"Local\";i:1;s:8:\"Regional\";i:2;s:8:\"National\";i:3;s:7:\"Foreign\";}s:6:\"values\";a:4:{i:0;i:3;i:1;i:1;i:2;i:0;i:3;i:0;}}s:6:\"status\";a:2:{s:6:\"labels\";a:3:{i:0;s:8:\"Approved\";i:1;s:7:\"Pending\";i:2;s:9:\"Cancelled\";}s:6:\"values\";a:3:{i:0;i:0;i:1;i:4;i:2;i:3;}}}', 1784870183),
('e-turismo-cache-registration-otp-send:::1', 'i:1;', 1784800009),
('e-turismo-cache-registration-otp-send:::1:timer', 'i:1784800009;', 1784800009);

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
  `checkin_latitude` decimal(10,6) DEFAULT NULL,
  `checkin_longitude` decimal(10,6) DEFAULT NULL,
  `checkin_radius` int(11) NOT NULL DEFAULT 100,
  `last_updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `initials`, `location`, `capacity`, `description`, `photos`, `availability_status`, `checkin_latitude`, `checkin_longitude`, `checkin_radius`, `last_updated_by`, `created_at`, `updated_at`) VALUES
(5, 'Lake Maragang', 'LM', '7043, Limas, Tigbao, Zamboanga del Sur, Philippines', 100, NULL, NULL, 'Available', 7.819258, 123.288880, 100, 'STAFF', '2026-07-06 00:18:42', '2026-07-19 02:24:22'),
(6, 'Timberland', 'TIM', 'TBD', 100, NULL, NULL, 'Available', NULL, NULL, 100, NULL, '2026-07-23 01:32:00', '2026-07-23 01:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `destination_images`
--

CREATE TABLE `destination_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(15, '2026_07_09_183710_add_contact_and_name_fields_to_users_table', 7),
(16, '2026_07_13_000001_add_processing_status_to_users_table', 8),
(17, '2026_07_13_161030_add_suffix_to_users_table', 9),
(18, '2026_07_14_145034_create_destination_images_table', 10),
(19, '2026_07_14_165523_create_walk_ins_table', 11),
(20, '2026_07_15_000001_add_checkin_coords_to_destinations_table', 12),
(21, '2026_07_15_000002_add_checkin_radius_to_destinations_table', 13),
(22, '2026_07_15_000003_add_last_updated_by_to_destinations_table', 14),
(23, '2026_07_15_000004_add_duration_days_to_walk_ins_table', 15),
(24, '2026_07_15_000005_add_performance_indexes_to_tables', 16),
(25, '2026_07_15_173441_create_sessions_table', 17),
(26, '2026_07_16_062016_repair_failed_jobs_table', 18),
(27, '2026_07_19_154513_add_gender_to_users_and_walk_ins', 19);

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

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient_id`, `recipient_type`, `type`, `message`, `related_booking_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-18 has been CONFIRMED! Your QR ticket code is: LM976695.', 62, 1, '2026-07-14 07:49:37', '2026-07-14 08:13:55'),
(2, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM for Lake Maragang on 2026-07-21.', 91, 1, '2026-07-14 08:16:24', '2026-07-15 06:35:11'),
(3, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-21 has been CONFIRMED! Your QR ticket code is: LM666744.', 91, 1, '2026-07-14 08:17:32', '2026-07-15 10:53:05'),
(4, 7, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-25 has been CONFIRMED! Your QR ticket code is: LM781432.', 67, 1, '2026-07-14 08:34:19', '2026-07-15 06:35:09'),
(5, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-18 has been DECLINED. Reason: ', 62, 0, '2026-07-16 00:01:43', '2026-07-16 00:01:43'),
(6, 7, 'staff', 'booking_alert', 'New booking request from ARNEL L. GABATO for Lake Maragang on 2026-07-18.', 92, 1, '2026-07-16 01:11:55', '2026-07-17 23:49:49'),
(7, 7, 'staff', 'booking_alert', 'New booking request from ARNEL L. GABATO for Lake Maragang on 2026-07-19.', 93, 1, '2026-07-16 01:14:40', '2026-07-17 23:49:47'),
(8, 10, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-19 has been CONFIRMED! Your QR ticket code is: LMPRROV7.', 93, 0, '2026-07-23 01:02:21', '2026-07-23 01:02:21'),
(9, 10, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-18 has been CONFIRMED! Your QR ticket code is: LMIFB5R2.', 92, 0, '2026-07-23 01:12:03', '2026-07-23 01:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('jylsam123@gmail.com', '$2y$12$neYYLbbmY.Mr7QbU43HJR.TDry1wOwClGA5NJ.dhtWepoefmLuu6K', '2026-07-15 22:54:14');

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

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `generated_by_admin_id`, `destination_id`, `type`, `date_from`, `date_to`, `total_visitors`, `total_bookings`, `confirmed_bookings`, `declined_bookings`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'monthly', '2026-07-01', '2026-07-16', 0, 2, 2, 0, '2026-07-15 23:54:41', '2026-07-15 23:54:41'),
(2, 1, NULL, 'monthly', '2026-07-01', '2026-07-19', 0, 6, 3, 1, '2026-07-19 06:33:43', '2026-07-19 06:33:43'),
(3, 1, NULL, 'monthly', '2026-07-01', '2026-07-23', 0, 10, 8, 1, '2026-07-23 02:50:50', '2026-07-23 02:50:50'),
(4, 1, 5, 'monthly', '2026-07-01', '2026-07-23', 0, 10, 8, 1, '2026-07-23 03:55:04', '2026-07-23 03:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('64NDXiSjZbqcE7caNGFXSykHUvOcajq7Q2uNUNCW', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNjlsOTlUcHNaZHBRYllBZFRxVUxnTmxMM2NBWFlNSGFiRVNGUDA2MCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9sb2NhbGhvc3QvZS10dXJpc21vL3B1YmxpYy9ub3RpZmljYXRpb25zL2xhdGVzdC1hbGVydCI7czo1OiJyb3V0ZSI7czoyNjoibm90aWZpY2F0aW9ucy5sYXRlc3QtYWxlcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1784869950),
('GVCyGBxxDmVGMY4v3QZDmfCKCqz2eRZHpIPtahhT', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXpwSWlpcTN6dVI4eGI2YmFDTnVzQ09rdkoyRzNGTHdZdVl3U1prZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvZS10dXJpc21vL3B1YmxpYyI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784869799),
('pP4hfJyTK3C3eJ00paDZuNduD32g0g46eAMlw0ty', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicG42S1BFM3pIZG5Ca2JrS0x4bzB5ZFZsSE03WTZCR2x3VEhzV0hyUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly9sb2NhbGhvc3QvZS10dXJpc21vL3B1YmxpYy9ub3RpZmljYXRpb25zL2xhdGVzdC1hbGVydCI7czo1OiJyb3V0ZSI7czoyNjoibm90aWZpY2F0aW9ucy5sYXRlc3QtYWxlcnQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1784811571),
('WV76bp3D9zF4S2NtUcwivqHVMfkcLUjEQ4A2Bxle', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVZwdWdxdTZzOTdyTmh4TldQWURzZ0FTYm5hbkRzMHU3MjZqbEdBdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MToiaHR0cDovL2xvY2FsaG9zdC9lLXR1cmlzbW8vcHVibGljL2FkbWluL3ZlcmlmaWNhdGlvbnMvcmV2aWV3cyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjYxOiJodHRwOi8vbG9jYWxob3N0L2UtdHVyaXNtby9wdWJsaWMvYWRtaW4vdmVyaWZpY2F0aW9ucy9yZXZpZXdzIjtzOjU6InJvdXRlIjtzOjIwOiJ2ZXJpZmljYXRpb24ucmV2aWV3cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784803720);

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

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `booking_id`, `qr_code`, `scanned_at`, `created_at`, `updated_at`) VALUES
(1, 62, 'LM976695', NULL, '2026-07-14 07:49:37', '2026-07-14 07:49:37'),
(2, 91, 'LM666744', NULL, '2026-07-14 08:17:32', '2026-07-14 08:17:32'),
(3, 67, 'LM781432', NULL, '2026-07-14 08:34:19', '2026-07-14 08:34:19'),
(4, 93, 'LMPRROV7', NULL, '2026-07-23 01:02:15', '2026-07-23 01:02:15'),
(5, 92, 'LMIFB5R2', NULL, '2026-07-23 01:12:02', '2026-07-23 01:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
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
  `id_verification_status` varchar(20) NOT NULL DEFAULT 'unverified',
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

INSERT INTO `users` (`id`, `name`, `last_name`, `suffix`, `gender`, `middle_initial`, `dob`, `email`, `email_verified_at`, `password`, `role`, `contact`, `classification`, `id_type`, `id_number`, `id_photo`, `is_manually_verified`, `id_verification_status`, `ready_to_complete_requirements`, `id_verification_score`, `id_verification_notes`, `id_verified_at`, `assigned_destination_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'TOURISM', 'PERSONNEL', NULL, NULL, NULL, '2026-07-01', 'admin@eturismo.com', '2026-07-05 01:50:56', '$2y$12$CHN284cR51/Uujjqi21FH.kVn0Doli2ellYVxicNhKyMYRcWOeK0.', 'admin', NULL, 'Local', NULL, NULL, NULL, 0, 'verified', 0, NULL, NULL, '2026-07-05 01:53:24', NULL, 'opxAs6HUGl0RLLWx0gua1UbaWO99QzFC69LCTsVMghlJnMUEwvhNgqu417Ci', '2026-07-05 01:49:29', '2026-07-05 01:53:24'),
(2, 'JYLSAM', 'QUIROG', NULL, NULL, 'M.', '2004-12-10', 'jylsam123@gmail.com', '2026-07-05 04:50:47', '$2y$12$p5WPmZI4RMZr4WeTXZFYzuN96UkvHlv91P8IVFPcHSVoRfA91KfVq', 'tourist', NULL, 'Local', 'School ID', '2022-041633', 'id_photos/1783245704_2d6ed43b-f01e-47ce-b616-8910397fa53c.jpg', 0, 'verified', 1, 100.00, 'Name match: 100% (found) | ID Number: 100% (found) | DOB: Skipped — this ID type does not print a date of birth', '2026-07-05 05:23:04', NULL, 'piGnVauXVQESkqL2aOjSplYmnj4cKZ4eRopxftzWJqeVl9eX3TCNCBsWLlyz', '2026-07-05 02:01:46', '2026-07-15 22:25:01'),
(7, 'LM', 'Staff', NULL, NULL, NULL, '2026-07-01', 'teststaff@gmail.com', '2026-07-09 18:44:01', '$2y$12$uFeKOW4ZUwyjtFcQPx7bWeJg3hFeWRVfKUtc6DwO.KkjAFywlaZ0y', 'staff', '1234567890', NULL, NULL, NULL, NULL, 1, 'verified', 0, 100.00, 'Status manually updated by Admin.', '2026-07-09 10:39:55', 5, 'WxOzKwNhr28JLUle373Ugx5vG9hA8j3zMAiX0ZdFv7AB7aRbBASJl49OIAX5', '2026-07-09 10:38:11', '2026-07-23 02:27:35'),
(9, 'DANRYL JAMES B. B. USA', 'USA', NULL, NULL, 'B.', '2005-01-02', 'danrylboncales@gmail.com', '2026-07-15 23:45:40', '$2y$12$czH4QQK1HpST4kGLRjj6kekYx26Etcw1m.ZcE1oDVhsAzkLv9GlDS', 'tourist', NULL, 'Local', 'School ID', '2022-044712', 'id_photos/1784188211_captured_id_1784188206570.jpg', 1, 'verified', 1, 31.17, 'Status manually updated by Admin.', '2026-07-16 00:59:14', NULL, NULL, '2026-07-15 23:45:40', '2026-07-16 00:59:14'),
(10, 'ARNEL L. GABATO', 'GABATO', NULL, NULL, 'L.', '1978-04-15', 'tigbaotourismoffice@gmail.com', '2026-07-16 01:00:49', '$2y$12$83RWCjm6h1HJkkxV2wMllOv4.pd6HmAykWHvMAl5KgGb/9xLOY0om', 'tourist', NULL, 'Local', 'Company ID', '097344000-000-0559', 'id_photos/1784192449_id_composite_1784192412378.jpg', 1, 'verified', 1, 79.75, 'Status manually updated by Admin.', '2026-07-16 01:01:27', NULL, NULL, '2026-07-16 01:00:50', '2026-07-16 01:01:27'),
(12, 'TM', 'Staff', NULL, NULL, NULL, NULL, 'cevibill@gmail.com', '2026-07-23 01:39:08', '$2y$12$19QuFBeDnHzaUYr.s/.1Dekjs4xVKTXCEiE3pwC1nmePguIFInB6m', 'staff', '09386616553', NULL, NULL, NULL, NULL, 0, 'verified', 0, 100.00, NULL, '2026-07-23 01:39:08', 6, NULL, '2026-07-23 01:39:08', '2026-07-23 02:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `walk_ins`
--

CREATE TABLE `walk_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `classification` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `duration_days` int(11) NOT NULL DEFAULT 1,
  `registered_by_staff_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `walk_ins`
--

INSERT INTO `walk_ins` (`id`, `destination_id`, `name`, `age`, `contact_number`, `email`, `classification`, `gender`, `duration_days`, `registered_by_staff_id`, `created_at`, `updated_at`) VALUES
(1, 5, 'kent', 15, NULL, NULL, 'Local', NULL, 1, 7, '2026-07-14 23:36:18', '2026-07-14 23:36:18');

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
  ADD KEY `bookings_checked_in_by_foreign` (`checked_in_by`),
  ADD KEY `bookings_destination_visit_status_index` (`destination_id`,`visit_date`,`status`),
  ADD KEY `bookings_status_visit_created_index` (`status`,`visit_date`,`created_at`),
  ADD KEY `bookings_tourist_status_index` (`tourist_id`,`status`);

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
  ADD KEY `checkins_staff_fk` (`verified_by_staff_id`),
  ADD KEY `check_ins_booking_arrival_index` (`booking_id`,`arrival_time`),
  ADD KEY `check_ins_arrival_time_index` (`arrival_time`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_images_destination_id_foreign` (`destination_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
  ADD KEY `users_destination_fk` (`assigned_destination_id`),
  ADD KEY `users_role_assigned_destination_index` (`role`,`assigned_destination_id`);

--
-- Indexes for table `walk_ins`
--
ALTER TABLE `walk_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `walk_ins_destination_visit_date_index` (`destination_id`,`created_at`),
  ADD KEY `walk_ins_staff_created_index` (`registered_by_staff_id`,`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destination_images`
--
ALTER TABLE `destination_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `walk_ins`
--
ALTER TABLE `walk_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `destination_images`
--
ALTER TABLE `destination_images`
  ADD CONSTRAINT `destination_images_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

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

--
-- Constraints for table `walk_ins`
--
ALTER TABLE `walk_ins`
  ADD CONSTRAINT `walk_ins_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `walk_ins_registered_by_staff_id_foreign` FOREIGN KEY (`registered_by_staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
