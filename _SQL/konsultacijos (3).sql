-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2019 at 06:23 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konsultacijos`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_reg_date` date NOT NULL,
  `reg_county` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `con_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `contacts` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `code`, `company_reg_date`, `reg_county`, `con_type`, `user_id`, `contacts`, `created_at`, `updated_at`) VALUES
(1, 'UAB Recovery', '1235678', '2015-10-29', 'kauno-m', 'VKT', 2, 'info@recovery.lt, \r\n+37064787224', '2019-10-29 16:36:12', '2019-11-06 09:05:54'),
(2, 'AB Tentukas', '99888312', '1997-10-30', 'akmenes-r', 'ECO', 1, 'info@tentukas.ab', '2019-10-30 10:30:34', '2019-10-30 10:30:34'),
(3, 'Romualdas Bardiūras', '111111111', '2006-10-30', 'vilkaviskio-r', 'EXPO', 1, 'info@bardiuras.bar', '2019-10-30 12:21:35', '2019-10-30 12:21:35'),
(4, 'UAB Trails', '98765432', '2017-05-15', 'kretingos-r', 'VKT', 3, '+37064787224, info@pg.lt', '2019-11-10 09:06:56', '2019-11-10 09:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contacts` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consultation_date` date NOT NULL,
  `consultation_length` time NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `county` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_sent` tinyint(1) NOT NULL,
  `consultation_time` time NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `paid_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `client_id`, `user_id`, `contacts`, `theme_id`, `address`, `consultation_date`, `consultation_length`, `method`, `created_at`, `updated_at`, `county`, `is_sent`, `consultation_time`, `is_paid`, `paid_date`) VALUES
(9, 1, 1, 'info@recovery.lt+37064787224', 28, 'Nemuno Krantinė 26-6', '2020-10-30', '02:00:00', 'skype', '2019-10-30 13:53:43', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(10, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2021-10-31', '02:00:00', 'tel', '2019-10-31 10:14:43', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(11, 2, 1, 'info@tentukas.ab', 2, 'Nemuno Krantinė 26-6', '2019-12-31', '03:00:00', 'vietoje', '2019-10-31 10:26:19', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(12, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 10:47:58', '2019-11-05 08:47:49', 'alytaus-r', 1, '00:00:00', 0, NULL),
(13, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 10:48:29', '2019-11-05 08:47:49', 'alytaus-r', 1, '00:00:00', 0, NULL),
(14, 1, 1, 'info@recovery.lt+37064787224', 24, 'Nemuno Krantinė 26-6', '2019-12-31', '03:00:00', 'skype', '2019-10-31 10:51:09', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(15, 1, 1, 'info@recovery.lt+37064787224', 24, 'Nemuno Krantinė 26-6', '2019-12-31', '03:00:00', 'skype', '2019-10-31 10:51:59', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(16, 3, 1, 'info@bardiuras.bar', 7, 'Vilniaus g. 30', '2020-11-27', '02:00:00', 'vietoje', '2019-10-31 10:55:18', '2019-11-05 08:47:49', 'vilniaus-m', 1, '00:00:00', 0, NULL),
(17, 3, 1, 'info@bardiuras.bar', 7, 'Vilniaus g. 30', '2020-01-31', '03:00:00', 'skype', '2019-10-31 11:06:05', '2019-11-05 08:47:49', 'birstono', 1, '00:00:00', 0, NULL),
(18, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 12:49:15', '2019-11-05 08:47:49', 'varenos-r', 1, '00:00:00', 0, NULL),
(19, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 13:02:20', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(20, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 13:02:51', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(21, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 13:35:54', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(22, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 13:36:06', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(23, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '02:00:00', 'skype', '2019-10-31 13:36:57', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(24, 3, 1, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-10-31', '04:00:00', 'vietoje', '2019-10-31 13:41:20', '2019-11-05 08:47:49', 'vilniaus-m', 1, '00:00:00', 0, NULL),
(25, 2, 1, 'info@tentukas.ab', 3, 'Nemuno Krantinė 26-6', '2019-10-31', '04:03:00', 'skype', '2019-10-31 13:42:20', '2019-10-31 13:42:20', 'zarasu-r', 1, '00:00:00', 0, NULL),
(26, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 10:50:44', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(27, 3, 1, 'info@bardiuras.bar', 9, 'Nemuno Krantinė 26-6', '2019-11-02', '04:03:00', 'skype', '2019-11-02 10:53:44', '2019-11-05 08:47:49', 'visagino-m', 1, '00:00:00', 0, NULL),
(28, 3, 1, 'info@bardiuras.bar', 9, 'Nemuno Krantinė 26-6', '2019-11-02', '04:03:00', 'skype', '2019-11-02 10:54:15', '2019-11-05 08:47:49', 'visagino-m', 1, '00:00:00', 0, NULL),
(29, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 10:55:57', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(30, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:50:34', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(31, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:52:16', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(32, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:53:11', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(33, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:53:57', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(34, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:54:55', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(35, 1, 1, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-02', '03:00:00', 'skype', '2019-11-02 16:55:08', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(36, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 17:12:29', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(37, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 17:12:51', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(38, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 17:13:52', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(39, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:14:23', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(40, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:15:25', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(41, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:15:49', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(42, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:16:05', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(43, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:16:20', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(44, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:18:39', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(45, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:18:49', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(46, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:20:40', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(47, 2, 1, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-02', '04:00:00', 'skype', '2019-11-02 17:25:44', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(48, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 17:35:31', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(49, 1, 1, 'info@recovery.lt+37064787224', 24, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:17:10', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(50, 1, 1, 'info@recovery.lt+37064787224', 24, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:19:44', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(51, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:26:21', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(52, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:28:10', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(53, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:57:55', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(54, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 18:58:11', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(55, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:00:24', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(56, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:00:42', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(57, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:11:59', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(58, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:12:34', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(59, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:12:59', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(60, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:14:11', '2019-11-05 08:47:49', 'telsiu-r', 1, '00:00:00', 0, NULL),
(61, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:16:44', '2019-11-05 08:47:49', 'telsiu-r', 1, '00:00:00', 0, NULL),
(62, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:17:02', '2019-11-05 08:47:49', 'telsiu-r', 1, '00:00:00', 0, NULL),
(63, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:17:24', '2019-11-05 08:47:49', 'telsiu-r', 1, '00:00:00', 0, NULL),
(64, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:18:33', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(65, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:19:27', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(66, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-02', '02:00:00', 'skype', '2019-11-02 19:19:44', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(67, 2, 1, 'info@tentukas.ab', 3, 'Nemuno Krantinė 26-6', '2019-11-04', '02:00:00', 'skype', '2019-11-04 10:35:14', '2019-11-05 08:47:49', 'alytaus-r', 1, '00:00:00', 0, NULL),
(68, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '02:00:00', 'skype', '2019-11-04 10:52:04', '2019-11-05 08:47:49', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(69, 1, 1, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 11:04:14', '2019-11-05 08:47:49', 'alytaus-r', 1, '00:00:00', 0, NULL),
(70, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '04:03:00', 'skype', '2019-11-04 11:05:31', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(71, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '04:03:00', 'skype', '2019-11-04 11:07:03', '2019-11-05 08:47:49', 'akmenes-r', 1, '00:00:00', 0, NULL),
(72, 2, 1, 'info@tentukas.ab', 2, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 11:08:40', '2019-11-05 08:47:49', 'elektrenu', 1, '00:00:00', 0, NULL),
(73, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 11:12:02', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(74, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '02:00:00', 'skype', '2019-11-04 11:17:25', '2019-11-05 08:47:49', 'vilniaus-r', 1, '00:00:00', 0, NULL),
(75, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '02:00:00', 'skype', '2019-11-04 11:18:41', '2019-11-05 08:47:49', 'alytaus-m', 1, '00:00:00', 0, NULL),
(76, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 12:14:55', '2019-11-04 12:14:55', 'alytaus-r', 1, '00:00:00', 0, NULL),
(77, 1, 1, 'info@recovery.lt+37064787224', 24, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 12:16:50', '2019-11-04 12:16:50', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(78, 2, 1, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-04', '03:00:00', 'skype', '2019-11-04 12:17:09', '2019-11-05 08:47:49', 'moletu-r', 1, '00:00:00', 0, NULL),
(79, 1, 1, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 09:44:41', '2019-11-05 09:44:41', 'alytaus-r', 1, '00:00:00', 0, NULL),
(80, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 09:47:58', '2019-11-05 10:05:04', 'kaisiadoriu-r', 1, '00:00:00', 0, NULL),
(81, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '04:00:00', 'skype', '2019-11-05 10:04:42', '2019-11-05 10:04:42', 'alytaus-r', 1, '00:00:00', 0, NULL),
(82, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 10:08:52', '2019-11-05 10:08:52', 'alytaus-m', 1, '00:00:00', 0, NULL),
(83, 1, 2, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 10:13:55', '2019-11-05 10:13:55', 'alytaus-r', 1, '00:00:00', 0, NULL),
(84, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 10:26:43', '2019-11-05 10:26:43', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(85, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 10:28:46', '2019-11-05 10:28:46', 'alytaus-r', 1, '00:00:00', 0, NULL),
(86, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 10:32:40', '2019-11-05 10:32:40', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(87, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 10:34:46', '2019-11-05 10:34:46', 'alytaus-m', 1, '00:00:00', 0, NULL),
(88, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 10:36:57', '2019-11-05 10:36:57', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(89, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 10:41:27', '2019-11-05 10:41:27', 'alytaus-r', 1, '00:00:00', 0, NULL),
(90, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 10:42:36', '2019-11-05 10:42:57', 'alytaus-m', 1, '00:00:00', 0, NULL),
(91, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 10:42:54', '2019-11-05 10:42:57', 'jonavos-r', 1, '00:00:00', 0, NULL),
(92, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 11:47:08', '2019-11-05 11:47:08', 'akmenes-r', 1, '00:00:00', 0, NULL),
(93, 1, 2, 'info@recovery.lt+37064787224', 25, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 11:49:40', '2019-11-05 11:49:40', 'alytaus-r', 1, '00:00:00', 0, NULL),
(94, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 11:52:02', '2019-11-05 11:52:02', 'rokiskio-r', 1, '00:00:00', 0, NULL),
(95, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 12:01:58', '2019-11-05 12:01:58', 'akmenes-r', 1, '00:00:00', 0, NULL),
(96, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:04:26', '2019-11-05 12:04:26', 'alytaus-m', 1, '00:00:00', 0, NULL),
(97, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '04:03:00', 'skype', '2019-11-05 12:11:43', '2019-11-05 12:11:43', 'alytaus-r', 1, '00:00:00', 0, NULL),
(98, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:15:27', '2019-11-05 12:15:27', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(99, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:19:09', '2019-11-05 12:19:09', 'alytaus-m', 1, '00:00:00', 0, NULL),
(100, 2, 2, 'info@tentukas.ab', 4, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:20:41', '2019-11-05 12:20:41', 'alytaus-m', 1, '00:00:00', 0, NULL),
(101, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:25:09', '2019-11-05 12:38:40', 'alytaus-m', 1, '00:00:00', 0, NULL),
(102, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 12:26:35', '2019-11-05 12:38:40', 'jurbarko-r', 1, '00:00:00', 0, NULL),
(103, 3, 2, 'info@bardiuras.bar', 8, 'Nemuno Krantinė 26-6', '2019-11-05', '04:03:00', 'skype', '2019-11-05 12:26:58', '2019-11-05 12:38:40', 'kazlu-rudos', 1, '00:00:00', 0, NULL),
(104, 1, 2, 'info@recovery.lt+37064787224', 29, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 12:27:17', '2019-11-05 12:38:40', 'elektrenu', 1, '00:00:00', 0, NULL),
(105, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-05', '03:00:00', 'skype', '2019-11-05 12:40:21', '2019-11-05 12:40:21', 'alytaus-m', 1, '00:00:00', 0, NULL),
(106, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 18:17:00', '2019-11-05 18:17:00', 'kupiskio-r', 1, '00:00:00', 0, NULL),
(107, 1, 2, 'info@recovery.lt+37064787224', 23, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 18:18:44', '2019-11-06 09:28:48', 'alytaus-r', 1, '00:00:00', 0, NULL),
(108, 1, 2, 'info@recovery.lt+37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-05', '04:03:00', 'skype', '2019-11-05 18:26:08', '2019-11-06 09:28:48', 'kelmes-r', 1, '00:00:00', 0, NULL),
(109, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 18:26:56', '2019-11-06 09:28:48', 'alytaus-r', 1, '00:00:00', 0, NULL),
(110, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-05', '02:00:00', 'skype', '2019-11-05 18:29:06', '2019-11-06 09:28:48', 'klaipedos-r', 1, '00:00:00', 0, NULL),
(111, 1, 2, 'info@recovery.lt+37064787224', 26, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 09:05:08', '2019-11-06 09:28:48', 'akmenes-r', 1, '00:00:00', 0, NULL),
(112, 1, 2, 'info@recovery.lt, +37064787224', 24, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 09:06:43', '2019-11-06 09:28:48', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(113, 2, 2, 'info@tentukas.ab', 5, 'Nemuno Krantinė 26-6', '2019-11-06', '03:00:00', 'skype', '2019-11-06 09:14:17', '2019-11-06 15:36:08', 'akmenes-r', 1, '00:00:00', 0, NULL),
(114, 2, 2, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-06', '03:00:00', 'skype', '2019-11-06 09:19:58', '2019-11-06 16:14:04', 'akmenes-r', 1, '00:00:00', 0, NULL),
(115, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 09:21:47', '2019-11-06 16:14:04', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(116, 1, 2, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 09:23:26', '2019-11-06 16:14:04', 'alytaus-m', 1, '00:00:00', 0, NULL),
(117, 1, 2, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-06', '03:00:00', 'skype', '2019-11-06 09:25:26', '2019-11-06 16:14:04', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(118, 1, 2, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 16:00:40', '2019-11-06 16:00:40', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(119, 1, 2, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-06', '02:00:00', 'skype', '2019-11-06 16:02:09', '2019-11-06 16:02:09', 'anyksciu-r', 1, '00:00:00', 0, NULL),
(120, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-06', '00:30:00', 'skype', '2019-11-06 16:04:53', '2019-11-06 16:04:53', 'klaipedos-m', 1, '00:00:00', 0, NULL),
(121, 3, 2, 'info@bardiuras.bar', 7, 'Nemuno Krantinė 26-6', '2019-11-06', '05:00:00', 'skype', '2019-11-06 16:07:39', '2019-11-06 16:07:39', 'rokiskio-r', 1, '00:00:00', 0, NULL),
(122, 1, 2, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-10', '02:00:00', 'skype', '2019-11-10 08:58:10', '2019-11-10 08:58:10', 'alytaus-m', 1, '00:00:00', 0, NULL),
(123, 4, 3, '+37064787224, info@pg.lt', 27, 'Nemuno Krantinė 26-6', '2019-11-10', '03:00:00', 'vietoje', '2019-11-10 09:13:46', '2019-11-10 10:39:48', 'salcininku-r', 1, '21:20:00', 0, NULL),
(124, 1, 3, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-10', '04:00:00', 'skype', '2019-11-10 09:17:56', '2019-11-10 10:41:48', 'silales-r', 1, '08:00:00', 0, NULL),
(126, 4, 3, '+37064787224, info@pg.lt', 28, 'Nemuno Krantinė 26-6', '2019-11-28', '03:00:00', 'vietoje', '2019-11-10 12:55:13', '2019-11-10 12:55:13', 'kelmes-r', 1, '19:30:00', 0, NULL),
(127, 1, 3, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-10', '03:00:00', 'skype', '2019-11-10 17:47:41', '2019-11-11 10:40:01', 'alytaus-m', 1, '08:00:00', 0, NULL),
(128, 1, 3, 'info@recovery.lt, +37064787224', 22, 'Nemuno Krantinė 26-6', '2019-11-10', '03:00:00', 'skype', '2019-11-10 18:05:14', '2019-11-10 18:11:21', 'anyksciu-r', 1, '14:30:00', 1, '2019-10-16'),
(129, 4, 3, '+37064787224, info@pg.lt', 29, 'Nemuno Krantinė 26-6', '2019-11-10', '02:00:00', 'skype', '2019-11-10 18:06:59', '2019-11-10 18:30:11', 'siauliu-r', 1, '15:30:00', 1, '2019-11-10'),
(130, 4, 3, '+37064787224, info@pg.lt', 22, 'Nemuno Krantinė 26', '2019-11-11', '02:00:00', 'skype', '2019-11-11 10:39:56', '2019-11-11 10:40:20', 'alytaus-r', 1, '14:30:00', 1, '2019-11-11'),
(131, 2, 3, 'info@tentukas.ab', 1, 'Nemuno Krantinė 26-6', '2019-11-11', '02:00:00', 'tel', '2019-11-11 10:40:49', '2019-11-11 10:40:49', 'kelmes-r', 1, '14:30:00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_10_16_151529_create_consultations_table', 1),
(13, '2019_10_16_151739_create_clients_table', 1),
(14, '2019_10_23_170156_add_county_to_consultations', 1),
(15, '2019_10_29_095705_create_themes_table', 1),
(16, '2019_10_29_120615_add_min_max_old_column_to_themes', 1),
(17, '2019_10_29_183258_delete_constraint_from_themes', 2),
(18, '2019_10_29_184044_add_nullable_to_min_old_max_old_in_themes', 3),
(19, '2019_10_29_184456_add_nullable_to_min_old_max_old_in_themes', 4),
(20, '2019_10_29_185541_change_old_min_max_in_themes_to_int', 5),
(21, '2019_10_30_143754_change_type_of_consultation_date_to_datetime_in_consultations', 6),
(22, '2019_10_30_154558_change_type_of_theme_in_consultations', 7),
(23, '2019_10_30_154931_change_name_of_theme_to_theme_id_in_consultations', 8),
(24, '2019_10_31_151254_add_is_sent_column_to_consultations', 9),
(25, '2019_11_04_145242_change_consultant_to_user_in_consultations', 10),
(26, '2019_11_10_110242_add_time_to_consultations', 11),
(27, '2019_11_10_110950_change_consultation_date_to_date_type_in_consultations', 12),
(28, '2019_11_10_195436_add_is_paid_to_consultations', 13),
(29, '2019_11_10_201348_add_paid_date_to_consultations', 14),
(30, '2019_11_10_201901_add_nullable_is_paid_to_consultations', 15),
(31, '2019_11_11_133247_add_user_id_to_clients', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `min_old` int(11) DEFAULT NULL,
  `max_old` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `main_theme`, `theme_number`, `created_at`, `updated_at`, `min_old`, `max_old`) VALUES
(1, 'Atliekų perdirbimas ir antrinis panaudojimas gamyboje', 'ECO', 1, NULL, NULL, NULL, NULL),
(2, 'Ekologinis gaminių projektavimas', 'ECO', 2, NULL, NULL, NULL, NULL),
(3, 'Taršos prevencija', 'ECO', 3, NULL, NULL, NULL, NULL),
(4, 'Ekoinovacijų diegimas', 'ECO', 4, NULL, NULL, NULL, NULL),
(5, 'Aplinkosaugos vadybos sistemų diegimas', 'ECO', 5, NULL, NULL, NULL, NULL),
(6, 'Pasirengimo eksportui veiksmų planas', 'EXPO', 1, NULL, NULL, NULL, 3),
(7, 'Eksporto strategija', 'EXPO', 2, NULL, NULL, 3, NULL),
(8, 'Tikslinių eksporto rinkų pasirinkimas ir išorinė komunikacija', 'EXPO', 3, NULL, NULL, 3, NULL),
(9, 'Tarptautinės prekybos teisiniai aspektai ir sertifikavimas užsienio rinkose', 'EXPO', 4, NULL, NULL, 3, NULL),
(10, 'Techniniai ir gamybiniai eksporto aspektai', 'EXPO', 5, NULL, NULL, 3, NULL),
(11, 'Eksporto rizikos valdymas', 'EXPO', 6, NULL, NULL, 3, NULL),
(12, 'Verslo planavimas', 'VKT', 1, NULL, NULL, NULL, 1),
(13, 'Mokesčiai ir buhalterinė apskaita', 'VKT', 2, NULL, NULL, NULL, 1),
(14, 'Parama verslui, verslo finansavimo šaltiniai', 'VKT', 3, NULL, NULL, NULL, 1),
(15, 'Produkto, paslaugos tobulinimas', 'VKT', 4, NULL, NULL, NULL, 1),
(16, 'Pardavimas', 'VKT', 5, NULL, NULL, NULL, 1),
(17, 'Rinkodara', 'VKT', 6, NULL, NULL, NULL, 1),
(18, 'Sutarčių sudarymas ir valdymas', 'VKT', 7, NULL, NULL, NULL, 1),
(19, 'Dokumentų rengimas ir valdymas', 'VKT', 8, NULL, NULL, NULL, 1),
(20, 'Personalo valdymas, darbo teisė ir sauga', 'VKT', 9, NULL, NULL, NULL, 1),
(21, 'Socialinis verslas', 'VKT', 10, NULL, NULL, NULL, 1),
(22, 'Įmonės strategija', 'VKT', 11, NULL, NULL, 1, 5),
(23, 'Įmonės veiklos procesai ir veiklos efektyvumas', 'VKT', 12, NULL, NULL, 1, 5),
(24, 'Rinkodara, įmonės įvaizdžio formavimas', 'VKT', 13, NULL, NULL, 1, 5),
(25, 'Įmonės finansų valdymas', 'VKT', 14, NULL, NULL, 1, 5),
(26, 'Pardavimas ir derybos', 'VKT', 15, NULL, NULL, 1, 5),
(27, 'Investicijos ir finansavimo šaltiniai', 'VKT', 16, NULL, NULL, 1, 5),
(28, 'Teisiniai aspektai', 'VKT', 17, NULL, NULL, 1, 5),
(29, 'Projektų valdymas', 'VKT', 18, NULL, NULL, 1, 5),
(30, 'Socialinis verslas', 'VKT', 19, NULL, NULL, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'kiprasbiel', '$2y$10$aHQBagxnTrNSLUI/0b0AL.Mtp8W1g9choMUCjo/Ea5uBMSFyDOCrG', 'Kipras', 'GfMUgumTryr2tX7FwRCnoo1xF9yP47li7TxbclypmR48kUHttepy4zXx49T4', '2019-10-29 16:34:45', '2019-10-29 16:34:45'),
(2, 'kiprasbiel2', '$2y$10$QJZL7H2vs2H/XJWnv6mfc.DrEb.jOlSecvXh7uAKCc3TrpXNIVQo2', 'Kipras 2', 'k0uvp0YCCS6LP00mOUJsvgTBv56QbVILaeQxobV2YLQXfq4GpygFZ3CFmlUm', '2019-11-04 12:21:43', '2019-11-04 12:21:43'),
(3, 'kiprasbiel3', '$2y$10$YQ.2n0whWJRIGJtra52va.O8BbTw0fg0jvV5JVQ8AcaHjdtZtmiam', 'Kipras 3', 'rMwicgQFO46vdXT4NWxwrLmlP4tPUSsnOaFeqiObPyqXNM2zeoRbdPzLnKR8', '2019-11-10 09:05:16', '2019-11-10 09:05:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
