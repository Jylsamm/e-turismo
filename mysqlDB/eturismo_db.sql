-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2026 at 07:57 PM
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
  `duration_days` int(11) NOT NULL DEFAULT 1,
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

INSERT INTO `bookings` (`id`, `tourist_id`, `destination_id`, `visit_date`, `duration_days`, `status`, `decline_reason`, `decided_by_staff_id`, `created_at`, `updated_at`, `gcash_reference_number`, `payment_screenshot_path`, `payment_status`, `rejection_reason`, `payment_submitted_at`, `payment_reviewed_at`, `reviewed_by`, `qr_token`, `qr_generated_at`, `checked_in_at`, `checked_in_by`) VALUES
(1, 2, 5, '2026-08-11', 1, 'confirmed', NULL, 7, '2026-08-09 23:29:03', '2026-08-12 04:30:42', NULL, NULL, 'approved', NULL, NULL, NULL, NULL, 'LMAHMCCK', '2026-08-12 04:30:42', NULL, NULL),
(2, 2, 5, '2026-08-11', 1, 'completed', NULL, 7, '2026-08-09 23:29:08', '2026-08-13 07:08:51', '522352344', 'payment_screenshots/DZ39zGOo7ICoyO1DPYslNggne4qdLzvsJF2HloJY.png', 'approved', NULL, '2026-08-09 23:30:58', NULL, NULL, 'LMAYN5HH', '2026-08-09 23:35:35', '2026-08-13 07:08:51', 7),
(3, 2, 5, '2026-08-17', 2, 'cancelled', 'Cancelled by tourist', 7, '2026-08-13 07:01:09', '2026-08-16 07:47:58', '964645464', 'payment_screenshots/x3RHzcLVzwSTPiSDufVAzyuOYkx6QRrJky2jQHd8.jpg', 'refund_pending', NULL, '2026-08-13 07:01:43', NULL, NULL, NULL, '2026-08-13 07:02:46', NULL, NULL),
(4, 2, 5, '2026-08-24', 5, 'cancelled', 'Cancelled by tourist', NULL, '2026-08-16 07:05:33', '2026-08-16 07:23:18', NULL, NULL, 'not_charged', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 5, '2026-08-19', 1, 'cancelled', 'Cancelled by tourist', NULL, '2026-08-16 08:04:53', '2026-08-16 08:09:27', NULL, NULL, 'not_charged', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, 5, '2026-08-25', 1, 'pending', NULL, NULL, '2026-08-16 08:10:27', '2026-08-16 08:10:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booking_companions`
--

CREATE TABLE `booking_companions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `classification` varchar(255) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_companions`
--

INSERT INTO `booking_companions` (`id`, `booking_id`, `name`, `age`, `gender`, `contact_number`, `email`, `classification`, `duration_days`, `created_at`, `updated_at`) VALUES
(1, 1, 'sadasda', 23, 'Male', NULL, NULL, 'Local', 1, '2026-08-09 23:29:03', '2026-08-09 23:29:03'),
(2, 2, 'sadasda', 23, 'Male', NULL, NULL, 'Local', 1, '2026-08-09 23:29:08', '2026-08-09 23:29:08'),
(3, 3, 'JYLSAM QUIROG', 21, 'Male', NULL, 'jylsam123@gmail.com', 'Local', 2, '2026-08-13 07:01:09', '2026-08-13 07:01:09'),
(4, 3, 'Glowen Tanaman', 12, 'Male', '09386616553', NULL, 'Local', 2, '2026-08-13 07:01:09', '2026-08-13 07:01:09'),
(5, 4, 'JYLSAM QUIROG', 21, 'Male', NULL, 'jylsam123@gmail.com', 'Local', 5, '2026-08-16 07:05:33', '2026-08-16 07:05:33'),
(6, 5, 'JYLSAM QUIROG', 21, 'Male', NULL, 'jylsam123@gmail.com', 'Local', 1, '2026-08-16 08:04:53', '2026-08-16 08:04:53'),
(7, 6, 'JYLSAM QUIROG', 21, 'Male', '09723462733', 'jylsam123@gmail.com', 'Local', 1, '2026-08-16 08:10:27', '2026-08-16 08:10:27');

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
('e-turismo-cache-admin_advanced_today', 'a:2:{s:6:\"gauges\";a:2:{i:0;a:2:{s:4:\"name\";s:13:\"Lake Maragang\";s:10:\"percentage\";d:0;}i:1;a:2:{s:4:\"name\";s:10:\"Timberland\";s:10:\"percentage\";d:0;}}s:7:\"heatmap\";a:7:{i:0;a:2:{s:4:\"name\";s:6:\"Monday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:1;a:2:{s:4:\"name\";s:7:\"Tuesday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:2;a:2:{s:4:\"name\";s:9:\"Wednesday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:1;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:3;a:2:{s:4:\"name\";s:8:\"Thursday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:2;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:4;a:2:{s:4:\"name\";s:6:\"Friday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:5;a:2:{s:4:\"name\";s:8:\"Saturday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}i:6;a:2:{s:4:\"name\";s:6:\"Sunday\";s:4:\"data\";a:5:{i:0;a:2:{s:1:\"x\";s:5:\"08:00\";s:1:\"y\";i:0;}i:1;a:2:{s:1:\"x\";s:5:\"10:00\";s:1:\"y\";i:0;}i:2;a:2:{s:1:\"x\";s:5:\"12:00\";s:1:\"y\";i:0;}i:3;a:2:{s:1:\"x\";s:5:\"14:00\";s:1:\"y\";i:0;}i:4;a:2:{s:1:\"x\";s:5:\"16:00\";s:1:\"y\";i:0;}}}}}', 1786900972),
('e-turismo-cache-admin_kpis_today', 'a:7:{s:14:\"activeTourists\";i:3;s:15:\"pendingRequests\";i:1;s:14:\"capacityHealth\";d:0;s:7:\"qrScans\";i:0;s:14:\"bookingsHalted\";b:0;s:8:\"pipeline\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;a:6:{s:2:\"id\";i:6;s:9:\"reference\";s:9:\"#TRB-0006\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-25\";s:6:\"status\";s:7:\"pending\";}i:1;a:6:{s:2:\"id\";i:5;s:9:\"reference\";s:9:\"#TRB-0005\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-19\";s:6:\"status\";s:9:\"cancelled\";}i:2;a:6:{s:2:\"id\";i:4;s:9:\"reference\";s:9:\"#TRB-0004\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-24\";s:6:\"status\";s:9:\"cancelled\";}i:3;a:6:{s:2:\"id\";i:3;s:9:\"reference\";s:9:\"#TRB-0003\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-17\";s:6:\"status\";s:9:\"cancelled\";}i:4;a:6:{s:2:\"id\";i:2;s:9:\"reference\";s:9:\"#TRB-0002\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-11\";s:6:\"status\";s:9:\"completed\";}i:5;a:6:{s:2:\"id\";i:1;s:9:\"reference\";s:9:\"#TRB-0001\";s:12:\"tourist_name\";s:13:\"JYLSAM QUIROG\";s:16:\"destination_name\";s:13:\"Lake Maragang\";s:10:\"visit_date\";s:10:\"2026-08-11\";s:6:\"status\";s:9:\"confirmed\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"sparklines\";a:4:{s:14:\"activeTourists\";a:7:{i:0;i:3;i:1;i:3;i:2;i:3;i:3;i:3;i:4;i:3;i:5;i:3;i:6;i:3;}s:15:\"pendingRequests\";a:7:{i:0;i:1;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:1;i:5;i:1;i:6;i:1;}s:14:\"capacityHealth\";a:7:{i:0;d:0;i:1;d:0;i:2;d:0;i:3;d:1;i:4;d:0;i:5;d:0;i:6;d:0;}s:7:\"qrScans\";a:7:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;}}}', 1786900972),
('e-turismo-cache-admin_trends_today', 'a:3:{s:6:\"trends\";a:3:{s:10:\"categories\";a:12:{i:0;s:5:\"06:00\";i:1;s:5:\"07:00\";i:2;s:5:\"08:00\";i:3;s:5:\"09:00\";i:4;s:5:\"10:00\";i:5;s:5:\"11:00\";i:6;s:5:\"12:00\";i:7;s:5:\"13:00\";i:8;s:5:\"14:00\";i:9;s:5:\"15:00\";i:10;s:5:\"16:00\";i:11;s:5:\"17:00\";}s:8:\"bookings\";a:12:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;i:9;i:1;i:10;i:2;i:11;i:0;}s:8:\"checkins\";a:12:{i:0;i:0;i:1;i:0;i:2;i:0;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:0;i:9;i:0;i:10;i:0;i:11;i:0;}}s:12:\"demographics\";a:2:{s:6:\"labels\";a:4:{i:0;s:5:\"Local\";i:1;s:8:\"Regional\";i:2;s:8:\"National\";i:3;s:7:\"Foreign\";}s:6:\"values\";a:4:{i:0;i:5;i:1;i:1;i:2;i:0;i:3;i:0;}}s:6:\"status\";a:2:{s:6:\"labels\";a:3:{i:0;s:8:\"Approved\";i:1;s:7:\"Pending\";i:2;s:9:\"Cancelled\";}s:6:\"values\";a:3:{i:0;i:0;i:1;i:1;i:2;i:3;}}}', 1786900972),
('e-turismo-cache-dest_month_avail_5_2026-08', 'a:31:{s:10:\"2026-08-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-11\";a:4:{s:5:\"slots\";i:98;s:6:\"booked\";i:2;s:3:\"pct\";d:2;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-31\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786902962),
('e-turismo-cache-dest_month_avail_5_2026-09', 'a:30:{s:10:\"2026-09-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-11\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786902962),
('e-turismo-cache-dest_month_avail_5_2026-10', 'a:31:{s:10:\"2026-10-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-11\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-10-31\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786895657),
('e-turismo-cache-dest_month_avail_5_2026-11', 'a:30:{s:10:\"2026-11-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-11\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-11-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786895658),
('e-turismo-cache-dest_month_avail_6_2026-08', 'a:31:{s:10:\"2026-08-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-11\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-08-31\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786896583),
('e-turismo-cache-dest_month_avail_6_2026-09', 'a:30:{s:10:\"2026-09-01\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-02\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-03\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-04\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-05\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-06\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-07\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-08\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-09\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-10\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-11\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-12\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-13\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-14\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-15\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-16\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-17\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-18\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-19\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-20\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-21\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-22\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-23\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-24\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-25\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-26\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-27\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-28\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-29\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}s:10:\"2026-09-30\";a:4:{s:5:\"slots\";i:100;s:6:\"booked\";i:0;s:3:\"pct\";d:0;s:6:\"status\";s:4:\"open\";}}', 1786896583);

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
(5, 'Lake Maragang', 'LM', '7043, Limas, Tigbao, Zamboanga del Sur, Philippines', 100, NULL, 'destination_photos/P75VQmPME54tYdtOieHm5OeJM0cG3jprVUa5hMla.jpg', 'Available', 7.819258, 123.288880, 100, 'STAFF', '2026-07-06 00:18:42', '2026-07-26 10:46:25'),
(6, 'Timberland', 'TIM', 'Purok 4, Poblacion, Timolan, Zamboanga del Sur', 100, NULL, 'destination_photos/YAW4q7rNZkVciczsa8w0Mjo7jQQbBBmlBf1sIzF7.jpg', 'Available', 7.813524, 123.238931, 100, 'TM', '2026-07-23 01:32:00', '2026-07-26 10:39:57');

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

--
-- Dumping data for table `destination_images`
--

INSERT INTO `destination_images` (`id`, `destination_id`, `path`, `is_primary`, `created_at`, `updated_at`) VALUES
(7, 6, 'destination_photos/YAW4q7rNZkVciczsa8w0Mjo7jQQbBBmlBf1sIzF7.jpg', 1, '2026-07-26 10:39:57', '2026-07-26 10:39:57'),
(8, 5, 'destination_photos/P75VQmPME54tYdtOieHm5OeJM0cG3jprVUa5hMla.jpg', 1, '2026-07-26 10:46:25', '2026-07-26 10:46:25');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(12, 'default', '{\"uuid\":\"6a6c52a9-9324-47a2-9df0-94173a414d40\",\"displayName\":\"App\\\\Jobs\\\\SendBookingNotificationJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendBookingNotificationJob\",\"command\":\"O:35:\\\"App\\\\Jobs\\\\SendBookingNotificationJob\\\":5:{s:12:\\\"recipientIds\\\";a:1:{i:0;i:2;}s:13:\\\"recipientType\\\";s:7:\\\"tourist\\\";s:4:\\\"type\\\";s:13:\\\"booking_alert\\\";s:7:\\\"message\\\";s:98:\\\"Your booking for Lake Maragang on 2026-08-17 has been CONFIRMED! Your QR ticket code is: LMXVF8HZ.\\\";s:16:\\\"relatedBookingId\\\";i:3;}\",\"batchId\":null},\"createdAt\":1786633366,\"delay\":null}', 0, NULL, 1786633366, 1786633366);

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
(27, '2026_07_19_154513_add_gender_to_users_and_walk_ins', 19),
(28, '2026_07_25_000001_update_id_verification_status_enum', 20),
(29, '2026_07_25_021450_add_duration_days_to_bookings_table', 20),
(30, '2026_07_27_000001_create_booking_companions_table', 20);

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
(5, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-18 has been DECLINED. Reason: ', 62, 1, '2026-07-16 00:01:43', '2026-07-26 11:36:09'),
(6, 7, 'staff', 'booking_alert', 'New booking request from ARNEL L. GABATO for Lake Maragang on 2026-07-18.', 92, 1, '2026-07-16 01:11:55', '2026-07-17 23:49:49'),
(7, 7, 'staff', 'booking_alert', 'New booking request from ARNEL L. GABATO for Lake Maragang on 2026-07-19.', 93, 1, '2026-07-16 01:14:40', '2026-07-17 23:49:47'),
(8, 10, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-19 has been CONFIRMED! Your QR ticket code is: LMPRROV7.', 93, 0, '2026-07-23 01:02:21', '2026-07-23 01:02:21'),
(9, 10, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-07-18 has been CONFIRMED! Your QR ticket code is: LMIFB5R2.', 92, 0, '2026-07-23 01:12:03', '2026-07-23 01:12:03'),
(10, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 2) for Lake Maragang on 2026-08-11.', 2, 1, '2026-08-09 23:29:08', '2026-08-12 04:52:44'),
(11, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 2) for Lake Maragang on 2026-08-11.', 1, 1, '2026-08-09 23:29:08', '2026-08-12 04:52:46'),
(12, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-08-11 has been CONFIRMED! Your QR ticket code is: LMAYN5HH.', 2, 1, '2026-08-09 23:35:35', '2026-08-12 06:31:46'),
(13, 2, 'tourist', 'booking_alert', 'Your booking for Lake Maragang on 2026-08-11 has been CONFIRMED! Your QR ticket code is: LMAHMCCK.', 1, 1, '2026-08-12 04:30:42', '2026-08-12 06:31:46'),
(14, 2, 'App\\Models\\User', 'broadcast_alert', '[CRITICAL] Severe Weather Warning: Heavy rainfall and high winds expected. Please avoid mountain trails and coastal areas.', NULL, 1, '2026-08-13 07:21:10', '2026-08-14 07:26:48'),
(15, 9, 'App\\Models\\User', 'broadcast_alert', '[CRITICAL] Severe Weather Warning: Heavy rainfall and high winds expected. Please avoid mountain trails and coastal areas.', NULL, 0, '2026-08-13 07:21:10', '2026-08-13 07:21:10'),
(16, 10, 'App\\Models\\User', 'broadcast_alert', '[CRITICAL] Severe Weather Warning: Heavy rainfall and high winds expected. Please avoid mountain trails and coastal areas.', NULL, 0, '2026-08-13 07:21:10', '2026-08-13 07:21:10'),
(17, 2, 'App\\Models\\User', 'broadcast_alert', '[WARNING] Facility Maintenance Notice: The destination spot is temporarily closed today for scheduled facility maintenance.', NULL, 1, '2026-08-14 08:07:29', '2026-08-16 04:13:30'),
(18, 9, 'App\\Models\\User', 'broadcast_alert', '[WARNING] Facility Maintenance Notice: The destination spot is temporarily closed today for scheduled facility maintenance.', NULL, 0, '2026-08-14 08:07:29', '2026-08-14 08:07:29'),
(19, 10, 'App\\Models\\User', 'broadcast_alert', '[WARNING] Facility Maintenance Notice: The destination spot is temporarily closed today for scheduled facility maintenance.', NULL, 0, '2026-08-14 08:07:29', '2026-08-14 08:07:29'),
(20, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 3) for Lake Maragang on 2026-08-17.', 3, 1, '2026-08-14 08:45:10', '2026-08-14 08:57:07'),
(21, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 2) for Lake Maragang on 2026-08-24.', 4, 0, '2026-08-16 07:05:33', '2026-08-16 07:05:33'),
(22, 7, 'staff', 'booking_alert', 'Booking #4 for Lake Maragang on 2026-08-24 has been cancelled by tourist JYLSAM.', 4, 0, '2026-08-16 07:23:18', '2026-08-16 07:23:18'),
(23, 2, 'tourist', 'booking_alert', 'Your booking #4 for Lake Maragang on 2026-08-24 has been cancelled.', 4, 1, '2026-08-16 07:23:18', '2026-08-16 08:06:03'),
(24, 7, 'staff', 'booking_alert', 'Booking #3 for Lake Maragang on 2026-08-17 has been cancelled by tourist JYLSAM.', 3, 0, '2026-08-16 07:47:58', '2026-08-16 07:47:58'),
(25, 2, 'tourist', 'booking_alert', 'Your booking #3 for Lake Maragang on 2026-08-17 has been cancelled.', 3, 1, '2026-08-16 07:47:58', '2026-08-16 08:06:02'),
(26, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 2) for Lake Maragang on 2026-08-19.', 5, 0, '2026-08-16 08:04:53', '2026-08-16 08:04:53'),
(27, 2, 'tourist', 'booking_alert', 'Booking request #5 submitted for Lake Maragang on 2026-08-19. Pending payment required: Please send your GCash payment and submit the reference number to confirm your slot.', 5, 1, '2026-08-16 08:04:53', '2026-08-16 08:05:59'),
(28, 7, 'staff', 'booking_alert', 'Booking #5 for Lake Maragang on 2026-08-19 has been cancelled by tourist JYLSAM.', 5, 0, '2026-08-16 08:09:27', '2026-08-16 08:09:27'),
(29, 2, 'tourist', 'booking_alert', 'Your booking #5 for Lake Maragang on 2026-08-19 has been cancelled.', 5, 1, '2026-08-16 08:09:27', '2026-08-16 08:36:46'),
(30, 7, 'staff', 'booking_alert', 'New booking request from JYLSAM (group of 2) for Lake Maragang on 2026-08-25.', 6, 0, '2026-08-16 08:10:27', '2026-08-16 08:10:27'),
(31, 2, 'tourist', 'booking_alert', 'Booking request #6 submitted for Lake Maragang on 2026-08-25. Pending payment required: Please send your GCash payment and submit the reference number to confirm your slot.', 6, 1, '2026-08-16 08:10:27', '2026-08-16 08:36:46');

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
('BXLbRkOgg3k0lhKs7jmJAq0Fhbh5dYtdl5XSBUk3', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1ZQaXRzZm11NnV5b3pjRHd6ZG9kb0hacHFPZGY3UzUzTzkxYTd3ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjM6Imh0dHA6Ly9sb2NhbGhvc3QvZS10dXJpc21vL3B1YmxpYy9ub3RpZmljYXRpb25zL3JlYWx0aW1lLXN0cmVhbSI7czo1OiJyb3V0ZSI7czoyMjoibm90aWZpY2F0aW9ucy5yZWFsdGltZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1786903044);

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
(5, 92, 'LMIFB5R2', NULL, '2026-07-23 01:12:02', '2026-07-23 01:12:02'),
(6, 2, 'LMAYN5HH', NULL, '2026-08-09 23:35:35', '2026-08-09 23:35:35'),
(7, 1, 'LMAHMCCK', NULL, '2026-08-12 04:30:42', '2026-08-12 04:30:42');

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
  `id_verification_status` enum('pending','verified') NOT NULL DEFAULT 'pending',
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
(1, 'TOURISM', 'PERSONNEL', NULL, NULL, NULL, '2026-07-01', 'admin@eturismo.com', '2026-07-05 01:50:56', '$2y$10$JHIE7.ce.QQBYdMtrjTlEO4n2FzPWQRjkp4aCqJmh.Ne.1bMhhbLi', 'admin', NULL, 'Local', NULL, NULL, NULL, 0, 'verified', 0, NULL, NULL, '2026-07-05 01:53:24', NULL, 'wxw5qnAqTz13YE8jBETEoAK4TXLhLU3NkI7oSzR16W3Lx4l6aOHBTn8kc5Xp', '2026-07-05 01:49:29', '2026-08-13 06:52:12'),
(2, 'JYLSAM', 'QUIROG', NULL, 'Male', 'M.', '2004-12-10', 'jylsam123@gmail.com', '2026-07-05 04:50:47', '$2y$10$qCr3YUUeNRsVPmTYHocVjOwTJfC53cKplARxSSlAZ93dzA8E7lgdK', 'tourist', '09723462733', 'Local', 'School ID', '2022-041633', 'id_photos/1783245704_2d6ed43b-f01e-47ce-b616-8910397fa53c.jpg', 0, 'verified', 1, 100.00, 'Name match: 100% (found) | ID Number: 100% (found) | DOB: Skipped — this ID type does not print a date of birth', '2026-07-05 05:23:04', NULL, 'CC0BlDQcwzRVnY9CkilDuOqgdFtq27ndbxxTmroj5Qac71GnUCFg76cuoXFL', '2026-07-05 02:01:46', '2026-08-16 08:07:48'),
(7, 'LM', 'Staff', NULL, NULL, NULL, '2026-07-01', 'staff@eturismo.com', '2026-07-09 18:44:01', '$2y$10$IbCyBRigpMsqnF4yWqmU7OIRxtLhux2Iu8bXATxf7Bu2q5RDhjmpu', 'staff', '1234567890', NULL, NULL, NULL, NULL, 1, 'verified', 0, 100.00, 'Status manually updated by Admin.', '2026-07-09 10:39:55', 5, 'QAAYwua8jQ84QBhlCdak2tmi7Efw0KkVAMmblvMJy6m1Jt1h2xqK9nUYPBVD', '2026-07-09 10:38:11', '2026-08-12 05:53:27'),
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
(1, 5, 'kent', 15, NULL, NULL, 'Local', NULL, 1, 7, '2026-07-14 23:36:18', '2026-07-14 23:36:18'),
(2, 5, 'Hahhas', 12, NULL, NULL, 'Local', 'Male', 1, 7, '2026-08-13 07:15:43', '2026-08-13 07:15:43'),
(3, 5, 'Jssjsjs', 23, NULL, NULL, 'Local', 'Male', 1, 7, '2026-08-13 07:17:31', '2026-08-13 07:17:31');

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
-- Indexes for table `booking_companions`
--
ALTER TABLE `booking_companions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_companions_booking_id_foreign` (`booking_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booking_companions`
--
ALTER TABLE `booking_companions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `walk_ins`
--
ALTER TABLE `walk_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_companions`
--
ALTER TABLE `booking_companions`
  ADD CONSTRAINT `booking_companions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `checkins_booking_fk` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkins_staff_fk` FOREIGN KEY (`verified_by_staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
