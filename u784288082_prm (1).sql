-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 26, 2026 at 06:06 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u784288082_prm`
--

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
('digitech-healthcare-cache-08d898a14bad143cf8ffec6bac80b92d', 'i:1;', 1779279536),
('digitech-healthcare-cache-08d898a14bad143cf8ffec6bac80b92d:timer', 'i:1779279536;', 1779279536),
('digitech-healthcare-cache-0ba6694f28ebe429296cfc7cbe8f85bc', 'i:1;', 1776411716),
('digitech-healthcare-cache-0ba6694f28ebe429296cfc7cbe8f85bc:timer', 'i:1776411716;', 1776411716),
('digitech-healthcare-cache-443c75cc49fdc52be71827a7046d37f6', 'i:2;', 1779700218),
('digitech-healthcare-cache-443c75cc49fdc52be71827a7046d37f6:timer', 'i:1779700218;', 1779700218),
('digitech-healthcare-cache-54349b008ad10abe7f4feed242aa0dce', 'i:1;', 1777445693),
('digitech-healthcare-cache-54349b008ad10abe7f4feed242aa0dce:timer', 'i:1777445693;', 1777445693),
('digitech-healthcare-cache-582990e9ce973864fbb799ece9c89df1', 'i:1;', 1776418782),
('digitech-healthcare-cache-582990e9ce973864fbb799ece9c89df1:timer', 'i:1776418782;', 1776418782),
('digitech-healthcare-cache-660968734958d35b7afd4d97622889ab', 'i:1;', 1778744053),
('digitech-healthcare-cache-660968734958d35b7afd4d97622889ab:timer', 'i:1778744053;', 1778744053),
('digitech-healthcare-cache-7da5218472d76eebc3e3927ae10ec6d4', 'i:1;', 1779707529),
('digitech-healthcare-cache-7da5218472d76eebc3e3927ae10ec6d4:timer', 'i:1779707529;', 1779707529),
('digitech-healthcare-cache-a997feccf75815eeb186871db9f05484', 'i:1;', 1779269558),
('digitech-healthcare-cache-a997feccf75815eeb186871db9f05484:timer', 'i:1779269558;', 1779269558),
('digitech-healthcare-cache-c2be61ea3c8af284f517107b1608c870', 'i:1;', 1773644771),
('digitech-healthcare-cache-c2be61ea3c8af284f517107b1608c870:timer', 'i:1773644771;', 1773644771),
('digitech-healthcare-cache-c525a5357e97fef8d3db25841c86da1a', 'i:1;', 1776420303),
('digitech-healthcare-cache-c525a5357e97fef8d3db25841c86da1a:timer', 'i:1776420303;', 1776420303),
('digitech-healthcare-cache-c8eeedf7a2ea26bb7f04c0daa3f706b4', 'i:1;', 1779441223),
('digitech-healthcare-cache-c8eeedf7a2ea26bb7f04c0daa3f706b4:timer', 'i:1779441223;', 1779441223),
('digitech-healthcare-cache-cceae3f5e5815bfe3d68889bc3703b08', 'i:1;', 1772272604),
('digitech-healthcare-cache-cceae3f5e5815bfe3d68889bc3703b08:timer', 'i:1772272604;', 1772272604),
('digitech-healthcare-cache-db414e4fc6cd73bafae86b7bac2a2ed6', 'i:1;', 1773655615),
('digitech-healthcare-cache-db414e4fc6cd73bafae86b7bac2a2ed6:timer', 'i:1773655615;', 1773655615),
('digitech-healthcare-cache-df01e7e6ca58f4cff82790bcc4a10978', 'i:1;', 1779352691),
('digitech-healthcare-cache-df01e7e6ca58f4cff82790bcc4a10978:timer', 'i:1779352691;', 1779352691),
('digitech-healthcare-cache-f69b58748e947f887434a4b0dafe1f9c', 'i:4;', 1778575978),
('digitech-healthcare-cache-f69b58748e947f887434a4b0dafe1f9c:timer', 'i:1778575978;', 1778575978),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1771228382),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1771228382;', 1771228382),
('laravel-cache-80340737b69afca398a2d6acdb685377', 'i:1;', 1770637811),
('laravel-cache-80340737b69afca398a2d6acdb685377:timer', 'i:1770637811;', 1770637811),
('laravel-cache-9abab034609a1bf6d14db6d7884ac1dd', 'i:1;', 1771585018),
('laravel-cache-9abab034609a1bf6d14db6d7884ac1dd:timer', 'i:1771585018;', 1771585018),
('laravel-cache-a94cce5ae94eb6c2e4a81c288f85dbbf', 'i:1;', 1771239541),
('laravel-cache-a94cce5ae94eb6c2e4a81c288f85dbbf:timer', 'i:1771239541;', 1771239541),
('laravel-cache-arjun@gmail.com|127.0.0.1', 'i:1;', 1770637811),
('laravel-cache-arjun@gmail.com|127.0.0.1:timer', 'i:1770637811;', 1770637811),
('laravel-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:23:\"Laravel\\Roster\\Approach\":1:{s:11:\"\0*\0approach\";E:38:\"Laravel\\Roster\\Enums\\Approaches:ACTION\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:11:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.30\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:FORTIFY\";s:14:\"\0*\0packageName\";s:15:\"laravel/fortify\";s:10:\"\0*\0version\";s:6:\"1.34.1\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.50.0\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:7:\"v0.3.12\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:6:\"0.3.12\";s:6:\"\0*\0dev\";b:0;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:6:\"^2.9.0\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:FLUXUI_FREE\";s:14:\"\0*\0packageName\";s:13:\"livewire/flux\";s:10:\"\0*\0version\";s:6:\"2.11.1\";s:6:\"\0*\0dev\";b:0;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^4.0\";s:10:\"\0*\0package\";E:38:\"Laravel\\Roster\\Enums\\Packages:LIVEWIRE\";s:14:\"\0*\0packageName\";s:17:\"livewire/livewire\";s:10:\"\0*\0version\";s:5:\"4.1.3\";s:6:\"\0*\0dev\";b:0;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.5.5\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.5.5\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.27.0\";s:6:\"\0*\0dev\";b:1;}i:7;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.52.0\";s:6:\"\0*\0dev\";b:1;}i:8;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:4:\"^4.3\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PEST\";s:14:\"\0*\0packageName\";s:12:\"pestphp/pest\";s:10:\"\0*\0version\";s:5:\"4.3.2\";s:6:\"\0*\0dev\";b:1;}i:9;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"12.5.8\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:6:\"12.5.8\";s:6:\"\0*\0dev\";b:1;}i:10;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:0:\"\";s:10:\"\0*\0package\";E:41:\"Laravel\\Roster\\Enums\\Packages:TAILWINDCSS\";s:14:\"\0*\0packageName\";s:11:\"tailwindcss\";s:10:\"\0*\0version\";s:6:\"4.1.18\";s:6:\"\0*\0dev\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1770702143;}', 1770788543),
('laravel-cache-c525a5357e97fef8d3db25841c86da1a', 'i:1;', 1771227205),
('laravel-cache-c525a5357e97fef8d3db25841c86da1a:timer', 'i:1771227205;', 1771227205),
('laravel-cache-cc7790c8e690f63491c163e634e89500', 'i:1;', 1771391655),
('laravel-cache-cc7790c8e690f63491c163e634e89500:timer', 'i:1771391655;', 1771391655),
('laravel-cache-cceae3f5e5815bfe3d68889bc3703b08', 'i:1;', 1772271722),
('laravel-cache-cceae3f5e5815bfe3d68889bc3703b08:timer', 'i:1772271722;', 1772271722),
('laravel-cache-df1c5126b5df6c1cca241bceac517d83', 'i:1;', 1771911085),
('laravel-cache-df1c5126b5df6c1cca241bceac517d83:timer', 'i:1771911085;', 1771911085),
('laravel-cache-e006b8ef0cd61fe3bf1279921af1df4f', 'i:1;', 1771486134),
('laravel-cache-e006b8ef0cd61fe3bf1279921af1df4f:timer', 'i:1771486134;', 1771486134),
('laravel-cache-e587b2c076d95e9751f5d58e59d5fccf', 'i:1;', 1772171411),
('laravel-cache-e587b2c076d95e9751f5d58e59d5fccf:timer', 'i:1772171411;', 1772171411);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `gst_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `company_name`, `gst_number`, `gst_enabled`, `address`, `dob`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Dr. Kanika Roy', 'kanika.2kool@gmail.com', '88001 66035', 'Dr. Kanika Roy', '', 0, NULL, NULL, 'active', '2026-05-21 06:39:40', '2026-05-21 06:39:40', NULL),
(5, 'DR. AMRENDRA PATHAK', 'gangaram@sgrh.com', '+91 11-42254000', 'DR. AMRENDRA PATHAK', '', 0, NULL, NULL, 'active', '2026-05-22 10:48:00', '2026-05-22 10:48:00', NULL),
(6, 'DR. PEEYUSH KUMAR', 'reachus@fortishealthcare.com', '91-124 4921021', 'DR. PEEYUSH KUMAR', '', 0, NULL, NULL, 'active', '2026-05-22 11:27:02', '2026-05-22 11:27:02', NULL),
(7, 'DR. LOKESH HM', 'drlokeshhm@gmail.com', '', 'DR. LOKESH HM', '', 0, NULL, NULL, 'active', '2026-05-22 11:55:34', '2026-05-22 11:55:34', NULL),
(8, 'Ayushi Digitech', 'ayushi.hrdigitech@gmail.com', '', '', '', 0, NULL, '2026-05-28', 'active', '2026-05-25 09:40:04', '2026-05-25 09:41:15', '2026-05-25 09:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `registrar` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `renewal_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domains`
--

INSERT INTO `domains` (`id`, `client_id`, `name`, `registrar`, `purchase_date`, `expiry_date`, `renewal_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 4, 'drkanikaroy.com', 'Hostinger', '2024-01-11', '2028-03-30', 1200.00, 'active', NULL, '2026-05-25 09:17:47', '2026-05-25 09:30:33');

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
-- Table structure for table `hostings`
--

CREATE TABLE `hostings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `domain_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `renewal_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hostings`
--

INSERT INTO `hostings` (`id`, `client_id`, `domain_id`, `provider`, `plan_name`, `ip_address`, `username`, `password`, `purchase_date`, `expiry_date`, `renewal_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 'Hostinger', 'shared hosting', NULL, NULL, NULL, '2026-05-25', '2026-05-30', 904.00, 'active', NULL, '2026-05-25 09:19:12', '2026-05-25 09:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client_id`, `subscription_id`, `invoice_number`, `invoice_date`, `due_date`, `subtotal`, `discount`, `tax`, `total_amount`, `payment_status`, `payment_method`, `created_at`, `updated_at`) VALUES
(5, 4, NULL, 'INV-6A1415B03F203', '2026-05-25', '2026-06-01', 3104.00, 0.00, 0.00, 3104.00, 'paid', 'cash', '2026-05-25 09:26:08', '2026-05-25 09:30:33'),
(6, 4, 3, 'INV-6A1416DDF162F', '2026-05-25', '2026-05-15', 63999.99, 0.00, 0.00, 63999.99, 'unpaid', NULL, '2026-05-25 09:31:09', '2026-05-25 09:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` varchar(255) NOT NULL DEFAULT 'custom',
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `item_type`, `item_id`, `description`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(9, 5, 'domain', 2, 'Domain Renewal: drkanikaroy.com', 1, 1200.00, 1200.00, '2026-05-25 09:26:08', '2026-05-25 09:26:08'),
(10, 5, 'hosting', 1, 'Hosting Renewal: shared hosting', 1, 904.00, 904.00, '2026-05-25 09:26:08', '2026-05-25 09:26:08'),
(11, 5, 'custom', NULL, 'TA', 1, 1000.00, 1000.00, '2026-05-25 09:26:08', '2026-05-25 09:26:08'),
(13, 6, 'package', 5, 'Gold Plan', 1, 63999.99, 63999.99, '2026-05-25 09:47:35', '2026-05-25 09:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
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
(4, '2025_08_14_170933_add_two_factor_columns_to_users_table', 1),
(5, '2026_02_09_071331_create_clients_table', 1),
(6, '2026_02_09_071331_create_packages_table', 1),
(7, '2026_02_09_071332_create_subscriptions_table', 1),
(8, '2026_02_09_071334_create_invoices_table', 1),
(9, '2026_02_09_071335_create_invoice_items_table', 1),
(10, '2026_02_09_073955_add_soft_deletes_to_clients_table', 1),
(11, '2026_02_09_104031_add_parent_subscription_id_to_subscriptions_table', 1),
(12, '2026_02_09_111151_create_services_table', 1),
(13, '2026_02_09_111154_create_package_service_table', 1),
(14, '2026_02_09_111158_create_subscription_services_table', 1),
(15, '2026_02_09_114121_create_payments_table', 1),
(16, '2026_02_10_054931_add_columns_to_payments_table', 2),
(17, '2026_02_10_063243_add_cancellation_fields_to_subscriptions_table', 3),
(18, '2026_02_11_060723_add_type_to_invoice_items_table', 4),
(19, '2026_02_11_064714_add_payment_method_to_invoices_table', 5),
(20, '2026_02_11_105648_create_domains_table', 6),
(21, '2026_02_11_105653_create_hostings_table', 6),
(22, '2026_02_12_103436_add_gst_columns_to_clients_table', 7),
(23, '2026_02_12_104151_add_address_to_clients_table', 8),
(24, '2026_04_17_112353_create_personal_access_tokens_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `duration_months`, `base_price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Silver Plan', 1, 12000.00, '', 'active', '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(3, 'Silver Plan', 3, 35000.00, '', 'active', '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(4, 'Gold Plan', 1, 18000.00, '', 'active', '2026-05-21 07:33:12', '2026-05-21 07:33:12'),
(5, 'Gold Plan', 3, 63999.99, '', 'active', '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(6, 'Diamond Plan', 1, 20000.00, '', 'active', '2026-05-21 07:37:14', '2026-05-21 07:37:49'),
(7, 'Diamond Plan', 3, 60000.00, '', 'active', '2026-05-21 07:38:51', '2026-05-21 07:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_service`
--

INSERT INTO `package_service` (`id`, `package_id`, `service_id`, `quantity`, `created_at`, `updated_at`) VALUES
(4, 2, 8, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(5, 2, 6, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(6, 2, 7, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(7, 2, 9, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(8, 2, 4, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(9, 2, 5, 1, '2026-05-21 07:30:24', '2026-05-21 07:30:24'),
(10, 3, 8, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(11, 3, 6, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(12, 3, 7, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(13, 3, 9, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(14, 3, 4, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(15, 3, 5, 1, '2026-05-21 07:31:52', '2026-05-21 07:31:52'),
(16, 4, 20, 1, '2026-05-21 07:33:12', '2026-05-21 07:34:08'),
(17, 4, 18, 1, '2026-05-21 07:33:12', '2026-05-21 07:34:08'),
(18, 4, 16, 1, '2026-05-21 07:33:12', '2026-05-21 07:34:08'),
(19, 4, 12, 1, '2026-05-21 07:33:12', '2026-05-21 07:34:08'),
(20, 4, 10, 1, '2026-05-21 07:33:12', '2026-05-21 07:34:08'),
(21, 4, 22, 1, '2026-05-21 07:34:08', '2026-05-21 07:34:08'),
(22, 5, 20, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(23, 5, 22, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(24, 5, 16, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(25, 5, 18, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(26, 5, 10, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(27, 5, 12, 1, '2026-05-21 07:35:10', '2026-05-21 07:35:10'),
(28, 6, 21, 1, '2026-05-21 07:37:14', '2026-05-21 07:38:04'),
(29, 6, 17, 1, '2026-05-21 07:37:14', '2026-05-21 07:38:04'),
(30, 6, 19, 1, '2026-05-21 07:37:14', '2026-05-21 07:38:04'),
(31, 6, 11, 1, '2026-05-21 07:37:14', '2026-05-21 07:38:04'),
(32, 6, 13, 1, '2026-05-21 07:37:14', '2026-05-21 07:38:04'),
(33, 6, 15, 1, '2026-05-21 07:38:04', '2026-05-21 07:38:04'),
(34, 7, 21, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51'),
(35, 7, 15, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51'),
(36, 7, 17, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51'),
(37, 7, 19, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51'),
(38, 7, 11, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51'),
(39, 7, 13, 1, '2026-05-21 07:38:51', '2026-05-21 07:38:51');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `created_at`, `updated_at`, `invoice_id`, `amount`, `payment_method`, `transaction_reference`, `paid_at`, `notes`) VALUES
(2, '2026-05-25 09:30:33', '2026-05-25 09:30:33', 5, 3104.00, 'cash', 'MANUAL-MARK-PAID', '2026-05-25 09:30:33', 'Marked as paid via admin interface');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `base_price`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Basic Website', NULL, NULL, 'active', '2026-05-21 06:41:21', '2026-05-21 07:04:05'),
(5, 'Basic Website SEO', NULL, NULL, 'active', '2026-05-21 06:41:39', '2026-05-21 07:08:44'),
(6, 'Basic Local SEO', NULL, NULL, 'active', '2026-05-21 06:41:51', '2026-05-21 07:10:26'),
(7, 'Basic Social Media', NULL, NULL, 'active', '2026-05-21 06:42:04', '2026-05-21 07:12:25'),
(8, 'Basic Graphic', NULL, NULL, 'active', '2026-05-21 06:42:15', '2026-05-21 07:07:26'),
(9, 'Basic Video', NULL, NULL, 'active', '2026-05-21 06:42:34', '2026-05-21 07:21:56'),
(10, 'Standard Website', NULL, NULL, 'active', '2026-05-21 07:06:25', '2026-05-21 07:20:59'),
(11, 'Premium Website', NULL, NULL, 'active', '2026-05-21 07:06:57', '2026-05-21 07:06:57'),
(12, 'Standard Website SEO', NULL, NULL, 'active', '2026-05-21 07:09:10', '2026-05-21 07:21:19'),
(13, 'Premium Website SEO', NULL, NULL, 'active', '2026-05-21 07:09:43', '2026-05-21 07:09:43'),
(15, 'Premium Local SEO', NULL, NULL, 'active', '2026-05-21 07:11:17', '2026-05-21 07:11:17'),
(16, 'Standard Social Media', NULL, NULL, 'active', '2026-05-21 07:13:18', '2026-05-21 07:20:11'),
(17, 'Premium Social Media', NULL, NULL, 'active', '2026-05-21 07:13:51', '2026-05-21 07:15:22'),
(18, 'Standard Video', NULL, NULL, 'active', '2026-05-21 07:22:44', '2026-05-21 07:22:44'),
(19, 'Premium Video', NULL, NULL, 'active', '2026-05-21 07:23:25', '2026-05-21 07:23:25'),
(20, 'Standard Graphic', NULL, NULL, 'active', '2026-05-21 07:24:14', '2026-05-21 07:24:14'),
(21, 'Premium Graphic', NULL, NULL, 'active', '2026-05-21 07:24:39', '2026-05-21 07:24:39'),
(22, 'Standard Local SEO', NULL, NULL, 'active', '2026-05-21 07:33:40', '2026-05-21 07:33:40');

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
('2lnk9nEI8qrD1f5oIF82jfls6PiuDop3dq7ji4Z6', NULL, '34.58.152.180', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWROWjdBVUcySVplMTNtMFREMTROY2tPbVRRR01hNlRVWTJJN1A0ViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1779717011),
('3iyxIf38hSaDabcu67rGwPUWEV4hyLm06GM1A9rQ', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicVBBNFlaY0NLdlBCbUxsMGxFUEVrM2M3dVpjUGd2Rlg4SDJXczVHWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1779710386),
('3PDdxZOQQ8yGHWrET0cu4EzC9wYBsD2nq2wDyWYB', 1, '2401:4900:1c5a:9e77:2472:c9de:a5ff:6a20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicGJzRW5XeUlPQllCVENHcnAxa3VCTWhmdVVybTdwTjUwS1RDME9EaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vc3Vic2NyaXB0aW9ucyI7czo1OiJyb3V0ZSI7czoxOToic3Vic2NyaXB0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1779705033),
('b9SFQrcK0bXg5iIeeQseeUPwM2g0mS4p1fIYRhMg', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0xoQTBCa1dPTm5aMnI4ZnlFMmZzOUNzREdVQmZJVGlScGpaRE9sMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1779710386),
('BMlQzkCgfzjXr7ioEA4Sv9Nenxk8ixMe6mOONNpM', NULL, '2600:1f16:743:ac00:1752:36dc:400f:b80f', 'visionheight.com/scan Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidDRCQUJuWVpKNXVkRkljcXRSaUN2N1JQNWV4VHo5SzF4R3hHU3ZDOSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly9jcm0uZGlnaXRlY2hoZWFsdGhjYXJlLmNvbS9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1779751438),
('HVDKwdIhqRsEtjGk06GpIzZjVUsvNhiZP4AaJRbk', NULL, '2600:1f16:743:ac00:1752:36dc:400f:b80f', 'visionheight.com/scan Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWhmaFpWWGdMeHFHS2JkMUllcGxsSWFlSk9idzE1M2pIRGpwdG5YbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1779751439),
('iAPefZzTXjQKzp7Kv0wnNg0orVPrinGjP2hP2E4H', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFN2RVlnY2F6Z2hVaGZFTTI0MkVVVlFpMUNTcVZETWQyanltbG1OdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779710386),
('lHcGpUcENIW6F5Cnjqu1jqhuYtS0hEi8CrHFoswq', NULL, '34.58.152.180', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2syU0UxbFNJWFZuMHJIQ05tdVZQYnVxMGxZMnZraXV4ajltZlhmbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1779717012),
('R1sKKtISGUEjMyZuzzrTeLtxSVRGjApN1sr62gWp', NULL, '34.58.152.180', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia3VMNGJURWNnTUZoV0h3ZjZ4QlFyY295NDNyQUVnODNLdjhLMWVmeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779717011),
('sw8lWevRYumS5smbdVonI5M7HvoAxctxQkaDxn2p', NULL, '2600:1f16:743:ac00:1752:36dc:400f:b80f', 'visionheight.com/scan Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEdRTzlPOFVkQmR5cjA4QjZVUmRMWU9EajU0eURSR3c1MXJ5N2x5ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779751438),
('UyrPH75N02aeuOHBNa3SY5x2khZW2OwfxODmMg1m', NULL, '2401:4900:1c5a:9e77:5cc9:a074:2d63:d25e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUWkwNDVKaUNFMFFiNnM0RXR5SmZMVGJTZzlWNUVaWXoxUmZQd2xubCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQ0OiJodHRwczovL2NybS5kaWdpdGVjaGhlYWx0aGNhcmUuY29tL2Rhc2hib2FyZCI7fX0=', 1779775374),
('vTGjhA9cn1dQm3uJ4kga9BQMJnjIs4QJ6fs4t4xI', 1, '2401:4900:1c5a:9e77:5cc9:a074:2d63:d25e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1BXSGltNXRCSFlTZHFsdUVsVEpzWUZkYjlrU0t3UXVwMzdJU2R2QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vY3JtLmRpZ2l0ZWNoaGVhbHRoY2FyZS5jb20vaW52b2ljZXMvNi9wZGYiO3M6NToicm91dGUiO3M6MTI6Imludm9pY2VzLnBkZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1779712164);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price_before_discount` decimal(10,2) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_subscription_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `client_id`, `package_id`, `start_date`, `end_date`, `price_before_discount`, `discount_type`, `discount_value`, `final_price`, `status`, `cancelled_at`, `cancellation_reason`, `created_at`, `updated_at`, `parent_subscription_id`) VALUES
(3, 4, 5, '2026-05-21', '2026-08-21', 63999.99, NULL, 0.00, 63999.99, 'active', NULL, NULL, '2026-05-21 07:40:09', '2026-05-21 07:40:09', NULL),
(4, 4, 7, '2026-05-25', '2026-08-25', 60000.00, 'flat', 5000.00, 55000.00, 'active', NULL, NULL, '2026-05-25 09:43:56', '2026-05-25 09:43:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_services`
--

CREATE TABLE `subscription_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_services`
--

INSERT INTO `subscription_services` (`id`, `subscription_id`, `service_name`, `service_price`, `quantity`, `created_at`, `updated_at`) VALUES
(5, 3, 'Standard Website', 0.00, 1, '2026-05-21 07:40:09', '2026-05-21 07:40:09'),
(6, 3, 'Standard Website SEO', 0.00, 1, '2026-05-21 07:40:09', '2026-05-21 07:40:09'),
(7, 3, 'Standard Social Media', 0.00, 1, '2026-05-21 07:40:10', '2026-05-21 07:40:10'),
(8, 3, 'Standard Video', 0.00, 1, '2026-05-21 07:40:10', '2026-05-21 07:40:10'),
(9, 3, 'Standard Graphic', 0.00, 1, '2026-05-21 07:40:10', '2026-05-21 07:40:10'),
(10, 3, 'Standard Local SEO', 0.00, 1, '2026-05-21 07:40:10', '2026-05-21 07:40:10'),
(11, 4, 'Premium Website', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57'),
(12, 4, 'Premium Website SEO', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57'),
(13, 4, 'Premium Local SEO', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57'),
(14, 4, 'Premium Social Media', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57'),
(15, 4, 'Premium Video', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57'),
(16, 4, 'Premium Graphic', 0.00, 1, '2026-05-25 09:43:57', '2026-05-25 09:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Arjun Sharma', 'admin@gmail.com', NULL, '$2y$12$qi0iRNiAmNAbvKnX.TJ8o.Vo2wgzKzh/IiY618CAQAWGSF3q1vVfO', NULL, NULL, NULL, NULL, '2026-02-09 06:21:14', '2026-02-09 06:21:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domains_name_unique` (`name`),
  ADD KEY `domains_client_id_foreign` (`client_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hostings`
--
ALTER TABLE `hostings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hostings_client_id_foreign` (`client_id`),
  ADD KEY `hostings_domain_id_foreign` (`domain_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_client_id_foreign` (`client_id`),
  ADD KEY `invoices_subscription_id_foreign` (`subscription_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

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
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_service_package_id_service_id_unique` (`package_id`,`service_id`),
  ADD KEY `package_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_client_id_foreign` (`client_id`),
  ADD KEY `subscriptions_package_id_foreign` (`package_id`),
  ADD KEY `subscriptions_parent_subscription_id_foreign` (`parent_subscription_id`);

--
-- Indexes for table `subscription_services`
--
ALTER TABLE `subscription_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_services_subscription_id_foreign` (`subscription_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostings`
--
ALTER TABLE `hostings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `package_service`
--
ALTER TABLE `package_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subscription_services`
--
ALTER TABLE `subscription_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `domains_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hostings`
--
ALTER TABLE `hostings`
  ADD CONSTRAINT `hostings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hostings_domain_id_foreign` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `invoices_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `package_service`
--
ALTER TABLE `package_service`
  ADD CONSTRAINT `package_service_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `subscriptions_parent_subscription_id_foreign` FOREIGN KEY (`parent_subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subscription_services`
--
ALTER TABLE `subscription_services`
  ADD CONSTRAINT `subscription_services_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
