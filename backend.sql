-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2020 at 08:12 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `in` datetime DEFAULT NULL,
  `out` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `alasan` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `level`, `name`, `email`, `username`, `password`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'admin', 'admin@admin.com', 'admin', '$2y$10$VvdbzQo0Cgm7MRTHfFCszOcNw43i.CIuq5jqNxDJqs0fh5.bO8FiC', 'sugihart', NULL, '2020-03-17 14:09:04', '2020-03-17 14:09:06');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `device_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_03_17_114032_create_admins_table', 1),
(5, '2020_03_17_130501_create_user_images_table', 1),
(6, '2020_04_08_031714_create_absensis_table', 2),
(7, '2020_04_08_040914_create_devices_table', 3),
(8, '2020_04_08_131701_create_settings_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `in` datetime DEFAULT NULL,
  `out` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `image`, `desc`, `in`, `out`, `created_at`, `updated_at`) VALUES
(1, 'AITI', NULL, 'Perusahaan IT', '2020-04-08 08:00:00', '2020-04-08 16:00:00', '2020-04-08 08:25:53', '2020-04-11 02:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `kk` varchar(255) DEFAULT NULL,
  `tlp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `gender`, `job`, `nik`, `kk`, `tlp`, `alamat`, `username`, `password`, `api_token`, `email`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 1, 'Boy', 1, 'Tinggi banget', '123', '123', '133', 'Hahah', 'Boy', '$2y$10$6qzx8J/PWLQGitJbLY6nZua07pLL22xQiy/Aoa5Xmz8BB/m9XHxVW', 'fjLLVj9s7RFvZrw3pcAPgMJSYd0PQUnZlz8kPNXCZs20p1AYAFjMysIjES2Uo5kJfMZiZpBXwpGSKBtc', 'Gsga@', NULL, NULL, '2020-03-24 16:56:14', '2020-03-24 16:56:14'),
(14, 2, 'Reja Jamil', 1, 'CEO', '111', '111', '111', 'Jl. Kopi', 'rejajamil', '$2y$10$FIeDztnYDnG0MDV1kBnqYuGEhFyULmJ5/DAFBt55Fn3rO0axoM.P.', 'za6DzbjixJjHj5dZLM9bNawyxMfl1SlPvuqfv9rhd47atgGnkIbzMo6v1nsAuo4hHli0murR9A7zRTpc', '@s', NULL, NULL, '2020-03-24 16:59:52', '2020-04-14 07:42:39'),
(15, 3, 'Indra', 1, 'CMO', '112', '133', '123', '244', 'Indra', '$2y$10$W6T5Zj2ma1uA8xv6PCUnv.y3Wb/gYjy/sofwRauNWcmYS2npVmfmS', 'CgdIeLlJQ5Ioxk8csSEkr9521ryrBzJFyXS69jMyTfgJxgqFVOMyKRWHoV5G5H7Ncja6sQq2lVNsRAdt', '@', NULL, NULL, '2020-03-24 17:05:25', '2020-03-24 17:05:25'),
(28, 4, 'Anjas', 1, 'Rocker', '123456', '123456789', '0812', 'Cibubur', 'anjashermawan', '$2y$10$Z.Jb/e62Qnmmn88YeOfxE.Mn5buRx4VBf8j/XwnbasV4BRwGAEiBS', '9FA6rog8LIJ94Z8FBfSDBPOfR5wxReIbHsdppFhAfKyw7D3CdzuVpD2gShBxw7sfarMVbpBVbsbJvCdJ', 'anjashermawan@gmail.con', NULL, NULL, '2020-03-25 19:30:42', '2020-04-07 01:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_image`
--

CREATE TABLE `user_image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_image`
--

INSERT INTO `user_image` (`id`, `image_id`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
(30, 1, 1, '1_20200324_1.jpg', '2020-03-24 16:56:23', '2020-03-24 16:56:23'),
(31, 2, 1, '1_20200324_2.jpg', '2020-03-24 16:56:28', '2020-03-24 16:56:28'),
(32, 3, 1, '1_20200324_3.jpg', '2020-03-24 16:56:32', '2020-03-24 16:56:32'),
(33, 4, 1, '1_20200324_4.jpg', '2020-03-24 16:56:36', '2020-03-24 16:56:36'),
(34, 5, 1, '1_20200324_5.jpg', '2020-03-24 16:56:40', '2020-03-24 16:56:40'),
(35, 6, 1, '1_20200324_6.jpg', '2020-03-24 16:56:44', '2020-03-24 16:56:44'),
(36, 7, 1, '1_20200324_7.jpg', '2020-03-24 16:56:48', '2020-03-24 16:56:48'),
(43, 14, 3, '3_20200324_1.jpg', '2020-03-24 17:05:28', '2020-03-24 17:05:28'),
(44, 15, 3, '3_20200324_2.jpg', '2020-03-24 17:05:31', '2020-03-24 17:05:31'),
(45, 16, 3, '3_20200324_3.jpg', '2020-03-24 17:05:34', '2020-03-24 17:05:34'),
(46, 17, 3, '3_20200324_4.jpg', '2020-03-24 17:05:37', '2020-03-24 17:05:37'),
(47, 18, 3, '3_20200324_5.jpg', '2020-03-24 17:05:40', '2020-03-24 17:05:40'),
(48, 19, 3, '3_20200324_6.jpg', '2020-03-24 17:05:43', '2020-03-24 17:05:43'),
(49, 20, 3, '3_20200324_7.jpg', '2020-03-24 17:05:46', '2020-03-24 17:05:46'),
(50, 21, 3, '3_20200324_8.jpg', '2020-03-24 17:05:49', '2020-03-24 17:05:49'),
(51, 22, 2, '2_20200325_1.jpg', '2020-03-25 07:07:24', '2020-03-25 07:07:24'),
(52, 23, 2, '2_20200325_2.jpg', '2020-03-25 07:07:24', '2020-03-25 07:07:24'),
(53, 24, 2, '2_20200325_3.jpg', '2020-03-25 07:07:24', '2020-03-25 07:07:24'),
(54, 25, 2, '2_20200325_4.jpg', '2020-03-25 07:07:24', '2020-03-25 07:07:24'),
(55, 26, 2, '2_20200325_5.jpg', '2020-03-25 07:07:25', '2020-03-25 07:07:25'),
(64, 27, 4, '4_20200407_1.jpg', '2020-04-07 00:55:24', '2020-04-07 00:55:24'),
(65, 28, 4, '4_20200407_2.jpg', '2020-04-07 00:55:29', '2020-04-07 00:55:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_username_unique` (`username`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
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
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
