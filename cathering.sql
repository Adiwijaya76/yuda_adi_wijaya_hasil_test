-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 16, 2026 at 10:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cathering`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-424f74a6a7ed4d4ed4761507ebcd209a6ef0937b', 'i:1;', 1792145270),
('laravel-cache-424f74a6a7ed4d4ed4761507ebcd209a6ef0937b:timer', 'i:1792145270;', 1792145270);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issued_at` date NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `invoice_number`, `issued_at`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV-20261016-DD6A4A2C', '2026-10-16', 125000.00, '2026-10-16 09:04:27', '2026-10-16 09:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `merchant_profile_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `merchant_profile_id`, `name`, `description`, `photo`, `price`, `is_available`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Nasi Kotak Ayam Bakar', 'Nasi, ayam bakar, sayur, sambal', '', 25000.00, 1, '2026-10-16 09:04:09', '2026-10-16 09:32:43', NULL),
(2, 1, 'Nasi Kotak Rendang', 'Nasi, rendang sapi, sayur, sambal', NULL, 30000.00, 1, '2026-10-16 09:04:09', '2026-10-16 09:04:09', NULL),
(3, 1, 'Nasi Kotak Vegetarian', 'Nasi, tumis sayur, tempe, tahu', NULL, 22000.00, 1, '2026-10-16 09:04:09', '2026-10-16 09:04:09', NULL),
(4, 1, 'Paket Prasmanan', 'Prasmanan untuk 10 porsi', NULL, 350000.00, 1, '2026-10-16 09:04:09', '2026-10-16 09:04:09', NULL),
(5, 2, 'Salad Bowl', 'Salad sayur dengan protein pilihan', NULL, 28000.00, 1, '2026-10-16 09:04:10', '2026-10-16 09:04:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_profiles`
--

CREATE TABLE `merchant_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `food_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchant_profiles`
--

INSERT INTO `merchant_profiles` (`id`, `user_id`, `company_name`, `address`, `phone`, `food_type`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Dapur Nusantara', 'Jl. Merdeka No. 10, Jakarta Selatan', '081234567890', 'Nasi Kotak', 'Katering makanan kantor dengan menu nusantara.', '2026-10-16 09:04:09', '2026-10-16 09:04:09', NULL),
(2, 3, 'Katering Sehat', 'Jl. Sudirman No. 5, Jakarta Pusat', '081298765432', 'Makanan Sehat', 'Katering sehat rendah minyak.', '2026-10-16 09:04:10', '2026-10-16 09:04:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_15_212833_add_role_to_users_table', 1),
(5, '2026_10_15_212834_create_merchant_profiles_table', 1),
(6, '2026_10_15_212835_create_menus_table', 1),
(7, '2026_10_15_212836_create_orders_table', 1),
(8, '2026_10_15_212837_create_order_items_table', 1),
(9, '2026_10_15_212838_create_invoices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `merchant_profile_id` bigint UNSIGNED NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `merchant_profile_id`, `delivery_date`, `delivery_address`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20261016-8A32C1DD', 4, 1, '2026-10-17', 'Gedung Kantor Pusat, Jl. Sudirman No. 1, Jakarta', 125000.00, 'delivered', '2026-10-16 09:04:26', '2026-10-16 09:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED DEFAULT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `menu_name`, `unit_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Nasi Kotak Ayam Bakar', 25000.00, 5, 125000.00, '2026-10-16 09:04:27', '2026-10-16 09:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0RkiCA2niDQUHPFXtQf72abFeYxBrII1FkHBVAgg', NULL, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJblJMZW5jNWIweFNiQzg0WmpRd2RqTjFXakJGYlZFOVBTSXNJblpoYkhWbElqb2lRemhRUTJVM1RGVm9kMlkzTW05aFRIa3ZXVTV6TWtsSFNtNDRhVXBpVGpKUlJXNDVWM3B5ZVhwUVNtZFBTelJZUWxGbU1FdE9kRTFaU20xWU1tZGFhbkZCUmpkYWJXOU5aVWhRWml0blVEazBla2RZT0RCelJXUXhRWEp2UkRSNVNqZzROM0JrZUhGeE5rSnhaRVJsZVdjMlQyZ3dhSE56V2xFemIzSmxNREJrWW1obmJEVTFlREpwUldreGRXVlZkREZVT0dkUVNXcEZka0ZqU1daV2RtWnNjbEJ6TDFaR01qZFpXbkJpUzJ0YWFHMDFTRk5zYkcwd1ZYVTJhMWR3ZEZoaGJVNVlNSFE1VDAxQk5qUXdhVVJyYzJSMGR6MDlJaXdpYldGaklqb2lOMk13T0dZM01qSmhNalF5T0RReU5qQmxabU0xWmpRek9XWmhZV0ZoTVRVMVkyWTVOalk1TmpKalltWTBOekZtWTJRNVpXTXhPVFZrTXpVeU1tTmtOU0lzSW5SaFp5STZJaUo5', 1792142232),
('2HLm6Ohb0Eqh2V42LiQ9qeH6DFs6tURbkdNz1bQw', 2, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJa2RwWm10bVUxTlFPR3cyU25aRFJrVkpOa3ROVlhjOVBTSXNJblpoYkhWbElqb2laRFZGUmk5c2NWVXZiV3RPTkZodVFreENjblZ3WlRaM2RXaHRhMWNyZUd0M2IwZ3plSHAxV1ZKQmFtY3hMM0JSTDNsRE4wdGpMMnM0ZDI1R2VqQkxUMHRCY1dKWE9UWndlWFJxVm1vMGVHZExiR3BMU0ZabE5YTk9lWGh6V1ZnNWVubE1URWxpUW1wSVNFRlJja2RwWkc1NVdFbGxZakZhTm5SallWZFRSV2hsWmtObGQwSkROVGhFWm1aWmJsaHlURWxZYUdwWWJ6bDBhR1pWTlVaUlVsUktRVVpDV0ZkeE0zVkhiRkJaZUhaUmJHSkRiR3c0VjNKdVFUUXpiamxsVWxaVVptdFhSM0l2YkdkSGFGaEZSMGRFVGxObk5UZ3lVM05uYzBveEszUkZTRU14TTBkSFZVWjRTVmwwVTBoblRXZDNUbFIzTWxONlJuWlplVzltVURkV1dFVXpWemRQVGtzcllUZGhOMkY2Wms4MU0zVTFka05XT1U5NGEwZFViaXRxT1VWWmIwbHhVR053V2tkd1J6WkJlbVp4UkVSVE1HazJPRXhHWjBwdFYzZG9OR0kwY2tKeFNFeHdLMGhXTjNWbFp5OXpSVWt6WXpOQlNuYzFObXRhVFhOTlR6QjFNVmxZWWxsdk9VVmxXamhQY0c5aE5WWmFlVnBxWmpKeWVVaFRUQzlaVTFoMWRYWklXQzluVGpGdGVsZDRNazVyWkhwclpXczFialZaU0VoVldUTTFZa0pTVFROUFJISldVV2xzY1RsWlUwNXFNMnRFU1M5amVpSXNJbTFoWXlJNklqTXhaVFJqWkRBME16azRNVEE0TmpsbVltWXhabVkzWWpka1lXTXlOalJtWVdFeU5UWTFaRGMyWkRJMk1HUTRNR0ZoWkRGaFpEbGtORGRqWlRrd056QWlMQ0owWVdjaU9pSWlmUT09', 1792142232),
('2xi15SncsTiY8upwmVDg0xJTN6kitAFhzy70xXkL', 4, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJbmhLWjFaS09FTldlV1ZCWkhGM2VIWndZVEJPUTJjOVBTSXNJblpoYkhWbElqb2lTRVVyYVZkd1JXNTNRakowVDBFMFZHeHBSemd4WjI5TFNsVTRRMEpNVkVocWFVcExMelJQTUV4VE9FMXNPQ3QyYVdoUWJXSlJLMUZWYkRObldYVkZWelJEWXpCUk5scG9LMmRTY1RBNFUzSlNhbWc0YkdwSFZIRTVaRFJUZDI1TlRrbFZaVzQ1VTBWRFNYWm9SbWxsU20xVVVHUlVRaXRqVm5jeVVXaHFTWE5pZEhWTVN6TlpSa3B5ZG5wUlZuaGxNRWRqUW5wT1pYWnVlVTF5ZWtWb2VtMVFSMWRuTkhsTVVEZEhkbGxwYlU1dE5IcGFiMFZEY0dGaU1YcE1ZVkUzT0ZoNFMxcGpPSGhrWjJKc01WWkVielJ4TlU5S01tbHZaekIzTXpOdGFIUk5NRmxoVUZOa04wbGliR1phTjJKdVprWkdaa3R0T0VjNGVWSlhUVXBDYWxoMlVYTXdNSE5DUlZsbGRUWlRWbGwyZDNSRlNFZFNaRkF3S3pGUVpGVklNV3czZG1KTU9YWnZjekpETXpaeE9EbGlSRXhKT0cxTlNqSTNhSG93TVdNdk1HRnROMUpaWlU1MFZqTjFNVE5EVjFoTE1FbzViMDl1V1RCRVkwdExSa2MyZGxacGNFMUtOREpLT0dwUVNtY3ZWR1ZoVjI1eGN6RndXRk5EVlhOT2QzQkxjRXQyV2pKcFZtVkxiblJ4TkZwV1FUTlNVamwxVVVzMU5HVnRhelZwWkZkUVdtcFZRVTQzU1hKRGIyWTNXVFZxVVhOVVIycFFXVWw0Vm1reFRWaEVjVzlxYm5ndmNXOXVkRlpPWjB4SmNUVlBiSGM5UFNJc0ltMWhZeUk2SW1OaE1ETXlNekkzWWpjeU5qTmlORFppTlRnek16a3hZVEpsTkdFeFlUSXpaV05oT0RJd01ETTJZVGhoWW1VM05tVm1ZVEl5WlRFNVlUQXhZV1poWWpRaUxDSjBZV2NpT2lJaWZRPT0=', 1792144772),
('43nAHgD5QxaVV8cSeJEgiHZzO2lZu9IAKzTt3g3d', 4, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJalJVWVdsV1dtWmxjMjlIU0VWaUszcDFSMmgyUTNjOVBTSXNJblpoYkhWbElqb2lVbUpUUTNobmJEaEJkVXN2Y1VjNVZUQlJZbGh4UVdoTWNuRmxUSFJEYUUxWllqVlJhRzg1VkdGelJ6VjVRMWQ2WW0xUlRVWk9SRGREUkZSVWVEUldLelpXUXpSdlRHRjRSbGQxYmxSMlJYSnFSR1IwTkhwbmVsWXpiVVlyUkZSTVpVOXhUekZHTVdGQk4yZFpPRzl4U1VKRmVWVkJiMUZITDBGU05tTTNjMjVxU0hBemRtcEdZVkpWWVV4SFRrOUZVVVZSVVdJdmRteExha2huTDFseVJHeE9jR0l5V1VWRWVtTnpXVVlyUzFKdlJsSnZVVzB3YVV0TVNFbGxVeXRzYjA1alpEbFVWR296V25GQllqVjNNMHRKV0hKck1sb3pkVmR3YTJKblRuaDZRbnBzZFdSS2NDdHdNWGRsVTNSUVNrTlNTM2M0UTBSSVJEbFhXWFpSUVZOMVRWQkZSMHRITUhSNk0yeE9OV3A1VGk5M0szRkdPRmRFUzFkT1pGUnBSemRpZFZGVWVFWnhjVEZrZVdsV1prcFlNa1ZuV1dSc01qZEVTVnAyWkRGeGJIUk5Ta1ZzVkVkck9HVnRSM2hHV0UwNFdIVTBZemxHYUVabVlYRllUR3QwV2xwbE9YbEtOVlZ5VG1oQ2NVcDRNalJETURWRFVGWkNRMnRTVW0wek1YcFFiMmxKUWxGM0t6Rmhaa0V3YkROR1VtUnhjekJVV1hwUlQyaExXbUZMTUhGWmJqUmthMmxUYjNBdk1XMUxVazVtWm5veVVIVjNWbnBVU1d3MVpDSXNJbTFoWXlJNkltVmpOVEpoTlRjNU1qVmhPR1U1TmpabU1ETTNNRFl3TW1Ka1ltRmtZVEpqTVdJeU5tTmtNamhoWVdWaE0yRTRNekU1WkROaU56VTNOVGN4T1dWa00yWWlMQ0owWVdjaU9pSWlmUT09', 1792142232),
('FU7oTcjyXGAczqRgyugyghe2C7RXMIWQFkZamRMC', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbU5OUjJjMlRtSjNRakJMWkVZNGRXWkhUMk5WZW1jOVBTSXNJblpoYkhWbElqb2liVm8xYmpBNWExcHRVamRhWWpaSlVHdG9VREpYZEVsU1QyUlBSbmd2VURST1FqaDJiRlZEV1RKa05rUnlNblpaZG1Rdk9FNWxjeXRyTkVneE16VnlkRTFQYTNBclZIaFNNa0U0UWtWRE0ydzJObEJ2YzBwd2RIWTJXRTVxSzJwR1RYUkpLMjlFWVZaSWQwTTBTRFJWTDFvclRFdFBWSEV3WVM4d2VFUnJVbFJYVlV0cVNrSllhWFYxUVNzM1YyUkRUemRGVTBkQmJpdDNOME5zZGpCRVNYQmFSMmhEVW5wWFMwdG5ZV1ZqV25SVGFTODBPWEp6Y0hVclpIbElRbkJWTldaYU5GUnFLeTl1YzFsbmN6WkNSbkY0SzFGR05VUm9hVmRLTVRRNE5FUmhTM0JUYzNwRU9GWmpjV3RHV2t4YVNHTXZZbEpGWTNVMFIxaG1URWxwU0Vab2FYSTJhWFk0Y1dkTE1XWndiWFJaTWxFMFRTOXdVMlZuWkRSdlVGVlFWMjlZVEUxS2FFeGtXRFpHZFZwdllWRmtNR0l5Y21GYVNVWk5hMjFRWVZwSmRURTBOV2RyUWpjdmEyY3JkSHBYWVdGSVQwWnhRMWRIZEhKeFdrcFdVRzFhYUdaQlJsQXlZazVyVmxWWGJVZFZPRVJWU0dwblZEWTNUM2xtY1Rsblp6aGhkbGsxTkdwc09YWTVPVGxtWTJOaUwydDJVR3BwYUN0Nk5IaDVVVlp6Y2xoa1oxcFBPVGxGU2tndldXUnpkVGhqY3pWbU5ubzRjamhSWm1jdmNtUnRTM2t6TjNGSVRuaHdOaTkxV0d0QmRIQXljSGM5UFNJc0ltMWhZeUk2SW1Jd04yTTFOVFJrWWpBNE9XUTJOemhtWkRNM09XRTRaV1JoTjJZM05XUTFZelUyTlRsak0yRmtOemN6Wm1KbFpUTTBabU5pTldOa1l6QmlZelUzWXpZaUxDSjBZV2NpT2lJaWZRPT0=', 1792145230),
('GK0fsmapMzltaaxQa2BHsFCdxrUjgAshftyZQMHF', 4, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJbU40WVVscVprVXpkMjV2TTJKVFlVaEdiVTlhTkVFOVBTSXNJblpoYkhWbElqb2lSVkJNTXpRNGRrNUVNbUZvYjNWMVozRlZWVEZvUTJFeFIwNDVaelV3YXk5blpYUndUU3R5VGswemNtNWxhelZvWkhKTVNXeEtaekZGTTJ4NFdtWlFUakl4U2psNU5sRkdPRmRNYTNCaGVrNXRNM1I2SzFNdlJIaHVVVVJsZGtOYVMzWkljMnN6ZFVkU1drbDVORUU0VHk5M2VVOVFTRk5xTW5NMFVtZHZjMnhJYUhRMFNWbHVWVk5UUm10NmN6bGlhbmRRUjNCalN6UXljVVo0ZUN0WlFXWTFRMjFTVmxsSE1VSXJVWFpCVUhsM1ZUTnlWbmhyTlhoWWVraFZXSGgyZVdSUVZ6Vm1ObG92TUdzM09XNDRXQ3RsUTJ4eFlrMHpjWFpMY1hCV2VGaDZSemhqWkZkeWJtcHlkbkU1VWs1dVQxbFJRVTVVWkdoV1FWWk9lR0ZpVjBKS1ZUQm5NVkF3YTJGdmRreExWaTkyTm1kWFVFbE5UVm8wVEhSWGVVTTFMM0pUVmxsR2RVc3pibFkwVEZwMGRqWkRUVU5WV1ZoNlNFRkZUU3RpWkc4NWFIcFRNbTAxYXpSRE4weHlkbEJvTDJkS1NIQXhTRFZ4VEd4a2QzZENibE0xU25GaWFHZFdXa2xDU3psYVJuSk9XbEJhV2xJNVRsaGlRbVJWWkRaVmRFSlhXR2Q1WVhsSlpqUklWbWhTT1dGa09HdHBWR05sT1VKRU5UWmtWV3d4TUV0WlFVSXhjbUZ5U2pOS1RFcFFiRWRFVWxCRFEwSmxhVk5yZVdKcVJTSXNJbTFoWXlJNklqWTBZMk15TnpRNVpqVmxaRGcyWm1KbE9EWmtaV0ZoTmpaaVpXSm1aVGd3WlRFMk5qTTNNV0prTURrMVpUSmhOR0k1TWpnMk9URmhORGd4TVRnMU9HTWlMQ0owWVdjaU9pSWlmUT09', 1792141488),
('IpX8bPfekUHJFJFrQJW2AAdBzi6YkX5RaOML8Aem', 2, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJalJPZEVad1FYSjVjVWc0ZFc1NU5VdzJNamhKTTNjOVBTSXNJblpoYkhWbElqb2ljamxNTjA1elFXdDRNWEV4VWxwRlMzTXpNVkEzVkZZclJXVXplRnAyUVVOSlIwWTFjRkJ6T1ZoeFNrNVVTbGRwYWtOS1NUTmlPVFFyZHl0RlNUWlFkRmh4WTNwclMweDBVR2RQWm1sWVpucGpTa1JUUzFsVFZYcGlObFkyYkU0MlQybDRSVXAyUTJGWVEyNWhUMFpYZERGaE9Xd3hPRWMzZEhKUmQwZHJRbE16V0hSMmJWTnNlV3RqYXpsS1YzTjJVbTkxZFZFM1JGVkdSakJET1c5RllXMU5OMVJEVVdod1UyTk5hVTEyWXpWeldIQkxUa3BTTlVkemRXOVlLMVJ2ZWxOVU5YQlpaM05uYUhwSVFVSXhSVGcwZERORk4xVkdRV00xVEdVd1NFWnRiRWd3TTNOUmRqUXhTMkZpYkhZM1NWZGFZME5zZG05d2RuaE9aa2xPYUZCM2VFZ3pjM0JrVDBOVU9UZElOVTlMZWxwTU5VSnNOaTk0Y1VoR09VWkdTMmRZWkZNdlRGZEliRlZCYkdsRVFVNXFSakpOVlRsTVdVVjRla1JvU2tkWFlqWmtOV1E0VFdGWFRtUnNOa2d4ZEc4eFQzZENXRGR0V1hKU2FEaEJSMDV4V2sweGFWTTNhbEJEY0hOV2NETTBZMDFaU1cweU9EYzFabnBuT1doaGNqaHVSRkZwWjNFMFNHeDFWVEIxVGsxcGFTOUxXa1Z4VjJOWFNsQXlWVE0xTW5SUVYzVnlTRnBJU20xblVWTjNaMWR5SzBjclZYZG9UMGxvU0Znd1ZDSXNJbTFoWXlJNklqazFOR0UyWW1RMFpqSTROVFUwTmpreU5UTmxOVFkyWkRZM05qWTNaamRqTTJZek5EWTVabU5pWVdJelpUSTRPV000TURCa01URXlZMlJsWmpsa1lUTWlMQ0owWVdjaU9pSWlmUT09', 1792141488),
('QRlZpnCZkyPrzkHC323YpzVvHVe5dN9teGjx82gs', NULL, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJbkZZVVRSS2N6Um9NbFZ0WWxscWNIWXhlV0p4YmtFOVBTSXNJblpoYkhWbElqb2lXVXcxVjJ4Q0wyaExjaTl5WjNCaFJYRlBNRzAwWjBOWVVsVnplVEIxU1RKWFF6ZFZVWFZWVFhSUU5UaEpUMVZIV0dWR01WUmlZVWQwY2psbksySkZOV1pDWmt0eGVXVnFPSFZ1UzI1cWNERTBXWEI1VjBOeVZERllZMFZ6TTFKMlQwVjViMFZYY0ZCV1EyeEZaRXA1Y3pWa2EwUkNkVTkyYlVSUGJ6bEVkV3RUTDFScGVtZHFhM1JIU1V4aVVqVkxUR3hOVUV0cVJFbHRSSEYzT0UxRmVFbGpTRXRUYjJNclNrMW5RbTVzUTJSdVIxa3hNV2x2T0dwNFJFNXFhbVJOZEhOd2VteHZSRWx2U1c5dFdsazFSM1pGT0hSQ1VUMDlJaXdpYldGaklqb2lOelJoTkRkbE1UTXdaamxpTjJRd1l6QTVNell4TVRjeE9UWmxZMll5T1RobFltSTRaVFJrTVdVeVpXRmxNalU0T1dZd1l6azNZakF4T1dVeE5USTNaaUlzSW5SaFp5STZJaUo5', 1792141488),
('QwqRcfpbyDK0YTuX4X63vQdGe04KPkdsxPOCt0X6', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'ZXlKcGRpSTZJbk16UTNrMEwwSmhWRnA0VG5sUFVYaHhRV2hPVVZFOVBTSXNJblpoYkhWbElqb2liRTVhVWxvME4wSnFhMHROUzBSbVNsUnhXRkp2TWxvd1NUWTVialZCUTNBemVIVTROWEV5YVVvemNEVkJkVVIwTmtSb1JEWTJibEp1TkZKVWFsUk1RV0ozTm5OTmRsSTFORTlMVDBkdFNXb3hhRmN3VkZoSmNIbFRjekJDUWs1RE1UaGlTM05tVWtGdGRFUlNUR0ZrV1dsamVHaHZUVXRrYW5oT1VXdG5hSGhHY1N0eFlXbFVaR3RQV1dVM1ZVMVNLMWh2SzFSWE1IZ3JjalZETW5STWFrOXdTbVJUVmt4U1ZEa3laa3BzWnpaUE1qUktSR05aZERjM1ZucFRjV3RGVnpkV05EazFWbmhIY1djdlV5dG5RbGt4VG5CTldrRnRjVFZtYm1vd2JHdEljM0pFZGtSYVowdzJTSFptTUZSTk5tY3JOVWhsSzFZeGFTOWhWRGwyWlRaSmVrczJLMnRRYlVoMVRHb3JkakFyV1V0d1R6QjBkSGRaWkZsak9IVlpSVlZyUWpFMFkza3dja2RUVld0WWExUXdPRUZ1VTJwd1dsTnVNV056UjJ4UUsydDNPVTFxYlRCTVpFdHpjbWxRVTA5d2FHVkdWMU16WW1kUVZuaDVVV2RUZDNGWVUwbE5hbTQyY1cxeldIUlBOM1JqWlZRdmFXTlpkek5zYlRseVZFWnlZbTVwUnpSc1IwRnhZbEI1WkdNek5uWm5kVUUxTkd0Wk1HdEtPVk4zYXpZNVEzSXpkbWxOYm1aRksxTmFOR1JXYkdoMVYzazFNMXBCZDFGSlFTSXNJbTFoWXlJNkltSXdNVGhpTlRRME9XRmtOMkZsWkRFeE5UTm1Zemt4TkdabE5UVTNNbU5pTW1WaU9UUTNZakF4WlRjMVpESXhNelEyTXpjMFlUSXhNelZqTWpCbE1HSWlMQ0owWVdjaU9pSWlmUT09', 1792141736),
('ri3MYUB9gHlsEX9kztOj0tKQUPMRF9ERS5paB0co', 1, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJa1J1ZHpkaE9YQndWR3RDU1V4TUwwUkZUV3hMWVZFOVBTSXNJblpoYkhWbElqb2liRkZtYkhOc1NUVktTMVF5VkhKUmEzQnRkbkExWkdjMWMwUmtURWxvTW5RME5reHlPR3N4WVc1amVrbFVNVVUxTmpJM1N6ZFJaSFUyYURCME1GVm9SRkZEY1dOdFIwVmxSMGhxVDJOalIyVlFkWGgwTTBGVGRpdEtkbkZ6VjFoUFNuSnVaVGQ2Tnpsck1GQnpLeTlhTjJ0VmVqSnFSV3R1YWs1d2RsaGFURXhoYkdjMlkwVk1PRVpKZDJWbFpWVXdPVk5FYjB3clFVcDNlRzl0VlZsVFFuQlNiRkkyYlU5bE5qVjRVRU5HUXpOQ1pTdHFjVEZYUldnNGFUUXJWeXRYTlZST1VtbDBRbHBqVDFZdlVFY3hSMDQyWkZsbVJFY3lTVmhMTVhSRGVYTnFjek54WjJwdFFVc3lNSHBNYjBWTWFVWm5kazFyY25aNVNqZHlVemRYY25ka2VYQTROR3hvWlhCcVdHWnNiWGhwWWl0bGRVaFdlbnBDU3pWR1FXSk9Wa2hKV1dGSWVUQXlUemxzYW1Rck1GRk5jVnBtY0hsVFprc3hiRXRGYWpodFFrazJaMnBoTkhocFdFVm5MMkpYTmpCa09IRkhlRlV5U1hZek5rNDJkemxWZW1wS1pGWnRZelJIYkVveFpFUTROMmd3WVVSNk5EZE5lR0o2VVhOSGNIQmpibGhxVUVKTlZFNTFValIxU1hCS2RWSnJLM1psTkM4elRFOW1VVXRFZG1kUE5scHVSR1kyZHowaUxDSnRZV01pT2lJMU5UazRNV05oTkRnMU1EQTFZV1poTVdaaE1tWXpaVGN5TURrelkyRmxPVFkyT1RrMFlURTVZbUUxTTJFMll6VTBNbVUxTlRka1pHTm1Zek13TVRjeklpd2lkR0ZuSWpvaUluMD0=', 1792141488),
('xhnpS7PBMOmdJpJMPMPYQEOdXiirEnzBIuiA6oeY', 2, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJbEpSTHpWdGExbE9WVWdyU0RWS2MweERTRWh5U1djOVBTSXNJblpoYkhWbElqb2lZV1l2T0ZZeFkxTkZUMGxpVDI1M1NtZEtMelJPU0U1UlIxbDBiMHB0VlRCV1MwbDBXRGR3YmxWVmEzaFdLMGRNVEZWeVVEVjNORGR3VFcwdlZVdzFkakZzVW1sR1UxVmxTbVV5Um1aNWRsRlFTV052ZVROUWNtY3lTVTlYY1hoMVlrbFZNVmhSVFhSdVpXTnJOWGhpVTNaRmJqQnFZMVkwUzJRck9XdG5OVEIzUjJSdFJFcG5NVlJYZGxaSlRqUTBNblpUUkZKelprSnZUVnBSVG1WM1R6TmtTbEIxVERWM1UzUjNTVUY0ZGxSVldsUnVMekUyWW1GTFZ6bG5Xa3QzWjNoVU5HdHRSVm93WVVKQ1YyVXJTVVFyTmxWblRubHlTM2d6U1hOT1VYWXZVMXAxVjJvckswNXdhMGQ0VWxKamN6WmhSRFU0YjBWS01HSkpTV3RNYTJWMmFYWkxNV2hTUzFCUmVqTjVRMEZ3VWxOMU0zZGpNR3hGVTFKRlVWUTROSFJuU0VGR2FuTXJTR1I0VUhJeE9EaE1RMjVVYzBFNU5uZFVWbkpGSzBacFlpOVNNMlIwTW5wUVRVMVlWMU5PWVdWdkwxZFRSMk5aT1VwTlVFRXZZaXRGV1V0NU5tbFhOa2hDVVhST2NYRXhWalpVTW5OSmJVNTNRalJMUjJjclNYa3JWVElyWVVObWRrcDFPVkE1V21VeE0wWjJhMHBTUldNeFZGVnJlSGxtT1RSVlRFTTFOSFZLUlQwaUxDSnRZV01pT2lKaVltTXpObVJoT0RnME1XUXhOVEpqWW1FMllURTVOMlV4WlRsallUVTFaall6WkdGaFpEUXpZak5oWXpGbE1tWTNaalptTkRjeU1ETmpaV0l6T0dZeklpd2lkR0ZuSWpvaUluMD0=', 1792142861),
('xTAngx9JqHsnITSWw4coE28z5X5MYdQaqkDGPkUl', 1, '127.0.0.1', 'Symfony', 'ZXlKcGRpSTZJbGh3WTFwcFkwSklOa05ZWjNORGFEbHZWVkJqSzJjOVBTSXNJblpoYkhWbElqb2lVMkk1WW01cFkwRkxRbUZpV1M5U2QwbG5lWFIwYkhGblUwNUdkR1pqWVRVM0wzTjNkbWxFVjNOVEwwSXljRVkxTTNsNlpqWjZVazFZU1ZFNGQycHJUVFZ6WW5aNE5sbFRVbHBYVmxZM1ZYUndLM0puTVZSSlNXOHdTWE5ZU0c1R016aExTR2hsVFV0RkwyNXFOV0ZpZUdoU2FXZHROM1kzTXk5UGJXczBiV1o0YWtKNWNISTFTbFZCYVZSUmRUTlFVazl6TVZSM1kxTkZjM1l5Ym10UFlqQkdhRWxIU21Sd1JWbHFjbkYwZGtsbFYzQkNhVE0zVEdsS2VIVnJXRzFwYlhGRFRYWm5Za3RaYkRWWFkzRkxSa0pxZWpKNlIza3ZOak5PUjJkU1lqZDBZMnRqWTFaS1JuZEhTRkp3VVdoR1JHWm5RblJLUVd4amVDdENhbWh4YzJWSlpIZHVTMm81Y2tvclpIa3dhSGx2TmtSTFpYWnBjVUUzV0NzMFFYaHNiVmx2ZURWSk1teDNSamhtYmtaRUwzZGxVekpPWkdaMEsyTlNkbGh2WlhGVlpsZEZWekZLS3pGT1dYVnljVk5tZFhaaFJ6bFVWbmhEZFd0emRXZFFaV1JXWlhjdk9VNDBRakZ2ZGk5U2NuaDNaV1ZUTUhwbGVWQTJTMU0yU0hWcU0yOTNZMFpLTW5wa2QyNUZiSG96TXl0RWFXRmxjR3hZY0dSaU1YTmlTMGxKUVhwd1kzTnZRamw0UVQwaUxDSnRZV01pT2lKall6aGtNVGMxWVRNNFlXVmlNek13T1RjMk5UUXdaak13TVdJNE5USTFNekJoTWpCak56azFNbU15WkRKaU16QTBOalV3TUdWbU0yRmhZbU00TldOa0lpd2lkR0ZuSWpvaUluMD0=', 1792142232);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@example.com', NULL, '$2y$12$uCukrnY2Jf53m041pbhOLe/n80SSLbNSNcXERahweoiPtpSnF.lXy', 'admin', NULL, '2026-10-16 09:04:08', '2026-10-16 09:04:08'),
(2, 'Dapur Nusantara', 'merchant@example.com', NULL, '$2y$12$y6RwRonml8iEskriavoduej91q3XurxkM7eBdlFvrcD/0DUXCAUtK', 'merchant', NULL, '2026-10-16 09:04:09', '2026-10-16 09:04:09'),
(3, 'Katering Sehat', 'merchant2@example.com', NULL, '$2y$12$G0IyyYjMlx6XShmN5BAxf.uPv7g.Oci/FuoklMNS9ZuYqkSmuREB6', 'merchant', NULL, '2026-10-16 09:04:10', '2026-10-16 09:04:10'),
(4, 'PT Kantor Makmur', 'customer@example.com', NULL, '$2y$12$b64YJcIskfLqkxEMe137KeCdJv9jKI10F9ebGjaoNL4j7w19v53fy', 'customer', NULL, '2026-10-16 09:04:11', '2026-10-16 09:04:11');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_order_id_unique` (`order_id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`);

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
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_merchant_profile_id_foreign` (`merchant_profile_id`),
  ADD KEY `menus_is_available_index` (`is_available`);

--
-- Indexes for table `merchant_profiles`
--
ALTER TABLE `merchant_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `merchant_profiles_user_id_unique` (`user_id`),
  ADD KEY `merchant_profiles_food_type_index` (`food_type`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_merchant_profile_id_foreign` (`merchant_profile_id`),
  ADD KEY `orders_status_index` (`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `merchant_profiles`
--
ALTER TABLE `merchant_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_merchant_profile_id_foreign` FOREIGN KEY (`merchant_profile_id`) REFERENCES `merchant_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merchant_profiles`
--
ALTER TABLE `merchant_profiles`
  ADD CONSTRAINT `merchant_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_merchant_profile_id_foreign` FOREIGN KEY (`merchant_profile_id`) REFERENCES `merchant_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
