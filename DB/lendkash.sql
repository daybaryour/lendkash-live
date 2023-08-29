-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 01:41 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(150) NOT NULL,
  `bank_code` varchar(10) NOT NULL,
  `bvn` varchar(50) NOT NULL,
  `account_holder_name` varchar(150) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_masters`
--

CREATE TABLE `bank_masters` (
  `id` int(11) NOT NULL,
  `bank_code` varchar(150) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_masters`
--

INSERT INTO `bank_masters` (`id`, `bank_code`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, '560', 'Page MFBank', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(3, '304', 'Stanbic Mobile Money', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(4, '308', 'FortisMobile', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(5, '328', 'TagPay', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(6, '309', 'FBNMobile', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(7, '011', 'First Bank of Nigeria', 'active', '2020-04-09 14:49:52', '2020-04-09 14:49:52'),
(8, '326', 'Sterling Mobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(9, '990', 'Omoluabi Mortgage Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(10, '311', 'ReadyCash (Parkway)', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(11, '057', 'Zenith Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(12, '068', 'Standard Chartered Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(13, '306', 'eTranzact', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(14, '070', 'Fidelity Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(15, '023', 'CitiBank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(16, '215', 'Unity Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(17, '323', 'Access Money', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(18, '302', 'Eartholeum', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(19, '324', 'Hedonmark', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(20, '325', 'MoneyBox', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(21, '301', 'JAIZ Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(22, '050', 'Ecobank Plc', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(23, '307', 'EcoMobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(24, '318', 'Fidelity Mobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(25, '319', 'TeasyMobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(26, '999', 'NIP Virtual Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(27, '320', 'VTNetworks', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(28, '221', 'Stanbic IBTC Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(29, '501', 'Fortis Microfinance Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(30, '329', 'PayAttitude Online', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(31, '322', 'ZenithMobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(32, '303', 'ChamsMobile', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(33, '403', 'SafeTrust Mortgage Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(34, '551', 'Covenant Microfinance Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(35, '415', 'Imperial Homes Mortgage Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(36, '552', 'NPF MicroFinance Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(37, '526', 'Parralex', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(38, '035', 'Wema Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(39, '084', 'Enterprise Bank', 'active', '2020-04-09 14:49:53', '2020-04-09 14:49:53'),
(40, '063', 'Diamond Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(41, '305', 'Paycom', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(42, '100', 'SunTrust Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(43, '317', 'Cellulant', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(44, '401', 'ASO Savings and & Loans', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(45, '030', 'Heritage', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(46, '402', 'Jubilee Life Mortgage Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(47, '058', 'GTBank Plc', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(48, '032', 'Union Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(49, '232', 'Sterling Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(50, '076', 'Skye Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(51, '082', 'Keystone Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(52, '327', 'Pagatech', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(53, '559', 'Coronation Merchant Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(54, '601', 'FSDH', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(55, '313', 'Mkudi', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(56, '214', 'First City Monument Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(57, '314', 'FET', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(58, '523', 'Trustbond', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(59, '315', 'GTMobile', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(60, '033', 'United Bank for Africa', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(61, '044', 'Access Bank', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54'),
(62, '90115', 'TCF MFB', 'active', '2020-04-09 14:49:54', '2020-04-09 14:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_id` int(10) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin DEFAULT NULL,
  `inbox_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `state_id`, `name`, `created_at`, `updated_at`) VALUES
(9, 1, 1, 'Aba', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(10, 1, 1, 'Arochukwu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(11, 1, 1, 'Umuahia', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(12, 1, 2, 'Jimeta', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(13, 1, 2, 'Mubi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(14, 1, 2, 'Numan', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(15, 1, 2, 'Yola', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(16, 1, 3, 'Ikot Abasi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(17, 1, 3, 'Ikot Ekpene', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(18, 1, 3, 'Oron', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(19, 1, 3, 'Uyo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(20, 1, 4, 'Awka', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(21, 1, 4, 'Onitsha', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(22, 1, 5, 'Azare', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(23, 1, 5, 'Bauchi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(24, 1, 5, 'Jama\'are', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(25, 1, 5, 'Katagum', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(26, 1, 5, 'Misau', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(27, 1, 6, 'Brass', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(28, 1, 7, 'Makurdi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(29, 1, 8, 'Biu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(30, 1, 8, 'Dikwa', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(31, 1, 8, 'Maiduguri', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(32, 1, 9, 'Calabar', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(33, 1, 9, 'Ogoja', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(34, 1, 10, 'Asaba', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(35, 1, 10, 'Burutu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(36, 1, 10, 'Koko', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(37, 1, 10, 'Sapele', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(38, 1, 10, 'Ughelli', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(39, 1, 10, 'Warri', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(40, 1, 11, 'Abakaliki', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(41, 1, 12, 'Benin City', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(42, 1, 13, 'Ado-Ekiti', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(43, 1, 13, 'Effon-Alaiye', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(44, 1, 13, 'Ikere-Ekiti', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(45, 1, 14, 'Enugu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(46, 1, 14, 'Nsukka', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(47, 1, 15, 'Abuja', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(48, 1, 16, 'Deba Habe', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(49, 1, 16, 'Gombe', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(50, 1, 16, 'Kumo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(51, 1, 17, 'Owerri', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(52, 1, 18, 'Brirnin Kudu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(53, 1, 18, 'Dutse', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(54, 1, 18, 'Gumel', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(55, 1, 18, 'Hadejia', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(56, 1, 18, 'Kazaure', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(57, 1, 19, 'Jemma', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(58, 1, 19, 'Kaduna', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(59, 1, 19, 'Zaria', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(60, 1, 20, 'Kano', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(61, 1, 21, 'Daura', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(62, 1, 21, 'Katsina', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(63, 1, 22, 'Argungu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(64, 1, 22, 'Birnin Kebbi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(65, 1, 22, 'Gwandu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(66, 1, 22, 'Yelwa', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(67, 1, 23, 'Idah', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(68, 1, 23, 'Kabba', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(69, 1, 23, 'Lokoja', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(70, 1, 23, 'Okene', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(71, 1, 24, 'Ilorin', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(72, 1, 24, 'Jebba', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(73, 1, 24, 'Lafiagi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(74, 1, 24, 'Offa', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(75, 1, 24, 'Pategi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(76, 1, 25, 'Badagry', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(77, 1, 25, 'Epe', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(78, 1, 25, 'Ikeja', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(79, 1, 25, 'Ikorodu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(80, 1, 25, 'Lagos', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(81, 1, 25, 'Mushin', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(82, 1, 25, 'Shomolu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(83, 1, 25, 'Surulere', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(84, 1, 25, 'Lagos Mainland', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(85, 1, 25, 'Lagos Island', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(86, 1, 26, 'Keffi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(87, 1, 26, 'Lafia', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(88, 1, 26, 'Nasarawa', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(89, 1, 27, 'Agaie', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(90, 1, 27, 'Boro', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(91, 1, 27, 'Bida', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(92, 1, 27, 'Kontagora', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(93, 1, 27, 'Lapai', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(94, 1, 27, 'Minna', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(95, 1, 27, 'Suleja', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(96, 1, 28, 'AbeokutaIjebu-Ode', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(97, 1, 28, 'Ilaro', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(98, 1, 28, 'Shagamu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(99, 1, 29, 'Akure', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(100, 1, 29, 'Ikare', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(101, 1, 29, 'Oka-Akoko', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(102, 1, 29, 'Ondo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(103, 1, 29, 'Owo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(104, 1, 30, 'Ede', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(105, 1, 30, 'Ikire', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(106, 1, 30, 'Ikirun', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(107, 1, 30, 'Ila', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(108, 1, 30, 'Ilesha', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(109, 1, 30, 'Ilobu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(110, 1, 30, 'Inisa', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(111, 1, 30, 'Iwo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(112, 1, 30, 'Oshogbo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(113, 1, 31, 'Ibadan', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(114, 1, 31, 'iseyin', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(115, 1, 31, 'Ogbomosho', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(116, 1, 31, 'Oyo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(117, 1, 31, 'Saki', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(118, 1, 32, 'Bukuru', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(119, 1, 32, 'Jos', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(120, 1, 32, 'Vom', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(121, 1, 32, 'Wase', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(122, 1, 33, 'Bonny', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(123, 1, 33, 'Degema', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(124, 1, 33, 'Okrika', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(125, 1, 33, 'Port Harcourt', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(126, 1, 34, 'Sokoto', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(127, 1, 35, 'Ibi', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(128, 1, 35, 'Jalingo', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(129, 1, 35, 'Muri', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(130, 1, 36, 'Damaturu', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(131, 1, 36, 'Nguru', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(132, 1, 37, 'Gusau', '2020-01-14 00:00:00', '2020-01-14 18:19:30'),
(133, 1, 37, 'Kaura Namoda', '2020-01-14 00:00:00', '2020-01-14 18:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int(11) NOT NULL,
  `type` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `type`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'about', 'About', '<p class=\"MsoNormal\" style=\"font-size: medium;\">Hello Shiva,</p>\n<p class=\"MsoNormal\" style=\"font-size: medium;\">According to our research on paystack, there are two way to integrate paystack:-</p>\n<p class=\"MsoNormal\" style=\"font-size: medium;\">1 <strong>Paystack Inline-&gt;</strong>Paystack Inline offers a simple, secure and convenient payment flow for web and mobile</p>\n<p class=\"MsoNormal\" style=\"font-size: medium;\">In mobile Application on pay button click it will open below screen in mobile application and after successful payment it will redirect back to success payment page.</p>\n<p class=\"MsoNormal\" style=\"font-size: medium;\"><strong>Link</strong> : <a href=\"https://developers.paystack.co/docs/paystack-inline\">https://developers.paystack.co/docs/paystack-inline</a></p>\n<p class=\"MsoNormal\" style=\"font-size: medium;\"><strong><span style=\"color: red;\">Note</span></strong> : In this case we need to open remove save card list ,add card.</p>', '2020-01-23 11:21:00', '2020-02-08 08:02:49'),
(2, 'terms_and_condition', 'Terms and Condition', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2020-01-23 11:16:00', '2020-01-23 07:19:21'),
(3, 'privacy_policy', 'Privacy Policy', '<p>LenndKash (LendKash, Lepta, or We, Our, Us) respect your privacy and are committed to protecting your Personally Identifiable Information (PII) that may be collected through your use of our website or mobile application (together, Site) or in applying for or receiving any of our products or services (Services). This privacy policy (Policy) describes how we collect and use your PII and how you can control that use.&nbsp;</p>\n<p>Please read this Policy carefully.&nbsp;</p>\n<p>By Clicking the continue or Accept icon or any other icon that indicated agreement with this Privacy Policy, downloading the LendKash app and applying for any of our services including but not limited to the Loan and Investment Application, you agree to our collection, use, and sharing of your PII as described in this Policy.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>1. Application and Principles&nbsp;</p>\n<p>1.1 This privacy policy (Policy) describes how we collect and use your PII and how you can control that use. Please read this Policy carefully.&nbsp;</p>\n<p>1.2 By Clicking the continue or Accept icon or any other icon that indicated agreement with this Privacy Policy, downloading the LendKash&nbsp; App and applying for any of our services including but not limited to the Loan and Investment Application, you agree to our collection, use, and sharing of your PII as described in this Policy;&nbsp;</p>\n<p>1.3 This Policy shall apply to visitors to the Lendkash website and app and the Privacy Policy together with the Terms and Conditions of the Loan and Investment Account Agreement shall jointly apply to the use of:&nbsp;</p>\n<p>a. Any User of the content of the LendKash website and app;&nbsp;</p>\n<p>b. The LendKash Mobile Application Software available for download and/or streaming from the LendKash Website, Google Play Store or any other platform/ third party sites where the App is hosted; and&nbsp;</p>\n<p>c. Applying or subscribing to any of the Services offered by LendKash including but not limited to application for loan and investment.&nbsp;</p>\n<p>1.4 The underlisted principles guide how LendKash processes your personal data:&nbsp;</p>\n<p>a) Purpose: collected only for specified, explicit and legitimate purposes and not further processed in a manner incompatible with those purposes.&nbsp;</p>\n<p>b) Law and Fairness: processed lawfully, fairly, in a transparent manner and with respect for the dignity of the human person.&nbsp;</p>\n<p>c) Need: adequate, relevant and limited to what is necessary in relation to the purposes for which it is processed.&nbsp;</p>\n<p>d) Timeliness: accurate and where necessary kept up to date.&nbsp;</p>\n<p>e) Duration: not kept in a form which permits identification of data subjects for longer than is necessary for the purposes for which the personal data is processed.&nbsp;</p>\n<p>f) Security: processed in a manner that ensures its security, using appropriate technical and organisational measures to protect against unauthorised or unlawful processing and against accidental loss, destruction or damage.&nbsp;</p>\n<p>1.5 You confirm that you agree and consent to this Privacy Policy together with the Terms and Conditions by downloading the App, or use of any of the LendKash Services and you also consent to the collection, use and storage of your information in the manner provided herein.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>2. Purpose of Collecting your Personal Identifiable Information (PII)&nbsp;</p>\n<p>2.1 LendKash shall require your Personal Identifiable Information (PII) for the purpose of you downloading the App and your opening of an account with LendKash;&nbsp;</p>\n<p>2.2 LendKash shall require your PII to comply with the Know Your Customer (KYC) requirements of the Central Bank of Nigeria (CBN) and other regulatory provisions to which LendKash is bound;&nbsp;</p>\n<p>2.3 LendKash shall also require information to ascertain your satisfaction of its service criteria for prospective clients including but not limited to age, occupation and determine your creditworthiness.&nbsp;</p>\n<p>2.4 You may withdraw your consent from this privacy policy, however, all accrued obligations prior such withdrawal shall remain subsisting and valid until such obligations are fulfilled.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>3. Required Information&nbsp;</p>\n<p>3.1 Submitted information:&nbsp;</p>\n<p>a. Information we may collect and process from you include those you provide to us whilst filling in forms in the App or on our Site(s), provided by corresponding with us;&nbsp;</p>\n<p>provided by registering to use our Site, downloading or registering the App, subscribing to any of our Services (such as applying for a loan or investment), searching for an app or Service, sharing data via the App\'s social media functions, entering a competition, promotion or survey, and reporting a problem with the App, our Services, our App Site or any of Our Service Sites.&nbsp;</p>\n<p>b. This information may include your name, address, email address and phone number, the Device\'s phone number, SIM card details, age, username, password and other registration information, financial and credit information (including your mobile money account details, bank account details, and bank verification number, where applicable), personal description and photograph.&nbsp;</p>\n<p>3.2 Collected Information:&nbsp;</p>\n<p>a. Information we may collect from you automatically include information including but not limited to your, technical information, including the type of mobile device you use, unique device identifiers (for example, your Device\'s IMEI or serial number), information about the SIM card used by the Device, mobile network information, your Devices operating system, browser information and details, or your Devices location and time zone setting (Device Information); information stored on your Device, including contact lists, call logs, SMS logs, photos, videos or other digital content (Content Information); data from your use of any other third-party application on the Device or the Service Sites; and details of your use of any of our Apps or your visits to any of Our Service Sites; including, but not limited to, traffic data, location data, weblogs and other communication data (Log Information).&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>4. Location and Movement information.&nbsp;</p>\n<p>a. By Downloading and Using any of our services, you consent to our automatic collection of data relating to your location via GPS Technology or other location services.&nbsp;</p>\n<p>b. You can withdraw your consent to our collection, processing or use of this information at any time by logging out and uninstalling the App from your Device.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>5. Unique Application Numbers.&nbsp;</p>\n<p>We may receive information on the type of operating system, Unique Application number and installation information when you install or uninstall a Service containing a unique application number or when such a Service searches for automatic updates&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>6. Cookies and Other Tracking Technologies&nbsp;</p>\n<p>6.1 We may use mobile tracking technologies and/or website cookies to distinguish you from other users of the App, App Site, or Service Sites.&nbsp;</p>\n<p>6.2 To Provide you with a good experience when you visit the Website or use the App or browse any of the sites and also allows us to improve the App and Our Sites, we make use of cookies&nbsp;</p>\n<p>6.3 Statistical or aggregated information does not directly identify a specific person, but it may be derived from your PII. For example, we may aggregate PII to calculate the percentage of users in a particular area.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>7. Processing your Information&nbsp;</p>\n<p>7.1 In accordance with this Policy, we may associate any category of information with any other category of information and will treat the combined information as personal data for as long as it is combined.&nbsp;</p>\n<p>7.2 Information collected by us shall be used to determine the prospective customers credit worthiness and for the purpose of determining whether or not to provide a loan application to the customer, the amount of such loan and the terms and conditions applicable to such loan.&nbsp;</p>\n<p>7.3 Save in compliance with an order of the Court, Arbitral Panel, Tribunal, Regulatory Directive or Order or any other legal or regulatory obligation, we do not disclose information about identifiable individuals to other parties, but we may provide them with anonymous aggregate information about our users.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>8. Third Party Access to your Information&nbsp;</p>\n<p>8.1 To ensure efficient delivery of our services to you we may receive information from other sources and may be required to work with a number of third parties (including credit reference agencies and mobile network providers) and we may receive information about you from them.&nbsp;</p>\n<p>8.2 LendKash shall secure the confidentiality of your data and PII to avoid unauthorized without prejudice to our right to share information, including PII, with third parties, as described below:&nbsp;</p>\n<p>a. Service Providers: We may share information with service providers that help us perform functions and process your transactions.&nbsp;</p>\n<p>b. Affiliates: We may share information with a parent company, subsidiaries, joint ventures, or other companies under common control with us who shall also comply with the terms of this Privacy Policy. We provide such information to other trusted businesses or persons for the purpose of processing personal information on our behalf. We require that these parties agree to process such information based on our instructions and in compliance with this Privacy Policy and any other appropriate confidentiality and security measures.&nbsp;</p>\n<p>c. Other Companies: We may share information with other companies for purposes of marketing our products to you or for analysing our business and transactions.&nbsp;</p>\n<p>d. Corporate Structure: We may share information in connection with a merger, acquisition, consolidation, change of control, or sale of all or a portion of our assets or if we undergo bankruptcy or liquidation.&nbsp;</p>\n<p>e. To Prevent Harm: We may share information if we believe it is necessary in order to detect, investigate, prevent, or take action against illegal activities, fraud, or situations involving potential threats to the rights, property, or personal safety of any person.&nbsp;</p>\n<p>f. As Required by Law: We will share information where we are legally required to do so, such as in response to court orders or legal process, to establish, protect, or exercise our legal rights, to defend against legal claims or demands, or to comply with the requirements of mandatory applicable law.&nbsp;</p>\n<p>g. Reasonable Necessity: We have a good faith belief that access, use, preservation or disclosure of such information is reasonably necessary to:&nbsp;</p>\n<p>i. satisfy any applicable law, regulation, legal process or enforceable governmental request;&nbsp;</p>\n<p>ii. enforce applicable terms of service, including investigation of potential violations thereof, necessary to enforce repayment on loans;&nbsp;</p>\n<p>iii. detect, prevent, or otherwise address fraud, security or technical issues; or&nbsp;</p>\n<p>iv. Protect against imminent harm to the rights, property or safety of LendKash, its users or the public as required or permitted by law.&nbsp;</p>\n<p>h. to enforce our Terms and Conditions and other agreements or to investigate potential breaches; report defaulters to any credit bureau in accordance with the Terms of Use of our services; or for the purpose of publishing statistics relating to the use of the App, in which case all information may be aggregated or made anonymous.&nbsp;</p>\n<p>i. With your Consent: We may request your permission to share your PII for a specific purpose. We will notify you and request consent before you provide PII or before the PII you have already provided is shared for such purposes.&nbsp;</p>\n<p>j. Without Identifying You: We may share information in a manner that does not identify you. For example, we may share anonymous, aggregate information about your use of our Site and products with our service providers.&nbsp;</p>\n<p>8.3 Storage and Security of your personal data&nbsp;</p>\n<p>8.3.1 The data that we collect from you may be transferred to, and stored at a destination outside your country of origin or residence (as applicable). It may also be processed by staff operating outside your country of origin or residence (as applicable), who work for us or for one of our suppliers. These staff members may be engaged in the fulfilment of your requests on the Service Sites.&nbsp;</p>\n<p>8.3.2 By submitting your personal data, you agree to the collection, transfer, storing or processing of your personal data in the manner set out above.&nbsp;</p>\n<p>8.3.3 We will take all steps reasonably necessary to ensure that your data is treated, stored and processed securely and in accordance with this Privacy Policy.&nbsp;</p>\n<p>8.3.4 You agree and consent that it is your responsibility to keep all tokens and passwords that enables you to access certain parts of Our Service Sites safe, intact and confidential password with anyone.&nbsp;</p>\n<p>8.3.5 Knowing that there is no absolute guarantee of the security of internet transmitted information, LendKash shall endeavour to ensure the protection of your personal data, however all transmission is at your own risk. Once received, your information will be accorded strict procedures and security features via the use of encryption to try to prevent unauthorised access.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>9. Your rights&nbsp;</p>\n<p>9.1 Your data may be used for the purposes of compiling statistics relating to our user base or loan and investment portfolio and may disclose such information to any third party for such purposes, provided that such information will always be anonymous.&nbsp;</p>\n<p>9.2 You can contact us (via hello@lendkash.com) if you believe we need some adjustment but we reserve the right to consider its effectiveness and applicability to our Policy.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>10. Violation of Privacy Policy&nbsp;</p>\n<p>10.1 lendkash will undertake all reasonable measures to ensure that your personal data remains protected with firm procedures to deal with any suspected personal data breach and will notify you of any personal data breach and let you know the steps we have taken to remedy the breach and the security measures we have applied to render your personal data unintelligible.&nbsp;</p>\n<p>10.2 All suspected breach of personal data will be remedied within three months from the date of the report of the breach.&nbsp;</p>\n<p>10.3 If you know or suspect that a personal data breach has occurred, you should immediately contact Us at hello@lendkash.com.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>11. Limitation of Liability&nbsp;</p>\n<p>LendKash will not be responsible for any personal data breach which occurs as a result of:an event which is&nbsp;</p>\n<p>i. beyond the control of LendKash;&nbsp;</p>\n<p>ii. an act or threats of terrorism war, hostilities (whether war be declared or not), invasion, act of foreign enemies, mobilisation, requisition, or embargo, rebellion, revolution, insurrection, or military or usurped power, or civil war which compromises LendKash data protection measures;&nbsp;</p>\n<p>iii. an act of God (such as, but not limited to fires, explosions, earthquakes, drought, tidal waves and floods) which compromises LendKash data protection measures;&nbsp;</p>\n<p>iv. the transfer of your personal data to a third party on your instructions;&nbsp;</p>\n<p>v. Unauthorized access to your device leading to the transfer of your personal data and&nbsp;</p>\n<p>vi. The use of your personal data by a third party designated by you.&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>12. Changes to privacy policy&nbsp;</p>\n<p>12.1 Changes may be made to this Policy to comply with the law, in line with best practices and to ensure the continued provision of LendKash Business Services to you.&nbsp;</p>\n<p>12.2 You will be notified of any changes made to this Policy within a reasonable time via email.&nbsp;</p>\n<p>12.3 The new terms may be displayed on-screen and you may be required to read and accept them to continue your use of the App or the Services.&nbsp;</p>\n<p>12.4 In any event, by continuing to use the App or any Services after the posting of any changes, you confirm your continuing acceptance of this Policy together with such changes, and your consent to the terms set out therein.&nbsp;</p>\n<p>12.5 Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to hello@lendkash.com.&nbsp;</p>', '2020-01-23 11:16:00', '2020-06-16 12:45:52'),
(4, 'description', 'Description', '<p>LendKash&reg; is a digital lending marketplace and investment platform. We leverage technology to connect creditworthy borrowers with individual and institutional investors. With Lendkash you can apply for instant micro loans with reduced rate, and also invest money with a guaranteed attractive return. You can send and receive money from family and friends with just a single tap.&nbsp;</p>\n<p>We are currently available in Nigeria. Ghana, Kenya, Uganda &ndash; Coming Soon!&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>Our Unique Features&nbsp;</p>\n<p>1. Store money securely in our Wallet. No management fees or hidden charges. 2. Reduced rate on loans as low as 2% monthly. 3. Attractive return on investments upto 20% p.a. 4. Send and Receive Money for FREE. 5. Instant withdrawal of funds to your bank account. 6. Chat with borrowers before lending. 7. Instant Support. 8. Ratings of Borrowers and Lenders.&nbsp;</p>\n<p>&nbsp;</p>\n<p>With LendKash, you can invest and borrow without barriers.&nbsp;</p>', '2020-01-23 11:16:00', '2020-06-16 12:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Behrain', '0000-00-00 00:00:00', '2019-10-17 01:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `inbox_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hold_accept_requests`
--

CREATE TABLE `hold_accept_requests` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inboxes`
--

CREATE TABLE `inboxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('single','group') COLLATE utf8mb4_bin DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `invests`
--

CREATE TABLE `invests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invest_amount` double NOT NULL,
  `invests_term` int(11) NOT NULL,
  `interest_rate` decimal(10,2) DEFAULT 0.00 COMMENT 'interest rate at the time of apply for invest',
  `maturity_amount` double(10,2) NOT NULL DEFAULT 0.00 COMMENT 'final amount of invest (FD) on maturity ',
  `status` enum('pending','approved','rejected','completed','cancelled') NOT NULL DEFAULT 'pending',
  `invest_start_date` datetime DEFAULT NULL,
  `invest_end_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lender_reject_requests`
--

CREATE TABLE `lender_reject_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_emis`
--

CREATE TABLE `loan_emis` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `emi_date` datetime NOT NULL,
  `emi_paid_date` datetime DEFAULT NULL,
  `emi_status` enum('pending','paid','pre_paid','missed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_requests`
--

CREATE TABLE `loan_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `loan_interest_rate` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'rate in percent',
  `loan_term` int(11) NOT NULL COMMENT 'monthly term (3, 6, 9, 12)',
  `total_emi` int(11) NOT NULL,
  `loan_request_amount` double(10,2) NOT NULL,
  `admin_interest_rate` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'interest rate of admin at a time request is added',
  `loan_description` text DEFAULT NULL,
  `okra_log` text DEFAULT NULL,
  `okra_record_id` varchar(255) DEFAULT NULL,
  `okra_bank_id` varchar(255) DEFAULT NULL,
  `okra_customer_id` varchar(255) DEFAULT NULL,
  `loan_status` enum('pending','approved','waiting','active','rejected','cancelled','completed','expired') NOT NULL DEFAULT 'pending',
  `loan_cancelled_reason` text DEFAULT NULL,
  `received_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `payment_frequency` varchar(50) DEFAULT NULL COMMENT 'Default monthly',
  `loan_request_date` datetime NOT NULL,
  `request_expiry_date` datetime DEFAULT NULL,
  `last_emi_date` datetime DEFAULT NULL,
  `next_emi_date` datetime DEFAULT NULL,
  `next_emi_id` int(11) DEFAULT NULL,
  `loan_start_date` datetime DEFAULT NULL,
  `loan_end_date` datetime DEFAULT NULL,
  `loan_amount_with_interest` double(10,2) NOT NULL DEFAULT 0.00,
  `emi_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_request_lenders`
--

CREATE TABLE `loan_request_lenders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `paid_amount` double(10,2) NOT NULL,
  `payment_status` enum('paid','reject') NOT NULL DEFAULT 'paid',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manage_faqs`
--

CREATE TABLE `manage_faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, '2020_01_13_093731_create_invests_table', 0),
(2, '2020_01_13_093731_create_loan_emis_table', 0),
(3, '2020_01_13_093731_create_loan_request_lenders_table', 0),
(4, '2020_01_13_093731_create_loan_requests_table', 0),
(5, '2020_01_13_093731_create_money_requests_table', 0),
(6, '2020_01_13_093731_create_ratings_table', 0),
(7, '2020_01_13_093731_create_settings_table', 0),
(8, '2020_01_13_093731_create_user_details_table', 0),
(9, '2020_01_13_093731_create_users_table', 0),
(10, '2020_01_13_093731_create_wallets_table', 0),
(11, '2020_01_13_093732_add_foreign_keys_to_invests_table', 0),
(12, '2020_01_13_093732_add_foreign_keys_to_loan_emis_table', 0),
(13, '2020_01_13_093732_add_foreign_keys_to_loan_request_lenders_table', 0),
(14, '2020_01_13_093732_add_foreign_keys_to_loan_requests_table', 0),
(15, '2020_01_13_093732_add_foreign_keys_to_money_requests_table', 0),
(16, '2020_01_13_093732_add_foreign_keys_to_ratings_table', 0),
(17, '2020_01_13_093732_add_foreign_keys_to_user_details_table', 0),
(18, '2020_01_13_093732_add_foreign_keys_to_wallets_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `money_requests`
--

CREATE TABLE `money_requests` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `notification_data` text DEFAULT NULL,
  `is_read` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `transaction_ref` varchar(255) DEFAULT NULL,
  `transaction_fee` float(10,2) NOT NULL DEFAULT 0.00,
  `transaction_message` varchar(255) DEFAULT NULL,
  `type` enum('loan','invest','add_money','send_money','bank_transfer') NOT NULL DEFAULT 'loan',
  `currency` varchar(100) NOT NULL,
  `charged_amount` int(10) DEFAULT NULL,
  `ip_ref` varchar(100) DEFAULT NULL,
  `payment_status` enum('pending','successful','failed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_type` varchar(100) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `charge_type` varchar(255) DEFAULT NULL,
  `order_ref` varchar(255) DEFAULT NULL,
  `rave_ref` varchar(255) DEFAULT NULL,
  `logs` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `account_number` int(100) DEFAULT NULL,
  `card_number` int(10) DEFAULT NULL,
  `account_bank` int(11) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `reviews` text DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saved_cards`
--

CREATE TABLE `saved_cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry_month` int(10) NOT NULL,
  `expiry_year` int(10) NOT NULL,
  `card_bin` varchar(125) NOT NULL,
  `last_four_digits` int(10) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `issuing_country` varchar(255) NOT NULL,
  `type` varchar(150) NOT NULL,
  `card_tokens` text NOT NULL,
  `embed_token` text NOT NULL,
  `log` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`, `comments`, `created_at`, `updated_at`) VALUES
(1, 'one_month_admin_loan_commission', '55.00', NULL, '2020-01-16 06:13:15', '2020-02-27 12:01:14'),
(2, 'three_month_admin_loan_commission', '26.00', NULL, '2020-01-16 00:00:00', '2020-02-27 12:01:14'),
(3, 'six_month_admin_loan_commission', '10.00', NULL, '2020-01-16 00:00:00', '2020-02-27 12:01:14'),
(4, 'twelve_month_admin_loan_commission', '15.00', NULL, '2020-01-16 00:00:00', '2020-02-27 12:01:14'),
(5, 'six_month_interest', '8.50', NULL, '2020-01-16 00:00:00', '2020-07-27 09:28:59'),
(6, 'twelve_month_interest', '12.50', NULL, '2020-01-16 00:00:00', '2020-07-27 09:29:00'),
(7, 'wallet_commission_to_bank_account', '15.50', NULL, '2020-01-16 00:00:00', '2020-07-27 09:28:58'),
(8, 'commission_for_loan_request', '9.35', NULL, '2020-01-16 00:00:00', '2020-07-27 09:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Abia\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(2, 1, 'Adamawa', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(3, 1, 'Akwa Ibom', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(4, 1, 'Anambra', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(5, 1, 'Bauchi\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(6, 1, 'Bayelsa', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(7, 1, 'Benue', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(8, 1, 'Borno', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(9, 1, 'Cross River\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(10, 1, 'Delta', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(11, 1, 'Ebonyi', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(12, 1, 'Edo', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(13, 1, 'Ekiti\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(14, 1, 'Enugu', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(15, 1, 'Federal Capital Territory', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(16, 1, 'Gombe', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(17, 1, 'Imo\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(18, 1, 'Jigawa', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(19, 1, 'Kaduna', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(20, 1, 'Kano', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(21, 1, 'Katsina\r\n', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(22, 1, 'Kebbi', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(23, 1, 'Kogi', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(24, 1, 'Kwara', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(25, 1, 'Lagos', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(26, 1, 'Nasarawa', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(27, 1, 'Niger', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(28, 1, 'Ogun', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(29, 1, 'Ondo', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(30, 1, 'Osun', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(31, 1, 'Oyo', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(32, 1, 'Plateau', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(33, 1, 'Rivers', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(34, 1, 'Sokoto', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(35, 1, 'Taraba', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(36, 1, 'Yobe', '0000-00-00 00:00:00', '2020-01-14 18:07:35'),
(37, 1, 'Zamfara', '0000-00-00 00:00:00', '2020-01-14 18:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unpaid_emis`
--

CREATE TABLE `unpaid_emis` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `emi_id` int(10) NOT NULL,
  `emi_number` int(10) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `emi_paid_date` datetime DEFAULT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_token` varchar(255) DEFAULT NULL,
  `mobile_number` bigint(20) NOT NULL,
  `otp` int(4) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('inactive','active','deleted') NOT NULL DEFAULT 'active',
  `otp_status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `password_token`, `mobile_number`, `otp`, `role`, `status`, `otp_status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(5, 'Admin', 'admin@mailinator.com', '$2y$10$qtkJog8zwH/hYj39lCXvYO2hXHehb2iHRHYpsdN9NqsR3fmVaXg0K', '51e190005a33e49748d0fa241a7681d6a388f5b7162a3a6a35ddf48982ba5caf', 3434343433, 7052, 'admin', 'active', 'inactive', 0, '2020-01-27 11:20:44', '2020-03-02 10:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `employer_detail` text DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT 0,
  `kyc_status` tinyint(4) NOT NULL DEFAULT 0,
  `bank_name` varchar(100) DEFAULT NULL,
  `bvn` varchar(50) DEFAULT NULL,
  `account_holder_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `id_proof_document` varchar(255) DEFAULT NULL,
  `employment_document` varchar(255) DEFAULT NULL,
  `wallet_balance` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `dob`, `user_image`, `address`, `employer_detail`, `country_id`, `state_id`, `city_id`, `is_approved`, `kyc_status`, `bank_name`, `bvn`, `account_holder_name`, `account_number`, `id_proof_document`, `employment_document`, `wallet_balance`, `created_at`, `updated_at`) VALUES
(1, 5, '2020-10-13', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, '0000-00-00 00:00:00', '2020-10-19 17:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `authorization` text NOT NULL,
  `device_id` text NOT NULL,
  `device_type` varchar(50) NOT NULL,
  `certification_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `emi_id` int(11) DEFAULT NULL,
  `transaction_type` enum('loan','invest','wallet','loan_emi','add_money','bank_transfer','lender_hold_amount') NOT NULL,
  `payment_type` enum('debit','credit') NOT NULL,
  `amount` double(10,2) NOT NULL,
  `send_money_type` enum('no','yes') NOT NULL DEFAULT 'no',
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_masters`
--
ALTER TABLE `bank_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_from_id_foreign` (`from_id`),
  ADD KEY `chats_inbox_id_foreign` (`inbox_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_members_user_id_foreign` (`user_id`),
  ADD KEY `group_members_inbox_id_foreign` (`inbox_id`);

--
-- Indexes for table `hold_accept_requests`
--
ALTER TABLE `hold_accept_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inboxes`
--
ALTER TABLE `inboxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `invests`
--
ALTER TABLE `invests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lender_reject_requests`
--
ALTER TABLE `lender_reject_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `loan_emis`
--
ALTER TABLE `loan_emis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `loan_requests`
--
ALTER TABLE `loan_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `loan_request_lenders`
--
ALTER TABLE `loan_request_lenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `manage_faqs`
--
ALTER TABLE `manage_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_requests`
--
ALTER TABLE `money_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`),
  ADD KEY `rating_details_ibfk_1` (`request_id`);

--
-- Indexes for table `saved_cards`
--
ALTER TABLE `saved_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`user_id`),
  ADD KEY `rating_details_ibfk_1` (`request_id`);

--
-- Indexes for table `unpaid_emis`
--
ALTER TABLE `unpaid_emis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `emi_id` (`emi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_masters`
--
ALTER TABLE `bank_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hold_accept_requests`
--
ALTER TABLE `hold_accept_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inboxes`
--
ALTER TABLE `inboxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invests`
--
ALTER TABLE `invests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lender_reject_requests`
--
ALTER TABLE `lender_reject_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_emis`
--
ALTER TABLE `loan_emis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_requests`
--
ALTER TABLE `loan_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan_request_lenders`
--
ALTER TABLE `loan_request_lenders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manage_faqs`
--
ALTER TABLE `manage_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `money_requests`
--
ALTER TABLE `money_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_cards`
--
ALTER TABLE `saved_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unpaid_emis`
--
ALTER TABLE `unpaid_emis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cities_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invests`
--
ALTER TABLE `invests`
  ADD CONSTRAINT `invests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lender_reject_requests`
--
ALTER TABLE `lender_reject_requests`
  ADD CONSTRAINT `lender_reject_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lender_reject_requests_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_emis`
--
ALTER TABLE `loan_emis`
  ADD CONSTRAINT `loan_emis_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_requests`
--
ALTER TABLE `loan_requests`
  ADD CONSTRAINT `loan_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_request_lenders`
--
ALTER TABLE `loan_request_lenders`
  ADD CONSTRAINT `loan_request_lenders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_request_lenders_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `money_requests`
--
ALTER TABLE `money_requests`
  ADD CONSTRAINT `money_requests_ibfk_1` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_requests_ibfk_2` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_cards`
--
ALTER TABLE `saved_cards`
  ADD CONSTRAINT `saved_cards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support`
--
ALTER TABLE `support`
  ADD CONSTRAINT `support_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unpaid_emis`
--
ALTER TABLE `unpaid_emis`
  ADD CONSTRAINT `unpaid_emis_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `loan_requests` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `unpaid_emis_ibfk_2` FOREIGN KEY (`emi_id`) REFERENCES `loan_emis` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD CONSTRAINT `user_devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
