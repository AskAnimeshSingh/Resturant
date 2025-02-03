-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2025 at 09:29 AM
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
-- Database: `xcrino_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_stocks`
--

CREATE TABLE `add_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `unit` varchar(15) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_received_from` varchar(30) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `img` text DEFAULT NULL,
  `type` enum('admin','user','kitchen','staff') DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `lname`, `email`, `password`, `phone`, `bio`, `birthday`, `img`, `type`, `branch_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$cgOL3JHHtUqtG6VCcqbhmOGT/K4OeDs.n9N9aJQCS6r9L0R0X8iuC', '8009610334', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias molestias minus quod dignissimos.', NULL, NULL, 'admin', NULL, 1, '2022-11-11 01:08:50', '2024-09-12 10:41:59'),
(2, 'Himanshu', 'Mehta', 'himanshu@gmail.com', '$2y$10$cgOL3JHHtUqtG6VCcqbhmOGT/K4OeDs.n9N9aJQCS6r9L0R0X8iuC', '2525252552', '<p><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; text-align: left; float: right; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"></div></p><div style=\"margin: 0px 14.3906px 0px 28.7969px; padding: 0px; width: 436.797px; text-align: left; float: left; orphans: 2; text-indent: 0px; widows: 2; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify;\"><font face=\"Open Sans, Arial, sans-serif\"><b>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</b></font><br></p></div>', NULL, '/public/assets/admin/assets/img/default_cate.jpeg', 'kitchen', 1, 1, '2023-02-01 01:47:39', '2023-12-07 05:39:51'),
(3, 'Mahender Singh', 'Mahender Singh', 'mahender@gmail.com', '$2y$10$cgOL3JHHtUqtG6VCcqbhmOGT/K4OeDs.n9N9aJQCS6r9L0R0X8iuC', '5435165464', NULL, NULL, '/public/assets/admin/assets/img/default_cate.jpeg', 'admin', NULL, 1, '2023-02-01 08:21:46', '2023-02-15 01:30:13'),
(4, 'qwerty', 'qwerty', 'admin@gmail.com', '$2y$10$BmtoiBjc3.GA/3qRaq3FQunOuMSj4HtNJYeolBvqxWSb8nhTKbaCa', '1234567890', NULL, NULL, '/public/assets/admin/assets/img/admin/167714260063f72a4814e8d.jpg', 'admin', 2, 1, '2023-02-23 03:26:40', '2023-02-23 03:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_by_id` bigint(20) UNSIGNED NOT NULL,
  `created_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `name`, `description`, `created_by_id`, `created_date`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sample blog', '<p><div style=\"margin: 0px 28.7969px 0px 14.3906px; padding: 0px; width: 436.797px; text-align: left; float: right; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"></div></p><div style=\"margin: 0px 14.3906px 0px 28.7969px; padding: 0px; width: 436.797px; text-align: left; float: left; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify;\"><strong style=\"margin: 0px; padding: 0px;\">Lorem Ipsum</strong><span>&nbsp;</span>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p></div>', 1, '2023-02-23', '/public/assets/admin/assets/img/blog/167713777163f7176b81d2d.jpg', 1, '2023-02-23 02:06:11', '2023-02-23 02:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `booking_tables`
--

CREATE TABLE `booking_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `delivery_fee` double NOT NULL,
  `dollor` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `phone`, `address`, `delivery_fee`, `dollor`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Branch 1', '9965768294', 'Dibrugarh west', 30, 1, 1, '2023-03-20 07:03:04', '2023-03-20 07:04:01'),
(2, 'Branch 2', '9996557284', 'Dibrugarh East', 20, 1, 1, '2023-03-20 07:03:54', '2023-03-20 07:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cate_name` varchar(255) NOT NULL,
  `cate_img` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cate_name`, `cate_img`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Burger', '/public/assets/admin/assets/img/category/1679036588641410ac1f579.jpg', 1, '2023-03-17 01:33:08', '2023-03-17 01:33:08'),
(2, 'Pizza', '/public/assets/admin/assets/img/category/1679036675641411030be79.jpg', 1, '2023-03-17 01:34:35', '2023-03-17 01:34:35'),
(3, 'Chinese', '/public/assets/admin/assets/img/category/167903672364141133cf568.jpg', 1, '2023-03-17 01:35:23', '2023-03-17 01:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `delivery_fee` double NOT NULL,
  `dollor` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

CREATE TABLE `chefs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 = active, 1 = inactive',
  `phone` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chefs`
--

INSERT INTO `chefs` (`id`, `first_name`, `last_name`, `image`, `email`, `status`, `phone`, `created_at`, `updated_at`) VALUES
(2, 'Anita', 'Verma', '/public/uploads/chef/img/1683185850645360ba3828a.jpg', 'anita@gmail.com', 0, 123456859, '2023-05-04 02:06:56', '2023-05-04 02:14:30'),
(3, 'Sanjay', 'Mishra', '/public/uploads/chef/img/16831868126453647ced23f.jpg', 'sanjay@gmail.com', 0, 5632635154, '2023-05-04 02:23:32', '2023-05-04 02:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `child_categories`
--

CREATE TABLE `child_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cate_id` bigint(20) UNSIGNED NOT NULL,
  `sub_cate_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `combopacks`
--

CREATE TABLE `combopacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `price` double(8,2) NOT NULL,
  `tax` double(8,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `combopacks`
--

INSERT INTO `combopacks` (`id`, `package_name`, `start_date`, `end_date`, `status`, `price`, `tax`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Chinese Platter', '2023-03-17', '2023-05-31', 1, 30.00, 5.00, '/public/assets/admin/assets/img/combo/167904329464142ade257ab.jpg', '2023-03-17 03:24:54', '2023-03-17 03:24:54'),
(2, 'Test combo', '2023-03-30', '2023-05-31', 1, 60.00, 2.00, '/public/assets/admin/assets/img/combo/16801759386425734274343.png', '2023-03-30 06:02:18', '2023-03-30 06:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `combo_products`
--

CREATE TABLE `combo_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pack_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `combo_products`
--

INSERT INTO `combo_products` (`id`, `pack_id`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, '2023-03-17 03:24:54', '2023-03-17 03:24:54'),
(2, 2, 1, 1, '2023-03-30 06:02:18', '2023-03-30 06:02:18'),
(3, 2, 3, 1, '2023-03-30 06:02:18', '2023-03-30 06:02:18'),
(4, 2, 4, 1, '2023-03-30 06:02:18', '2023-03-30 06:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_name` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `discount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_name`, `product_id`, `start_date`, `end_date`, `status`, `discount`, `created_at`, `updated_at`) VALUES
(1, 'NEW', NULL, '2023-03-17', '2023-07-31', 1, 10.00, '2023-03-17 03:38:18', '2023-03-17 03:38:18'),
(2, 'TEST', NULL, '2023-04-18', '2023-06-30', 1, 5.00, '2023-04-18 06:32:08', '2023-04-18 06:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `image` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `name`, `email`, `phone`, `password`, `branch_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Delivery Guy 2', 'delivery2@gmail.com', '9965572842', '$2y$10$3xmFaKzToLhLbp6Dvh426.A0Er03wSxG95XGeRFbmUhVJ1HKjoK9K', 1, '/assets/admin/assets/img/delivery/1679317410641859a2e514a.png', 1, '2023-03-20 07:33:06', '2024-06-20 20:50:36'),
(2, 'Delivery Dev', 'del@gmail.com', '7678192083', '$2y$10$za84j7cmKMUQDzGyG947OuGuQfnfQnwD4KTTovUB/dB1H.fBiGXHq', 1, '/assets/admin/assets/img/delivery/1681797381643e310577a18.png', 1, '2023-03-20 07:34:49', '2023-04-18 02:32:31'),
(3, 'Delivery Guy 3', 'delivery3@gmail.com', '9965768293', '$2y$10$cr/YiEq4FHY0li3y.dr2U.qs9OGqkeM7BAiYw4Eh1glkdA8kfN1Xi', 2, '/assets/admin/assets/img/delivery/167931762564185a79e964a.png', 1, '2023-03-20 07:37:06', '2023-03-20 07:37:06'),
(4, 'Prince', 'abc@gmail.com', '23343434342', '$2y$10$bI8rVv/ubYZAhnOVqi.VNOeTR3mm8iHuRTiBQRMuS5/PBytbSfYwy', 1, '/assets/admin/assets/img/delivery/17189742676675773b69db5.png', 1, '2024-06-21 12:51:07', '2024-06-21 12:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) NOT NULL,
  `charges` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_charges`
--

INSERT INTO `delivery_charges` (`id`, `charges`, `status`, `created_at`, `updated_at`) VALUES
(1, 11.00, 1, '2023-03-23 05:38:42', '2023-03-23 02:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `commission` double NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
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
-- Table structure for table `food_purchases`
--

CREATE TABLE `food_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `purchase_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `food_item` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `total_amnt` double NOT NULL,
  `due_amnt` double NOT NULL,
  `paid_amnt` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_purchase_histories`
--

CREATE TABLE `food_purchase_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `food_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` double NOT NULL,
  `price` double NOT NULL,
  `total_price` double NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generals`
--

CREATE TABLE `generals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` mediumint(9) DEFAULT NULL,
  `back_logo_col` varchar(11) DEFAULT NULL,
  `back_foot_col` varchar(11) DEFAULT NULL,
  `currency_col` varchar(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `tax` double(8,2) DEFAULT 0.00,
  `discount` double(8,2) NOT NULL DEFAULT 0.00,
  `timezone` time DEFAULT NULL,
  `bill_head` varchar(255) DEFAULT NULL,
  `bill_foot` varchar(255) DEFAULT NULL,
  `web_foot` int(11) DEFAULT NULL,
  `order_detail` enum('0','1') DEFAULT NULL,
  `beep_sound` enum('0','1') DEFAULT NULL,
  `show_table` enum('0','1') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `helps`
--

CREATE TABLE `helps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_delivery_addresses`
--

CREATE TABLE `home_delivery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `bussiness_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `house` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `cross_street` varchar(255) DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ind_grps`
--

CREATE TABLE `ind_grps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ind_grps`
--

INSERT INTO `ind_grps` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Veg Toppings', 1, '2023-03-17 01:52:23', '2023-03-17 01:52:23'),
(2, 'Non Veg Toppings', 1, '2023-03-17 01:52:34', '2023-03-17 01:52:34'),
(3, 'Crust', 1, '2023-03-17 01:56:17', '2023-03-17 01:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `ind_items`
--

CREATE TABLE `ind_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ind_grp_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ind_items`
--

INSERT INTO `ind_items` (`id`, `ind_grp_id`, `name`, `unit`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'New Hand Tossed', '10', 1, '2023-03-17 01:58:22', '2023-03-17 01:58:22'),
(2, 3, '100% Wheat Thin Crust', '10', 1, '2023-03-17 01:58:55', '2023-03-17 01:58:55'),
(3, 3, 'Fresh Pan Pizza', '10', 1, '2023-03-17 01:59:26', '2023-03-17 01:59:26'),
(4, 3, 'Cheese Brust', '10', 1, '2023-03-17 01:59:42', '2023-03-17 01:59:42'),
(5, 3, 'Classic Hand Tossed', '10', 1, '2023-03-17 02:00:02', '2023-03-17 02:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_purchase`
--

CREATE TABLE `ingredient_purchase` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `payment_type` enum('cash','cc') DEFAULT NULL,
  `total_amount` decimal(11,2) DEFAULT NULL,
  `paid_amount` decimal(11,2) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_stocks`
--

CREATE TABLE `ingredient_stocks` (
  `id` int(11) NOT NULL,
  `ingredients_purchase_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `heading` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount` double(8,2) DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `name`, `product_id`, `start_date`, `end_date`, `discount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Festival Special', 1, '2023-03-17', '2023-06-30', 10.00, 1, '2023-03-17 03:28:33', '2023-03-17 03:28:33'),
(2, 'Festival Offer', 2, '2023-03-17', '2023-06-30', 5.00, 1, '2023-03-17 03:29:26', '2023-03-17 03:29:26'),
(3, 'Festive Season', 4, '2023-03-17', '2023-07-31', 20.00, 1, '2023-03-17 06:02:41', '2023-03-17 06:02:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 11, 'otp-token', '8340de3c0967793d6b94ff7f3030bdcb36fbc4007960bdd000a2f66649299cfd', '[\"*\"]', NULL, '2024-04-26 14:32:58', '2024-04-26 14:32:58'),
(2, 'App\\Models\\User', 11, 'otp-token', '01fce6e51f8a3bdf9a63ba67a96469e668923db40141800c9d20151e3a0bcf4a', '[\"*\"]', NULL, '2024-04-26 14:33:43', '2024-04-26 14:33:43'),
(3, 'App\\Models\\User', 11, 'otp-token', '2f9ec43fab5cd0cbebcdc5ef3785372a93c207c31c73e5f145b82f630cdf4585', '[\"*\"]', NULL, '2024-04-26 17:36:49', '2024-04-26 17:36:49'),
(4, 'App\\Models\\User', 11, 'otp-token', '075e0bd5e449fd37740bb336c84fc04b622ae8647bc23a5246fca5b87073b8b2', '[\"*\"]', NULL, '2024-04-29 10:36:32', '2024-04-29 10:36:32'),
(5, 'App\\Models\\User', 11, 'otp-token', 'a6f4758a89997a7dc3074e5cbb8886bea3602ef6f249e8e04985e8be7f3d5422', '[\"*\"]', NULL, '2024-05-03 10:23:50', '2024-05-03 10:23:50'),
(6, 'App\\Models\\User', 24, 'otp-token', 'b5682d8569beb8015a3d56fa95617b82cfbb5303c3734ae4fba18c43718d6de9', '[\"*\"]', NULL, '2024-05-06 09:55:53', '2024-05-06 09:55:53'),
(7, 'App\\Models\\User', 24, 'otp-token', 'f09b43d66c7ea6cb5b15e8c6b52317b71377fc7e5d6480f15b0e845eb65010c0', '[\"*\"]', NULL, '2024-05-09 17:20:47', '2024-05-09 17:20:47'),
(8, 'App\\Models\\User', 24, 'otp-token', '329322a7c7859ca3c9ced16416c73376998f5d68924c369bedd2f17bea15f6f4', '[\"*\"]', NULL, '2024-05-09 17:25:09', '2024-05-09 17:25:09'),
(9, 'App\\Models\\User', 48, 'api-token', '6706b0bdcf8ccc58f1e2f70683497188215f95bf0874df9cb342a0f9dc851bad', '[\"*\"]', NULL, '2024-11-13 15:24:59', '2024-11-13 15:24:59'),
(10, 'App\\Models\\User', 48, 'api-token', '0ad36f5a325a909151cc3cf2657e4c9e39316acff56fcafcb82aa860ad6d6254', '[\"*\"]', NULL, '2024-11-13 15:30:09', '2024-11-13 15:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `pickup_addresses`
--

CREATE TABLE `pickup_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_location` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading1` varchar(255) DEFAULT NULL,
  `answer1` varchar(255) DEFAULT NULL,
  `heading2` varchar(255) DEFAULT NULL,
  `answer2` longtext DEFAULT NULL,
  `heading3` varchar(255) DEFAULT NULL,
  `answer3` longtext DEFAULT NULL,
  `heading4` varchar(255) DEFAULT NULL,
  `answer4` longtext DEFAULT NULL,
  `heading5` varchar(255) DEFAULT NULL,
  `answer5` longtext DEFAULT NULL,
  `heading6` varchar(255) DEFAULT NULL,
  `answer6` longtext DEFAULT NULL,
  `heading7` varchar(255) DEFAULT NULL,
  `answer7` longtext DEFAULT NULL,
  `heading8` varchar(255) DEFAULT NULL,
  `answer8` longtext DEFAULT NULL,
  `heading9` varchar(255) DEFAULT NULL,
  `answer9` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policies`
--

INSERT INTO `privacy_policies` (`id`, `heading1`, `answer1`, `heading2`, `answer2`, `heading3`, `answer3`, `heading4`, `answer4`, `heading5`, `answer5`, `heading6`, `answer6`, `heading7`, `answer7`, `heading8`, `answer8`, `heading9`, `answer9`, `created_at`, `updated_at`) VALUES
(1, 'heading1', 'answer1', 'heading2', 'answer2', 'heading3', 'answer3', 'heading4', 'answer4', 'heading5', 'answer5', 'heading6', 'answer6', 'heading7', 'answer7', 'heading8', 'answer8', 'heading9', 'answer9', '2023-03-21 07:55:19', '2023-03-21 07:55:19');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `module` int(11) DEFAULT NULL,
  `submodule` int(11) DEFAULT NULL,
  `access` varchar(255) DEFAULT NULL,
  `add` varchar(255) DEFAULT NULL,
  `edit` varchar(255) DEFAULT NULL,
  `delete` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_des` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double(8,2) NOT NULL,
  `tax` double(8,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `category` bigint(20) UNSIGNED NOT NULL,
  `sub_category` bigint(20) UNSIGNED DEFAULT NULL,
  `child_category` bigint(20) UNSIGNED DEFAULT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addon` tinyint(4) NOT NULL DEFAULT 0,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `has_varients` tinyint(1) DEFAULT NULL,
  `has_properties` tinyint(1) DEFAULT NULL,
  `default_varients` int(11) DEFAULT NULL,
  `default_toppings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_crust` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_img`, `product_des`, `qty`, `price`, `tax`, `status`, `category`, `sub_category`, `child_category`, `size`, `type`, `addon`, `extra`, `created_at`, `updated_at`, `has_varients`, `has_properties`, `default_varients`, `default_toppings`, `default_crust`) VALUES
(1, 'Potato Tikki Burger', '/public/assets/admin/assets/img/product_image/167903954764141c3b95199.jpg', 'Flavorful  potato tikki with tomato, onion and homemade sauce( no cheese )', 0, 15.00, 2.00, 1, 1, 1, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:22:27', '2023-03-17 02:22:27', 0, 0, 0, '', 0),
(2, 'Classic chicken burger', '/public/assets/admin/assets/img/product_image/167903965764141ca9d5ae1.jpg', 'A classic chicken burger with crispy chicken patty', 0, 20.00, 3.00, 1, 1, 2, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:24:17', '2023-03-17 02:24:17', 0, 0, 0, '', 0),
(3, 'Margherita Pizza', '/public/assets/admin/assets/img/product_image/167903986164141d7538d21.jpg', 'Classic delight with 100% real mozzarella cheese', 0, 20.00, 3.00, 1, 2, 3, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:27:41', '2023-03-17 02:27:41', 1, 1, 0, '', 0),
(4, 'Pepper Barbecue Chicken Pizza', '/public/assets/admin/assets/img/product_image/167904002564141e192264b.jpg', 'Pepper barbecue chicken for that extra zing', 0, 25.00, 5.00, 1, 2, 4, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:30:25', '2023-03-17 02:30:25', 1, 1, 0, '', 0),
(5, 'Noodles', '/public/assets/admin/assets/img/product_image/1679040536641420186ff43.jpg', 'Classic noodles on go', 0, 10.00, 1.00, 1, 3, 5, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:38:56', '2023-03-17 02:38:56', 0, 0, 0, '', 0),
(6, 'Chicken Momo', '/public/assets/admin/assets/img/product_image/167904058464142048d396f.jpg', 'Hot steamed momos', 0, 9.00, 1.00, 1, 3, 6, NULL, NULL, NULL, 0, NULL, '2023-03-17 02:39:44', '2023-03-17 02:39:44', 0, 0, 0, '', 0),
(7, 'Coffee', '/public/assets/admin/assets/img/product_image/16811214116433e08379eef.png', 'coffee', 0, 100.00, 1.00, 1, 3, NULL, NULL, NULL, NULL, 0, NULL, '2023-04-10 04:40:11', '2023-04-10 04:40:11', 1, 0, 0, '', 0),
(8, 'Supreme Pizza', '/public/assets/admin/assets/img/product_image/1681892298643fa3ca9275f.webp', 'When you can’t decide which toppings to get, it’s time for the supreme pizza. The “supreme” refers to the litany of toppings that come scattered on these pies, from sausage to vegetables to pepperoni. And it’s the combination of the flavors that really makes it sing.', 0, 100.00, 2.00, 1, 2, 4, NULL, NULL, NULL, 0, NULL, '2023-04-19 02:48:18', '2023-04-27 06:37:48', 1, 1, 2, '[\"15\",\"5\",\"20\",\"24\"]', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_add_ons`
--

CREATE TABLE `product_add_ons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_extras`
--

CREATE TABLE `product_extras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `extra_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_properties`
--

CREATE TABLE `product_properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `properties_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_properties`
--

INSERT INTO `product_properties` (`id`, `product_id`, `properties_id`, `created_at`, `updated_at`) VALUES
(1, 3, 2, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(2, 4, 2, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(3, 4, 3, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(32, 8, 2, '2024-12-18 06:25:27', '2024-12-18 06:25:27'),
(33, 8, 3, '2024-12-18 06:25:27', '2024-12-18 06:25:27'),
(34, 8, 4, '2024-12-18 06:25:27', '2024-12-18 06:25:27'),
(35, 8, 5, '2024-12-18 06:25:27', '2024-12-18 06:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_toppings`
--

CREATE TABLE `product_toppings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ingredients_id` bigint(20) UNSIGNED NOT NULL,
  `ingredents_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_toppings`
--

INSERT INTO `product_toppings` (`id`, `product_id`, `ingredients_id`, `ingredents_price`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 5.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(2, 3, 2, 10.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(3, 3, 3, 15.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(4, 3, 4, 20.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(5, 3, 5, 10.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(6, 4, 1, 5.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(7, 4, 2, 10.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(8, 4, 3, 15.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(9, 4, 4, 20.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(10, 4, 5, 10.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(11, 8, 1, 10.00, '2023-04-19 02:48:18', '2023-04-19 02:48:18'),
(12, 8, 2, 20.00, '2023-04-19 02:48:18', '2023-04-19 02:48:18'),
(13, 8, 3, 30.00, '2023-04-19 02:48:18', '2023-04-19 02:48:18'),
(14, 8, 4, 40.00, '2023-04-19 02:48:18', '2023-04-19 02:48:18'),
(15, 9, 2, 2.00, '2023-06-09 04:38:29', '2023-06-09 04:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `varients_id` bigint(20) UNSIGNED NOT NULL,
  `varients_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `varients_id`, `varients_price`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 20.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(2, 3, 2, 30.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(3, 3, 3, 40.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(4, 3, 4, 45.00, '2023-03-17 02:27:41', '2023-03-17 02:27:41'),
(5, 4, 1, 25.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(6, 4, 2, 35.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(7, 4, 3, 45.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(8, 4, 4, 50.00, '2023-03-17 02:30:25', '2023-03-17 02:30:25'),
(9, 7, 2, 100.00, '2023-04-10 04:40:11', '2023-04-10 04:40:11'),
(10, 7, 3, 200.00, '2023-04-10 04:40:11', '2023-04-10 04:40:11'),
(45, 8, 1, 100.00, '2024-12-18 06:25:27', '2024-12-18 06:25:27'),
(46, 8, 2, 200.00, '2024-12-18 06:25:27', '2024-12-18 06:25:27'),
(47, 8, 3, 300.00, '2024-12-18 06:25:27', '2024-12-18 06:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `position`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Add Veg Toppings', '3', 1, NULL, NULL),
(3, 'Cheese', '2', 1, NULL, NULL),
(4, 'Sauces', '1', 1, NULL, NULL),
(5, 'Add Non-Veg Toppings', '4', 1, NULL, NULL),
(6, 'Add Slice Toppings', '5', 1, NULL, NULL),
(36, 'demo', '6', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `properties_items`
--

CREATE TABLE `properties_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `properties_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_multiple` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties_items`
--

INSERT INTO `properties_items` (`id`, `properties_id`, `name`, `price`, `is_multiple`, `status`, `created_at`, `updated_at`) VALUES
(5, 3, 'Peri - Peri Chicken', 2.00, 0, 1, '2023-03-17 02:02:27', '2023-03-17 02:02:27'),
(6, 3, 'Barbecue Chicken', 5.00, 0, 1, '2023-03-17 02:02:54', '2023-03-17 02:02:54'),
(7, 3, 'Grilled Chicken Rasher', 5.00, 0, 1, '2023-03-17 02:03:30', '2023-03-17 02:03:30'),
(8, 3, 'Chicken Sausages', 10.00, 0, 1, '2023-03-17 02:03:53', '2023-03-17 02:03:53'),
(9, 3, 'Chicken Tikka', 10.00, 0, 1, '2023-03-17 02:04:14', '2023-03-17 02:04:14'),
(10, 3, 'Chicken Pepperoni', 10.00, 0, 1, '2023-03-17 02:04:50', '2023-03-17 02:04:50'),
(11, 3, 'Chicken Keema', 5.00, 0, 1, '2023-03-17 02:05:02', '2023-03-17 02:05:02'),
(12, 2, 'Grilled Mushrooms', 1.00, 0, 1, '2023-03-17 02:16:18', '2023-03-17 02:16:18'),
(13, 2, 'Onion', 1.00, 0, 1, '2023-03-17 02:16:32', '2023-03-17 02:16:32'),
(14, 2, 'Paneer', 2.00, 0, 1, '2023-03-17 02:16:42', '2023-03-17 02:16:42'),
(15, 2, 'Red Pepper', 1.00, 0, 1, '2023-03-17 02:17:14', '2023-03-17 02:17:14'),
(16, 2, 'Jalapeno', 2.00, 0, 1, '2023-03-17 02:17:34', '2023-03-17 02:17:34'),
(17, 2, 'Black Olives', 3.00, 0, 1, '2023-03-17 02:17:48', '2023-03-17 02:17:48'),
(18, 2, 'Tomato', 1.00, 0, 1, '2023-03-17 02:18:06', '2023-03-17 02:18:06'),
(19, 2, 'Capsicum', 1.00, 0, 1, '2023-03-17 02:18:28', '2023-03-17 02:18:28'),
(20, 4, 'Cheddar', 7.00, 0, 1, '2023-04-19 01:59:14', '2023-04-19 01:59:14'),
(21, 4, 'Mozzarella', 10.00, 0, 1, '2023-04-19 01:59:34', '2023-04-19 01:59:34'),
(22, 4, 'Ricotta', 5.00, 0, 1, '2023-04-19 01:59:49', '2023-04-19 01:59:49'),
(23, 4, 'Parmesan', 10.00, 0, 1, '2023-04-19 02:00:12', '2023-04-19 02:00:12'),
(24, 5, 'Spicy Red Sauces', 5.00, 0, 1, '2023-04-19 02:43:00', '2023-04-19 02:43:00'),
(25, 5, 'Peppery Red Sauce', 4.00, 0, 1, '2023-04-19 02:43:14', '2023-04-19 02:43:14'),
(26, 5, 'Sweet Pizza Sauces', 3.00, 0, 1, '2023-04-19 02:43:30', '2023-04-19 02:43:30'),
(27, 5, 'Pesto Sauce', 10.00, 0, 1, '2023-04-19 02:43:48', '2023-04-19 02:43:48'),
(28, 5, 'BBQ Sauce', 4.00, 0, 1, '2023-04-19 02:44:12', '2023-04-19 02:44:12'),
(29, 5, 'Mayonnaise', 2.00, 0, 1, '2023-04-19 02:44:28', '2023-04-19 02:44:28'),
(30, 6, 'Chicken Fry', 2.00, 0, 1, '2023-06-09 04:41:05', '2023-06-09 04:41:05'),
(31, 6, 'Paneer', 2.00, 0, 1, '2023-06-09 07:11:16', '2023-06-09 07:11:16'),
(32, 6, 'Capsicum & Onion', 2.00, 0, 1, '2023-06-09 07:11:36', '2023-06-09 07:11:36'),
(33, 6, 'Sweet Corn', 1.00, 0, 1, '2023-06-09 07:11:59', '2023-06-09 07:11:59'),
(34, 6, 'Farmhouse', 2.00, 0, 1, '2023-06-09 07:12:10', '2023-06-09 07:12:10'),
(35, 6, 'Peri Peri Chicken', 2.00, 0, 1, '2023-06-09 07:12:37', '2023-06-09 07:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `properties_sides_in_cart`
--

CREATE TABLE `properties_sides_in_cart` (
  `id` bigint(20) NOT NULL,
  `usercart_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `property_id` bigint(20) NOT NULL,
  `sides` varchar(20) NOT NULL,
  `is_extra` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties_sides_in_cart`
--

INSERT INTO `properties_sides_in_cart` (`id`, `usercart_id`, `product_id`, `property_id`, `sides`, `is_extra`, `created_at`, `updated_at`) VALUES
(7, 136, NULL, 14, 'right', 0, '2023-06-30 17:25:11', '2023-06-30 17:25:11'),
(8, 136, NULL, 15, 'left', 0, '2023-06-30 17:25:11', '2023-06-30 17:25:11'),
(9, 136, NULL, 7, 'whole', 0, '2023-06-30 17:25:11', '2023-06-30 17:25:11'),
(10, 137, NULL, 12, 'left', 0, '2023-06-30 22:03:22', '2023-06-30 22:03:22'),
(11, 137, NULL, 13, 'right', 0, '2023-06-30 22:03:22', '2023-06-30 22:03:22'),
(12, 138, NULL, 15, 'quarter', 0, '2023-07-03 19:35:46', '2023-07-03 19:35:46'),
(13, 139, NULL, 15, 'whole', 0, '2023-08-14 00:27:12', '2023-08-14 00:27:12'),
(14, 139, NULL, 6, 'whole', 0, '2023-08-14 00:27:12', '2023-08-14 00:27:12'),
(15, 139, NULL, 7, 'right', 0, '2023-08-14 00:27:12', '2023-08-14 00:27:12'),
(16, 139, NULL, 21, 'whole', 0, '2023-08-14 00:27:12', '2023-08-14 00:27:12'),
(17, 139, NULL, 26, 'right', 0, '2023-08-14 00:27:12', '2023-08-14 00:27:12'),
(18, 140, NULL, 15, 'left', 0, '2023-08-14 00:31:52', '2023-08-14 00:31:52'),
(19, 140, NULL, 5, 'whole', 0, '2023-08-14 00:31:52', '2023-08-14 00:31:52'),
(20, 140, NULL, 7, 'right', 0, '2023-08-14 00:31:52', '2023-08-14 00:31:52'),
(21, 140, NULL, 9, 'left', 0, '2023-08-14 00:31:52', '2023-08-14 00:31:52'),
(22, 140, NULL, 21, 'right', 0, '2023-08-14 00:31:52', '2023-08-14 00:31:52'),
(23, 141, NULL, 15, 'left', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(24, 141, NULL, 5, 'whole', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(25, 141, NULL, 7, 'right', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(26, 141, NULL, 9, 'left', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(27, 141, NULL, 21, 'right', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(28, 141, NULL, 24, 'whole', 0, '2023-08-14 00:32:11', '2023-08-14 00:32:11'),
(29, 142, NULL, 15, 'whole', 0, '2023-08-30 06:06:35', '2023-08-30 06:06:35'),
(30, 142, NULL, 5, 'whole', 0, '2023-08-30 06:06:35', '2023-08-30 06:06:35'),
(31, 142, NULL, 20, 'whole', 0, '2023-08-30 06:06:35', '2023-08-30 06:06:35'),
(32, 142, NULL, 24, 'whole', 0, '2023-08-30 06:06:35', '2023-08-30 06:06:35'),
(33, 143, NULL, 15, 'whole', 0, '2023-08-30 06:06:58', '2023-08-30 06:06:58'),
(34, 143, NULL, 5, 'whole', 0, '2023-08-30 06:06:58', '2023-08-30 06:06:58'),
(35, 143, NULL, 20, 'whole', 0, '2023-08-30 06:06:58', '2023-08-30 06:06:58'),
(36, 143, NULL, 24, 'whole', 0, '2023-08-30 06:06:58', '2023-08-30 06:06:58'),
(37, 143, NULL, 31, 'whole', 0, '2023-08-30 06:06:58', '2023-08-30 06:06:58'),
(39, 145, NULL, 8, 'right', 0, '2023-08-30 06:37:31', '2023-08-30 06:37:31'),
(40, 146, NULL, 15, 'whole', 0, '2023-08-30 08:28:30', '2023-08-30 08:28:30'),
(41, 146, NULL, 5, 'whole', 0, '2023-08-30 08:28:30', '2023-08-30 08:28:30'),
(42, 146, NULL, 20, 'whole', 0, '2023-08-30 08:28:30', '2023-08-30 08:28:30'),
(43, 146, NULL, 24, 'whole', 0, '2023-08-30 08:28:30', '2023-08-30 08:28:30'),
(45, 147, NULL, 5, 'whole', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(46, 147, NULL, 7, 'left', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(47, 147, NULL, 8, 'right', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(48, 147, NULL, 20, 'whole', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(49, 147, NULL, 22, 'left', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(50, 147, NULL, 23, 'right', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(51, 147, NULL, 24, 'whole', 0, '2023-09-14 06:05:33', '2023-09-14 06:05:33'),
(52, 148, NULL, 15, 'whole', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(53, 148, NULL, 5, 'whole', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(54, 148, NULL, 7, 'left', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(55, 148, NULL, 8, 'right', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(56, 148, NULL, 20, 'whole', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(57, 148, NULL, 24, 'whole', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(58, 148, NULL, 26, 'left', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(59, 148, NULL, 27, 'right', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(60, 148, NULL, 32, 'whole', 0, '2023-09-14 06:13:23', '2023-09-14 06:13:23'),
(61, 150, NULL, 15, 'whole', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(62, 150, NULL, 5, 'whole', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(63, 150, NULL, 6, 'left', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(64, 150, NULL, 7, 'right', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(65, 150, NULL, 20, 'whole', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(66, 150, NULL, 22, 'left', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(67, 150, NULL, 23, 'quarter', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(68, 150, NULL, 24, 'whole', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(69, 150, NULL, 27, 'whole', 0, '2023-09-14 08:48:43', '2023-09-14 08:48:43'),
(70, 151, NULL, 14, 'left', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(71, 151, NULL, 15, 'whole', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(72, 151, NULL, 16, 'right', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(73, 151, NULL, 5, 'whole', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(74, 151, NULL, 6, 'left', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(75, 151, NULL, 7, 'right', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(76, 151, NULL, 20, 'whole', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(77, 151, NULL, 21, 'left', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(78, 151, NULL, 22, 'right', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(79, 151, NULL, 24, 'whole', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(80, 151, NULL, 25, 'left', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(81, 151, NULL, 26, 'right', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(82, 151, NULL, 31, 'right', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(83, 151, NULL, 32, 'left', 0, '2023-09-21 05:38:24', '2023-09-21 05:38:24'),
(84, 152, NULL, 15, 'whole', 0, '2023-09-21 09:23:27', '2023-09-21 09:23:27'),
(85, 152, NULL, 5, 'whole', 0, '2023-09-21 09:23:27', '2023-09-21 09:23:27'),
(86, 152, NULL, 20, 'whole', 0, '2023-09-21 09:23:27', '2023-09-21 09:23:27'),
(87, 152, NULL, 24, 'whole', 0, '2023-09-21 09:23:27', '2023-09-21 09:23:27'),
(88, 153, NULL, 12, 'quarter', 0, '2023-09-21 09:34:16', '2023-09-21 09:34:16'),
(89, 153, NULL, 13, 'whole', 0, '2023-09-21 09:34:16', '2023-09-21 09:34:16'),
(90, 153, NULL, 14, 'right', 0, '2023-09-21 09:34:16', '2023-09-21 09:34:16'),
(94, 153, NULL, 7, 'right', 0, '2023-09-21 09:34:16', '2023-09-21 09:34:16'),
(95, 153, NULL, 8, 'quarter', 0, '2023-09-21 09:34:16', '2023-09-21 09:34:16'),
(103, 155, NULL, 5, 'whole', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(104, 155, NULL, 6, 'left', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(105, 155, NULL, 20, 'whole', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(106, 155, NULL, 21, 'right', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(107, 155, NULL, 24, 'whole', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(108, 155, NULL, 25, 'quarter', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(109, 155, NULL, 30, 'left', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(110, 155, NULL, 31, 'right', 0, '2023-09-22 06:54:53', '2023-09-22 06:54:53'),
(113, 156, NULL, 7, 'left', 0, '2023-09-22 06:55:16', '2023-09-22 06:55:16'),
(114, 156, NULL, 9, 'right', 0, '2023-09-22 06:55:16', '2023-09-22 06:55:16'),
(115, 158, NULL, 13, 'left', 0, '2023-09-22 08:33:35', '2023-09-22 08:33:35'),
(116, 158, NULL, 14, 'whole', 0, '2023-09-22 08:33:35', '2023-09-22 08:33:35'),
(117, 158, NULL, 15, 'right', 0, '2023-09-22 08:33:35', '2023-09-22 08:33:35'),
(118, 158, NULL, 6, 'left', 0, '2023-09-22 08:33:35', '2023-09-22 08:33:35'),
(119, 158, NULL, 7, 'right', 0, '2023-09-22 08:33:35', '2023-09-22 08:33:35'),
(120, 159, NULL, 15, 'whole', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(121, 159, NULL, 5, 'whole', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(124, 159, NULL, 20, 'whole', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(125, 159, NULL, 21, 'quarter', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(126, 159, NULL, 24, 'whole', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(127, 159, NULL, 25, 'left', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(128, 159, NULL, 26, 'right', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(129, 159, NULL, 31, 'left', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(130, 159, NULL, 32, 'quarter', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(131, 159, NULL, 33, 'right', 0, '2023-09-23 01:44:00', '2023-09-23 01:44:00'),
(132, 160, 4, 14, 'left', 0, '2023-09-23 02:37:53', '2023-09-23 02:37:53'),
(133, 160, 4, 15, 'right', 0, '2023-09-23 02:37:53', '2023-09-23 02:37:53'),
(134, 160, 4, 6, 'whole', 0, '2023-09-23 02:37:53', '2023-09-23 02:37:53'),
(135, 160, 4, 7, 'left', 0, '2023-09-23 02:37:53', '2023-09-23 02:37:53'),
(136, 160, 4, 8, 'right', 0, '2023-09-23 02:37:53', '2023-09-23 02:37:53'),
(137, 170, 3, 13, 'whole', 0, '2023-09-23 04:41:51', '2023-09-23 04:41:51'),
(138, 170, 3, 14, 'left', 0, '2023-09-23 04:41:51', '2023-09-23 04:41:51'),
(139, 170, 3, 15, 'right', 0, '2023-09-23 04:41:51', '2023-09-23 04:41:51'),
(140, 171, 4, 13, 'left', 0, '2023-09-23 04:42:14', '2023-09-23 04:42:14'),
(141, 171, 4, 14, 'whole', 0, '2023-09-23 04:42:14', '2023-09-23 04:42:14'),
(142, 171, 4, 6, 'right', 0, '2023-09-23 04:42:14', '2023-09-23 04:42:14'),
(143, 171, 4, 7, 'whole', 0, '2023-09-23 04:42:14', '2023-09-23 04:42:14'),
(144, 172, 8, 14, 'left', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(145, 172, 8, 15, 'whole', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(146, 172, 8, 5, 'quarter', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(147, 172, 8, 6, 'right', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(148, 172, 8, 20, 'whole', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(149, 172, 8, 21, 'left', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(150, 172, 8, 24, 'whole', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(151, 172, 8, 25, 'right', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(152, 172, 8, 31, 'left', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(153, 172, 8, 32, 'whole', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(154, 172, 8, 33, 'right', 0, '2023-09-23 04:42:45', '2023-09-23 04:42:45'),
(155, 173, 4, 12, 'right', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(156, 173, 4, 13, 'left', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(157, 173, 4, 14, 'whole', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(158, 173, 4, 15, 'quarter', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(159, 173, 4, 5, 'right', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(160, 173, 4, 6, 'left', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(161, 173, 4, 7, 'whole', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(162, 173, 4, 8, 'quarter', 0, '2023-09-23 08:34:48', '2023-09-23 08:34:48'),
(163, 174, 8, 13, 'quarter', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(164, 174, 8, 15, 'whole', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(165, 174, 8, 5, 'whole', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(166, 174, 8, 6, 'quarter', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(167, 174, 8, 20, 'whole', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(168, 174, 8, 21, 'right', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(169, 174, 8, 24, 'whole', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(170, 174, 8, 26, 'left', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(171, 174, 8, 31, 'quarter', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(172, 174, 8, 32, 'quarter', 0, '2023-09-23 08:35:25', '2023-09-23 08:35:25'),
(173, 177, 3, 13, 'left', 0, '2023-10-06 02:57:04', '2023-10-06 02:57:04'),
(174, 177, 3, 14, 'whole', 0, '2023-10-06 02:57:04', '2023-10-06 02:57:04'),
(175, 177, 3, 15, 'right', 0, '2023-10-06 02:57:04', '2023-10-06 02:57:04'),
(176, 178, 4, 14, 'whole', 0, '2023-10-06 02:57:20', '2023-10-06 02:57:20'),
(177, 178, 4, 6, 'left', 0, '2023-10-06 02:57:20', '2023-10-06 02:57:20'),
(178, 178, 4, 7, 'right', 0, '2023-10-06 02:57:20', '2023-10-06 02:57:20'),
(179, 179, 8, 15, 'whole', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(180, 179, 8, 5, 'whole', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(181, 179, 8, 20, 'whole', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(182, 179, 8, 24, 'whole', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(183, 179, 8, 31, 'right', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(184, 179, 8, 32, 'left', 0, '2023-10-06 02:57:35', '2023-10-06 02:57:35'),
(185, 185, 3, 14, 'right', 0, '2023-10-06 10:23:36', '2023-10-06 10:23:36'),
(186, 185, 3, 15, 'left', 0, '2023-10-06 10:23:36', '2023-10-06 10:23:36'),
(187, 186, 4, 14, 'left', 0, '2023-10-06 10:23:54', '2023-10-06 10:23:54'),
(188, 186, 4, 8, 'right', 0, '2023-10-06 10:23:54', '2023-10-06 10:23:54'),
(189, 189, 4, 13, 'left', 0, '2023-10-06 10:31:52', '2023-10-06 10:31:52'),
(190, 189, 4, 16, 'right', 0, '2023-10-06 10:31:52', '2023-10-06 10:31:52'),
(191, 189, 4, 7, 'whole', 0, '2023-10-06 10:31:52', '2023-10-06 10:31:52'),
(192, 192, 4, 15, 'right', 0, '2023-10-06 12:21:21', '2023-10-06 12:21:21'),
(193, 192, 4, 6, 'left', 0, '2023-10-06 12:21:21', '2023-10-06 12:21:21'),
(194, 192, 4, 7, 'whole', 0, '2023-10-06 12:21:21', '2023-10-06 12:21:21'),
(195, 192, 4, 8, 'whole', 0, '2023-10-06 12:21:21', '2023-10-06 12:21:21'),
(196, 195, 4, 14, 'whole', 0, '2023-10-07 00:39:07', '2023-10-07 00:39:07'),
(197, 195, 4, 6, 'left', 0, '2023-10-07 00:39:07', '2023-10-07 00:39:07'),
(198, 195, 4, 8, 'right', 0, '2023-10-07 00:39:07', '2023-10-07 00:39:07'),
(199, 197, 4, 14, 'left', 0, '2023-10-08 06:06:06', '2023-10-08 06:06:06'),
(200, 197, 4, 15, 'right', 0, '2023-10-08 06:06:06', '2023-10-08 06:06:06'),
(201, 197, 4, 7, 'whole', 0, '2023-10-08 06:06:06', '2023-10-08 06:06:06'),
(202, 198, 4, 14, 'whole', 0, '2023-10-11 11:56:33', '2023-10-11 11:56:33'),
(203, 198, 4, 6, 'left', 0, '2023-10-11 11:56:33', '2023-10-11 11:56:33'),
(204, 198, 4, 8, 'right', 0, '2023-10-11 11:56:33', '2023-10-11 11:56:33'),
(205, 199, 8, 13, 'right', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(206, 199, 8, 14, 'left', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(207, 199, 8, 15, 'whole', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(208, 199, 8, 5, 'whole', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(209, 199, 8, 20, 'whole', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(210, 199, 8, 21, 'right', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(211, 199, 8, 22, 'left', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(212, 199, 8, 24, 'whole', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(213, 199, 8, 31, 'left', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(214, 199, 8, 32, 'right', 0, '2023-10-11 11:57:18', '2023-10-11 11:57:18'),
(215, 1, 8, 13, 'right', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(216, 1, 8, 14, 'left', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(217, 1, 8, 15, 'whole', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(218, 1, 8, 5, 'whole', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(219, 1, 8, 6, 'left', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(220, 1, 8, 7, 'right', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(221, 1, 8, 20, 'whole', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(222, 1, 8, 21, 'left', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(223, 1, 8, 22, 'right', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(224, 1, 8, 24, 'whole', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(225, 1, 8, 25, 'left', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(226, 1, 8, 26, 'right', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(227, 1, 8, 31, 'left', 0, '2023-12-07 05:31:01', '2023-12-07 05:31:01'),
(228, 2, 8, 14, 'left', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(229, 2, 8, 15, 'whole', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(230, 2, 8, 5, 'whole', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(231, 2, 8, 7, 'right', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(232, 2, 8, 20, 'whole', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(233, 2, 8, 22, 'left', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(234, 2, 8, 24, 'whole', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(235, 2, 8, 26, 'right', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(236, 2, 8, 32, 'left', 0, '2023-12-07 05:35:03', '2023-12-07 05:35:03'),
(237, 4, 3, 13, 'left', 0, '2023-12-07 05:35:24', '2023-12-07 05:35:24'),
(238, 4, 3, 14, 'right', 0, '2023-12-07 05:35:24', '2023-12-07 05:35:24'),
(239, 6, 4, 12, 'whole', 0, '2023-12-11 08:40:18', '2023-12-11 08:40:18'),
(240, 6, 4, 14, 'left', 0, '2023-12-11 08:40:18', '2023-12-11 08:40:18'),
(241, 6, 4, 15, 'right', 0, '2023-12-11 08:40:18', '2023-12-11 08:40:18'),
(242, 6, 4, 7, 'left', 0, '2023-12-11 08:40:18', '2023-12-11 08:40:18'),
(243, 6, 4, 8, 'right', 0, '2023-12-11 08:40:18', '2023-12-11 08:40:18'),
(244, 7, 3, 13, 'left', 0, '2023-12-16 02:23:43', '2023-12-16 02:23:43'),
(245, 7, 3, 14, 'right', 0, '2023-12-16 02:23:43', '2023-12-16 02:23:43'),
(246, 7, 3, 15, 'right', 0, '2023-12-16 02:23:43', '2023-12-16 02:23:43'),
(247, 7, 3, 16, 'whole', 0, '2023-12-16 02:23:43', '2023-12-16 02:23:43'),
(248, 8, 8, 15, 'whole', 0, '2023-12-16 02:24:46', '2023-12-16 02:24:46'),
(249, 8, 8, 5, 'whole', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(250, 8, 8, 6, 'right', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(251, 8, 8, 20, 'whole', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(252, 8, 8, 22, 'right', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(253, 8, 8, 24, 'whole', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(254, 8, 8, 25, 'right', 0, '2023-12-16 02:24:47', '2023-12-16 02:24:47'),
(255, 9, 8, 15, 'whole', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(256, 9, 8, 5, 'whole', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(257, 9, 8, 7, 'left', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(258, 9, 8, 8, 'right', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(259, 9, 8, 9, 'right', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(260, 9, 8, 20, 'whole', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(261, 9, 8, 22, 'right', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(262, 9, 8, 24, 'whole', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(263, 9, 8, 25, 'right', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(264, 9, 8, 26, 'left', 0, '2023-12-16 03:33:17', '2023-12-16 03:33:17'),
(265, 10, 3, 14, 'left', 0, '2023-12-16 03:34:22', '2023-12-16 03:34:22'),
(266, 11, 3, 14, 'left', 0, '2023-12-16 03:34:22', '2023-12-16 03:34:22'),
(267, 12, 8, 15, 'whole', 0, '2023-12-16 03:35:28', '2023-12-16 03:35:28'),
(268, 12, 8, 5, 'whole', 0, '2023-12-16 03:35:28', '2023-12-16 03:35:28'),
(269, 12, 8, 20, 'whole', 0, '2023-12-16 03:35:28', '2023-12-16 03:35:28'),
(270, 12, 8, 24, 'whole', 0, '2023-12-16 03:35:28', '2023-12-16 03:35:28'),
(271, 13, 8, 13, 'right', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(272, 13, 8, 15, 'whole', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(273, 13, 8, 5, 'whole', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(274, 13, 8, 7, 'right', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(275, 13, 8, 20, 'whole', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(276, 13, 8, 22, 'right', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(277, 13, 8, 25, 'whole', 0, '2023-12-16 03:44:34', '2023-12-16 03:44:34'),
(278, 15, 8, 13, 'right', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(279, 15, 8, 15, 'whole', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(280, 15, 8, 7, 'left', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(281, 15, 8, 20, 'whole', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(282, 15, 8, 22, 'left', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(283, 15, 8, 24, 'whole', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(284, 15, 8, 26, 'right', 0, '2023-12-16 03:50:08', '2023-12-16 03:50:08'),
(285, 16, 4, 13, 'left', 0, '2023-12-20 04:36:39', '2023-12-20 04:36:39'),
(286, 16, 4, 14, 'right', 0, '2023-12-20 04:36:39', '2023-12-20 04:36:39'),
(287, 16, 4, 6, 'whole', 0, '2023-12-20 04:36:39', '2023-12-20 04:36:39'),
(288, 16, 4, 7, 'left', 0, '2023-12-20 04:36:39', '2023-12-20 04:36:39'),
(289, 16, 4, 8, 'right', 0, '2023-12-20 04:36:39', '2023-12-20 04:36:39'),
(290, 17, 8, 15, 'whole', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(291, 17, 8, 5, 'whole', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(292, 17, 8, 6, 'left', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(293, 17, 8, 7, 'right', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(294, 17, 8, 20, 'whole', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(295, 17, 8, 24, 'whole', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(296, 17, 8, 26, 'left', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(297, 17, 8, 27, 'right', 0, '2023-12-20 04:37:42', '2023-12-20 04:37:42'),
(298, 19, 4, 14, 'left', 0, '2023-12-20 04:52:15', '2023-12-20 04:52:15'),
(299, 19, 4, 7, 'whole', 0, '2023-12-20 04:52:15', '2023-12-20 04:52:15'),
(300, 20, 4, 13, 'whole', 0, '2023-12-20 04:53:51', '2023-12-20 04:53:51'),
(301, 20, 4, 15, 'left', 0, '2023-12-20 04:53:51', '2023-12-20 04:53:51'),
(302, 20, 4, 7, 'whole', 0, '2023-12-20 04:53:51', '2023-12-20 04:53:51'),
(303, 21, 4, 13, 'whole', 0, '2024-01-15 04:45:20', '2024-01-15 04:45:20'),
(304, 21, 4, 14, 'right', 0, '2024-01-15 04:45:20', '2024-01-15 04:45:20'),
(305, 21, 4, 15, 'left', 0, '2024-01-15 04:45:20', '2024-01-15 04:45:20'),
(306, 21, 4, 6, 'right', 0, '2024-01-15 04:45:20', '2024-01-15 04:45:20'),
(307, 21, 4, 7, 'left', 0, '2024-01-15 04:45:20', '2024-01-15 04:45:20'),
(310, 25, 4, 15, 'left', 0, '2024-04-08 12:01:53', '2024-04-08 12:01:53'),
(311, 25, 4, 8, 'right', 0, '2024-04-08 12:01:53', '2024-04-08 12:01:53'),
(312, 26, 3, 15, 'whole', 0, '2024-04-15 07:41:20', '2024-04-15 07:41:20'),
(313, 27, 4, 14, 'right', 0, '2024-04-16 09:40:37', '2024-04-16 09:40:37'),
(314, 27, 4, 7, 'right', 0, '2024-04-16 09:40:37', '2024-04-16 09:40:37'),
(315, 28, 8, 12, 'whole', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(316, 28, 8, 5, 'whole', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(317, 28, 8, 20, 'whole', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(318, 28, 8, 22, 'right', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(319, 28, 8, 27, 'right', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(320, 28, 8, 32, 'whole', 0, '2024-04-16 10:36:55', '2024-04-16 10:36:55'),
(321, 29, 4, 12, 'whole', 0, '2024-04-16 10:39:31', '2024-04-16 10:39:31'),
(322, 29, 4, 5, 'whole', 0, '2024-04-16 10:39:31', '2024-04-16 10:39:31'),
(323, 30, 8, 12, 'whole', 0, '2024-04-17 04:22:59', '2024-04-17 04:22:59'),
(324, 30, 8, 5, 'whole', 0, '2024-04-17 04:22:59', '2024-04-17 04:22:59'),
(325, 30, 8, 20, 'whole', 0, '2024-04-17 04:22:59', '2024-04-17 04:22:59'),
(326, 30, 8, 24, 'whole', 0, '2024-04-17 04:22:59', '2024-04-17 04:22:59'),
(327, 30, 8, 30, 'whole', 0, '2024-04-17 04:22:59', '2024-04-17 04:22:59'),
(328, 31, 8, 15, 'whole', 0, '2024-04-17 04:54:08', '2024-04-17 04:54:08'),
(329, 31, 8, 5, 'whole', 0, '2024-04-17 04:54:08', '2024-04-17 04:54:08'),
(330, 31, 8, 20, 'whole', 0, '2024-04-17 04:54:08', '2024-04-17 04:54:08'),
(331, 31, 8, 24, 'whole', 0, '2024-04-17 04:54:08', '2024-04-17 04:54:08'),
(332, 32, 8, 15, 'whole', 0, '2024-04-17 06:50:33', '2024-04-17 06:50:33'),
(333, 32, 8, 5, 'whole', 0, '2024-04-17 06:50:33', '2024-04-17 06:50:33'),
(334, 32, 8, 20, 'whole', 0, '2024-04-17 06:50:33', '2024-04-17 06:50:33'),
(335, 32, 8, 24, 'whole', 0, '2024-04-17 06:50:33', '2024-04-17 06:50:33'),
(336, 32, 8, 30, 'whole', 0, '2024-04-17 06:50:33', '2024-04-17 06:50:33'),
(337, 33, 8, 12, 'whole', 0, '2024-04-17 06:51:13', '2024-04-17 06:51:13'),
(338, 33, 8, 5, 'whole', 0, '2024-04-17 06:51:13', '2024-04-17 06:51:13'),
(339, 33, 8, 20, 'whole', 0, '2024-04-17 06:51:13', '2024-04-17 06:51:13'),
(340, 33, 8, 24, 'whole', 0, '2024-04-17 06:51:13', '2024-04-17 06:51:13'),
(341, 33, 8, 30, 'whole', 0, '2024-04-17 06:51:13', '2024-04-17 06:51:13'),
(342, 34, 8, 15, 'whole', 0, '2024-04-17 06:51:31', '2024-04-17 06:51:31'),
(343, 34, 8, 5, 'whole', 0, '2024-04-17 06:51:31', '2024-04-17 06:51:31'),
(344, 34, 8, 20, 'whole', 0, '2024-04-17 06:51:31', '2024-04-17 06:51:31'),
(345, 34, 8, 24, 'whole', 0, '2024-04-17 06:51:31', '2024-04-17 06:51:31'),
(346, 34, 8, 32, 'whole', 0, '2024-04-17 06:51:31', '2024-04-17 06:51:31'),
(347, 35, 8, 15, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(348, 35, 8, 5, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(349, 35, 8, 20, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(350, 35, 8, 24, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(351, 35, 8, 30, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(352, 35, 8, 31, 'whole', 0, '2024-04-17 06:59:25', '2024-04-17 06:59:25'),
(353, 36, 8, 15, 'whole', 0, '2024-04-17 07:08:18', '2024-04-17 07:08:18'),
(354, 36, 8, 5, 'whole', 0, '2024-04-17 07:08:18', '2024-04-17 07:08:18'),
(355, 36, 8, 20, 'whole', 0, '2024-04-17 07:08:18', '2024-04-17 07:08:18'),
(356, 36, 8, 24, 'whole', 0, '2024-04-17 07:08:18', '2024-04-17 07:08:18'),
(357, 37, 8, 15, 'whole', 0, '2024-04-17 07:08:41', '2024-04-17 07:08:41'),
(358, 37, 8, 5, 'whole', 0, '2024-04-17 07:08:41', '2024-04-17 07:08:41'),
(359, 37, 8, 20, 'whole', 0, '2024-04-17 07:08:41', '2024-04-17 07:08:41'),
(360, 37, 8, 24, 'whole', 0, '2024-04-17 07:08:41', '2024-04-17 07:08:41'),
(361, 37, 8, 25, 'whole', 0, '2024-04-17 07:08:41', '2024-04-17 07:08:41'),
(366, 38, 8, 15, 'whole', 0, '2024-04-17 07:30:00', '2024-04-17 07:30:00'),
(367, 38, 8, 5, 'whole', 0, '2024-04-17 07:30:00', '2024-04-17 07:30:00'),
(368, 38, 8, 20, 'whole', 0, '2024-04-17 07:30:00', '2024-04-17 07:30:00'),
(369, 38, 8, 24, 'whole', 0, '2024-04-17 07:30:00', '2024-04-17 07:30:00'),
(370, 38, 8, 31, 'whole', 0, '2024-04-17 07:30:00', '2024-04-17 07:30:00'),
(377, 39, 8, 6, 'whole', 0, '2024-04-17 09:59:58', '2024-04-17 09:59:58'),
(384, 39, 8, 27, 'whole', 0, '2024-04-17 10:00:44', '2024-04-17 10:00:44'),
(389, 39, 8, 20, 'whole', 0, '2024-04-17 11:08:09', '2024-04-17 11:08:09'),
(394, 39, 8, 5, 'whole', 0, '2024-04-17 11:09:10', '2024-04-17 11:09:10'),
(395, 39, 8, 30, 'whole', 0, '2024-04-17 11:09:10', '2024-04-17 11:09:10'),
(429, 39, 8, 15, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(431, 39, 8, 8, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(432, 39, 8, 22, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(434, 39, 8, 24, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(435, 39, 8, 25, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(436, 39, 8, 32, 'whole', 0, '2024-04-17 11:23:52', '2024-04-17 11:23:52'),
(442, 39, 8, 33, 'whole', 0, '2024-04-17 11:51:19', '2024-04-17 11:51:19'),
(455, 39, 8, 12, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(456, 39, 8, 13, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(457, 39, 8, 14, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(458, 39, 8, 7, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(459, 39, 8, 23, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(460, 39, 8, 26, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(461, 39, 8, 31, 'whole', 0, '2024-04-17 12:19:56', '2024-04-17 12:19:56'),
(462, 41, 3, 13, 'whole', 0, '2024-04-17 12:23:01', '2024-04-17 12:23:01'),
(464, 42, 4, 14, 'whole', 0, '2024-04-17 12:23:40', '2024-04-17 12:23:40'),
(467, 41, 3, 14, 'whole', 0, '2024-04-17 12:23:55', '2024-04-17 12:23:55'),
(468, 42, 4, 13, 'whole', 0, '2024-04-17 12:24:23', '2024-04-17 12:24:23'),
(469, 42, 4, 7, 'whole', 0, '2024-04-17 12:24:23', '2024-04-17 12:24:23'),
(475, 43, 8, 5, 'whole', 0, '2024-04-17 12:25:06', '2024-04-17 12:25:06'),
(476, 43, 8, 20, 'whole', 0, '2024-04-17 12:25:06', '2024-04-17 12:25:06'),
(479, 43, 8, 15, 'whole', 0, '2024-04-17 12:27:08', '2024-04-17 12:27:08'),
(480, 43, 8, 24, 'whole', 0, '2024-04-17 12:27:08', '2024-04-17 12:27:08'),
(481, 43, 8, 31, 'whole', 0, '2024-04-17 12:27:08', '2024-04-17 12:27:08'),
(482, 44, 3, 13, 'whole', 0, '2024-04-17 12:27:33', '2024-04-17 12:27:33'),
(484, 44, 3, 14, 'whole', 0, '2024-04-17 12:36:34', '2024-04-17 12:36:34'),
(490, 45, 8, 15, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(491, 45, 8, 5, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(492, 45, 8, 20, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(493, 45, 8, 24, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(494, 45, 8, 30, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(495, 45, 8, 31, 'whole', 0, '2024-04-17 12:54:49', '2024-04-17 12:54:49'),
(496, 46, 3, 14, 'whole', 0, '2024-04-17 12:55:01', '2024-04-17 12:55:01'),
(497, 47, 4, 13, 'whole', 0, '2024-04-18 04:11:19', '2024-04-18 04:11:19'),
(501, 47, 4, 14, 'whole', 0, '2024-04-18 04:31:39', '2024-04-18 04:31:39'),
(502, 47, 4, 6, 'whole', 0, '2024-04-18 04:31:39', '2024-04-18 04:31:39'),
(503, 48, 8, 13, 'left', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(504, 48, 8, 15, 'whole', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(505, 48, 8, 5, 'whole', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(506, 48, 8, 6, 'right', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(507, 48, 8, 20, 'whole', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(508, 48, 8, 22, 'left', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(509, 48, 8, 24, 'whole', 0, '2024-04-18 11:16:52', '2024-04-18 11:16:52'),
(511, 49, 8, 5, 'whole', 0, '2024-04-18 11:22:30', '2024-04-18 11:22:30'),
(512, 49, 8, 20, 'whole', 0, '2024-04-18 11:22:30', '2024-04-18 11:22:30'),
(513, 49, 8, 24, 'whole', 0, '2024-04-18 11:22:30', '2024-04-18 11:22:30'),
(514, 49, 8, 30, 'whole', 0, '2024-04-18 11:22:30', '2024-04-18 11:22:30'),
(519, 49, 8, 15, 'whole', 0, '2024-04-18 11:24:05', '2024-04-18 11:24:05'),
(520, 49, 8, 6, 'whole', 0, '2024-04-18 11:24:05', '2024-04-18 11:24:05'),
(521, 49, 8, 21, 'whole', 0, '2024-04-18 11:24:05', '2024-04-18 11:24:05'),
(522, 49, 8, 26, 'whole', 0, '2024-04-18 11:24:05', '2024-04-18 11:24:05'),
(523, 49, 8, 32, 'right', 0, '2024-04-18 11:24:05', '2024-04-18 11:24:05'),
(525, 51, 3, 13, 'whole', 0, '2024-04-18 11:24:42', '2024-04-18 11:24:42'),
(526, 51, 3, 14, 'right', 0, '2024-04-18 11:24:42', '2024-04-18 11:24:42'),
(527, 52, 8, 15, 'whole', 0, '2024-04-18 12:13:45', '2024-04-18 12:13:45'),
(528, 52, 8, 5, 'whole', 0, '2024-04-18 12:13:45', '2024-04-18 12:13:45'),
(529, 52, 8, 20, 'whole', 0, '2024-04-18 12:13:45', '2024-04-18 12:13:45'),
(530, 52, 8, 24, 'whole', 0, '2024-04-18 12:13:45', '2024-04-18 12:13:45'),
(531, 53, 8, 15, 'whole', 0, '2024-04-18 12:14:13', '2024-04-18 12:14:13'),
(532, 53, 8, 5, 'whole', 0, '2024-04-18 12:14:13', '2024-04-18 12:14:13'),
(533, 53, 8, 20, 'right', 0, '2024-04-18 12:14:13', '2024-04-18 12:14:13'),
(534, 53, 8, 24, 'whole', 0, '2024-04-18 12:14:13', '2024-04-18 12:14:13'),
(539, 54, 8, 15, 'whole', 0, '2024-04-18 12:14:46', '2024-04-18 12:14:46'),
(540, 54, 8, 5, 'right', 0, '2024-04-18 12:14:46', '2024-04-18 12:14:46'),
(541, 54, 8, 20, 'whole', 0, '2024-04-18 12:14:46', '2024-04-18 12:14:46'),
(542, 54, 8, 24, 'whole', 0, '2024-04-18 12:14:46', '2024-04-18 12:14:46'),
(543, 60, 8, 13, 'right', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(544, 60, 8, 15, 'whole', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(545, 60, 8, 5, 'whole', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(546, 60, 8, 7, 'right', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(547, 60, 8, 20, 'whole', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(548, 60, 8, 22, 'left', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(549, 60, 8, 24, 'whole', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(550, 60, 8, 26, 'left', 0, '2024-04-26 22:24:39', '2024-04-26 22:24:39'),
(551, 61, 8, 15, 'whole', 0, '2024-04-26 22:25:08', '2024-04-26 22:25:08'),
(552, 61, 8, 5, 'whole', 0, '2024-04-26 22:25:08', '2024-04-26 22:25:08'),
(553, 61, 8, 20, 'whole', 0, '2024-04-26 22:25:08', '2024-04-26 22:25:08'),
(554, 61, 8, 24, 'whole', 0, '2024-04-26 22:25:08', '2024-04-26 22:25:08'),
(555, 62, 3, 13, 'right', 0, '2024-04-26 22:26:57', '2024-04-26 22:26:57'),
(556, 62, 3, 14, 'whole', 0, '2024-04-26 22:26:57', '2024-04-26 22:26:57'),
(557, 63, 8, 14, 'right', 0, '2024-04-27 05:31:01', '2024-04-27 05:31:01'),
(558, 63, 8, 15, 'whole', 0, '2024-04-27 05:31:01', '2024-04-27 05:31:01'),
(559, 63, 8, 5, 'whole', 0, '2024-04-27 05:31:01', '2024-04-27 05:31:01'),
(560, 63, 8, 20, 'whole', 0, '2024-04-27 05:31:01', '2024-04-27 05:31:01'),
(561, 63, 8, 24, 'whole', 0, '2024-04-27 05:31:01', '2024-04-27 05:31:01'),
(566, 64, 8, 13, 'right', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(567, 64, 8, 14, 'left', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(568, 64, 8, 15, 'whole', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(569, 64, 8, 5, 'whole', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(570, 64, 8, 20, 'whole', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(571, 64, 8, 24, 'whole', 0, '2024-04-27 05:32:12', '2024-04-27 05:32:12'),
(572, 66, 8, 13, 'left', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(573, 66, 8, 15, 'whole', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(574, 66, 8, 16, 'right', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(575, 66, 8, 5, 'whole', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(576, 66, 8, 20, 'whole', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(577, 66, 8, 24, 'whole', 0, '2024-04-27 05:43:52', '2024-04-27 05:43:52'),
(578, 67, 8, 12, 'left', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(579, 67, 8, 13, 'whole', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(580, 67, 8, 14, 'left', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(581, 67, 8, 15, 'whole', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(582, 67, 8, 5, 'whole', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(583, 67, 8, 20, 'whole', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(584, 67, 8, 24, 'whole', 0, '2024-04-27 05:44:34', '2024-04-27 05:44:34'),
(585, 69, 8, 15, 'whole', 0, '2024-04-27 05:48:05', '2024-04-27 05:48:05'),
(586, 69, 8, 5, 'whole', 0, '2024-04-27 05:48:05', '2024-04-27 05:48:05'),
(587, 69, 8, 20, 'whole', 0, '2024-04-27 05:48:05', '2024-04-27 05:48:05'),
(588, 69, 8, 24, 'whole', 0, '2024-04-27 05:48:05', '2024-04-27 05:48:05'),
(589, 70, 3, 13, 'left', 0, '2024-04-27 05:49:37', '2024-04-27 05:49:37'),
(590, 70, 3, 14, 'right', 0, '2024-04-27 05:49:37', '2024-04-27 05:49:37'),
(591, 70, 3, 15, 'whole', 0, '2024-04-27 05:49:37', '2024-04-27 05:49:37'),
(592, 71, 3, 15, 'whole', 0, '2024-04-27 05:51:52', '2024-04-27 05:51:52'),
(593, 72, 3, 14, 'whole', 0, '2024-04-27 05:55:28', '2024-04-27 05:55:28'),
(594, 73, 8, 13, 'right', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(595, 73, 8, 15, 'whole', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(596, 73, 8, 5, 'whole', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(597, 73, 8, 7, 'right', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(598, 73, 8, 8, 'right', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(599, 73, 8, 9, 'right', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(600, 73, 8, 20, 'whole', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(601, 73, 8, 24, 'whole', 0, '2024-04-27 05:57:42', '2024-04-27 05:57:42'),
(602, 76, 8, 13, 'right', 0, '2024-04-29 09:25:59', '2024-04-29 09:25:59'),
(603, 76, 8, 15, 'whole', 0, '2024-04-29 09:25:59', '2024-04-29 09:25:59'),
(604, 76, 8, 5, 'whole', 0, '2024-04-29 09:25:59', '2024-04-29 09:25:59'),
(605, 76, 8, 20, 'whole', 0, '2024-04-29 09:25:59', '2024-04-29 09:25:59'),
(606, 76, 8, 24, 'whole', 0, '2024-04-29 09:25:59', '2024-04-29 09:25:59'),
(607, 81, 8, 12, 'right', 0, '2024-05-08 09:19:33', '2024-05-08 09:19:33'),
(608, 81, 8, 15, 'whole', 0, '2024-05-08 09:19:33', '2024-05-08 09:19:33'),
(609, 81, 8, 5, 'whole', 0, '2024-05-08 09:19:33', '2024-05-08 09:19:33'),
(610, 81, 8, 20, 'whole', 0, '2024-05-08 09:19:33', '2024-05-08 09:19:33'),
(611, 81, 8, 24, 'whole', 0, '2024-05-08 09:19:33', '2024-05-08 09:19:33'),
(612, 82, 8, 13, 'right', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(613, 82, 8, 15, 'whole', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(614, 82, 8, 5, 'whole', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(615, 82, 8, 7, 'whole', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(616, 82, 8, 20, 'whole', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(617, 82, 8, 22, 'left', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(618, 82, 8, 24, 'whole', 0, '2024-05-13 20:53:29', '2024-05-13 20:53:29'),
(619, 87, 8, 15, 'whole', 0, '2024-05-14 08:37:18', '2024-05-14 08:37:18'),
(620, 87, 8, 5, 'whole', 0, '2024-05-14 08:37:18', '2024-05-14 08:37:18'),
(621, 87, 8, 20, 'whole', 0, '2024-05-14 08:37:18', '2024-05-14 08:37:18'),
(622, 87, 8, 24, 'whole', 0, '2024-05-14 08:37:18', '2024-05-14 08:37:18'),
(623, 95, 4, 13, 'whole', 0, '2024-06-13 15:54:32', '2024-06-13 15:54:32'),
(624, 95, 4, 7, 'right', 0, '2024-06-13 15:54:32', '2024-06-13 15:54:32'),
(625, 96, 4, 14, 'whole', 0, '2024-06-17 09:47:25', '2024-06-17 09:47:25'),
(626, 96, 4, 7, 'left', 0, '2024-06-17 09:47:25', '2024-06-17 09:47:25'),
(627, 96, 4, 8, 'right', 0, '2024-06-17 09:47:25', '2024-06-17 09:47:25'),
(628, 24, 3, 13, 'left', 0, '2024-06-17 09:47:46', '2024-06-17 09:47:46'),
(629, 24, 3, 14, 'whole', 0, '2024-06-17 09:47:46', '2024-06-17 09:47:46'),
(630, 24, 3, 15, 'whole', 0, '2024-06-17 09:47:46', '2024-06-17 09:47:46'),
(633, 136, 4, 12, 'whole', 0, '2024-09-05 11:34:27', '2024-09-05 11:34:27'),
(637, 136, 4, 13, 'whole', 0, '2024-09-05 11:34:37', '2024-09-05 11:34:37'),
(638, 136, 4, 5, 'whole', 0, '2024-09-05 11:34:37', '2024-09-05 11:34:37'),
(639, 136, 4, 6, 'whole', 0, '2024-09-05 11:34:37', '2024-09-05 11:34:37'),
(640, 145, 4, 12, 'right', 0, '2024-11-14 11:40:48', '2024-11-14 11:40:48'),
(641, 145, 4, 14, 'left', 0, '2024-11-14 11:40:48', '2024-11-14 11:40:48'),
(642, 145, 4, 9, 'whole', 0, '2024-11-14 11:40:48', '2024-11-14 11:40:48'),
(643, 147, 3, 12, 'left', 0, '2024-11-14 12:00:52', '2024-11-14 12:00:52'),
(644, 147, 3, 15, 'right', 0, '2024-11-14 12:00:52', '2024-11-14 12:00:52'),
(645, 151, 3, 13, 'right', 0, '2024-11-14 14:37:52', '2024-11-14 14:37:52'),
(646, 152, 3, 13, 'whole', 0, '2024-11-14 14:38:02', '2024-11-14 14:38:02'),
(647, 153, 8, 15, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(648, 153, 8, 5, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(649, 153, 8, 6, 'left', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(650, 153, 8, 20, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(651, 153, 8, 24, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(652, 154, 8, 15, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(653, 154, 8, 5, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(654, 154, 8, 6, 'left', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(655, 154, 8, 20, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(656, 154, 8, 24, 'whole', 0, '2024-11-15 22:09:21', '2024-11-15 22:09:21'),
(657, 155, 3, 13, 'right', 0, '2024-11-18 10:01:37', '2024-11-18 10:01:37'),
(658, 155, 3, 14, 'whole', 0, '2024-11-18 10:01:37', '2024-11-18 10:01:37'),
(659, 155, 3, 15, 'left', 0, '2024-11-18 10:01:37', '2024-11-18 10:01:37'),
(660, 155, 3, 16, 'right', 0, '2024-11-18 10:01:37', '2024-11-18 10:01:37'),
(661, 156, 8, 12, 'right', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(662, 156, 8, 13, 'right', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(663, 156, 8, 14, 'left', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(664, 156, 8, 15, 'whole', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(665, 156, 8, 16, 'left', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(666, 156, 8, 6, 'left', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(667, 156, 8, 20, 'left', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(668, 156, 8, 24, 'whole', 0, '2024-11-18 10:06:48', '2024-11-18 10:06:48'),
(669, 159, 4, 12, 'quarter', 0, '2024-11-18 10:34:48', '2024-11-18 10:34:48'),
(670, 159, 4, 14, 'left', 0, '2024-11-18 10:34:48', '2024-11-18 10:34:48'),
(671, 159, 4, 16, 'quarter', 0, '2024-11-18 10:34:48', '2024-11-18 10:34:48'),
(672, 159, 4, 6, 'right', 0, '2024-11-18 10:34:48', '2024-11-18 10:34:48'),
(673, 159, 4, 7, 'left', 0, '2024-11-18 10:34:48', '2024-11-18 10:34:48'),
(674, 162, 4, 13, 'left', 0, '2024-11-18 10:53:11', '2024-11-18 10:53:11'),
(675, 162, 4, 15, 'right', 0, '2024-11-18 10:53:11', '2024-11-18 10:53:11'),
(676, 162, 4, 6, 'whole', 0, '2024-11-18 10:53:11', '2024-11-18 10:53:11'),
(677, 165, 4, 6, 'whole', 0, '2025-01-30 05:49:54', '2025-01-30 05:49:54'),
(678, 165, 4, 14, 'right', 0, '2025-01-30 05:49:54', '2025-01-30 05:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency` bigint(20) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `rate` double(8,2) NOT NULL,
  `alignment` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `currency`, `symbol`, `rate`, `alignment`, `status`, `created_at`, `updated_at`) VALUES
(2, 'rupees', 11, '@', 6.00, 'qwert', 1, '2022-12-05 23:13:10', '2022-12-07 00:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smtps`
--

CREATE TABLE `smtps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mailer` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `encryption` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smtps`
--

INSERT INTO `smtps` (`id`, `mailer`, `host`, `port`, `name`, `password`, `encryption`, `address`, `created_at`, `updated_at`) VALUES
(1, 'dfyj', 'dfgh', 'fghj', 'sdfgh', 'dfghjk', 'fghjk', 'fgfghj', '2022-12-08 01:47:03', '2022-12-08 01:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `stock_inventries`
--

CREATE TABLE `stock_inventries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `stock` double NOT NULL,
  `price` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cate_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `cate_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pure Veg', 1, '/public/assets/admin/assets/img/sub_category/1679036836641411a473cb2.jpg', 1, '2023-03-17 01:37:16', '2023-03-17 01:37:16'),
(2, 'Chicken', 1, '/public/assets/admin/assets/img/sub_category/1679036884641411d440e37.jpg', 1, '2023-03-17 01:38:04', '2023-03-17 01:38:04'),
(3, 'Veg berbeque Pizza', 2, '/public/assets/admin/assets/img/sub_category/1679036985641412398e79f.jpg', 1, '2023-03-17 01:39:45', '2023-03-30 04:00:33'),
(4, 'Non Veg Pizza', 2, '/public/assets/admin/assets/img/sub_category/16790370336414126974e3c.jpg', 1, '2023-03-17 01:40:33', '2023-03-17 01:40:33'),
(5, 'Noodles', 3, '/public/assets/admin/assets/img/sub_category/1679037152641412e0d6eb1.jpg', 1, '2023-03-17 01:42:32', '2023-03-17 01:42:32'),
(6, 'Momos', 3, '/public/assets/admin/assets/img/sub_category/16790371966414130c4fb65.jpg', 1, '2023-03-17 01:43:16', '2023-03-17 01:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `guest_capacity` int(11) NOT NULL,
  `status` enum('open','check_in','seated','check_out','dirty') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_details`
--

CREATE TABLE `table_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_table_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `area` varchar(255) NOT NULL,
  `table_num` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `heading1` varchar(255) DEFAULT NULL,
  `answer1` longtext DEFAULT NULL,
  `heading2` varchar(255) DEFAULT NULL,
  `answer2` longtext DEFAULT NULL,
  `heading3` varchar(255) DEFAULT NULL,
  `answer3` longtext DEFAULT NULL,
  `heading4` varchar(255) DEFAULT NULL,
  `answer4` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_and_conditions`
--

INSERT INTO `terms_and_conditions` (`id`, `heading1`, `answer1`, `heading2`, `answer2`, `heading3`, `answer3`, `heading4`, `answer4`, `created_at`, `updated_at`) VALUES
(1, 'heading1', 'answer1', 'heading2', 'answer2', 'heading3', 'answer3', 'heading4', 'answer4', '2023-03-21 08:27:34', '2023-03-21 08:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `otp_verify` varchar(255) DEFAULT NULL,
  `otp_email` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `fcm` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `person_id`, `name`, `image`, `gender`, `email`, `email_verified_at`, `password`, `remember_token`, `country_code`, `phone`, `otp_verify`, `otp_email`, `dob`, `age`, `address`, `fcm`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Shah', NULL, NULL, 'test@gmail.com', NULL, NULL, NULL, NULL, '8009610334', '1234', NULL, '1970-01-01', '15-25', 'no issue in address hgghjg', NULL, '2022-12-14 23:55:09', '2023-02-20 04:03:23'),
(2, NULL, 'Test', NULL, NULL, 'user@gmail.com', NULL, '$2y$10$ngFDnG9kSISUzWmux7FKHOy9rp0yOKaWs.iQHogtcNK7Xor6a5RqO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-14 12:21:29', '2023-01-14 12:21:29'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567890', '1234', NULL, NULL, NULL, NULL, NULL, '2023-02-15 04:18:22', '2023-02-27 00:14:22'),
(8, NULL, 'Test', NULL, NULL, 'user1@gmail.com', NULL, '$2y$10$alVWQCIHiwUpZpVEor2xtOa9CaeWCfg458Akzm2CeJ/aDYWwazfFa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-16 06:47:29', '2023-02-16 06:47:29'),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8998989989', '1234', NULL, NULL, NULL, NULL, NULL, '2023-02-22 02:25:37', '2023-02-22 02:25:37'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9540040448', '1234', NULL, NULL, NULL, NULL, NULL, '2023-02-23 01:08:42', '2023-02-23 06:29:35'),
(11, NULL, 'Debasish Bhattacharjee', NULL, NULL, 'deb_bhatt200811@yahoo.com', NULL, 'password', NULL, NULL, '7678192082', '1234', NULL, '1994-11-04', '29', 'Cross_street11, Dibrugarh', NULL, '2023-03-05 22:45:37', '2024-12-01 23:16:19'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9965768294', '1234', NULL, NULL, NULL, NULL, NULL, '2023-03-23 02:09:47', '2023-03-23 02:14:55'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9996557284', '1234', NULL, NULL, NULL, NULL, NULL, '2023-03-29 08:01:37', '2023-08-29 23:57:20'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7678182082', '1234', NULL, NULL, NULL, NULL, NULL, '2023-03-30 07:39:27', '2023-03-30 07:39:27'),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7678192000', '1234', NULL, NULL, NULL, NULL, NULL, '2023-03-31 01:13:03', '2023-03-31 01:13:03'),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5435165464', '1234', NULL, NULL, NULL, NULL, NULL, '2023-06-09 02:27:43', '2023-06-09 02:27:43'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6383598271', '1234', NULL, NULL, NULL, NULL, NULL, '2023-06-09 03:38:13', '2023-06-09 03:38:13'),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2345678909', '1234', NULL, NULL, NULL, NULL, NULL, '2023-06-09 03:41:11', '2023-06-09 03:41:11'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9953920493', '1234', NULL, NULL, NULL, NULL, NULL, '2023-06-12 02:17:52', '2023-06-12 02:17:52'),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012328323', '1234', NULL, NULL, NULL, NULL, NULL, '2023-12-16 02:22:16', '2024-11-18 10:16:06'),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9458553354', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-08 11:53:48', '2024-04-08 11:53:48'),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234569870', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-16 09:36:07', '2024-04-16 09:36:07'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9953728039', '7072', NULL, NULL, NULL, NULL, NULL, '2024-04-18 11:17:28', '2024-04-29 09:53:24'),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7756825385', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-18 23:45:22', '2024-04-19 12:20:47'),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9935728031', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 12:25:33', '2024-04-19 12:25:33'),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9953728034', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 12:27:02', '2024-04-19 12:27:02'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2345678901', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 12:34:10', '2024-04-19 12:34:10'),
(28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8747585425', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 12:37:38', '2024-04-19 12:37:38'),
(29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9953728021', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 12:40:55', '2024-04-19 12:40:55'),
(30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9953728028', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-19 13:26:11', '2024-04-19 13:26:11'),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9876544569', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-24 17:12:01', '2024-04-24 17:12:01'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5543332211', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-25 08:09:00', '2024-04-25 08:09:00'),
(33, NULL, 'demo', NULL, NULL, 'aadi@gmil.com', NULL, '$2y$10$9u3HQD0IXQua25Ax8TdvMOprXsSmUYkIg4lagnWVqXQohqri95Gva', NULL, '+91', '1387459632', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-26 13:14:52', '2024-04-26 13:14:52'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015556366', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-27 05:58:49', '2024-04-27 05:58:49'),
(35, NULL, 'fdasdfasaa', NULL, NULL, 'aadi12@gmil.com', NULL, '$2y$10$IBKHbPCG7uTG1VUnF3vUv.A2JXVzmcjZSDMFiPq0YdJq2vYlpYCR.', NULL, '91', '9954728044', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-29 10:35:31', '2024-04-29 10:35:31'),
(36, NULL, 'fdasdfasaa', NULL, NULL, 'aadi12545@gmil.com', NULL, '$2y$10$l07NqrR.U8nmXp155iHRV.EK/IwzZuW14pD9/S7TuU9mi/qPM79Fq', NULL, '91', '9954728033', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-29 11:40:29', '2024-04-29 11:40:29'),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1000177765', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-29 14:45:23', '2024-04-29 14:45:23'),
(38, NULL, 'jatin', NULL, NULL, 'jatin@gmil.com', NULL, '$2y$10$ZPLTworQhutB7xymPT727Oew3wkADaHOfHs.JrsAGTi1nIFHVyfJy', NULL, '+91', '9954728111', '1234', NULL, NULL, NULL, NULL, NULL, '2024-04-29 15:46:23', '2024-04-29 15:46:23'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0977771001', '1234', NULL, NULL, NULL, NULL, NULL, '2024-05-03 18:43:17', '2024-05-03 18:43:17'),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567891', '1234', NULL, NULL, NULL, NULL, NULL, '2024-06-22 11:22:17', '2024-06-22 11:22:17'),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567899', '1234', NULL, NULL, NULL, NULL, NULL, '2024-06-24 07:58:02', '2024-06-24 21:20:58'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2334343432', '1234', NULL, NULL, NULL, NULL, NULL, '2024-07-15 05:13:01', '2024-07-15 05:50:01'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2334343467', '1234', NULL, NULL, NULL, NULL, NULL, '2024-07-15 05:50:14', '2024-07-15 05:50:14'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9885774705', '1234', NULL, NULL, NULL, NULL, NULL, '2024-09-11 10:21:13', '2024-09-18 07:23:27'),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9650407212', '1234', NULL, NULL, NULL, NULL, NULL, '2024-09-12 10:38:57', '2024-09-12 10:38:57'),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9745835943', '1234', NULL, NULL, NULL, NULL, NULL, '2024-10-11 11:28:17', '2024-10-11 11:28:17'),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9745835988', '1234', NULL, NULL, NULL, NULL, NULL, '2024-10-14 16:04:24', '2024-10-14 16:04:24'),
(48, NULL, 'Jatin', NULL, NULL, 'jatinjeetsingh041@gmail.com', NULL, '$2y$10$E3HhvSNz0CtG.ERq1PxI9OSkE9Bh2ipu6JHaJOOG.rD0RSUzChibG', NULL, '+91', '9452422162', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-13 15:23:51', '2024-11-13 15:23:51'),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2048445098', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-14 11:36:32', '2024-11-14 11:38:13'),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6048445098', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-14 11:37:36', '2024-11-14 11:55:40'),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9876543212', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-14 11:55:58', '2024-11-14 12:01:48'),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1111252222', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-18 10:17:37', '2024-11-18 10:17:37'),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0987654321', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-18 10:31:17', '2024-11-18 10:47:20'),
(54, NULL, 'Jatin', NULL, NULL, 'jatinjeetsingh031@gmail.com', NULL, '$2y$10$QGS69P.UBU8NNxv1MYdj9eVIMYj6Y.JCM.wWSgaSskQTbc7uWsORC', NULL, '+91', '9953728031', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-18 12:13:55', '2024-11-18 12:13:55'),
(55, NULL, 'Jatin', NULL, NULL, 'jatinje2etsingh041@gmail.com', NULL, '$2y$10$ER9XtAUTaBairsYzQvs30.a0Og94rS.oqvqr.w26msh4D39O7uYR2', NULL, '+91', '9953728033', '1234', NULL, NULL, NULL, NULL, NULL, '2024-11-18 12:14:38', '2024-11-18 12:14:38'),
(56, NULL, 'Debasish Bhattacharjee', NULL, NULL, 'admin@gmail.com', NULL, '$2y$10$3/xzA5WHc.OuG6m5wVfAvewZQpZdED6KuOWwgJI9QQG.iAkXxNWPC', NULL, NULL, '09954657284', NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-30 11:51:34', '2024-11-29 23:51:42'),
(57, NULL, 'Debasish Bhattacharjee', NULL, NULL, 'admin1@gmail.com', NULL, '$2y$10$PwRYeRwLyHRiMNaWCdqN4udqmLDxRCGW/6bVW.4ZTIkJRTbihkTia', NULL, NULL, '9954657284', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-02 04:52:59', '2024-12-02 04:53:14'),
(58, 'Person1234', 'Debasish Bhattacharjee', NULL, NULL, 'admin2@gmail.com', NULL, '$2y$10$.m6Sz51sI7NLkEXsOkuQHedXxfNvATL1H9dJjBkfcMe7JMP2oZy7.', NULL, NULL, '09954657281', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-02 11:08:43', '2024-12-01 23:14:59'),
(59, 'person000', 'Dev dev', NULL, NULL, 'dev1@gmail.com', NULL, '$2y$10$Bej62bNmx/PJrl6gVCuTXecyi6O950.XV3RYCH/7StJQI2.kO5EEu', NULL, NULL, '7678192080', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:25:04', '2024-12-03 22:56:29'),
(60, 'person001', 'Dev Sharma', NULL, NULL, 'dev2@gmail.com', NULL, '$2y$10$GFADvBTKrctCnQUaRah8qedwzw92DB44bJbwbnEQjBy2TKHN0G/d6', NULL, NULL, '7678192081', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-04 11:01:38', '2024-12-04 11:01:38'),
(61, 'person002', 'Dev last', NULL, NULL, 'dev3@gmail.com', NULL, '$2y$10$a1S6Iq3OGHPiE64n6q9j4euGiWb69XaHFxd/ct2YbAiCK3eXR50La', NULL, NULL, '7678192083', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-05 05:45:58', '2024-12-05 05:47:33'),
(62, 'person003', 'person3 person3', NULL, NULL, 'person3@gmail.com', NULL, '$2y$10$Z8Z7QIVyRI790RHmEj6x.umHGn3oxN9HQlfqITlwILu5u1tbbOdoa', NULL, NULL, '7678192088', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-30 05:44:49', '2025-01-30 05:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `house` varchar(255) NOT NULL,
  `apartment` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(100) DEFAULT NULL,
  `cross_street` varchar(255) DEFAULT NULL,
  `block` text DEFAULT NULL,
  `plot_no` varchar(100) DEFAULT NULL,
  `instruction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `house`, `apartment`, `street`, `city`, `state`, `zip_code`, `cross_street`, `block`, `plot_no`, `instruction`, `created_at`, `updated_at`) VALUES
(22, 59, 'house11', 'jgcjgc', 'Bashbasi Pather', 'Dibrugarh', 'Assam', '786001', 'Bashbasi Pather', 'idgd', 'xhfx', NULL, '2024-12-04 10:49:27', '2024-12-04 10:49:27'),
(23, 60, 'house11', 'fjfjf', 'Bashbasi Pather', 'Dibrugarh', 'Assam', '786001', 'Bashbasi Pather', 'idgd', 'xhfx', NULL, '2024-12-04 11:02:00', '2024-12-04 11:02:00'),
(24, 61, 'house11', 'jgcjgc', 'Bashbasi Pather', 'Dibrugarh', 'Assam', '786001', 'Bashbasi Pather', 'idgd', 'xhfx', NULL, '2024-12-05 05:46:45', '2024-12-05 05:46:45'),
(25, 59, 'House 1', 'Apartment 1', 'Street 1', 'Dib', 'Assam', '786001', 'Bashbasi Pather', 'idgd', '11', 'hfjgfjf', '2024-12-19 05:40:21', '2024-12-19 05:40:21'),
(26, 62, 'house11', 'jgcjgc', 'Bashbasi Pather', 'Dibrugarh', 'Assam', '786001', 'Bashbasi Pather', 'idgd', '11', NULL, '2025-01-30 05:46:21', '2025-01-30 05:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_carts`
--

CREATE TABLE `user_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `combo_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `tax` double(8,2) DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `varients` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toppings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_carts`
--

INSERT INTO `user_carts` (`id`, `product_id`, `combo_id`, `user_id`, `qty`, `price`, `discount_percent`, `discounted_price`, `tax`, `status`, `extra`, `varients`, `properties`, `toppings`, `type`, `created_at`, `updated_at`) VALUES
(55, 5, NULL, 24, 4, 10.00, 0.00, 10.00, 1.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 2, NULL, 24, 1, 20.00, 0.00, 20.00, 3.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, NULL, 2, 23, 2, 60.00, 0.00, 60.00, 2.00, 1, NULL, NULL, NULL, NULL, 'combo', NULL, NULL),
(59, 8, NULL, 30, 1, 100.00, 0.00, 100.00, 2.00, 1, NULL, '1', '[\"30\",\"34\"]', '', NULL, NULL, NULL),
(89, 1, NULL, 39, 1, 15.00, 0.00, 15.00, 2.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 6, NULL, 39, 1, 9.00, 0.00, 9.00, 1.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 5, NULL, 39, 1, 10.00, 0.00, 10.00, 1.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 2, NULL, 43, 1, 20.00, 0.00, 20.00, 3.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 7, NULL, 43, 1, 200.00, 0.00, 200.00, 1.00, 1, NULL, '3', '', '', NULL, NULL, NULL),
(132, NULL, 1, 43, 1, 30.00, 0.00, 30.00, 5.00, 1, NULL, NULL, NULL, NULL, 'combo', NULL, NULL),
(140, NULL, 2, 44, 1, 60.00, 0.00, 60.00, 2.00, 1, NULL, NULL, NULL, NULL, 'combo', NULL, NULL),
(155, 3, NULL, 20, 1, 30.00, 0.00, 30.00, 3.00, 1, NULL, '2', '[\"13\",\"14\",\"15\",\"16\"]', '[\"3\"]', NULL, NULL, NULL),
(156, 8, NULL, 20, 1, 200.00, 0.00, 200.00, 2.00, 1, NULL, '2', '[\"12\",\"13\",\"14\",\"15\",\"16\",\"6\",\"20\",\"24\"]', '[\"3\"]', NULL, NULL, NULL),
(161, 2, NULL, 53, 1, 20.00, 0.00, 20.00, 3.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 4, NULL, 53, 1, 35.00, 0.00, 35.00, 5.00, 1, NULL, '2', '[\"13\",\"15\",\"6\"]', '[\"2\"]', NULL, NULL, NULL),
(163, 2, NULL, 59, 1, 20.00, 0.00, 20.00, 3.00, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 1, '2023-03-17 02:18:57', '2023-03-17 02:18:57'),
(2, 'Medium', 1, '2023-03-17 02:19:05', '2023-03-17 02:19:05'),
(3, 'Large', 1, '2023-03-17 02:19:10', '2023-03-17 02:19:10'),
(4, 'Extra Large', 1, '2023-03-17 02:19:19', '2023-03-17 02:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `waiters`
--

CREATE TABLE `waiters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_orders`
--

CREATE TABLE `web_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_type` enum('Home Delivery','Take Away') NOT NULL DEFAULT 'Home Delivery',
  `payment_mode` varchar(255) NOT NULL,
  `pay_amount` double(8,2) NOT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount_value` decimal(10,2) DEFAULT NULL,
  `txn_id` varchar(255) NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `status` enum('READY','COMPLETED','PENDING','CANCELLED','DISPATCHED','COOKING') NOT NULL DEFAULT 'PENDING',
  `payment_status` enum('PAID','PENDING') NOT NULL DEFAULT 'PENDING',
  `coupon_code` varchar(255) DEFAULT NULL,
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cookingstart` timestamp NULL DEFAULT NULL,
  `endcooking` timestamp NULL DEFAULT NULL,
  `delivery_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_orders`
--

INSERT INTO `web_orders` (`id`, `user_id`, `delivery_id`, `shipping_address`, `branch_id`, `delivery_type`, `payment_mode`, `pay_amount`, `tax`, `discount_value`, `txn_id`, `invoice_id`, `status`, `payment_status`, `coupon_code`, `delivery_charge`, `cookingstart`, `endcooking`, `delivery_time`, `created_at`, `updated_at`) VALUES
(98, 62, NULL, 26, NULL, 'Home Delivery', 'Cash', 75.70, 2.70, 0.00, '1738216291679b13639eb5b', '1738216291679b13639eb5827', 'PENDING', 'PENDING', NULL, 11.00, NULL, NULL, NULL, '2025-01-30 05:51:31', '2025-01-30 05:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `web_order_products`
--

CREATE TABLE `web_order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cart_id` bigint(20) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `base_price` double(8,2) NOT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `price_before_discount` decimal(10,2) NOT NULL,
  `normal_price` decimal(10,2) DEFAULT NULL,
  `tax_percent` decimal(10,2) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `combo_pack_id` bigint(20) DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `varients` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toppings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chef_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `web_order_products`
--

INSERT INTO `web_order_products` (`id`, `user_id`, `product_id`, `cart_id`, `qty`, `base_price`, `discount_percent`, `price_before_discount`, `normal_price`, `tax_percent`, `order_id`, `combo_pack_id`, `type`, `extra`, `varients`, `properties`, `toppings`, `chef_id`, `created_at`, `updated_at`) VALUES
(217, 62, 5, 164, 1, 10.00, 0.00, 10.00, 10.00, 1.00, 98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-30 05:51:31', '2025-01-30 05:51:31'),
(218, 62, 4, 165, 1, 35.00, 0.00, 35.00, 52.00, 5.00, 98, NULL, NULL, NULL, '2', '[\"6\",\"14\"]', '[\"2\"]', NULL, '2025-01-30 05:51:31', '2025-01-30 05:51:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_stocks`
--
ALTER TABLE `add_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_created_by_id_foreign` (`created_by_id`);

--
-- Indexes for table `booking_tables`
--
ALTER TABLE `booking_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chefs`
--
ALTER TABLE `chefs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child_categories`
--
ALTER TABLE `child_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_categories_cate_id_foreign` (`cate_id`),
  ADD KEY `child_categories_sub_cate_id_foreign` (`sub_cate_id`);

--
-- Indexes for table `combopacks`
--
ALTER TABLE `combopacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_products`
--
ALTER TABLE `combo_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `combo_products_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_product_id_foreign` (`product_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveries_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `food_purchases`
--
ALTER TABLE `food_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_purchases_branch_id_foreign` (`branch_id`),
  ADD KEY `food_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `food_purchases_food_item_foreign` (`food_item`);

--
-- Indexes for table `food_purchase_histories`
--
ALTER TABLE `food_purchase_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_purchase_histories_food_purchase_id_foreign` (`food_purchase_id`),
  ADD KEY `food_purchase_histories_branch_id_foreign` (`branch_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `generals`
--
ALTER TABLE `generals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `helps`
--
ALTER TABLE `helps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_delivery_addresses`
--
ALTER TABLE `home_delivery_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_delivery_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `ind_grps`
--
ALTER TABLE `ind_grps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ind_items`
--
ALTER TABLE `ind_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_purchase`
--
ALTER TABLE `ingredient_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_stocks`
--
ALTER TABLE `ingredient_stocks`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickup_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privileges_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_foreign` (`category`),
  ADD KEY `products_sub_category_foreign` (`sub_category`),
  ADD KEY `products_child_category_foreign` (`child_category`);

--
-- Indexes for table `product_add_ons`
--
ALTER TABLE `product_add_ons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_add_ons_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_extras`
--
ALTER TABLE `product_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_extras_product_id_foreign` (`product_id`),
  ADD KEY `product_extras_extra_id_foreign` (`extra_id`);

--
-- Indexes for table `product_properties`
--
ALTER TABLE `product_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_extras_product_id_foreign` (`product_id`),
  ADD KEY `product_extras_extra_id_foreign` (`properties_id`);

--
-- Indexes for table `product_toppings`
--
ALTER TABLE `product_toppings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_extras_product_id_foreign` (`product_id`),
  ADD KEY `product_extras_extra_id_foreign` (`ingredients_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_extras_product_id_foreign` (`product_id`),
  ADD KEY `product_extras_extra_id_foreign` (`varients_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties_items`
--
ALTER TABLE `properties_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties_sides_in_cart`
--
ALTER TABLE `properties_sides_in_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_cate_id_foreign` (`cate_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_details`
--
ALTER TABLE `table_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_carts`
--
ALTER TABLE `user_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_carts_product_id_foreign` (`product_id`),
  ADD KEY `user_carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_orders`
--
ALTER TABLE `web_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_orders_user_id_foreign` (`user_id`),
  ADD KEY `web_orders_deliveries_id_foreign` (`delivery_id`),
  ADD KEY `web_orders_user_addresses_foreign` (`shipping_address`),
  ADD KEY `web_orders_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `web_order_products`
--
ALTER TABLE `web_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_order_products_user_id_foreign` (`user_id`),
  ADD KEY `web_order_products_product_id_foreign` (`product_id`),
  ADD KEY `web_order_products_order_id_foreign` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_stocks`
--
ALTER TABLE `add_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_tables`
--
ALTER TABLE `booking_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chefs`
--
ALTER TABLE `chefs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `child_categories`
--
ALTER TABLE `child_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `combopacks`
--
ALTER TABLE `combopacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `combo_products`
--
ALTER TABLE `combo_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `helps`
--
ALTER TABLE `helps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_delivery_addresses`
--
ALTER TABLE `home_delivery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ind_grps`
--
ALTER TABLE `ind_grps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ind_items`
--
ALTER TABLE `ind_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ingredient_purchase`
--
ALTER TABLE `ingredient_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredient_stocks`
--
ALTER TABLE `ingredient_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_add_ons`
--
ALTER TABLE `product_add_ons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_extras`
--
ALTER TABLE `product_extras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_properties`
--
ALTER TABLE `product_properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product_toppings`
--
ALTER TABLE `product_toppings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `properties_items`
--
ALTER TABLE `properties_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `properties_sides_in_cart`
--
ALTER TABLE `properties_sides_in_cart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=679;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_details`
--
ALTER TABLE `table_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_carts`
--
ALTER TABLE `user_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `web_orders`
--
ALTER TABLE `web_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `web_order_products`
--
ALTER TABLE `web_order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `child_categories`
--
ALTER TABLE `child_categories`
  ADD CONSTRAINT `child_categories_cate_id_foreign` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `child_categories_sub_cate_id_foreign` FOREIGN KEY (`sub_cate_id`) REFERENCES `sub_categories` (`id`);

--
-- Constraints for table `combo_products`
--
ALTER TABLE `combo_products`
  ADD CONSTRAINT `combo_products_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `combopacks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `home_delivery_addresses`
--
ALTER TABLE `home_delivery_addresses`
  ADD CONSTRAINT `home_delivery_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  ADD CONSTRAINT `pickup_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_child_category_foreign` FOREIGN KEY (`child_category`) REFERENCES `child_categories` (`id`),
  ADD CONSTRAINT `products_sub_category_foreign` FOREIGN KEY (`sub_category`) REFERENCES `sub_categories` (`id`);

--
-- Constraints for table `product_add_ons`
--
ALTER TABLE `product_add_ons`
  ADD CONSTRAINT `product_add_ons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_extras`
--
ALTER TABLE `product_extras`
  ADD CONSTRAINT `product_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_extras_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_cate_id_foreign` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_carts`
--
ALTER TABLE `user_carts`
  ADD CONSTRAINT `user_carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `user_carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `web_orders`
--
ALTER TABLE `web_orders`
  ADD CONSTRAINT `web_orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `web_orders_deliveries_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  ADD CONSTRAINT `web_orders_user_addresses_foreign` FOREIGN KEY (`shipping_address`) REFERENCES `user_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `web_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `web_order_products`
--
ALTER TABLE `web_order_products`
  ADD CONSTRAINT `web_order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `web_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `web_order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `web_order_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
