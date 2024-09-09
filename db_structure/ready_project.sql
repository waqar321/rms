-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2024 at 09:25 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ready_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'New York', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(2, 1, 'Washington', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(3, 2, 'London', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(4, 2, 'Birmingham', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(5, 3, 'Berlin', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(6, 3, 'Stuttgart', '2024-04-18 18:56:54', '2024-04-18 18:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'United States', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(2, 'United Kingdom', '2024-04-18 18:56:54', '2024-04-18 18:56:54'),
(3, 'Germany', '2024-04-18 18:56:54', '2024-04-18 18:56:54');

-- --------------------------------------------------------

--
-- Table structure for table `cron_jobs`
--

CREATE TABLE `cron_jobs` (
  `id` int NOT NULL,
  `cron_name` varchar(50) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IdNames` json DEFAULT NULL,
  `ClassNames` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `permission_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `icon`, `url`, `IdNames`, `ClassNames`, `order`, `parent_id`, `permission_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dashboard ', 'fa fa-home', '/dashboard', '[\"\"]', '[\"\"]', 1, NULL, 12, 1, '2024-06-07 17:35:38', '2024-07-15 23:24:36', NULL),
(2, 'Manage Users', 'fa fa-group', NULL, '[\"\"]', '[\"\"]', 2, NULL, 1, 1, '2024-06-07 12:58:12', '2024-07-15 18:24:33', NULL),
(3, 'Users', NULL, '/manage_user', '[\"\"]', '[\"\"]', 3, 2, 13, 1, '2024-06-07 13:15:55', '2024-06-12 16:27:29', NULL),
(4, 'Roles', NULL, '/manage_user/roles/', '[\"\"]', '[\"\"]', 4, 2, 14, 1, '2024-06-07 13:15:55', '2024-06-12 16:27:29', NULL),
(5, 'Course Category', 'fa fa-list-alt', NULL, '[\"\"]', '[\"\"]', 3, NULL, 2, 1, '2024-06-07 12:35:38', '2024-09-09 09:11:21', '2024-09-09 09:11:21'),
(6, 'Permissions', NULL, '/manage_user/permissions', '[\"\"]', '[\"\"]', 6, 2, 15, 1, '2024-06-07 13:15:55', '2024-06-12 16:05:28', NULL),
(7, 'Manage Sidebars', '', '/sidebar', '[\"\"]', '[\"\"]', 7, 2, 16, 1, '2024-06-07 12:35:38', '2024-06-12 16:05:28', NULL),
(22, 'Video Tutorials', NULL, '/tutorials', '[\"\"]', '[\"\"]', 1, 19, NULL, 1, '2024-06-08 04:44:35', '2024-06-08 04:44:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Created For Laravel Framework';

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(146, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(149, '2024_09_09_125348_create_alter_user_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `messagebody` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `multicast_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_message_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_uploader_id` bigint UNSIGNED DEFAULT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `sub_department_id` bigint UNSIGNED DEFAULT NULL,
  `zone_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int UNSIGNED DEFAULT NULL,
  `branch_id` int DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `shift_time_id` bigint UNSIGNED DEFAULT NULL,
  `upload_csv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_csv_json_data` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `zone_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications_status`
--

CREATE TABLE `notifications_status` (
  `id` bigint UNSIGNED NOT NULL,
  `notification_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Created For Laravel Framework';

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'user_management', 1, '2024-06-26 16:17:54', '2024-06-12 15:53:12', NULL),
(2, 'category_management', 1, '2024-06-09 17:17:09', '2024-08-01 20:39:31', '2024-08-01 20:39:31'),
(3, 'department_management', 1, '2024-06-09 18:00:10', '2024-08-01 20:39:34', '2024-08-01 20:39:34'),
(4, 'manage_course', 1, '2024-06-09 18:00:20', '2024-08-01 20:39:36', '2024-08-01 20:39:36'),
(5, 'manage_align_course', 1, '2024-06-09 18:00:45', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(6, 'manage_my_course', 1, '2024-06-09 18:00:51', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(7, 'manage_lecture', 1, '2024-06-09 18:01:04', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(8, 'manage_notification', 1, '2024-06-09 18:01:41', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(9, 'manage_city', 1, '2024-06-09 18:01:49', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(10, 'manage_zone', 1, '2024-06-09 18:01:55', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(11, 'manage_time', 1, '2024-06-09 18:02:01', '2024-08-01 21:50:26', '2024-08-01 21:50:26'),
(12, 'manage_dashboard', 1, '2024-06-09 20:16:50', '2024-06-09 20:16:50', NULL),
(13, 'manage_users', 1, '2024-06-12 15:23:16', '2024-06-12 15:53:22', NULL),
(14, 'manage_roles', 1, '2024-06-12 15:23:25', '2024-06-12 15:53:31', NULL),
(15, 'manage_permissions', 1, '2024-06-12 15:23:33', '2024-06-27 09:59:02', NULL),
(16, 'manage_sidebar', 1, '2024-06-12 15:23:43', '2024-06-12 15:23:43', NULL),
(17, 'manage_categoires', 1, '2024-06-12 15:54:04', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(18, 'manage_sub_categories', 1, '2024-06-12 15:54:13', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(19, 'manage_departments', 1, '2024-06-12 15:54:22', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(20, 'manage_sub_departments', 1, '2024-06-12 15:54:31', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(21, 'delete_course', 1, '2024-06-12 16:21:17', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(22, 'manage_haris updated', 1, '2024-06-13 05:18:15', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(23, 'arshad', 1, '2024-06-18 10:14:54', '2024-06-18 10:15:12', '2024-06-18 10:15:12'),
(24, 'HR_DATA', 1, '2024-06-25 15:22:11', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(25, 'dashboard_view', 1, '2024-06-26 16:52:48', '2024-06-26 17:09:24', NULL),
(26, 'Course creation', 1, '2024-06-27 11:59:36', '2024-08-01 21:50:08', '2024-08-01 21:50:08'),
(27, 'user_listing', 1, '2024-06-27 13:41:55', '2024-06-27 13:41:55', NULL),
(28, 'user_add', 1, '2024-06-27 13:41:59', '2024-06-27 13:41:59', NULL),
(29, 'role_add', 1, '2024-06-27 13:42:03', '2024-06-27 13:42:03', NULL),
(30, 'role_listing', 1, '2024-06-27 13:42:07', '2024-06-27 13:42:07', NULL),
(31, 'permission_listing', 1, '2024-06-27 13:42:12', '2024-06-27 13:42:12', NULL),
(32, 'permission_add', 1, '2024-06-27 13:42:20', '2024-06-27 13:42:20', NULL),
(33, 'sidebar_operation_add', 1, '2024-06-27 13:42:26', '2024-06-27 13:42:26', NULL),
(34, 'sidebar_operation_listing', 1, '2024-06-27 13:42:30', '2024-06-27 13:42:30', NULL),
(35, 'course_category_add', 1, '2024-06-27 13:42:34', '2024-08-01 21:49:40', '2024-08-01 21:49:40'),
(36, 'course_category_listing', 1, '2024-06-27 13:42:38', '2024-08-01 20:56:43', '2024-08-01 20:56:43'),
(37, 'course_subcategory_add', 1, '2024-06-27 13:42:42', '2024-08-01 20:56:32', '2024-08-01 20:56:32'),
(38, 'course_subcategory_listing', 1, '2024-06-27 13:42:46', '2024-08-01 20:40:36', '2024-08-01 20:40:36'),
(39, 'city_listing', 1, '2024-06-27 13:42:50', '2024-08-01 20:40:34', '2024-08-01 20:40:34'),
(40, 'zone_listing', 1, '2024-06-27 13:42:53', '2024-08-01 20:40:32', '2024-08-01 20:40:32'),
(41, 'schedule_listing', 1, '2024-06-27 13:42:58', '2024-08-01 20:40:30', '2024-08-01 20:40:30'),
(42, 'course_sub_category_add', 1, '2024-06-27 14:06:39', '2024-08-01 20:40:28', '2024-08-01 20:40:28'),
(43, 'create_notification', 1, '2024-06-27 15:03:40', '2024-08-01 20:40:26', '2024-08-01 20:40:26'),
(44, 'Testing done ', 1, '2024-06-28 16:25:37', '2024-08-01 20:40:23', '2024-08-01 20:40:23'),
(45, 'create_lecture', 1, '2024-07-18 19:34:49', '2024-08-01 20:39:20', '2024-08-01 20:39:20'),
(46, 'select_instructor', 1, '2024-07-24 18:47:14', '2024-08-01 20:39:17', '2024-08-01 20:39:17'),
(47, 'cod_payment', 1, '2024-08-02 00:34:39', '2024-08-02 00:34:39', NULL),
(48, 'day_end_payments', 1, '2024-08-02 02:10:57', '2024-08-02 02:10:57', NULL),
(49, 'deposit_slips', 1, '2024-08-02 02:11:04', '2024-08-02 02:11:04', NULL),
(50, 'courer_payment_recieves', 1, '2024-08-02 02:11:12', '2024-08-02 02:11:12', NULL),
(51, 'transactions', 1, '2024-08-02 02:11:16', '2024-08-02 02:11:16', NULL),
(52, 'cod_reports', 1, '2024-08-02 02:11:20', '2024-08-02 02:11:20', NULL),
(53, 'locations', 1, '2024-08-02 02:57:52', '2024-08-02 06:28:54', NULL),
(54, 'location_listing', 1, '2024-08-02 02:59:49', '2024-08-02 22:51:51', NULL),
(55, 'add_location', 1, '2024-08-02 22:50:46', '2024-08-02 22:51:18', NULL),
(56, 'awdawd', 1, '2024-08-03 00:52:45', '2024-08-03 00:55:11', '2024-08-03 00:55:11'),
(57, 'awd', 1, '2024-08-03 01:20:57', '2024-08-03 01:21:01', '2024-08-03 01:21:01'),
(58, 'COD_list', 1, '2024-08-03 02:01:05', '2024-08-03 02:01:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role_pivot`
--

CREATE TABLE `permission_role_pivot` (
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `permission_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role_pivot`
--

INSERT INTO `permission_role_pivot` (`role_id`, `permission_id`) VALUES
(1, 1),
(3, 4),
(3, 7),
(1, 12),
(2, 1),
(2, 3),
(4, 11),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(2, 13),
(2, 14),
(2, 15),
(2, 19),
(2, 20),
(3, 11),
(3, 25),
(1, 25),
(2, 25),
(6, 25),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(5, 6),
(5, 8),
(2, 27),
(2, 28),
(8, 47),
(8, 48),
(8, 52),
(1, 53),
(1, 54),
(8, 54),
(10, 1),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 27),
(10, 28),
(10, 29),
(10, 30),
(10, 31),
(10, 32),
(10, 53),
(1, 55),
(8, 58),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 58),
(10, 33),
(10, 34),
(8, 51),
(8, 49),
(10, 54),
(10, 55);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Created For Laravel Frameowrk';

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(6174, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '1cf2fb6a556d5566d3f5dda072e63e50109c73f62d1d73c11679a76e3849a9b4', '[\"*\"]', NULL, NULL, '2024-04-10 15:19:09', '2024-04-10 15:19:09'),
(6175, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '62835db7fd954701c2bd052eb7ac5d6b7aa4bdbdb3bf7bf1ac150f807dfdb382', '[\"*\"]', NULL, NULL, '2024-04-10 15:19:23', '2024-04-10 15:19:23'),
(6176, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '6fe3a1231bc2210db76de28abefa8651d1b602635262f0863d358b026aeb4469', '[\"*\"]', NULL, NULL, '2024-04-10 15:19:54', '2024-04-10 15:19:54'),
(6177, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'dfca60646f43968b9739076518d3c8d75c560d0342d2dff36b0da04cd91df3c8', '[\"*\"]', NULL, NULL, '2024-04-12 08:07:44', '2024-04-12 08:07:44'),
(6178, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '28451e52fdf8528415bd11ece9a75bfb4905041cc978befc5f3d731edaac0929', '[\"*\"]', NULL, NULL, '2024-04-12 11:09:48', '2024-04-12 11:09:48'),
(6179, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '2b84739e438c7c9d2aaa385ae1345ce5a80f9bb8c1b69b72f7b4f77e6c3345e5', '[\"*\"]', NULL, NULL, '2024-04-16 06:38:51', '2024-04-16 06:38:51'),
(6180, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'b4c30ad12e121b00dcfbc19afee922d6f4a7fa8553eea5d8bc32ea562b3b631a', '[\"*\"]', NULL, NULL, '2024-04-16 08:03:48', '2024-04-16 08:03:48'),
(6181, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '28099fd36923a62cd806c48be17645dff87239c188baf10919c3212d6deb1510', '[\"*\"]', NULL, NULL, '2024-04-19 11:15:01', '2024-04-19 11:15:01'),
(6182, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '778f44db2226ce20991666fe8d127556ad521d61138a23096926986b042f8bc6', '[\"*\"]', NULL, NULL, '2024-04-19 11:16:57', '2024-04-19 11:16:57'),
(6183, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '57cc8856c0e8b898ca68bbd6bf629cf8ca393ff710b93f25385f64db9c18c12d', '[\"*\"]', NULL, NULL, '2024-04-19 11:17:04', '2024-04-19 11:17:04'),
(6184, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e2ba9c5a1cfc940a8e153c3714e2ede969a99017a0afe0d0d5299c4d5c911e88', '[\"*\"]', NULL, NULL, '2024-04-19 11:17:23', '2024-04-19 11:17:23'),
(6185, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f2ef99c6fca42b93c22b71757651814f5416f65d629b8d2b9ede6225e3d4d84e', '[\"*\"]', NULL, NULL, '2024-04-19 11:30:49', '2024-04-19 11:30:49'),
(6186, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'cb68299efb76c3f423b7dc4e88475d075b8d4f3e82ed02dbc492aa9d68f01928', '[\"*\"]', NULL, NULL, '2024-04-19 11:30:56', '2024-04-19 11:30:56'),
(6187, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'a28c96bc97a4fa04c78f94516733ac474ef2a7c45fe4fbf554730e22d082c61d', '[\"*\"]', NULL, NULL, '2024-04-19 11:31:11', '2024-04-19 11:31:11'),
(6188, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ee037070ed25a93e06aeb29c3788f4a1ec6a22b5664c20ebdf6a8fc366c6f900', '[\"*\"]', NULL, NULL, '2024-04-19 12:05:28', '2024-04-19 12:05:28'),
(6189, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'b07259af90d7abaf1c1e91f51beb386e723dff16aa506a0b445f6c4f5fdfcc04', '[\"*\"]', NULL, NULL, '2024-04-19 12:05:42', '2024-04-19 12:05:42'),
(6190, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '6aa068c55db20c41d9c5cd6115f4c2166a741cbf5e03579386c7f6a4aae7ff99', '[\"*\"]', NULL, NULL, '2024-04-19 18:08:55', '2024-04-19 18:08:55'),
(6191, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '7e87c1bdf67fa91c7a7c3f20807131f5724edab170b1ac4da3842ea93fe90477', '[\"*\"]', NULL, NULL, '2024-04-21 09:16:04', '2024-04-21 09:16:04'),
(6192, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '1cf066e05bdf5a99c32e3eb0f7407116d77121b2f77ffb84902197aa75203688', '[\"*\"]', NULL, NULL, '2024-04-22 05:27:46', '2024-04-22 05:27:46'),
(6193, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '49769412af05e1bee74dbd08dd5936597fb3759cc316aaa63368c5e8f6ccda63', '[\"*\"]', NULL, NULL, '2024-04-22 08:39:15', '2024-04-22 08:39:15'),
(6194, 'App\\Models\\Admin\\ecom_admin_user', 83128, 'MyApp', 'b99e6a2661328656fe51a9e646185ca44771f7eba10556d3a69065c69401a8c9', '[\"*\"]', NULL, NULL, '2024-04-22 13:51:57', '2024-04-22 13:51:57'),
(6195, 'App\\Models\\Admin\\ecom_admin_user', 83128, 'MyApp', '74d11e8fd010dbb7835273d9f05689e117c6c58eeca294f69f8079dbc4c9f83d', '[\"*\"]', NULL, NULL, '2024-04-22 13:52:28', '2024-04-22 13:52:28'),
(6196, 'App\\Models\\Admin\\ecom_admin_user', 83125, 'MyApp', '427ca80ee48bed61a22968d68e37ab03aeddcdcd4d30cebc8ce8361464407060', '[\"*\"]', NULL, NULL, '2024-04-22 14:11:36', '2024-04-22 14:11:36'),
(6197, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '0b25fc388f4ae63be23c75f7c4b9a7fc911e76918c9753a73908faa13a98ad4c', '[\"*\"]', NULL, NULL, '2024-04-23 05:17:09', '2024-04-23 05:17:09'),
(6198, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '4b91cf3fda8a66f6f165360cc1aa70667d17c7ed8ec5ed1082c7ceb30d53a4a6', '[\"*\"]', NULL, NULL, '2024-04-23 14:39:41', '2024-04-23 14:39:41'),
(6199, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '9dd3040bf277464171b8b3071b3241729ceedd3a182d3ee8cb1e52ef296de40d', '[\"*\"]', NULL, NULL, '2024-04-24 05:24:53', '2024-04-24 05:24:53'),
(6200, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '124a13aa6388df5d79fcfd8c1b8849b9d6c14636ce66340a5fde53b3d611b18a', '[\"*\"]', NULL, NULL, '2024-04-25 06:48:08', '2024-04-25 06:48:08'),
(6201, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ce77e5150f4aea44302a9f47bc117b871b1dace72438b13a8372573163aaf804', '[\"*\"]', NULL, NULL, '2024-04-26 05:41:23', '2024-04-26 05:41:23'),
(6202, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '63bdaff029aa647f2e9e90b8dddb1681ca82f223a0c9cc4b30b49abfe554ee9f', '[\"*\"]', NULL, NULL, '2024-04-29 06:12:19', '2024-04-29 06:12:19'),
(6203, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '0eb2e507bf3326baca901c74e8894b6e3ce55fe0121d64288e56f2baa316bb2b', '[\"*\"]', NULL, NULL, '2024-04-30 06:20:18', '2024-04-30 06:20:18'),
(6204, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '486dcca5a5595e4f2cb1536fae037d4a5fa663975ad258d9673cc825b0425d76', '[\"*\"]', NULL, NULL, '2024-04-30 19:08:17', '2024-04-30 19:08:17'),
(6205, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e5b93d1dbc2fe287f34b4c5be3078dd8139fb7a10f5d70fe0c7c38124b4f4a63', '[\"*\"]', NULL, NULL, '2024-05-01 07:35:47', '2024-05-01 07:35:47'),
(6206, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '14dd3103c074c650290f8191ee88cc388440f6a36f9ca8ff29567014369f2d7e', '[\"*\"]', NULL, NULL, '2024-05-02 05:57:18', '2024-05-02 05:57:18'),
(6207, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '4a9e0ee121255dde750ac78d9d126456c888d9af2ad16ea0eb7f5e631d865ac5', '[\"*\"]', NULL, NULL, '2024-05-03 05:27:23', '2024-05-03 05:27:23'),
(6208, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '60defe2f290a4e661eee81a64484476d31f98d30c98103dbb9d5b25824f5af2d', '[\"*\"]', NULL, NULL, '2024-05-06 07:40:05', '2024-05-06 07:40:05'),
(6209, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '5c66c8ca319d3b33b970d7ce7869c50f13b0847682006b7bedd890a17d84e6f1', '[\"*\"]', NULL, NULL, '2024-05-06 17:01:35', '2024-05-06 17:01:35'),
(6210, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '546d43bc61223ff7a22aeefc3fc36b81dadeae30ad3ba62257241fc106d9fe69', '[\"*\"]', NULL, NULL, '2024-05-07 08:10:17', '2024-05-07 08:10:17'),
(6211, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '11a3906a8a2eae06e47e2f2cbad0a09bee27ed4bb9fdaced8124069c660fe0aa', '[\"*\"]', NULL, NULL, '2024-05-07 12:04:35', '2024-05-07 12:04:35'),
(6212, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '7aa8fa593db09949e1809bf11aa005a9fddb6db0d891c8b663416540d9301f97', '[\"*\"]', NULL, NULL, '2024-05-07 15:49:21', '2024-05-07 15:49:21'),
(6213, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'aef22b80c8be39925a8451905cbb686b05274458d9a037fd0fbf7993c3ee2ffd', '[\"*\"]', NULL, NULL, '2024-05-08 05:53:36', '2024-05-08 05:53:36'),
(6214, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '88ad710ff1eca9be5c83b1a2a300bf6a6e5f70395d8bc551366a12445aa23d6c', '[\"*\"]', NULL, NULL, '2024-05-08 08:16:00', '2024-05-08 08:16:00'),
(6215, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f9c50ddb2579430d5d99a55f9d664e3539c46f850c9db68204642822406f6738', '[\"*\"]', NULL, NULL, '2024-05-08 11:52:07', '2024-05-08 11:52:07'),
(6216, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '279d2ab96e5d0e724b24e9aa4aa5f9669234bd3a053a037efe35c0408df9be3f', '[\"*\"]', NULL, NULL, '2024-05-08 11:56:11', '2024-05-08 11:56:11'),
(6217, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '849cfffddf0c74852426b205ae89eb93f1930af4b9ec739714a1e77b8a2b37f2', '[\"*\"]', NULL, NULL, '2024-05-08 16:53:27', '2024-05-08 16:53:27'),
(6218, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'a93ffeb42d9ed55c43b66b61e54a0e7d1220fcf6429050e137b7e05059d223b4', '[\"*\"]', NULL, NULL, '2024-05-09 06:05:41', '2024-05-09 06:05:41'),
(6219, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', 'd2820747e0dc31569c24cbce151f60476eb582fe0badf273ee8cb2bacfbe3ed3', '[\"*\"]', NULL, NULL, '2024-05-09 06:13:17', '2024-05-09 06:13:17'),
(6220, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', 'ffe2604e26418e08ac17d7309f06607152e2211a08e376ab100b0b85635d092d', '[\"*\"]', NULL, NULL, '2024-05-09 07:30:02', '2024-05-09 07:30:02'),
(6221, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', 'a6f222b7f84c214d70fea050e1c6f1566c1ee3e6c5c3787e135eec7d88bc3e6c', '[\"*\"]', NULL, NULL, '2024-05-09 07:41:31', '2024-05-09 07:41:31'),
(6222, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '3b46c898650bf909996a52c401714c6e3ee2aa2965d8f72b01a9d93e134e6f33', '[\"*\"]', NULL, NULL, '2024-05-09 07:48:31', '2024-05-09 07:48:31'),
(6223, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', 'f6b0b78f3d6f95a651bcf2427eaa1bf20306d306eab3bf59b76603d20c02e7e8', '[\"*\"]', NULL, NULL, '2024-05-09 07:49:12', '2024-05-09 07:49:12'),
(6224, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', 'af3b3afc1d98f9c58554a113e28501ae6e34b42ec9b0db25302d71ae30a7c4b4', '[\"*\"]', NULL, NULL, '2024-05-09 07:49:56', '2024-05-09 07:49:56'),
(6225, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', '3e044e83679ec658bf1fc6b8b1df852ea2df97320ed8b80fadd60f1b5e2dc56a', '[\"*\"]', NULL, NULL, '2024-05-09 07:51:04', '2024-05-09 07:51:04'),
(6226, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '545442873cea049fcac6b4c3d62471ecfbb5028f85d7cc2ed6e654a2ce60b91b', '[\"*\"]', NULL, NULL, '2024-05-09 07:59:25', '2024-05-09 07:59:25'),
(6227, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', '14a979af22692ae8b7667b94ea4d4f9363152246a4a063cebdb00b2713c07a0c', '[\"*\"]', NULL, NULL, '2024-05-09 07:59:54', '2024-05-09 07:59:54'),
(6228, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '0fa2445a57256030dd2ed85e7d92c70fdf095e567993c495e790a44f5b0ba592', '[\"*\"]', NULL, NULL, '2024-05-09 08:01:23', '2024-05-09 08:01:23'),
(6229, 'App\\Models\\Admin\\ecom_admin_user', 83131, 'MyApp', '8e70e506090c6ae5d3ce0f5020e03f9b493d8ffa474c1092b58062a26a307a7b', '[\"*\"]', NULL, NULL, '2024-05-09 08:02:16', '2024-05-09 08:02:16'),
(6230, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '3bb5069ac64fcd3544cc64af69a434bb8101e1eeb435f0a89d4f83e4816042f6', '[\"*\"]', NULL, NULL, '2024-05-09 08:07:32', '2024-05-09 08:07:32'),
(6231, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '494d1b9fe44056303217329e389c2fa8446032bf9a7134eeaadc9b06597b8c86', '[\"*\"]', NULL, NULL, '2024-05-09 11:51:06', '2024-05-09 11:51:06'),
(6232, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'b1e686fde7db9f8c8868aa206c86213f1bced714bed8a938e770e9249e5339e9', '[\"*\"]', NULL, NULL, '2024-05-09 15:01:49', '2024-05-09 15:01:49'),
(6233, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '083253852deeea39a49c7da1c09b6b095e034253f06a15bd5289883f2aaceba3', '[\"*\"]', NULL, NULL, '2024-05-09 15:02:06', '2024-05-09 15:02:06'),
(6234, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', 'd5739965d624e620e866915cd7c9deeda592e25df6c0dcc8a322f577088d086a', '[\"*\"]', NULL, NULL, '2024-05-09 15:34:56', '2024-05-09 15:34:56'),
(6235, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '4efbe60d188a210a9ec3f646781ecebb891f3eec0e1926d50ef0aebef4529be8', '[\"*\"]', NULL, NULL, '2024-05-09 21:47:19', '2024-05-09 21:47:19'),
(6236, 'App\\Models\\Admin\\ecom_admin_user', 83128, 'MyApp', '5bd56ec795db02b0fb6c7a1d500ba858c90b76b8f0d46680c87f3899bd50cd6f', '[\"*\"]', NULL, NULL, '2024-05-09 21:49:48', '2024-05-09 21:49:48'),
(6237, 'App\\Models\\Admin\\ecom_admin_user', 83128, 'MyApp', '93533b55f680c2731f7aa56a4c5707d7f34025b728a0c4df9942679aba0c193a', '[\"*\"]', NULL, NULL, '2024-05-10 05:06:29', '2024-05-10 05:06:29'),
(6238, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '4b236125be7e522c73702132bf753d443c994932ffef43d298c8566959062871', '[\"*\"]', NULL, NULL, '2024-05-10 05:09:38', '2024-05-10 05:09:38'),
(6239, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '2f74a98fee29ba1aa3915af3d488e80231da2ab42b7f65d499cf28e6b754cbda', '[\"*\"]', NULL, NULL, '2024-05-10 05:32:31', '2024-05-10 05:32:31'),
(6240, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', 'f9ed2128253d48d996ac7332cfcd793a23403e25b87d510690743c8d9cd6af09', '[\"*\"]', NULL, NULL, '2024-05-10 05:50:35', '2024-05-10 05:50:35'),
(6241, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '171a404cd360e84d577125c332b3cb561abf8f6e651369eaf112d025141c72ce', '[\"*\"]', NULL, NULL, '2024-05-10 07:18:59', '2024-05-10 07:18:59'),
(6242, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '7e8df085247d4825073aa71cf949a9580a3b91f27b633464af3e21ca75cd6cda', '[\"*\"]', NULL, NULL, '2024-05-10 11:26:39', '2024-05-10 11:26:39'),
(6243, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '1f6a4b84601314ce0e860b1df4cd465bded8ecf45f5dc06935112da16c2fdae4', '[\"*\"]', NULL, NULL, '2024-05-11 16:40:05', '2024-05-11 16:40:05'),
(6244, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f85811ff8894cdc46683429099c5baaaa5aa4b7801495be137769a83aef5cb89', '[\"*\"]', NULL, NULL, '2024-05-13 05:33:06', '2024-05-13 05:33:06'),
(6245, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '0f62d6aea9d4543a24bdb57bbc81596f9a2766842dc8685ba2a0569651460183', '[\"*\"]', NULL, NULL, '2024-05-13 07:47:59', '2024-05-13 07:47:59'),
(6246, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '8460bae689a5ff681f829feaeeb4a3bcc0c0d1038ca8ef19fb1244037abcc8c3', '[\"*\"]', NULL, NULL, '2024-05-13 07:48:58', '2024-05-13 07:48:58'),
(6247, 'App\\Models\\Admin\\ecom_admin_user', 83128, 'MyApp', 'e34519711c6077f7a0e0e72c548cc6e805bb800f25e94b9b426b23fb8f5a2cb8', '[\"*\"]', NULL, NULL, '2024-05-13 11:53:09', '2024-05-13 11:53:09'),
(6248, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '51c01438115c2e69979dc95ce1fed2dc72dc58001814ecc1694fe160c2f34e49', '[\"*\"]', NULL, NULL, '2024-05-13 15:37:53', '2024-05-13 15:37:53'),
(6249, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '4e1608b9671a1a520a454cc305bbc2b1739665cae95780ac8b525e776240822c', '[\"*\"]', NULL, NULL, '2024-05-14 06:20:13', '2024-05-14 06:20:13'),
(6250, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '1a45a07f976ae14e0a8271f9acd2014e4f7fca1faf871d0c3d8e05f26307ecaf', '[\"*\"]', NULL, NULL, '2024-05-14 06:24:45', '2024-05-14 06:24:45'),
(6251, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '248ea33408baa3a22fe4bbeb4fd8104a6f389cc6bb6c20023c4e2a5081921cd1', '[\"*\"]', NULL, NULL, '2024-05-15 05:39:30', '2024-05-15 05:39:30'),
(6252, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ef49df8d7b8b3458858f0dccf870bec04cda928f8c4b5a1b70d5ea5ff1801238', '[\"*\"]', NULL, NULL, '2024-05-15 05:45:15', '2024-05-15 05:45:15'),
(6253, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', 'c270746dc29850b44e64ebd5a63b661e670eba07f9024c053de29339026308f1', '[\"*\"]', NULL, NULL, '2024-05-15 05:45:44', '2024-05-15 05:45:44'),
(6254, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', '404d5e569a99f97e8c3a5726f15ce03e0a9cff68cd031acf685fd12b6716c2e0', '[\"*\"]', NULL, NULL, '2024-05-15 06:25:19', '2024-05-15 06:25:19'),
(6255, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '0147ba1e6b8f617443c4e5a9ffa410cd789dd9e14ae5ac0808d9eb8c99d37b90', '[\"*\"]', NULL, NULL, '2024-05-16 07:21:03', '2024-05-16 07:21:03'),
(6256, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '435dfc806d2f583c66ce15254d490cf3bb8726b02b716d0b2faefbb89714c5ba', '[\"*\"]', NULL, NULL, '2024-05-17 05:10:19', '2024-05-17 05:10:19'),
(6257, 'App\\Models\\Admin\\ecom_admin_user', 83127, 'MyApp', 'e6b3316a5df52026e34a4f3a1b4cef9c71359950a9eea4ce76ecbb9f202ece74', '[\"*\"]', NULL, NULL, '2024-05-17 07:21:37', '2024-05-17 07:21:37'),
(6258, 'App\\Models\\Admin\\ecom_admin_user', 83132, 'MyApp', '9b457ae99e8973b4580e1d91f1516b78a315512acbdb22b9d7dd7cf68c0fece1', '[\"*\"]', NULL, NULL, '2024-05-17 07:21:47', '2024-05-17 07:21:47'),
(6259, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '0df2c5db783f50e67e01023e03060303fc68897590e10cc8b04b39e0760ae35b', '[\"*\"]', NULL, NULL, '2024-05-18 19:30:46', '2024-05-18 19:30:46'),
(6260, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'bb1830e76772428f947340b91e16bea281892d77bddf08175d0e322fe2ff800f', '[\"*\"]', NULL, NULL, '2024-05-19 06:23:41', '2024-05-19 06:23:41'),
(6261, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ac4340cefb7b7670eb4a3b7c85d2ec24359cbd4a1cda07de0e6cab092d116702', '[\"*\"]', NULL, NULL, '2024-05-19 06:51:51', '2024-05-19 06:51:51'),
(6262, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'c660382a8383c7f23023a112cba8abf608e0bc2ff199c4bad46568363513ec87', '[\"*\"]', NULL, NULL, '2024-05-20 06:22:18', '2024-05-20 06:22:18'),
(6263, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '341fc34bfb727ef7df1076e194bc444d3bd33f62d8223fd27b95cbd328a188a5', '[\"*\"]', NULL, NULL, '2024-05-21 11:47:42', '2024-05-21 11:47:42'),
(6264, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '3c022e1777aea620cdddcf7b11aee274d9e90349d3a9ed46f086da1ffde36413', '[\"*\"]', NULL, NULL, '2024-05-22 05:39:35', '2024-05-22 05:39:35'),
(6265, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '170b83396424898014b982e4079f2e527f35395e9a1d91511492f307ff3a52e3', '[\"*\"]', NULL, NULL, '2024-05-23 07:57:01', '2024-05-23 07:57:01'),
(6266, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e2f530022b2e6db3b9f365efc1a2eaf1c52e6d3ff5c4f095f62fd6e32fe32a04', '[\"*\"]', NULL, NULL, '2024-05-24 11:57:47', '2024-05-24 11:57:47'),
(6267, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ea62f634d53c32684582ff484f808622c2034efcaa970aadec011048eaebcfe3', '[\"*\"]', NULL, NULL, '2024-05-27 05:10:20', '2024-05-27 05:10:20'),
(6268, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '6af5d8dc0dda6d7a320e59a89c359a279d42e0e4b2bd037b16a9acb461ec0a83', '[\"*\"]', NULL, NULL, '2024-05-29 06:03:00', '2024-05-29 06:03:00'),
(6269, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '7597caddb613d0885e71d68d54053d855b71e5d8b3eb12e799c8b9fd9f65814c', '[\"*\"]', NULL, NULL, '2024-05-31 07:23:31', '2024-05-31 07:23:31'),
(6270, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '262b3d6268477816478bb515639b987adec5014378aebffbeca643290b8eb645', '[\"*\"]', NULL, NULL, '2024-05-31 12:05:27', '2024-05-31 12:05:27'),
(6271, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'eb415af000da842e2bc03cd0d20a4412f0766baf3b65032bc44a36a83edf76c1', '[\"*\"]', NULL, NULL, '2024-05-31 12:26:18', '2024-05-31 12:26:18'),
(6272, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f0fff9b3922389d6710b90cf53beed6e2471c8f6d4f814a31150095cacde0d22', '[\"*\"]', NULL, NULL, '2024-05-31 14:17:41', '2024-05-31 14:17:41'),
(6273, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'b827ee044857e1236ead40be8af7a2fbde3d4e502886fa7823ec6c2074ad16d3', '[\"*\"]', NULL, NULL, '2024-06-01 07:18:48', '2024-06-01 07:18:48'),
(6274, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '2acf9d142283777089f4ac6e33d9cc0b48bcb8fc964e2fc1e0355ccd8a2ee395', '[\"*\"]', NULL, NULL, '2024-06-02 16:50:02', '2024-06-02 16:50:02'),
(6275, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '2db164d5b716914f7d4d33bfb65f33f7c401bb7092f052a8ad5c87644729f9b8', '[\"*\"]', NULL, NULL, '2024-06-03 06:13:46', '2024-06-03 06:13:46'),
(6276, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '58b37704796b88aebbb00c70e967a8dcc31252d18954a17f8bb11bee85b3ec42', '[\"*\"]', NULL, NULL, '2024-06-03 08:18:04', '2024-06-03 08:18:04'),
(6277, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '05f4536d9a869a6534137175d6533f51787c57f6ec7f85b5b73f51a0ec537114', '[\"*\"]', NULL, NULL, '2024-06-04 06:14:57', '2024-06-04 06:14:57'),
(6278, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '2d0bee25f15cb65907020ae8ac23105daf27a72bdf30b9161cc4f7a3df84c212', '[\"*\"]', NULL, NULL, '2024-06-04 07:48:58', '2024-06-04 07:48:58'),
(6279, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f550684c5b193ce0480088fd5e57e3881cb1fc722c0f05740eee3af57da30829', '[\"*\"]', NULL, NULL, '2024-06-05 06:50:54', '2024-06-05 06:50:54'),
(6280, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '14049fe52822e3bc436509fc030aaa05badf19433d0f03d0ca394a738cadea23', '[\"*\"]', NULL, NULL, '2024-06-05 19:53:14', '2024-06-05 19:53:14'),
(6281, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '7c2c6fb32ef8b1ba7738ffbf46ad6b18cbca320719ae3e7ae6c95e6e91da7ee7', '[\"*\"]', NULL, NULL, '2024-06-06 05:43:00', '2024-06-06 05:43:00'),
(6282, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '90b3035220d936ec3c01585b076b4d6ea140f21034223d3e661d19d379efe365', '[\"*\"]', NULL, NULL, '2024-06-06 09:07:10', '2024-06-06 09:07:10'),
(6283, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'b70616303a1c8303e78610952e71aea3db1a029305e16a42e47c9180a84934bc', '[\"*\"]', NULL, NULL, '2024-06-07 05:43:33', '2024-06-07 05:43:33'),
(6284, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e7dec251a66d26c15a4a25b21853f0d17d81f518c6fb24ddad785526167abac4', '[\"*\"]', NULL, NULL, '2024-06-07 06:02:48', '2024-06-07 06:02:48'),
(6285, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e4e78984d395d154678414d88270dd271bb422da060becf816c19789d550da43', '[\"*\"]', NULL, NULL, '2024-06-07 06:21:37', '2024-06-07 06:21:37'),
(6286, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'd9327d66dd8d5f581988c4c96d99f472b309e09baa4dc22aaccf4d2b2a21d1ab', '[\"*\"]', NULL, NULL, '2024-06-07 06:21:41', '2024-06-07 06:21:41'),
(6287, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'c58b52cde6268a1f0597553da60d6052a88019de3a84b577a55bf5108f0eda8f', '[\"*\"]', NULL, NULL, '2024-06-07 06:22:44', '2024-06-07 06:22:44'),
(6288, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '1729681d24961133746b1e708667a465b0683f709a674f453173be8b52a37623', '[\"*\"]', NULL, NULL, '2024-06-07 16:34:30', '2024-06-07 16:34:30'),
(6289, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '537c04a23281ea331f6a42c0e542cbdb2b776d8e498bf2786bb3a10d9a8776b0', '[\"*\"]', NULL, NULL, '2024-06-08 04:11:41', '2024-06-08 04:11:41'),
(6290, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '5773575c52fa2a988c753804eab0e0c6c69cceabfc4eab67aeb6e15de809acb4', '[\"*\"]', NULL, NULL, '2024-06-09 07:23:44', '2024-06-09 07:23:44'),
(6291, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'ba2eef4a11ea0c88e20d89dafc9739682722e6b61a205175fbe12ef8df39e791', '[\"*\"]', NULL, NULL, '2024-06-09 10:20:33', '2024-06-09 10:20:33'),
(6292, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '8d19674e89176a0da3801957e0e8e993a3e0c07f0f3067bf1fd9203d3adae384', '[\"*\"]', NULL, NULL, '2024-06-09 10:48:27', '2024-06-09 10:48:27'),
(6293, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '2493f503f3df9594655bd62f3a78f652506c38ec19b6e1d3877b28797e21a84a', '[\"*\"]', NULL, NULL, '2024-06-09 10:49:14', '2024-06-09 10:49:14'),
(6294, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '0058a57504225b3d4135c276c91a4b58c5181475853bf169b22290ac92192ee7', '[\"*\"]', NULL, NULL, '2024-06-09 19:52:48', '2024-06-09 19:52:48'),
(6295, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'c41e0823f3b46d0eb36533d8f6bee9f8a5859e038fd7582983880aed97630b59', '[\"*\"]', NULL, NULL, '2024-06-09 20:44:17', '2024-06-09 20:44:17'),
(6296, 'App\\Models\\Admin\\ecom_admin_user', 166197, 'MyApp', '62f486dfedd9ca9620e5413dbd37f08ed93fd1b356dcd5bf371bfbbc6a05abf8', '[\"*\"]', NULL, NULL, '2024-06-09 20:51:00', '2024-06-09 20:51:00'),
(6297, 'App\\Models\\Admin\\ecom_admin_user', 166196, 'MyApp', '47af36a6321237dcf1adfed5960414e7cecad07455fc15f0d180b6763c6ad157', '[\"*\"]', NULL, NULL, '2024-06-09 20:53:18', '2024-06-09 20:53:18'),
(6298, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'dfeacbb845b94ad27eacff6f2c62e7b4797e6811fe520904b44dad9fd3474e0b', '[\"*\"]', NULL, NULL, '2024-06-11 00:02:38', '2024-06-11 00:02:38'),
(6299, 'App\\Models\\Admin\\ecom_admin_user', 166196, 'MyApp', '4a8b8336bb9308055c92316020c38f76a0757e3790061458569037e8f3586f9f', '[\"*\"]', NULL, NULL, '2024-06-11 00:05:44', '2024-06-11 00:05:44'),
(6300, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'c39a459e5278756c15a59d015845f99176cb0250b6d7f68dd18b8aab3d5b154c', '[\"*\"]', NULL, NULL, '2024-06-11 18:58:47', '2024-06-11 18:58:47'),
(6301, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'e7968bc148d426a4da870c3472c809297717ee8ee067a467e82148321de94500', '[\"*\"]', NULL, NULL, '2024-06-12 02:33:38', '2024-06-12 02:33:38'),
(6302, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'dd329b2f0a87176890bf99fd389710f69a16d33d5824276bf7a9dfc1423d6abe', '[\"*\"]', NULL, NULL, '2024-06-12 03:03:21', '2024-06-12 03:03:21'),
(6303, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'dc90f81ada3f3f90e4d06b24d897d56fcca4594c36b38d5f3191bcfaa9a22365', '[\"*\"]', NULL, NULL, '2024-06-12 08:02:26', '2024-06-12 08:02:26'),
(6304, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '129e3e537061efd3f5e54dc9a3c55462189e5102ea50bf81af07005f14c51547', '[\"*\"]', NULL, NULL, '2024-06-12 14:06:37', '2024-06-12 14:06:37'),
(6305, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'a92e4857131ed6e5af3643dcfbbd7ab33a3f511d2f3ad3fcd3141399d660467c', '[\"*\"]', NULL, NULL, '2024-06-12 14:30:50', '2024-06-12 14:30:50'),
(6306, 'App\\Models\\Admin\\ecom_admin_user', 166198, 'MyApp', 'd67de35c7fb7a8b66f2af549c40d0d30cf8afedab8a216804b91ce9ebec8715f', '[\"*\"]', NULL, NULL, '2024-06-12 14:31:25', '2024-06-12 14:31:25'),
(6307, 'App\\Models\\Admin\\ecom_admin_user', 166196, 'MyApp', '4d09db80091ee249b01139a831c256147067d8d52957399d127de54567b04dfd', '[\"*\"]', NULL, NULL, '2024-06-12 14:59:46', '2024-06-12 14:59:46'),
(6308, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'f995ea0c013f3a23360d94a9fe2e24bf823d38e1c5bef2dccf84b595c2628b4c', '[\"*\"]', NULL, NULL, '2024-06-13 05:05:15', '2024-06-13 05:05:15'),
(6309, 'App\\Models\\Admin\\ecom_admin_user', 166197, 'MyApp', '268491c156751aa245a0d079af41bea5b55f5608d57eb6b9efa990d89700ff46', '[\"*\"]', NULL, NULL, '2024-06-13 05:06:56', '2024-06-13 05:06:56'),
(6310, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', 'd5748dbb551dc3fe61ca79fd66af8cd01a17cb17796919bc093676b18b00ea7c', '[\"*\"]', NULL, NULL, '2024-06-13 08:46:37', '2024-06-13 08:46:37'),
(6311, 'App\\Models\\Admin\\ecom_admin_user', 83124, 'MyApp', '5f2a369e196f64823c9c79d6a0d45d0ea2faed0b1d41fa8e55f45818242df71c', '[\"*\"]', NULL, NULL, '2024-06-13 13:39:35', '2024-06-13 13:39:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 1, '2024-06-09 16:20:02', '2024-06-26 18:05:06', NULL),
(8, 'Manager', 1, '2024-08-02 01:53:26', '2024-08-28 00:06:37', NULL),
(9, 'User', 1, '2024-08-02 01:53:26', '2024-08-02 02:55:21', NULL),
(10, 'Administrator', 1, NULL, NULL, NULL),
(11, 'Developers', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `is_active`, `created_at`, `updated_at`, `last_activity`) VALUES
(1, NULL, 'Waqar Mughal', 'waqar@gmail.com', NULL, '$2y$10$cWF2nJSJBbwkDmuPJ1WpFuyX7.0ZCmihSPlu1hNw1giQ6CXWXEMvO', NULL, 1, '2024-09-09 08:05:51', '2024-09-09 09:23:35', '2024-09-09 09:23:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_foreign` (`parent_id`),
  ADD KEY `menus_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_user_uploader_id_foreign` (`user_uploader_id`),
  ADD KEY `notifications_instructor_id_foreign` (`instructor_id`),
  ADD KEY `notifications_employee_id_foreign` (`employee_id`),
  ADD KEY `notifications_department_id_foreign` (`department_id`),
  ADD KEY `notifications_sub_department_id_foreign` (`sub_department_id`),
  ADD KEY `notifications_city_id_foreign` (`city_id`),
  ADD KEY `notifications_branch_id_foreign` (`branch_id`),
  ADD KEY `notifications_role_id_foreign` (`role_id`),
  ADD KEY `notifications_shift_time_id_foreign` (`shift_time_id`);

--
-- Indexes for table `notifications_status`
--
ALTER TABLE `notifications_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_status_notification_id_foreign` (`notification_id`),
  ADD KEY `notifications_status_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role_pivot`
--
ALTER TABLE `permission_role_pivot`
  ADD KEY `permission_role_pivot_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_pivot_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`) USING BTREE,
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cron_jobs`
--
ALTER TABLE `cron_jobs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10152;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications_status`
--
ALTER TABLE `notifications_status`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6312;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
