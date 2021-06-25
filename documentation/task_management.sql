-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2021 at 04:07 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_management`
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
(1, '60ae0264177be162201661232025', 'Admin', 'admin@gmail.com', NULL, '$2y$10$IdGUHBKp2J5KOLdoEuFdSO.plhsM6gUDzOytuM.t0otezGganHXea', 1, '2021-05-26 13:40:12', '2021-05-26 13:42:06', 'A', '1622016726PFM5VOKB60ae02d65de28', '::1', 'Admin Description Here', '2021-05-26', 'SuperAdmin'),
(2, '60ae29cb2c227162202669930728', 'vishal kumar', 'vishalmail@mail.me', '', '$2y$10$Uc7z1mntk4PHfuARgDxp8OhcQ/YN2CxLFUv.k62amzg5dfzv.pWqW', 1, '2021-05-26 16:28:19', '2021-05-26 18:25:02', 'E', '162203370212W80V8Y60ae45260c4fc', '::1', '', '2021-05-26', 'Designer');

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
(1, 'Company Name', 'youremail@company.mail', '', '2021-05-26 13:40:12', '2021-05-26 13:42:35', 'India', '', '', '', '', '', '60ae02f32668f1622016755.jpg');

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
(3, '2021-05-26', 'jhghjg', 2, 1, '2021-05-26 18:23:35', '2021-05-26 18:44:30', 270, 19, 1, 1, 'nmbmbmnbmn'),
(4, '2021-05-26', 'jyfjyff', 2, 1, '2021-05-26 18:40:58', '2021-05-26 18:40:58', 510, 307, 4, 11, 'jhfjg'),
(5, '2021-05-25', 'mhhjg jhghjg', 2, 1, '2021-05-26 18:46:23', '2021-05-26 18:46:44', 72, 60, 3, 10, ''),
(6, '2021-05-25', 'vj jhgjhg', 2, 1, '2021-05-26 18:47:42', '2021-05-26 19:02:28', 73, 0, 3, 9, ''),
(7, '2021-05-11', 'bbbb', 2, 1, '2021-05-26 19:02:55', '2021-05-26 19:02:55', 489, 0, 2, 6, ''),
(8, '2021-05-05', 'nnnnnnnn  mmmmm', 2, 1, '2021-05-26 19:03:30', '2021-05-26 19:03:30', 150, 124, 3, 9, ''),
(9, '2021-05-08', 'hg hghj', 2, 1, '2021-05-26 19:05:08', '2021-05-26 19:05:08', 210, 0, 2, 6, ''),
(10, '2021-04-07', 'm jh', 2, 1, '2021-05-26 19:05:55', '2021-05-26 19:05:55', 210, 0, 2, 0, '');

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
(9, '2021_05_11_081550_create_company_configurations_table', 1),
(10, '2021_05_26_075925_create_tags_category_table', 1);

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
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT 'ecreated_by',
  `is_deployed` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-no, 1-yes',
  `is_active` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-deactive, 2- deleted',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `uuid`, `project_name`, `project_description`, `admin_id`, `is_deployed`, `is_active`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(1, '60ae26be5b6f8162202591826440', 'BigDaddy', '', 1, 0, 1, '2021-05-26 16:15:18', '2021-05-26 16:15:18', '2021-05-26', NULL),
(2, '60ae29f2f3d09162202673852099', 'iThru', '', 1, 0, 1, '2021-05-26 16:28:58', '2021-05-26 16:28:58', '2021-05-04', NULL),
(3, '60ae2a078f379162202675934935', 'AugBiz', '', 1, 0, 1, '2021-05-26 16:29:19', '2021-05-26 16:29:19', '2021-05-26', NULL),
(4, '60ae2a1581cb1162202677374584', 'Task Management', '', 1, 0, 1, '2021-05-26 16:29:33', '2021-05-26 16:29:33', '2021-05-26', NULL),
(5, '60ae2a2173aa8162202678521697', 'Kipu', '', 1, 0, 1, '2021-05-26 16:29:45', '2021-05-26 16:29:45', '2021-05-26', NULL),
(6, '60ae2a3bdfe4d162202681179372', 'CVgig', '', 1, 0, 1, '2021-05-26 16:30:11', '2021-05-26 16:30:11', '2021-05-26', NULL);

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
(2, '60ae2a4c3942c162202682844382', 1, 2, 1, '2021-05-26 16:30:28', '2021-05-26 16:30:28'),
(3, '60ae2a4c6f5f5162202682832061', 2, 2, 1, '2021-05-26 16:30:28', '2021-05-26 16:30:28'),
(4, '60ae2a4cd8e38162202682829309', 3, 2, 1, '2021-05-26 16:30:28', '2021-05-26 16:30:28'),
(5, '60ae2a4d4be7e162202682956158', 4, 2, 1, '2021-05-26 16:30:29', '2021-05-26 16:30:29'),
(6, '60ae2a4d6a59c162202682956441', 6, 2, 1, '2021-05-26 16:30:29', '2021-05-26 16:30:29');

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
(1, '60ae26be86dd4162202591893988', 'Client Web', NULL, 1, 1, '2021-05-26 16:15:18', '2021-05-26 16:15:18'),
(2, '60ae26bed0cf9162202591897302', 'Admin Web', NULL, 1, 1, '2021-05-26 16:15:18', '2021-05-26 16:15:18'),
(3, '60ae26bf02b48162202591944991', 'iOS App', NULL, 1, 1, '2021-05-26 16:15:19', '2021-05-26 16:15:19'),
(4, '60ae26bf34d19162202591942479', 'Graphics', NULL, 1, 1, '2021-05-26 16:15:19', '2021-05-26 16:15:19'),
(5, '60ae29f31caa9162202673928075', 'Apps', NULL, 2, 1, '2021-05-26 16:28:59', '2021-05-26 16:28:59'),
(6, '60ae29f3489cc162202673963972', 'iOS App', NULL, 2, 1, '2021-05-26 16:28:59', '2021-05-26 16:28:59'),
(7, '60ae29f375376162202673993504', 'Admin Web', NULL, 2, 1, '2021-05-26 16:28:59', '2021-05-26 16:28:59'),
(8, '60ae2a07aaaba162202675944099', 'iOS App', NULL, 3, 1, '2021-05-26 16:29:19', '2021-05-26 16:29:19'),
(9, '60ae2a07c1f92162202675947514', 'Client Web', NULL, 3, 1, '2021-05-26 16:29:19', '2021-05-26 16:29:19'),
(10, '60ae2a085c46e162202676066617', 'Dynamic Website', NULL, 3, 1, '2021-05-26 16:29:20', '2021-05-26 16:29:20'),
(11, '60ae2a15a096a162202677317846', 'Admin Web', NULL, 4, 1, '2021-05-26 16:29:33', '2021-05-26 16:29:33'),
(12, '60ae2a21928a4162202678541006', 'Admin Web', NULL, 5, 1, '2021-05-26 16:29:45', '2021-05-26 16:29:45'),
(13, '60ae2a3c13a93162202681237243', 'Apps', NULL, 6, 1, '2021-05-26 16:30:12', '2021-05-26 16:30:12'),
(14, '60ae2a3c5237e162202681248316', 'Admin Web', NULL, 6, 1, '2021-05-26 16:30:12', '2021-05-26 16:30:12'),
(15, '60ae2a3c8cb0f162202681274197', 'Client Web', NULL, 6, 1, '2021-05-26 16:30:12', '2021-05-26 16:30:12'),
(16, '60ae2a3cc70a6162202681281963', 'Dynamic Website', NULL, 6, 1, '2021-05-26 16:30:12', '2021-05-26 16:30:12'),
(17, '60ae2a3d2781e162202681376767', 'Graphics', NULL, 6, 1, '2021-05-26 16:30:13', '2021-05-26 16:30:13');

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
(5, '60ae26a583cad162202589323207', 'Graphics', 1, '2021-05-26 16:14:53', '2021-05-26 16:14:53');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_configurations`
--
ALTER TABLE `company_configurations`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_tasks`
--
ALTER TABLE `daily_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_assigned`
--
ALTER TABLE `project_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tags_category`
--
ALTER TABLE `tags_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
