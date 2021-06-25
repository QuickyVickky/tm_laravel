-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2021 at 01:54 PM
-- Server version: 10.5.10-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostapps_taskmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(111) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'email',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'E' COMMENT 'A-SuperAdmin, E- Employee',
  `active_session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipaddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `uuid`, `fullname`, `email`, `mobile`, `password`, `is_active`, `created_at`, `updated_at`, `role`, `active_session`, `ipaddress`, `about`, `joining_date`, `designation`) VALUES
(1, '609a5a2209213162072835415346', 'Admin', 'admin@gmail.com', NULL, '$2y$10$v9tYESRN5HDa8.ILNAiZEO3Q4V1v9Z.2ITPyOVQWN9ySdDjAsYgpy', 1, '2021-05-11 15:49:14', '2021-05-27 12:37:15', 'A', '1622099235GPPAIRYL60af4523b38be', '103.232.125.110', 'Admin Description Here', NULL, 'owner'),
(2, '609a822443361162073859691340', 'Vishal', 'vishal@gmail.com', '+919797879878', '$2y$10$M4/G1p5eDjHd2EUByeuzvO34UtIMIbZ9LTJCzAxANVAWzctGOaNti', 1, '2021-05-11 18:39:56', '2021-05-27 11:18:26', 'E', '1622094506VNOLEMIY60af32aa13c28', '49.34.103.18', 'ok', '2021-05-11', 'Web Designer'),
(3, '609a82c15d4f8162073875390959', ' Bajrangi', 'gaut56amtest@gmail.com', '+919797879820', '$2y$10$iP5oCOviH6EP0hdKEviDT.44c5RnmazsdnsiVyMHMBXdHD2FOa31i', 1, '2021-05-11 18:42:33', '2021-05-11 18:42:33', 'E', NULL, NULL, 'jghjg kjb', '2021-05-11', 'Laravel Developer'),
(4, '609b6299ccfdf162079605784363', 'Gautam ABC', 'gautam@gmail.com', '8905402995', '$2y$10$DfALtDSor101bIWh5z/k5.tLC3XWvXLzPW4wKT7bkEgzQwshxvPXG', 1, '2021-05-12 10:37:38', '2021-05-20 19:49:58', 'E', NULL, '116.72.21.2', 'Gautam ABC from surat', '2020-05-18', 'Laravel Developer'),
(5, '609badcee156d162081531082288', 'Sandeep Kumar', 'Sandeep@mail.com', '', '$2y$10$H5hBLOaeZpE8y.wvBVRYO.7ERKiziFH3wZ.XiZWl8UuvJgUi8TM52', 1, '2021-05-12 15:58:31', '2021-05-24 17:09:25', 'E', NULL, '::1', '', '2021-05-10', 'Android Developer'),
(6, '60a6680656185162151834233665', 'Shreyas', 'Shreyas@mail.co', '', '$2y$10$E3jB.IgR/IEQPLr7QMMQT.4RJxfreRpEf2efnJ12TqZyWs9Q1PeQO', 1, '2021-05-20 19:15:42', '2021-05-27 12:28:12', 'E', '16220986927VV00NNU60af43047b1d3', '47.15.166.102', '', '2021-05-20', 'Graphics Designer'),
(7, '60ac77c21fe3b162191558680897', 'Pranav begade', 'pranav@technomads.in', '', '$2y$10$0EHnMpW6IiXv5vUsYc/.weLBY7R0.K5SqTh.laFG1/YcvqsmgLJTS', 1, '2021-05-25 09:36:26', '2021-05-27 12:37:11', 'E', NULL, '103.232.125.110', '', '2021-05-25', 'Fullstack');

-- --------------------------------------------------------

--
-- Table structure for table `company_configurations`
--

CREATE TABLE `company_configurations` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Company Name',
  `email` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'India',
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_configurations`
--

INSERT INTO `company_configurations` (`id`, `company_name`, `email`, `mobile`, `created_at`, `updated_at`, `country`, `state`, `city`, `pincode`, `address`, `landmark`, `invoice_logo`) VALUES
(1, 'Company Name', 'youremail@company.mail', '', '2021-05-11 15:49:14', '2021-05-24 17:11:22', 'India', '', '', '', '', '', '60ab90e2b28461621856482.png');

-- --------------------------------------------------------

--
-- Table structure for table `daily_tasks`
--

CREATE TABLE `daily_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dailytask_date` date NOT NULL COMMENT 'Required',
  `task_description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Required',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'employee id',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `dailytask_minutes` mediumint(9) NOT NULL DEFAULT 0,
  `overtime_minutes` mediumint(9) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0 COMMENT 'project_id',
  `project_category_id` int(11) NOT NULL DEFAULT 0 COMMENT 'project_category_id',
  `any_notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_tasks`
--

INSERT INTO `daily_tasks` (`id`, `dailytask_date`, `task_description`, `admin_id`, `is_active`, `created_at`, `updated_at`, `dailytask_minutes`, `overtime_minutes`, `project_id`, `project_category_id`, `any_notes`) VALUES
(1, '2021-05-13', 'jfjg jhv', 4, 1, '2021-05-13 15:28:49', '2021-05-13 15:28:49', 45, 0, 1, 1, NULL),
(2, '2021-05-13', 'kgkg kjgkg kkjgk jkbkj bkjgkh trtyryt nbvnbv hg', 4, 1, '2021-05-13 17:31:27', '2021-05-13 17:31:27', 254, 0, 1, 1, NULL),
(3, '2021-05-13', 'jhghj kuguikg', 4, 1, '2021-05-13 17:32:24', '2021-05-13 17:32:24', 205, 0, 5, 7, NULL),
(4, '2021-05-13', 'kjgh kjb', 4, 1, '2021-05-13 17:38:03', '2021-05-13 17:38:03', 210, 0, 1, 8, 'mnmn'),
(5, '2021-05-13', 'kghjg', 4, 1, '2021-05-13 17:45:55', '2021-05-13 17:45:55', 193, 0, 5, 2, NULL),
(7, '2021-05-13', 'TaskManagement-\r\nadd/edit/update project, add/edit/update project category,\r\nadmin/employee edit/update with project assignment completed,\r\nuploaded https://taskmanagement.hostappshere.co.in/public/adminside.\r\nBigDaddy-\r\nall new changes of laravel uploaded on live server,\r\ndb changes updated on live, issues discussion etc.\r\n', 4, 1, '2021-05-13 17:59:42', '2021-05-13 17:59:42', 510, 0, 1, 0, ''),
(8, '2021-05-13', 'abc ifd', 4, 1, '2021-05-13 18:38:30', '2021-05-19 12:36:38', 126, 0, 1, 1, 'xyz'),
(9, '2021-05-19', 'ok ok ok  www', 1, 1, '2021-05-19 15:32:05', '2021-05-19 15:32:05', 141, 0, 1, 1, 'nmnm'),
(10, '2021-05-04', 'jhfhjf hfgyj jhf', 4, 1, '2021-05-19 15:50:46', '2021-05-19 15:50:46', 205, 0, 1, 6, 'nbmb'),
(11, '2021-05-19', 'xchg hj gfh', 4, 1, '2021-05-19 15:58:12', '2021-05-19 15:58:12', 510, 0, 5, 7, 'jhvjgh'),
(12, '2021-03-18', 'iyiuy jhghjg jhgjg jghjg jhghjgjhfhgfh', 4, 1, '2021-05-19 15:59:58', '2021-05-25 10:52:36', 373, 0, 1, 6, 'gfhf jhgjg'),
(13, '2021-05-19', 'dhfhgv jgv rg hrg t r yrty', 4, 1, '2021-05-19 16:03:35', '2021-05-19 16:03:35', 200, 0, 1, 1, 'hgjgj jvjgv'),
(14, '2021-05-19', 'nmn hkjh', 4, 1, '2021-05-19 16:05:12', '2021-05-19 16:05:12', 510, 0, 5, 2, ''),
(15, '2021-05-05', 'okok 3434', 4, 1, '2021-05-19 17:17:39', '2021-05-19 17:28:01', 74, 0, 1, 6, 'www'),
(16, '2021-05-19', 'iuio jhghj jgyjg jh g hg hjkhkjhkj hbhjbfjdbg kbkjbfg kbjfdgkjfbg \nfghdhgfjkghh kbhbghjdfg jmbjb fdgkjdhgkjf kjbjkgdf', 4, 1, '2021-05-19 17:40:41', '2021-05-19 17:40:41', 197, 0, 1, 6, 'w'),
(17, '2021-05-19', 'nbmbm mbmbm hghjfghjf hgfhjshfjsd fjfhsdf jb rytweyre jhghjg eruiywi\niiyiyiewr hgh kjghjgjewr weryer kjgh iuyuir mhjh ewruyer kghgwer iuyui\nnbmbm mbmbm hghjfghjf hgfhjshfjsd fjfhsdf jb rytweyre jhghjg eruiywi\niiyiyiewr hgh kjghjgjewr weryer kjgh iuyuir mhjh ewruyer kghgwer iuyui', 5, 1, '2021-05-19 18:03:24', '2021-05-19 18:03:24', 372, 0, 1, 1, 'jkl'),
(18, '2021-05-04', 'ghfghfg', 4, 1, '2021-05-20 15:43:24', '2021-05-20 15:43:24', 90, 0, 1, 6, ''),
(19, '2021-05-20', 'df dhgf jfj', 4, 1, '2021-05-20 18:05:46', '2021-05-20 18:05:46', 510, 0, 1, 1, ''),
(20, '2021-05-20', 'sgfsdfh dhgf f fgdjfj', 4, 1, '2021-05-20 19:15:16', '2021-05-20 19:15:16', 510, 0, 1, 1, ''),
(21, '2021-05-20', 'APIs', 4, 1, '2021-05-20 19:50:56', '2021-05-20 19:50:56', 510, 0, 2, 0, ''),
(22, '2021-05-20', 'google distance matrix api RND , checked other 3rd party api also [https://api.distancematrix.ai/],\nadded time limits for sending otp to customer for multiple resending otp, \nCancel Order Api Changes CORS errors issues in Cancel Order Apis for VueJs, \ndiscussion/help/askformultipleoptimization to denisha, \nworking on setup to notify/manage admin for late pickup/deliver order by driver\nbased on dummy data of google distance matrix api response...', 4, 1, '2021-05-20 20:01:47', '2021-05-20 20:01:47', 690, 0, 2, 0, 'no detail'),
(23, '2021-05-24', 'b jfgfh uyyutuy', 4, 1, '2021-05-24 17:01:38', '2021-05-24 17:01:38', 510, 0, 1, 1, ''),
(24, '2021-05-24', 'g fghgfh', 2, 1, '2021-05-24 19:26:15', '2021-05-24 19:26:15', 30, 0, 1, 1, ''),
(25, '2021-05-24', 'fg dff', 2, 1, '2021-05-24 19:27:24', '2021-05-24 19:27:24', 30, 0, 5, 7, ''),
(28, '2021-05-25', 'rg hh jfjgfj', 6, 1, '2021-05-25 11:08:33', '2021-05-25 11:08:33', 1, 0, 1, 1, ''),
(29, '2021-05-25', 'nmhjg hgjhghjg jhghj', 6, 1, '2021-05-25 11:13:33', '2021-05-25 11:13:33', 9, 0, 4, 10, ''),
(30, '2021-05-25', 'nmjkj khckvjh cjhvbhxcjv', 6, 1, '2021-05-25 11:24:12', '2021-05-25 11:24:12', 4, 0, 1, 1, ''),
(31, '2021-05-25', 'we fw d', 6, 1, '2021-05-25 11:24:43', '2021-05-25 11:24:43', 2, 0, 1, 1, ''),
(32, '2021-05-25', 'df fgfdg', 6, 1, '2021-05-25 11:25:03', '2021-05-25 11:25:03', 3, 0, 1, 1, ''),
(33, '2021-05-25', 'bvbvnb', 6, 1, '2021-05-25 11:25:30', '2021-05-25 11:25:30', 3, 0, 1, 6, ''),
(36, '2021-05-25', 'bnvbnvbn nvv bvnvnbv jhgjhgjgjhg jygyjgyugu jhghjgjhgj jhghjghj hghj bnvbnvbn nvv bvnvnbv jhgjhgjgjhg jygyjgyugu jhghjgjhgj jhghjghj hghjbnvbnvbn nvv bvnvnbv jhgjhgjgjhg jygyjgyugu jhghjgjhgj jhghjghj hghjbnvbnvbn nvv bvnvnbv jhgjhgjgjhg jygyjgyugu jhghjgjhgj jhghjghj hghj', 6, 1, '2021-05-25 11:37:13', '2021-05-25 11:37:13', 13, 0, 1, 1, ''),
(37, '2021-05-25', 'asdgadgadgfdaga', 7, 1, '2021-05-25 11:46:10', '2021-05-25 11:46:10', 270, 0, 1, 8, ''),
(38, '2021-05-25', 'fgsdfgsdgsdg', 7, 1, '2021-05-25 11:46:33', '2021-05-25 11:46:33', 270, 0, 6, 3, ''),
(39, '2021-05-25', 'nmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh\nnmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh\nnmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh\nnmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh\nnmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh\nnmbnm jyy jgjg hgjhg jh nmbnm jyy jgjg hgjhg jh', 6, 1, '2021-05-25 15:41:19', '2021-05-25 15:41:19', 144, 0, 1, 6, ''),
(40, '2021-05-25', 'vhgfhg jhj', 6, 1, '2021-05-25 15:42:19', '2021-05-25 15:42:19', 19, 0, 4, 10, ''),
(41, '2021-05-24', 'gfgh fgghf hfgh', 6, 1, '2021-05-25 15:45:30', '2021-05-25 15:45:30', 508, 0, 4, 12, ''),
(42, '2021-05-23', 'hjfhj jhvjgh jhg', 6, 1, '2021-05-25 15:47:03', '2021-05-25 15:47:03', 510, 0, 1, 6, ''),
(43, '2021-05-25', 'vjvg jhgjhgj jgjhghj kjbjh', 6, 1, '2021-05-25 15:49:13', '2021-05-25 15:49:13', 330, 0, 4, 10, ''),
(44, '2021-05-11', 'jhghj', 6, 1, '2021-05-25 15:58:50', '2021-05-25 15:58:50', 510, 0, 1, 6, ''),
(45, '2021-05-06', 'gfhf', 6, 1, '2021-05-25 15:59:21', '2021-05-25 15:59:21', 510, 0, 4, 11, ''),
(46, '2021-04-14', 'hfjgv jhv jhvh kjgh', 6, 1, '2021-05-25 17:37:48', '2021-05-25 17:37:48', 510, 0, 1, 6, ''),
(47, '2021-04-22', 'khtr rtg trhtgb grthtgbhrt', 6, 1, '2021-05-25 17:38:35', '2021-05-25 17:38:35', 510, 0, 4, 8, ''),
(48, '2021-05-25', 'gfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdf gfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdfgfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdfgfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdfgfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdfgfgf jvjh jbkdf kjghdfk jghdfkj ghkdfh gkdfhgkhdfkgfdh gdf gkjhdfkg hkjfdh gkdjfhgkhdf', 2, 1, '2021-05-26 10:57:14', '2021-05-26 10:57:14', 131, 0, 1, 8, 'hm'),
(49, '2021-05-26', 'Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check Responsive check', 2, 1, '2021-05-26 11:27:08', '2021-05-26 11:27:08', 510, 0, 1, 8, ''),
(50, '2021-05-25', 'new', 2, 1, '2021-05-26 11:34:42', '2021-05-26 11:34:42', 510, 0, 5, 2, ''),
(51, '2021-05-12', 'test only', 2, 1, '2021-05-26 11:46:41', '2021-05-26 11:47:16', 750, 0, 6, 3, ''),
(52, '2021-05-26', 'bhgfgvh', 2, 1, '2021-05-26 17:01:34', '2021-05-26 17:01:34', 150, 0, 6, 3, ''),
(53, '2021-05-27', 'rtr', 2, 1, '2021-05-27 11:12:18', '2021-05-27 11:12:18', 510, 300, 1, 8, ''),
(54, '2021-05-26', 'ok', 2, 1, '2021-05-27 11:18:54', '2021-05-27 11:18:54', 90, 0, 1, 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_05_11_072349_create_admins_table', 1),
(5, '2021_05_11_073033_create_daily_tasks_table', 1),
(6, '2021_05_11_073053_create_projects_table', 1),
(7, '2021_05_11_073107_create_project_assigned_table', 1),
(8, '2021_05_11_073121_create_project_category_table', 1),
(9, '2021_05_11_081550_create_company_configurations_table', 1);

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'created_by',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `is_deployed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `uuid`, `project_name`, `project_description`, `admin_id`, `is_active`, `is_deployed`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(1, 'iyiu76876ghjgjh87678687hg', 'BigDaddy', 'BigDaddy Info All', 0, 1, 0, '2021-05-11 18:45:55', '2021-05-11 18:45:55', NULL, NULL),
(2, 'iyiu76876ghjgjh8767868776jhg', 'iThru', 'iThru', 0, 1, 0, '2021-05-11 18:45:55', '2021-05-11 18:45:55', NULL, NULL),
(3, 'iyiu76876ghjgjh8767868776j', 'CvHelpme', '', 0, 1, 0, '2021-05-11 18:45:55', '2021-05-24 17:12:37', '2021-04-27', NULL),
(4, 'iyiu76876ghjgjh87868776j', 'ResumeVV', '', 0, 1, 1, '2021-05-11 18:45:55', '2021-05-24 17:13:06', '2021-04-29', NULL),
(5, '609bc0bcc4916162082015617673', 'Task Management', 'ABC', 1, 1, 0, '2021-05-12 17:19:16', '2021-05-24 17:13:30', '2021-05-06', NULL),
(6, '609cbc412c93e162088454596627', 'AugBiz', 'AugBiz Info', 1, 1, 0, '2021-05-13 11:12:25', '2021-05-24 16:57:08', '2021-05-10', NULL),
(7, '60a2a1beb656d162127097480302', 'CVgig', '', 1, 1, 1, '2021-05-17 22:32:54', '2021-05-24 17:12:01', '2021-05-04', NULL),
(8, '60ae50744c30e162203659681889', 'Shopify', '', 1, 1, 0, '2021-05-26 19:13:16', '2021-05-26 19:13:16', '2021-05-26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_assigned`
--

CREATE TABLE `project_assigned` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0 COMMENT 'project_id',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'employee id',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_assigned`
--

INSERT INTO `project_assigned` (`id`, `uuid`, `project_id`, `admin_id`, `is_active`, `created_at`, `updated_at`) VALUES
(34, '60a66ffaae78e162152037834746', 1, 4, 1, '2021-05-20 19:49:38', '2021-05-20 19:49:38'),
(35, '60a66ffaaf7d6162152037860111', 2, 4, 1, '2021-05-20 19:49:38', '2021-05-20 19:49:38'),
(36, '60a66ffab079f162152037826837', 5, 4, 1, '2021-05-20 19:49:38', '2021-05-20 19:49:38'),
(37, '60a66ffab192f162152037858760', 6, 4, 1, '2021-05-20 19:49:38', '2021-05-20 19:49:38'),
(52, '60ab906d3d7ef162185636549106', 1, 5, 1, '2021-05-24 17:09:25', '2021-05-24 17:09:25'),
(53, '60ab906d3e245162185636521310', 2, 5, 1, '2021-05-24 17:09:25', '2021-05-24 17:09:25'),
(54, '60ab906d3ebf6162185636597449', 6, 5, 1, '2021-05-24 17:09:25', '2021-05-24 17:09:25'),
(59, '60ac77c241d2c162191558616404', 1, 7, 1, '2021-05-25 09:36:26', '2021-05-25 09:36:26'),
(60, '60ac77c242a7c162191558642047', 6, 7, 1, '2021-05-25 09:36:26', '2021-05-25 09:36:26'),
(61, '60ac8d2e1bae5162192107065438', 1, 6, 1, '2021-05-25 11:07:50', '2021-05-25 11:07:50'),
(62, '60ac8d2e1c985162192107026652', 4, 6, 1, '2021-05-25 11:07:50', '2021-05-25 11:07:50'),
(78, '60af329c6526e162209449218271', 1, 2, 1, '2021-05-27 11:18:12', '2021-05-27 11:18:12'),
(79, '60af329c6611d162209449212900', 3, 2, 1, '2021-05-27 11:18:12', '2021-05-27 11:18:12'),
(80, '60af329c66d5f162209449266371', 5, 2, 1, '2021-05-27 11:18:12', '2021-05-27 11:18:12'),
(81, '60af329c67831162209449214739', 6, 2, 1, '2021-05-27 11:18:12', '2021-05-27 11:18:12'),
(82, '60af329c68308162209449288722', 7, 2, 1, '2021-05-27 11:18:12', '2021-05-27 11:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `project_category`
--

CREATE TABLE `project_category` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'optional',
  `project_id` int(11) NOT NULL DEFAULT 0 COMMENT 'project_id',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_category`
--

INSERT INTO `project_category` (`id`, `uuid`, `category_title`, `category_description`, `project_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'mjhhjg876876vjhg', 'Apps', 'Apps ok', 1, 1, '2021-05-12 18:08:02', '2021-05-12 18:29:23'),
(2, '609bd0978229b162082421577419', 'Web', 'hghj kj', 5, 1, '2021-05-12 18:26:55', '2021-05-13 11:11:06'),
(3, '609cbc5ab484a162088457037462', 'Web Client Side', NULL, 6, 1, '2021-05-13 11:12:50', '2021-05-13 11:12:50'),
(4, '609cbc7272c40162088459434111', 'Android App', NULL, 6, 1, '2021-05-13 11:13:14', '2021-05-13 11:13:14'),
(5, '609cbcb230b91162088465845443', 'iOS App', NULL, 6, 1, '2021-05-13 11:14:18', '2021-05-13 11:14:18'),
(6, '609d04d166246162090312112501', 'iOS App', NULL, 1, 1, '2021-05-13 16:22:01', '2021-05-13 16:22:01'),
(7, '609d04df2b3f5162090313570261', 'VHGH', NULL, 5, 1, '2021-05-13 16:22:15', '2021-05-13 16:22:15'),
(8, '609d04eb04089162090314758752', 'Admin Web', '', 1, 1, '2021-05-13 16:22:27', '2021-05-24 17:14:43'),
(9, '60a63ae311896162150678770747', 'JKL', '', 4, 1, '2021-05-20 16:03:07', '2021-05-24 17:14:22'),
(10, '60a63ae333ca9162150678778176', 'XYZ', '', 4, 1, '2021-05-20 16:03:07', '2021-05-24 17:14:12'),
(11, '60a63ae352601162150678772594', 'DEF', '', 4, 1, '2021-05-20 16:03:07', '2021-05-24 17:14:03'),
(12, '60a63ae37ee94162150678712675', 'ABC', '', 4, 1, '2021-05-20 16:03:07', '2021-05-24 17:13:53'),
(13, '60ae50744dd39162203659679449', 'Admin Web', NULL, 8, 1, '2021-05-26 19:13:16', '2021-05-26 19:13:16'),
(14, '60ae50744ed80162203659639131', 'Graphics', 'anything', 8, 1, '2021-05-26 19:13:16', '2021-05-27 12:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `tags_category`
--

CREATE TABLE `tags_category` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags_category`
--

INSERT INTO `tags_category` (`id`, `uuid`, `category_title`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '60ae267558f82162202584592340', 'Apps', 1, '2021-05-26 16:14:05', '2021-05-26 16:14:05'),
(2, '60ae2681e3a1b162202585755287', 'Client Web', 1, '2021-05-26 16:14:17', '2021-05-26 16:14:17'),
(3, '60ae268e44dcb162202587094993', 'Admin Web', 1, '2021-05-26 16:14:30', '2021-05-26 16:14:30'),
(4, '60ae269a456f1162202588299187', 'iOS App', 1, '2021-05-26 16:14:42', '2021-05-26 16:14:42'),
(5, '60ae26a583cad162202589323207', 'Graphics Design', 1, '2021-05-26 16:14:53', '2021-05-26 19:13:54'),
(7, '60ae573da987f162203833385119', 'Dynamic Site', 1, '2021-05-26 19:42:13', '2021-05-26 19:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_configurations`
--
ALTER TABLE `company_configurations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_tasks`
--
ALTER TABLE `daily_tasks`
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
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_assigned`
--
ALTER TABLE `project_assigned`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_category`
--
ALTER TABLE `project_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags_category`
--
ALTER TABLE `tags_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `company_configurations`
--
ALTER TABLE `company_configurations`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_tasks`
--
ALTER TABLE `daily_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_assigned`
--
ALTER TABLE `project_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tags_category`
--
ALTER TABLE `tags_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
