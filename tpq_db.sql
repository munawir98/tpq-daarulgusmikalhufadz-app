-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2026 pada 02.26
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpq_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'Santri baru ditambahkan untuk testing chart', NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2025-12-09 08:18:11', '2025-12-09 08:18:11'),
(2, 'user', 'Sistem membuat akun user Admin TPQ', 'App\\Models\\User', 'created', 1, NULL, NULL, '{\"attributes\":{\"id\":1,\"name\":\"Admin TPQ\",\"email\":\"admin@tpq.test\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$m3rZVjiozUncoj862fvf8OrZrlquy1A\\/hvrLuW2rns3Fz5yanjVmq\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"aktif\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-12T09:16:49.000000Z\",\"updated_at\":\"2025-12-12T09:16:49.000000Z\"}}', NULL, '2025-12-12 02:16:49', '2025-12-12 02:16:49'),
(3, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 2, NULL, NULL, '{\"attributes\":{\"id\":2,\"name\":\"Test Santri\",\"email\":\"santri1@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$9h7U9vhnWQHn8CmxzXrXnO81weO0GGqkFHcJk5\\/4DCvD1eQ.euGvy\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-12T12:11:05.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-12T12:11:05.000000Z\",\"updated_at\":\"2025-12-12T12:11:05.000000Z\"}}', NULL, '2025-12-12 05:11:05', '2025-12-12 05:11:05'),
(4, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-12T12:13:02.000000Z\",\"updated_at\":\"2025-12-12T12:13:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-12T12:11:05.000000Z\",\"updated_at\":\"2025-12-12T12:11:05.000000Z\"}}', NULL, '2025-12-12 05:13:02', '2025-12-12 05:13:02'),
(5, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-12T12:13:49.000000Z\",\"updated_at\":\"2025-12-12T12:13:49.000000Z\"},\"old\":{\"last_login\":\"2025-12-12T12:13:02.000000Z\",\"updated_at\":\"2025-12-12T12:13:02.000000Z\"}}', NULL, '2025-12-12 05:13:49', '2025-12-12 05:13:49'),
(6, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-12T12:17:21.000000Z\",\"updated_at\":\"2025-12-12T12:17:21.000000Z\"},\"old\":{\"last_login\":\"2025-12-12T12:13:49.000000Z\",\"updated_at\":\"2025-12-12T12:13:49.000000Z\"}}', NULL, '2025-12-12 05:17:21', '2025-12-12 05:17:21'),
(7, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-12T12:24:20.000000Z\",\"updated_at\":\"2025-12-12T12:24:20.000000Z\"},\"old\":{\"last_login\":\"2025-12-12T12:17:21.000000Z\",\"updated_at\":\"2025-12-12T12:17:21.000000Z\"}}', NULL, '2025-12-12 05:24:20', '2025-12-12 05:24:20'),
(8, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-12T12:54:18.000000Z\",\"updated_at\":\"2025-12-12T12:54:18.000000Z\"},\"old\":{\"last_login\":\"2025-12-12T12:24:20.000000Z\",\"updated_at\":\"2025-12-12T12:24:20.000000Z\"}}', NULL, '2025-12-12 05:54:18', '2025-12-12 05:54:18'),
(9, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '{\"attributes\":{\"foto\":\"profile\\/693c11fa9a964.jpg\",\"updated_at\":\"2025-12-12T13:00:42.000000Z\"},\"old\":{\"foto\":\"default\\/profile.png\",\"updated_at\":\"2025-12-12T12:54:18.000000Z\"}}', NULL, '2025-12-12 06:00:42', '2025-12-12 06:00:42'),
(10, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 4, NULL, NULL, '{\"attributes\":{\"id\":4,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri2@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$SOCO9glyL6K5ltr1riaIFuK2oNyfTG3Ut3v6yKoqyD\\/GIteK7BEGu\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-13T06:34:55.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-13T06:34:55.000000Z\",\"updated_at\":\"2025-12-13T06:34:55.000000Z\"}}', NULL, '2025-12-12 23:34:55', '2025-12-12 23:34:55'),
(11, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 5, NULL, NULL, '{\"attributes\":{\"id\":5,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri3@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$5gpWUp23G5GmTTND12IqdepjS3XQP6Vzbf.Z1ZUmGMY3VUDmKO35u\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-13T06:37:42.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-13T06:37:42.000000Z\",\"updated_at\":\"2025-12-13T06:37:42.000000Z\"}}', NULL, '2025-12-12 23:37:43', '2025-12-12 23:37:43'),
(12, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 6, NULL, NULL, '{\"attributes\":{\"id\":6,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri4@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$zV8uMvNvoS6XLSe3EafBEuI.dqJsQx0\\/.hI3NqAz.ziK4AkYuk4Je\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-13T06:40:11.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-13T06:40:11.000000Z\",\"updated_at\":\"2025-12-13T06:40:11.000000Z\"}}', NULL, '2025-12-12 23:40:11', '2025-12-12 23:40:11'),
(13, 'santri', 'Sistem menambahkan data santri Test Santri', 'App\\Models\\Santri', 'created', 2, NULL, NULL, '{\"attributes\":{\"id\":2,\"nis\":\"NIS-2025-0006\",\"nama_lengkap\":\"Test Santri\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":1,\"kelas_id\":2,\"created_at\":\"2025-12-13T06:40:11.000000Z\",\"updated_at\":\"2025-12-13T06:40:11.000000Z\",\"user_id\":6}}', NULL, '2025-12-12 23:40:11', '2025-12-12 23:40:11'),
(14, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 6, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-13T06:41:48.000000Z\",\"updated_at\":\"2025-12-13T06:41:48.000000Z\"},\"old\":{\"last_login\":\"2025-12-13T06:40:11.000000Z\",\"updated_at\":\"2025-12-13T06:40:11.000000Z\"}}', NULL, '2025-12-12 23:41:48', '2025-12-12 23:41:48'),
(15, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 6, 'App\\Models\\User', 6, '{\"attributes\":{\"foto\":\"profile\\/693d0b162ec52.jpg\",\"updated_at\":\"2025-12-13T06:43:34.000000Z\"},\"old\":{\"foto\":\"default\\/profile.png\",\"updated_at\":\"2025-12-13T06:41:48.000000Z\"}}', NULL, '2025-12-12 23:43:34', '2025-12-12 23:43:34'),
(16, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 6, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T02:08:22.000000Z\",\"updated_at\":\"2025-12-14T02:08:23.000000Z\"},\"old\":{\"last_login\":\"2025-12-13T06:41:48.000000Z\",\"updated_at\":\"2025-12-13T06:43:34.000000Z\"}}', NULL, '2025-12-13 19:08:23', '2025-12-13 19:08:23'),
(17, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 6, 'App\\Models\\User', 6, '{\"attributes\":{\"foto\":\"profile\\/693e1c490217f.jpg\",\"updated_at\":\"2025-12-14T02:09:17.000000Z\"},\"old\":{\"foto\":\"profile\\/693d0b162ec52.jpg\",\"updated_at\":\"2025-12-14T02:08:23.000000Z\"}}', NULL, '2025-12-13 19:09:17', '2025-12-13 19:09:17'),
(18, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 6, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T02:09:38.000000Z\",\"updated_at\":\"2025-12-14T02:09:38.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T02:08:22.000000Z\",\"updated_at\":\"2025-12-14T02:09:17.000000Z\"}}', NULL, '2025-12-13 19:09:38', '2025-12-13 19:09:38'),
(19, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 7, NULL, NULL, '{\"attributes\":{\"id\":7,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri5@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$KGcTUnc4iiu4IN82EuEt.ezq\\/lhfwD3.UvJdURps0n5c\\/IiCg\\/wPi\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-14T03:51:31.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-14T03:51:31.000000Z\",\"updated_at\":\"2025-12-14T03:51:31.000000Z\"}}', NULL, '2025-12-13 20:51:31', '2025-12-13 20:51:31'),
(20, 'santri', 'Sistem menambahkan data santri Test Santri', 'App\\Models\\Santri', 'created', 3, NULL, NULL, '{\"attributes\":{\"id\":3,\"nis\":\"NIS-2025-0007\",\"nama_lengkap\":\"Test Santri\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":1,\"kelas_id\":2,\"created_at\":\"2025-12-14T03:51:31.000000Z\",\"updated_at\":\"2025-12-14T03:51:31.000000Z\",\"user_id\":7}}', NULL, '2025-12-13 20:51:31', '2025-12-13 20:51:31'),
(21, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 7, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T03:51:45.000000Z\",\"updated_at\":\"2025-12-14T03:51:45.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T03:51:31.000000Z\",\"updated_at\":\"2025-12-14T03:51:31.000000Z\"}}', NULL, '2025-12-13 20:51:45', '2025-12-13 20:51:45'),
(22, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 7, 'App\\Models\\User', 7, '{\"attributes\":{\"foto\":\"profile\\/693e348621149.jpg\",\"updated_at\":\"2025-12-14T03:52:38.000000Z\"},\"old\":{\"foto\":\"default\\/profile.png\",\"updated_at\":\"2025-12-14T03:51:45.000000Z\"}}', NULL, '2025-12-13 20:52:38', '2025-12-13 20:52:38'),
(23, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 7, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T03:53:01.000000Z\",\"updated_at\":\"2025-12-14T03:53:01.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T03:51:45.000000Z\",\"updated_at\":\"2025-12-14T03:52:38.000000Z\"}}', NULL, '2025-12-13 20:53:01', '2025-12-13 20:53:01'),
(24, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 8, NULL, NULL, '{\"attributes\":{\"id\":8,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri6@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$ls8qQRUxjvtzkmv8fX8iXufkNYuTgYJfDHAgq1gy1WjpJwqyu0rOq\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-14T08:48:46.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-14T08:48:47.000000Z\",\"updated_at\":\"2025-12-14T08:48:47.000000Z\"}}', NULL, '2025-12-14 01:48:48', '2025-12-14 01:48:48'),
(25, 'santri', 'Sistem menambahkan data santri Test Santri', 'App\\Models\\Santri', 'created', 4, NULL, NULL, '{\"attributes\":{\"id\":4,\"nis\":\"NIS-2025-0008\",\"nama_lengkap\":\"Test Santri\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":1,\"kelas_id\":2,\"created_at\":\"2025-12-14T08:48:48.000000Z\",\"updated_at\":\"2025-12-14T08:48:48.000000Z\",\"user_id\":8}}', NULL, '2025-12-14 01:48:48', '2025-12-14 01:48:48'),
(26, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 7, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T08:49:02.000000Z\",\"updated_at\":\"2025-12-14T08:49:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T03:53:01.000000Z\",\"updated_at\":\"2025-12-14T03:53:01.000000Z\"}}', NULL, '2025-12-14 01:49:02', '2025-12-14 01:49:02'),
(27, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 7, 'App\\Models\\User', 7, '{\"attributes\":{\"foto\":\"profile\\/693e7a26d8ce7.jpg\",\"updated_at\":\"2025-12-14T08:49:47.000000Z\"},\"old\":{\"foto\":\"profile\\/693e348621149.jpg\",\"updated_at\":\"2025-12-14T08:49:02.000000Z\"}}', NULL, '2025-12-14 01:49:47', '2025-12-14 01:49:47'),
(28, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 9, NULL, NULL, '{\"attributes\":{\"id\":9,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri7@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$s5hLIdWZGEUF3phC2ks0n.f0lZDJQB7DRO3PeVc7QS9FqOyfsb.E2\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-14T10:00:12.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-14T10:00:13.000000Z\",\"updated_at\":\"2025-12-14T10:00:13.000000Z\"}}', NULL, '2025-12-14 03:00:14', '2025-12-14 03:00:14'),
(29, 'santri', 'Sistem menambahkan data santri Test Santri', 'App\\Models\\Santri', 'created', 5, NULL, NULL, '{\"attributes\":{\"id\":5,\"nis\":\"NIS-2025-0009\",\"nama_lengkap\":\"Test Santri\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":1,\"kelas_id\":2,\"created_at\":\"2025-12-14T10:00:14.000000Z\",\"updated_at\":\"2025-12-14T10:00:14.000000Z\",\"user_id\":9}}', NULL, '2025-12-14 03:00:14', '2025-12-14 03:00:14'),
(30, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T10:02:32.000000Z\",\"updated_at\":\"2025-12-14T10:02:32.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T10:00:12.000000Z\",\"updated_at\":\"2025-12-14T10:00:13.000000Z\"}}', NULL, '2025-12-14 03:02:32', '2025-12-14 03:02:32'),
(31, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-14T10:03:49.000000Z\",\"updated_at\":\"2025-12-14T10:03:49.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T10:02:32.000000Z\",\"updated_at\":\"2025-12-14T10:02:32.000000Z\"}}', NULL, '2025-12-14 03:03:49', '2025-12-14 03:03:49'),
(32, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, 'App\\Models\\User', 9, '{\"attributes\":{\"foto\":\"profile\\/693e8bda1263b.jpg\",\"updated_at\":\"2025-12-14T10:05:18.000000Z\"},\"old\":{\"foto\":\"default\\/profile.png\",\"updated_at\":\"2025-12-14T10:03:49.000000Z\"}}', NULL, '2025-12-14 03:05:18', '2025-12-14 03:05:18'),
(33, 'user', 'Sistem memperbarui akun user Admin TPQ', 'App\\Models\\User', 'updated', 1, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$8Gqflo\\/\\/7ssGMPz5KPqzFOl2T8KN6OTRQzNI3zLQmjZdhCf4GouuC\",\"updated_at\":\"2025-12-15T23:32:51.000000Z\"},\"old\":{\"password\":\"$2y$12$m3rZVjiozUncoj862fvf8OrZrlquy1A\\/hvrLuW2rns3Fz5yanjVmq\",\"updated_at\":\"2025-12-12T09:19:10.000000Z\"}}', NULL, '2025-12-15 16:32:52', '2025-12-15 16:32:52'),
(34, 'user', 'Sistem memperbarui akun user Admin TPQ', 'App\\Models\\User', 'updated', 1, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-15T23:35:11.000000Z\",\"updated_at\":\"2025-12-15T23:35:11.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-15T23:32:51.000000Z\"}}', NULL, '2025-12-15 16:35:11', '2025-12-15 16:35:11'),
(35, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-16T02:03:13.000000Z\",\"updated_at\":\"2025-12-16T02:03:13.000000Z\"},\"old\":{\"last_login\":\"2025-12-14T10:03:49.000000Z\",\"updated_at\":\"2025-12-14T10:05:18.000000Z\"}}', NULL, '2025-12-15 19:03:13', '2025-12-15 19:03:13'),
(36, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-16T02:04:15.000000Z\",\"updated_at\":\"2025-12-16T02:04:15.000000Z\"},\"old\":{\"last_login\":\"2025-12-16T02:03:13.000000Z\",\"updated_at\":\"2025-12-16T02:03:13.000000Z\"}}', NULL, '2025-12-15 19:04:15', '2025-12-15 19:04:15'),
(37, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-16T02:23:20.000000Z\",\"updated_at\":\"2025-12-16T02:23:20.000000Z\"},\"old\":{\"last_login\":\"2025-12-16T02:04:15.000000Z\",\"updated_at\":\"2025-12-16T02:04:15.000000Z\"}}', NULL, '2025-12-15 19:23:20', '2025-12-15 19:23:20'),
(38, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-16T13:20:40.000000Z\",\"updated_at\":\"2025-12-16T13:20:40.000000Z\"},\"old\":{\"last_login\":\"2025-12-16T02:23:20.000000Z\",\"updated_at\":\"2025-12-16T02:23:20.000000Z\"}}', NULL, '2025-12-16 06:20:40', '2025-12-16 06:20:40'),
(39, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, 'App\\Models\\User', 9, '{\"attributes\":{\"foto\":\"profile\\/6941630f2de34.jpg\",\"updated_at\":\"2025-12-16T13:47:59.000000Z\"},\"old\":{\"foto\":\"profile\\/693e8bda1263b.jpg\",\"updated_at\":\"2025-12-16T13:20:40.000000Z\"}}', NULL, '2025-12-16 06:47:59', '2025-12-16 06:47:59'),
(40, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-17T07:06:16.000000Z\",\"updated_at\":\"2025-12-17T07:06:16.000000Z\"},\"old\":{\"last_login\":\"2025-12-16T13:20:40.000000Z\",\"updated_at\":\"2025-12-16T13:47:59.000000Z\"}}', NULL, '2025-12-17 00:06:16', '2025-12-17 00:06:16'),
(41, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-17T08:04:49.000000Z\",\"updated_at\":\"2025-12-17T08:04:49.000000Z\"},\"old\":{\"last_login\":\"2025-12-17T07:06:16.000000Z\",\"updated_at\":\"2025-12-17T07:06:16.000000Z\"}}', NULL, '2025-12-17 01:04:49', '2025-12-17 01:04:49'),
(42, 'user', 'Sistem membuat akun user Test Santri', 'App\\Models\\User', 'created', 11, NULL, NULL, '{\"attributes\":{\"id\":11,\"kelas_id\":2,\"name\":\"Test Santri\",\"email\":\"santri8@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$.PEnwtHPqDE.hXXHHkF9CuSXRjf4hIEzj3gn7EU1hD8zKmQFs5rjy\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-18T03:43:36.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-18T03:43:37.000000Z\",\"updated_at\":\"2025-12-18T03:43:37.000000Z\"}}', NULL, '2025-12-17 20:43:38', '2025-12-17 20:43:38'),
(43, 'santri', 'Sistem menambahkan data santri Test Santri', 'App\\Models\\Santri', 'created', 8, NULL, NULL, '{\"attributes\":{\"id\":8,\"nis\":\"NIS-2025-0011\",\"nama_lengkap\":\"Test Santri\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":true,\"kelas_id\":2,\"created_at\":\"2025-12-18T03:43:38.000000Z\",\"updated_at\":\"2025-12-18T03:43:38.000000Z\",\"user_id\":11}}', NULL, '2025-12-17 20:43:38', '2025-12-17 20:43:38'),
(44, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 9, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-18T03:43:53.000000Z\",\"updated_at\":\"2025-12-18T03:43:53.000000Z\"},\"old\":{\"last_login\":\"2025-12-17T08:04:49.000000Z\",\"updated_at\":\"2025-12-17T08:04:49.000000Z\"}}', NULL, '2025-12-17 20:43:53', '2025-12-17 20:43:53'),
(45, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 11, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-18T03:44:12.000000Z\",\"updated_at\":\"2025-12-18T03:44:12.000000Z\"},\"old\":{\"last_login\":\"2025-12-18T03:43:36.000000Z\",\"updated_at\":\"2025-12-18T03:43:37.000000Z\"}}', NULL, '2025-12-17 20:44:12', '2025-12-17 20:44:12'),
(46, 'user', 'Test Santri memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 11, 'App\\Models\\User', 11, '{\"attributes\":{\"foto\":\"profile\\/69437a0807f8a.jpg\",\"updated_at\":\"2025-12-18T03:50:36.000000Z\"},\"old\":{\"foto\":\"default\\/profile.png\",\"updated_at\":\"2025-12-18T03:44:12.000000Z\"}}', NULL, '2025-12-17 20:50:36', '2025-12-17 20:50:36'),
(47, 'user', 'Sistem memperbarui akun user Test Santri', 'App\\Models\\User', 'updated', 11, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-18T05:49:16.000000Z\",\"updated_at\":\"2025-12-18T05:49:16.000000Z\"},\"old\":{\"last_login\":\"2025-12-18T03:44:12.000000Z\",\"updated_at\":\"2025-12-18T03:50:36.000000Z\"}}', NULL, '2025-12-17 22:49:16', '2025-12-17 22:49:16'),
(48, 'user', 'Sistem memperbarui akun user Ustadz Ahmad', 'App\\Models\\User', 'updated', 3, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-18T06:58:56.000000Z\",\"updated_at\":\"2025-12-18T06:58:56.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-13T12:59:24.000000Z\"}}', NULL, '2025-12-17 23:58:56', '2025-12-17 23:58:56'),
(49, 'user', 'Sistem membuat akun user Admin', 'App\\Models\\User', 'created', 12, NULL, NULL, '{\"attributes\":{\"id\":12,\"kelas_id\":null,\"name\":\"Admin\",\"email\":\"santrineumi@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$6Uewn.Vtn7bJ8hcN53J5NOEBtKv.GLkZrPQ7s6XCMt0yoaATud1zm\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"aktif\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-18T12:29:03.000000Z\",\"updated_at\":\"2025-12-18T12:29:03.000000Z\"}}', NULL, '2025-12-18 05:29:03', '2025-12-18 05:29:03'),
(50, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"role\":\"admin\",\"updated_at\":\"2025-12-18T23:02:45.000000Z\"},\"old\":{\"role\":\"SANTRI\",\"updated_at\":\"2025-12-18T12:29:03.000000Z\"}}', NULL, '2025-12-18 16:02:45', '2025-12-18 16:02:45'),
(51, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-18T23:03:28.000000Z\",\"updated_at\":\"2025-12-18T23:03:28.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-18T23:02:45.000000Z\"}}', NULL, '2025-12-18 16:03:28', '2025-12-18 16:03:28'),
(52, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T00:16:53.000000Z\",\"updated_at\":\"2025-12-19T00:16:53.000000Z\"},\"old\":{\"last_login\":\"2025-12-18T23:03:28.000000Z\",\"updated_at\":\"2025-12-18T23:03:28.000000Z\"}}', NULL, '2025-12-18 17:16:53', '2025-12-18 17:16:53'),
(53, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T01:46:02.000000Z\",\"updated_at\":\"2025-12-19T01:46:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T00:16:53.000000Z\",\"updated_at\":\"2025-12-19T00:16:53.000000Z\"}}', NULL, '2025-12-18 18:46:03', '2025-12-18 18:46:03'),
(54, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T02:08:47.000000Z\",\"updated_at\":\"2025-12-19T02:08:47.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T01:46:02.000000Z\",\"updated_at\":\"2025-12-19T01:46:02.000000Z\"}}', NULL, '2025-12-18 19:08:47', '2025-12-18 19:08:47'),
(55, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T02:23:53.000000Z\",\"updated_at\":\"2025-12-19T02:23:53.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T02:08:47.000000Z\",\"updated_at\":\"2025-12-19T02:08:47.000000Z\"}}', NULL, '2025-12-18 19:23:53', '2025-12-18 19:23:53'),
(56, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T02:42:01.000000Z\",\"updated_at\":\"2025-12-19T02:42:01.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T02:23:53.000000Z\",\"updated_at\":\"2025-12-19T02:23:53.000000Z\"}}', NULL, '2025-12-18 19:42:01', '2025-12-18 19:42:01'),
(57, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-19T03:10:59.000000Z\",\"updated_at\":\"2025-12-19T03:10:59.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T02:42:01.000000Z\",\"updated_at\":\"2025-12-19T02:42:01.000000Z\"}}', NULL, '2025-12-18 20:10:59', '2025-12-18 20:10:59'),
(58, 'user', 'Sistem membuat akun user TEST SANTRI', 'App\\Models\\User', 'created', 14, NULL, NULL, '{\"attributes\":{\"id\":14,\"kelas_id\":null,\"name\":\"TEST SANTRI\",\"email\":\"testsantri2@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$YSckDJ6f2nsQkXp72NDyse7upIt1uCKy2c3eAXpszPXRASSFplOB2\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-27T10:10:10.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-27T10:10:11.000000Z\",\"updated_at\":\"2025-12-27T10:10:11.000000Z\"}}', NULL, '2025-12-27 03:10:12', '2025-12-27 03:10:12'),
(59, 'santri', 'Sistem menambahkan data santri TEST SANTRI', 'App\\Models\\Santri', 'created', 9, NULL, NULL, '{\"attributes\":{\"id\":9,\"nis\":\"NIS-2025-0014\",\"nama_lengkap\":\"TEST SANTRI\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":true,\"kelas_id\":null,\"created_at\":\"2025-12-27T10:10:12.000000Z\",\"updated_at\":\"2025-12-27T10:10:12.000000Z\",\"user_id\":14}}', NULL, '2025-12-27 03:10:12', '2025-12-27 03:10:12'),
(60, 'user', 'Sistem membuat akun user TEST', 'App\\Models\\User', 'created', 15, NULL, NULL, '{\"attributes\":{\"id\":15,\"kelas_id\":null,\"name\":\"TEST\",\"email\":\"test@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$9wL2CZZiv0amisu5SXX.5.m41fkwj3pGLTMKKojC6I2SCHgoKOxjW\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-27T13:31:21.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-27T13:31:21.000000Z\",\"updated_at\":\"2025-12-27T13:31:21.000000Z\"}}', NULL, '2025-12-27 06:31:21', '2025-12-27 06:31:21'),
(61, 'santri', 'Sistem menambahkan data santri TEST', 'App\\Models\\Santri', 'created', 10, NULL, NULL, '{\"attributes\":{\"id\":10,\"nis\":\"NIS-2025-0015\",\"nama_lengkap\":\"TEST\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":true,\"kelas_id\":null,\"created_at\":\"2025-12-27T13:31:21.000000Z\",\"updated_at\":\"2025-12-27T13:31:21.000000Z\",\"user_id\":15}}', NULL, '2025-12-27 06:31:21', '2025-12-27 06:31:21'),
(62, 'user', 'Sistem membuat akun user SANTRI BARU', 'App\\Models\\User', 'created', 16, NULL, NULL, '{\"attributes\":{\"id\":16,\"kelas_id\":null,\"name\":\"SANTRI BARU\",\"email\":\"santri_baru_2025@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$sAcmvdy\\/JSxwZsdjnlWrGu8sMqMVWesaxbwfh51rQq6ynL.3.lLgO\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-27T14:40:06.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-27T14:40:06.000000Z\",\"updated_at\":\"2025-12-27T14:40:06.000000Z\"}}', NULL, '2025-12-27 07:40:06', '2025-12-27 07:40:06'),
(63, 'santri', 'Sistem menambahkan data santri SANTRI BARU', 'App\\Models\\Santri', 'created', 11, NULL, NULL, '{\"attributes\":{\"id\":11,\"nis\":\"NIS-2025-0016\",\"nama_lengkap\":\"SANTRI BARU\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":true,\"kelas_id\":null,\"created_at\":\"2025-12-27T14:40:06.000000Z\",\"updated_at\":\"2025-12-27T14:40:06.000000Z\",\"user_id\":16}}', NULL, '2025-12-27 07:40:06', '2025-12-27 07:40:06'),
(64, 'user', 'Sistem membuat akun user TEST2', 'App\\Models\\User', 'created', 17, NULL, NULL, '{\"attributes\":{\"id\":17,\"kelas_id\":null,\"name\":\"TEST2\",\"email\":\"baru123@test.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$ip0FoNlEuD.blLF4WaaJieVe2PddtuMrGQDi\\/FyK0nuvoe5NaftXe\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":\"default\\/profile.png\",\"status\":\"aktif\",\"last_login\":\"2025-12-27T14:54:41.000000Z\",\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-27T14:54:41.000000Z\",\"updated_at\":\"2025-12-27T14:54:41.000000Z\"}}', NULL, '2025-12-27 07:54:41', '2025-12-27 07:54:41'),
(65, 'santri', 'Sistem menambahkan data santri TEST2', 'App\\Models\\Santri', 'created', 12, NULL, NULL, '{\"attributes\":{\"id\":12,\"nis\":\"NIS-2025-0017\",\"nama_lengkap\":\"TEST2\",\"nama_panggilan\":null,\"jenis_kelamin\":\"L\",\"tanggal_lahir\":null,\"tempat_lahir\":null,\"alamat\":null,\"nama_ayah\":null,\"nama_ibu\":null,\"no_hp_orang_tua\":null,\"tanggal_masuk\":null,\"status_aktif\":true,\"kelas_id\":null,\"created_at\":\"2025-12-27T14:54:41.000000Z\",\"updated_at\":\"2025-12-27T14:54:41.000000Z\",\"user_id\":17}}', NULL, '2025-12-27 07:54:41', '2025-12-27 07:54:41'),
(66, 'santri', 'Sistem memperbarui data santri Test Santri', 'App\\Models\\Santri', 'updated', 2, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$3Fxj03o1mLbMBsCP1FyKreSLhihbMaLu9JX7EO.4trayMjvoGjN4O\",\"updated_at\":\"2025-12-28T10:36:46.000000Z\"},\"old\":{\"password\":\"\",\"updated_at\":\"2025-12-13T06:40:11.000000Z\"}}', NULL, '2025-12-28 03:36:47', '2025-12-28 03:36:47'),
(67, 'user', 'Sistem membuat akun user MUNAWIR', 'App\\Models\\User', 'created', 18, NULL, NULL, '{\"attributes\":{\"id\":18,\"kelas_id\":null,\"name\":\"MUNAWIR\",\"email\":\"daarulgusmikalhufadz@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$fmTd4RJyePFoWsyYaWplqOZCv1KiZpU3TnxNw5gUlUtaTgMrQQuPS\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-28T12:36:22.000000Z\",\"updated_at\":\"2025-12-28T12:36:22.000000Z\"}}', NULL, '2025-12-28 05:36:22', '2025-12-28 05:36:22'),
(68, 'user', 'Sistem membuat akun user MUNAWIR', 'App\\Models\\User', 'created', 19, NULL, NULL, '{\"attributes\":{\"id\":19,\"kelas_id\":null,\"name\":\"MUNAWIR\",\"email\":\"arkan98store@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$EA6TCF3\\/1oNlGiMmELBpiOx.aBsINZKhenN4S.mvfdRPJMJhzQ\\/Ke\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-28T13:20:40.000000Z\",\"updated_at\":\"2025-12-28T13:20:40.000000Z\"}}', NULL, '2025-12-28 06:20:40', '2025-12-28 06:20:40'),
(69, 'user', 'Sistem membuat akun user AKBAR', 'App\\Models\\User', 'created', 20, NULL, NULL, '{\"attributes\":{\"id\":20,\"kelas_id\":null,\"name\":\"AKBAR\",\"email\":\"santi@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$8g70c9b82x75fLPXga8cy.UHULFz2Vmm9IoV6aC7T4s2tu8MsNgVe\",\"role\":\"SANTRI\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-28T13:25:42.000000Z\",\"updated_at\":\"2025-12-28T13:25:42.000000Z\"}}', NULL, '2025-12-28 06:25:42', '2025-12-28 06:25:42'),
(70, 'user', 'Sistem membuat akun user INDRA', 'App\\Models\\User', 'created', 21, NULL, NULL, '{\"attributes\":{\"id\":21,\"kelas_id\":null,\"name\":\"INDRA\",\"email\":\"indra@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$AUJKVStAxFynN19cJwn1F.Pkzdvd3.zPJyLbplvtGIK01Wylc7EWS\",\"role\":\"SANTRI\",\"nis\":\"NIS-2025-0016\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-28T13:29:42.000000Z\",\"updated_at\":\"2025-12-28T13:29:42.000000Z\"}}', NULL, '2025-12-28 06:29:42', '2025-12-28 06:29:42'),
(71, 'user', 'Sistem membuat akun user IRFAN', 'App\\Models\\User', 'created', 22, NULL, NULL, '{\"attributes\":{\"id\":22,\"kelas_id\":null,\"name\":\"IRFAN\",\"email\":\"irfan@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$zCH9RWPS77wNYPmNLEUnBurC7Qsm42NyxVHuYc6iZ4vH2i.WQ0U6i\",\"role\":\"SANTRI\",\"nis\":\"NIS-2025-0017\",\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-28T13:51:24.000000Z\",\"updated_at\":\"2025-12-28T13:51:24.000000Z\"}}', NULL, '2025-12-28 06:51:24', '2025-12-28 06:51:24'),
(72, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T14:10:33.000000Z\",\"updated_at\":\"2025-12-28T14:10:33.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-28T13:51:24.000000Z\"}}', NULL, '2025-12-28 07:10:33', '2025-12-28 07:10:33'),
(73, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T14:13:56.000000Z\",\"updated_at\":\"2025-12-28T14:13:56.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T14:10:33.000000Z\",\"updated_at\":\"2025-12-28T14:10:33.000000Z\"}}', NULL, '2025-12-28 07:13:56', '2025-12-28 07:13:56'),
(74, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"no_hp\":\"085710387661\",\"updated_at\":\"2025-12-28T14:38:16.000000Z\"},\"old\":{\"no_hp\":null,\"updated_at\":\"2025-12-28T14:13:56.000000Z\"}}', NULL, '2025-12-28 07:38:17', '2025-12-28 07:38:17'),
(75, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/Qp660ntoie6mQepMxysJDEGgFKMSeOCFy1Zh6yQI.png\",\"updated_at\":\"2025-12-28T14:59:15.000000Z\"},\"old\":{\"foto\":null,\"updated_at\":\"2025-12-28T14:38:16.000000Z\"}}', NULL, '2025-12-28 07:59:15', '2025-12-28 07:59:15'),
(76, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"no_hp\":null,\"foto\":\"profile-photos\\/UjpfZWfMyOC5KPJ8nJy7J9WK95QKciUqEQS6xwx3.png\",\"updated_at\":\"2025-12-28T15:09:57.000000Z\"},\"old\":{\"no_hp\":\"085710387661\",\"foto\":\"profile-photos\\/Qp660ntoie6mQepMxysJDEGgFKMSeOCFy1Zh6yQI.png\",\"updated_at\":\"2025-12-28T14:59:15.000000Z\"}}', NULL, '2025-12-28 08:09:58', '2025-12-28 08:09:58'),
(77, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/jYKRpxykXWW4EUeeVWx4Ki2O27aKrFPvgNqWS4xG.png\",\"updated_at\":\"2025-12-28T15:22:01.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/UjpfZWfMyOC5KPJ8nJy7J9WK95QKciUqEQS6xwx3.png\",\"updated_at\":\"2025-12-28T15:09:57.000000Z\"}}', NULL, '2025-12-28 08:22:01', '2025-12-28 08:22:01'),
(78, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T22:49:18.000000Z\",\"updated_at\":\"2025-12-28T22:49:18.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T14:13:56.000000Z\",\"updated_at\":\"2025-12-28T15:22:01.000000Z\"}}', NULL, '2025-12-28 15:49:18', '2025-12-28 15:49:18'),
(79, 'user', 'Sistem memperbarui akun user IRFAN', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/5Uz4ocwOR8JAI2PzbtjKCG8GZirvnFIdZGXTM10G.png\",\"updated_at\":\"2025-12-28T22:50:00.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/jYKRpxykXWW4EUeeVWx4Ki2O27aKrFPvgNqWS4xG.png\",\"updated_at\":\"2025-12-28T22:49:18.000000Z\"}}', NULL, '2025-12-28 15:50:00', '2025-12-28 15:50:00'),
(80, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"name\":\"GALIH\",\"no_hp\":\"085710387661\",\"updated_at\":\"2025-12-28T22:50:58.000000Z\"},\"old\":{\"name\":\"IRFAN\",\"no_hp\":null,\"updated_at\":\"2025-12-28T22:50:00.000000Z\"}}', NULL, '2025-12-28 15:50:58', '2025-12-28 15:50:58'),
(81, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T23:08:36.000000Z\",\"updated_at\":\"2025-12-28T23:08:36.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T22:49:18.000000Z\",\"updated_at\":\"2025-12-28T22:50:58.000000Z\"}}', NULL, '2025-12-28 16:08:37', '2025-12-28 16:08:37'),
(82, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/4UCqSz4TyLpUFz4ougJE7lIhF7AmeWc5cxUynTy4.png\",\"updated_at\":\"2025-12-28T23:09:12.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/5Uz4ocwOR8JAI2PzbtjKCG8GZirvnFIdZGXTM10G.png\",\"updated_at\":\"2025-12-28T23:08:36.000000Z\"}}', NULL, '2025-12-28 16:09:12', '2025-12-28 16:09:12'),
(83, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$rbX6WCh\\/E1V7DJ7rUzdY8uiuL\\/9wIev2PkQ7h08j.ZQPc.CX174y.\",\"updated_at\":\"2025-12-28T23:21:34.000000Z\"},\"old\":{\"password\":\"$2y$12$zCH9RWPS77wNYPmNLEUnBurC7Qsm42NyxVHuYc6iZ4vH2i.WQ0U6i\",\"updated_at\":\"2025-12-28T23:09:12.000000Z\"}}', NULL, '2025-12-28 16:21:34', '2025-12-28 16:21:34'),
(84, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T23:22:02.000000Z\",\"updated_at\":\"2025-12-28T23:22:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T23:08:36.000000Z\",\"updated_at\":\"2025-12-28T23:21:34.000000Z\"}}', NULL, '2025-12-28 16:22:02', '2025-12-28 16:22:02'),
(85, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/bf4HE6sqSWookvamAaA0Jn0tTRCqCsYTYbptwL6N.png\",\"updated_at\":\"2025-12-28T23:22:31.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/4UCqSz4TyLpUFz4ougJE7lIhF7AmeWc5cxUynTy4.png\",\"updated_at\":\"2025-12-28T23:22:02.000000Z\"}}', NULL, '2025-12-28 16:22:31', '2025-12-28 16:22:31'),
(86, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"no_hp\":null,\"foto\":\"profile-photos\\/kMjDllBIg4yh3vNWmmYWXAbaZxG1KncAKPwd36Dn.png\",\"updated_at\":\"2025-12-28T23:22:56.000000Z\"},\"old\":{\"no_hp\":\"085710387661\",\"foto\":\"profile-photos\\/bf4HE6sqSWookvamAaA0Jn0tTRCqCsYTYbptwL6N.png\",\"updated_at\":\"2025-12-28T23:22:31.000000Z\"}}', NULL, '2025-12-28 16:22:56', '2025-12-28 16:22:56'),
(87, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T23:23:21.000000Z\",\"updated_at\":\"2025-12-28T23:23:21.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T23:22:02.000000Z\",\"updated_at\":\"2025-12-28T23:22:56.000000Z\"}}', NULL, '2025-12-28 16:23:21', '2025-12-28 16:23:21'),
(88, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/I4M8pR2pqkeZwibwAYX9nYQFu3TYojEPlOCIZgM5.png\",\"updated_at\":\"2025-12-28T23:38:48.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/kMjDllBIg4yh3vNWmmYWXAbaZxG1KncAKPwd36Dn.png\",\"updated_at\":\"2025-12-28T23:23:21.000000Z\"}}', NULL, '2025-12-28 16:38:48', '2025-12-28 16:38:48'),
(89, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T23:39:33.000000Z\",\"updated_at\":\"2025-12-28T23:39:33.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T23:23:21.000000Z\",\"updated_at\":\"2025-12-28T23:38:48.000000Z\"}}', NULL, '2025-12-28 16:39:33', '2025-12-28 16:39:33'),
(90, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/KcAL3k0cJIbmJfqkaVNMJgX8vXviaN3CrMMvGJ7X.png\",\"updated_at\":\"2025-12-28T23:40:04.000000Z\"},\"old\":{\"foto\":\"profile-photos\\/I4M8pR2pqkeZwibwAYX9nYQFu3TYojEPlOCIZgM5.png\",\"updated_at\":\"2025-12-28T23:39:33.000000Z\"}}', NULL, '2025-12-28 16:40:04', '2025-12-28 16:40:04'),
(91, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-28T23:40:54.000000Z\",\"updated_at\":\"2025-12-28T23:40:54.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T23:39:33.000000Z\",\"updated_at\":\"2025-12-28T23:40:04.000000Z\"}}', NULL, '2025-12-28 16:40:54', '2025-12-28 16:40:54'),
(92, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T02:49:36.000000Z\",\"updated_at\":\"2025-12-29T02:49:36.000000Z\"},\"old\":{\"last_login\":\"2025-12-28T23:40:54.000000Z\",\"updated_at\":\"2025-12-28T23:40:54.000000Z\"}}', NULL, '2025-12-28 19:49:37', '2025-12-28 19:49:37'),
(93, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T02:58:41.000000Z\",\"updated_at\":\"2025-12-29T02:58:41.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-28T13:29:42.000000Z\"}}', NULL, '2025-12-28 19:58:41', '2025-12-28 19:58:41'),
(94, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T04:22:30.000000Z\",\"updated_at\":\"2025-12-29T04:22:30.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T02:49:36.000000Z\",\"updated_at\":\"2025-12-29T02:49:36.000000Z\"}}', NULL, '2025-12-28 21:22:30', '2025-12-28 21:22:30'),
(95, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T04:24:10.000000Z\",\"updated_at\":\"2025-12-29T04:24:10.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T04:22:30.000000Z\",\"updated_at\":\"2025-12-29T04:22:30.000000Z\"}}', NULL, '2025-12-28 21:24:10', '2025-12-28 21:24:10'),
(96, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T05:31:37.000000Z\",\"updated_at\":\"2025-12-29T05:31:37.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T02:58:41.000000Z\",\"updated_at\":\"2025-12-29T02:58:41.000000Z\"}}', NULL, '2025-12-28 22:31:37', '2025-12-28 22:31:37'),
(97, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$vyizLQStrMxYM8OvkFkucOsXmif\\/1XRUfUXQ9OkFDJGNDPkT4\\/dBm\",\"updated_at\":\"2025-12-29T05:56:05.000000Z\"},\"old\":{\"password\":\"$2y$12$6Uewn.Vtn7bJ8hcN53J5NOEBtKv.GLkZrPQ7s6XCMt0yoaATud1zm\",\"updated_at\":\"2025-12-19T03:10:59.000000Z\"}}', NULL, '2025-12-28 22:56:06', '2025-12-28 22:56:06'),
(98, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$.U0Jp2pn32db47kFWb3p\\/..7GpF5Cq9KUp2UFYaOR2ffliWfIro6i\",\"updated_at\":\"2025-12-29T05:58:26.000000Z\"},\"old\":{\"password\":\"$2y$12$vyizLQStrMxYM8OvkFkucOsXmif\\/1XRUfUXQ9OkFDJGNDPkT4\\/dBm\",\"updated_at\":\"2025-12-29T05:56:05.000000Z\"}}', NULL, '2025-12-28 22:58:26', '2025-12-28 22:58:26'),
(99, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T07:06:43.000000Z\",\"updated_at\":\"2025-12-29T07:06:43.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T04:24:10.000000Z\",\"updated_at\":\"2025-12-29T04:24:10.000000Z\"}}', NULL, '2025-12-29 00:06:43', '2025-12-29 00:06:43'),
(100, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$9Dx1Pc8QDE5RhL8sAUfHDurmEVhwybkXr5k.rZA3iHlMflLUL.IBW\",\"updated_at\":\"2025-12-29T07:16:16.000000Z\"},\"old\":{\"password\":\"$2y$12$.U0Jp2pn32db47kFWb3p\\/..7GpF5Cq9KUp2UFYaOR2ffliWfIro6i\",\"updated_at\":\"2025-12-29T05:58:26.000000Z\"}}', NULL, '2025-12-29 00:16:16', '2025-12-29 00:16:16'),
(101, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$SKnKRikfhhR.3uf7c1pZGuT\\/PabF0COjbq6hH268XwJ4RzxGNOwDa\",\"updated_at\":\"2025-12-29T07:17:14.000000Z\"},\"old\":{\"password\":\"$2y$12$9Dx1Pc8QDE5RhL8sAUfHDurmEVhwybkXr5k.rZA3iHlMflLUL.IBW\",\"updated_at\":\"2025-12-29T07:16:16.000000Z\"}}', NULL, '2025-12-29 00:17:14', '2025-12-29 00:17:14'),
(102, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$O4TcpvZw63lOLKGxnrbuyu4.sR5u6X4CdNS4o76mqQJfS9T8GUH3G\",\"updated_at\":\"2025-12-29T07:25:21.000000Z\"},\"old\":{\"password\":\"$2y$12$AUJKVStAxFynN19cJwn1F.Pkzdvd3.zPJyLbplvtGIK01Wylc7EWS\",\"updated_at\":\"2025-12-29T05:31:37.000000Z\"}}', NULL, '2025-12-29 00:25:22', '2025-12-29 00:25:22'),
(103, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T07:35:22.000000Z\",\"updated_at\":\"2025-12-29T07:35:22.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T05:31:37.000000Z\",\"updated_at\":\"2025-12-29T07:25:21.000000Z\"}}', NULL, '2025-12-29 00:35:22', '2025-12-29 00:35:22'),
(104, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T10:33:22.000000Z\",\"updated_at\":\"2025-12-29T10:33:22.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T07:06:43.000000Z\",\"updated_at\":\"2025-12-29T07:06:43.000000Z\"}}', NULL, '2025-12-29 03:33:23', '2025-12-29 03:33:23'),
(105, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T12:56:55.000000Z\",\"updated_at\":\"2025-12-29T12:56:55.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T10:33:22.000000Z\",\"updated_at\":\"2025-12-29T10:33:22.000000Z\"}}', NULL, '2025-12-29 05:56:56', '2025-12-29 05:56:56'),
(106, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$eSg1WschBooJ621WQ5PwUONrA1DFuOGWKswDfAP8I4yPnponeO5Xm\",\"updated_at\":\"2025-12-29T13:04:21.000000Z\"},\"old\":{\"password\":\"$2y$12$O4TcpvZw63lOLKGxnrbuyu4.sR5u6X4CdNS4o76mqQJfS9T8GUH3G\",\"updated_at\":\"2025-12-29T07:35:22.000000Z\"}}', NULL, '2025-12-29 06:04:23', '2025-12-29 06:04:23'),
(107, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$Lk.g3Ly\\/yoha6l.0jo.w6OG74dnqSXHO4u.1K25JNclUQUiFcnfzW\",\"updated_at\":\"2025-12-29T13:04:24.000000Z\"},\"old\":{\"password\":\"$2y$12$eSg1WschBooJ621WQ5PwUONrA1DFuOGWKswDfAP8I4yPnponeO5Xm\",\"updated_at\":\"2025-12-29T13:04:21.000000Z\"}}', NULL, '2025-12-29 06:04:24', '2025-12-29 06:04:24'),
(108, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$Xvi46q3XH4HDJja9M4x1s.aNOUdcNUfZBGdPFgdXzjETlkgyDlaiS\",\"updated_at\":\"2025-12-29T13:04:25.000000Z\"},\"old\":{\"password\":\"$2y$12$Lk.g3Ly\\/yoha6l.0jo.w6OG74dnqSXHO4u.1K25JNclUQUiFcnfzW\",\"updated_at\":\"2025-12-29T13:04:24.000000Z\"}}', NULL, '2025-12-29 06:04:25', '2025-12-29 06:04:25'),
(109, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:06:19.000000Z\",\"updated_at\":\"2025-12-29T13:06:19.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T07:35:22.000000Z\",\"updated_at\":\"2025-12-29T13:04:25.000000Z\"}}', NULL, '2025-12-29 06:06:19', '2025-12-29 06:06:19'),
(110, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$yknc16yuxWdnDgnlzy\\/29OwdP9LMj3UBTFOTIhvVIo0eHDrwmeVfa\",\"updated_at\":\"2025-12-29T13:07:43.000000Z\"},\"old\":{\"password\":\"$2y$12$Xvi46q3XH4HDJja9M4x1s.aNOUdcNUfZBGdPFgdXzjETlkgyDlaiS\",\"updated_at\":\"2025-12-29T13:06:19.000000Z\"}}', NULL, '2025-12-29 06:07:43', '2025-12-29 06:07:43'),
(111, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:08:04.000000Z\",\"updated_at\":\"2025-12-29T13:08:04.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:06:19.000000Z\",\"updated_at\":\"2025-12-29T13:07:43.000000Z\"}}', NULL, '2025-12-29 06:08:04', '2025-12-29 06:08:04'),
(112, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$4IRJIXW47VHNtcUeBIalCuc986sWN06DKZIefj.inGysb0AdMlQCC\",\"updated_at\":\"2025-12-29T13:09:37.000000Z\"},\"old\":{\"password\":\"$2y$12$SKnKRikfhhR.3uf7c1pZGuT\\/PabF0COjbq6hH268XwJ4RzxGNOwDa\",\"updated_at\":\"2025-12-29T07:17:14.000000Z\"}}', NULL, '2025-12-29 06:09:37', '2025-12-29 06:09:37');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(113, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:09:51.000000Z\",\"updated_at\":\"2025-12-29T13:09:51.000000Z\"},\"old\":{\"last_login\":\"2025-12-19T03:10:59.000000Z\",\"updated_at\":\"2025-12-29T13:09:37.000000Z\"}}', NULL, '2025-12-29 06:09:51', '2025-12-29 06:09:51'),
(114, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:10:20.000000Z\",\"updated_at\":\"2025-12-29T13:10:20.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:08:04.000000Z\",\"updated_at\":\"2025-12-29T13:08:04.000000Z\"}}', NULL, '2025-12-29 06:10:20', '2025-12-29 06:10:20'),
(115, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$fe\\/MEzxBxC584UbOIHgfG.rwq43vlM4ZxBBzSEZMe2eCuWZFFh9sC\",\"updated_at\":\"2025-12-29T13:15:10.000000Z\"},\"old\":{\"password\":\"$2y$12$4IRJIXW47VHNtcUeBIalCuc986sWN06DKZIefj.inGysb0AdMlQCC\",\"updated_at\":\"2025-12-29T13:09:51.000000Z\"}}', NULL, '2025-12-29 06:15:10', '2025-12-29 06:15:10'),
(116, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:15:51.000000Z\",\"updated_at\":\"2025-12-29T13:15:51.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:10:20.000000Z\",\"updated_at\":\"2025-12-29T13:10:20.000000Z\"}}', NULL, '2025-12-29 06:15:51', '2025-12-29 06:15:51'),
(117, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$M7dToWmO75ysJ4N4pQnOh.SbBh8.Qpfk3DzzJq25oOyR4KQFlLEdu\",\"updated_at\":\"2025-12-29T13:22:13.000000Z\"},\"old\":{\"password\":\"$2y$12$fe\\/MEzxBxC584UbOIHgfG.rwq43vlM4ZxBBzSEZMe2eCuWZFFh9sC\",\"updated_at\":\"2025-12-29T13:15:10.000000Z\"}}', NULL, '2025-12-29 06:22:13', '2025-12-29 06:22:13'),
(118, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:22:23.000000Z\",\"updated_at\":\"2025-12-29T13:22:23.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:09:51.000000Z\",\"updated_at\":\"2025-12-29T13:22:13.000000Z\"}}', NULL, '2025-12-29 06:22:23', '2025-12-29 06:22:23'),
(119, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:22:34.000000Z\",\"updated_at\":\"2025-12-29T13:22:34.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:22:23.000000Z\",\"updated_at\":\"2025-12-29T13:22:23.000000Z\"}}', NULL, '2025-12-29 06:22:34', '2025-12-29 06:22:34'),
(120, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$LMGQH3ZpgySEw2C0P3fW9OnY\\/8lkrwWfii2382ym\\/UlWqLslaT6Bm\",\"updated_at\":\"2025-12-29T13:36:08.000000Z\"},\"old\":{\"password\":\"$2y$12$M7dToWmO75ysJ4N4pQnOh.SbBh8.Qpfk3DzzJq25oOyR4KQFlLEdu\",\"updated_at\":\"2025-12-29T13:22:34.000000Z\"}}', NULL, '2025-12-29 06:36:08', '2025-12-29 06:36:08'),
(121, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:37:24.000000Z\",\"updated_at\":\"2025-12-29T13:37:24.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:22:34.000000Z\",\"updated_at\":\"2025-12-29T13:36:08.000000Z\"}}', NULL, '2025-12-29 06:37:24', '2025-12-29 06:37:24'),
(122, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:37:54.000000Z\",\"updated_at\":\"2025-12-29T13:37:54.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:37:24.000000Z\",\"updated_at\":\"2025-12-29T13:37:24.000000Z\"}}', NULL, '2025-12-29 06:37:54', '2025-12-29 06:37:54'),
(123, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:38:46.000000Z\",\"updated_at\":\"2025-12-29T13:38:46.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:37:54.000000Z\",\"updated_at\":\"2025-12-29T13:37:54.000000Z\"}}', NULL, '2025-12-29 06:38:46', '2025-12-29 06:38:46'),
(124, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:39:17.000000Z\",\"updated_at\":\"2025-12-29T13:39:17.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T12:56:55.000000Z\",\"updated_at\":\"2025-12-29T12:56:55.000000Z\"}}', NULL, '2025-12-29 06:39:17', '2025-12-29 06:39:17'),
(125, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:40:08.000000Z\",\"updated_at\":\"2025-12-29T13:40:08.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:15:51.000000Z\",\"updated_at\":\"2025-12-29T13:15:51.000000Z\"}}', NULL, '2025-12-29 06:40:08', '2025-12-29 06:40:08'),
(126, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:41:24.000000Z\",\"updated_at\":\"2025-12-29T13:41:24.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:38:46.000000Z\",\"updated_at\":\"2025-12-29T13:38:46.000000Z\"}}', NULL, '2025-12-29 06:41:24', '2025-12-29 06:41:24'),
(127, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:42:30.000000Z\",\"updated_at\":\"2025-12-29T13:42:30.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:41:24.000000Z\",\"updated_at\":\"2025-12-29T13:41:24.000000Z\"}}', NULL, '2025-12-29 06:42:30', '2025-12-29 06:42:30'),
(128, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:45:55.000000Z\",\"updated_at\":\"2025-12-29T13:45:55.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:42:30.000000Z\",\"updated_at\":\"2025-12-29T13:42:30.000000Z\"}}', NULL, '2025-12-29 06:45:55', '2025-12-29 06:45:55'),
(129, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:46:23.000000Z\",\"updated_at\":\"2025-12-29T13:46:23.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:45:55.000000Z\",\"updated_at\":\"2025-12-29T13:45:55.000000Z\"}}', NULL, '2025-12-29 06:46:23', '2025-12-29 06:46:23'),
(130, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-29T13:46:57.000000Z\",\"updated_at\":\"2025-12-29T13:46:57.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:46:23.000000Z\",\"updated_at\":\"2025-12-29T13:46:23.000000Z\"}}', NULL, '2025-12-29 06:46:57', '2025-12-29 06:46:57'),
(131, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T05:36:55.000000Z\",\"updated_at\":\"2025-12-30T05:36:55.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:46:57.000000Z\",\"updated_at\":\"2025-12-29T13:46:57.000000Z\"}}', NULL, '2025-12-29 22:36:55', '2025-12-29 22:36:55'),
(132, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T05:37:22.000000Z\",\"updated_at\":\"2025-12-30T05:37:22.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T05:36:55.000000Z\",\"updated_at\":\"2025-12-30T05:36:55.000000Z\"}}', NULL, '2025-12-29 22:37:22', '2025-12-29 22:37:22'),
(133, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T05:38:57.000000Z\",\"updated_at\":\"2025-12-30T05:38:57.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:39:17.000000Z\",\"updated_at\":\"2025-12-29T13:39:17.000000Z\"}}', NULL, '2025-12-29 22:38:57', '2025-12-29 22:38:57'),
(134, 'user', 'Sistem memperbarui akun user Admin', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T05:42:38.000000Z\",\"updated_at\":\"2025-12-30T05:42:38.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T05:37:22.000000Z\",\"updated_at\":\"2025-12-30T05:37:22.000000Z\"}}', NULL, '2025-12-29 22:42:38', '2025-12-29 22:42:38'),
(135, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"name\":\"MUNAWIR\",\"no_hp\":\"085710387661\",\"foto\":\"profile-photos\\/g3idPjoQU1c9s3jiX982m4aaD0zoPpycbipP1DHs.png\",\"updated_at\":\"2025-12-30T06:20:45.000000Z\"},\"old\":{\"name\":\"Admin\",\"no_hp\":null,\"foto\":null,\"updated_at\":\"2025-12-30T05:42:38.000000Z\"}}', NULL, '2025-12-29 23:20:45', '2025-12-29 23:20:45'),
(136, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$quTRFJdvQD7F6MxAgmZsvuoJxwR3jy1Pw2Adb\\/YdtpEwJqVKY5J.e\",\"updated_at\":\"2025-12-30T06:22:08.000000Z\"},\"old\":{\"password\":\"$2y$12$LMGQH3ZpgySEw2C0P3fW9OnY\\/8lkrwWfii2382ym\\/UlWqLslaT6Bm\",\"updated_at\":\"2025-12-30T06:20:45.000000Z\"}}', NULL, '2025-12-29 23:22:08', '2025-12-29 23:22:08'),
(137, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T06:33:06.000000Z\",\"updated_at\":\"2025-12-30T06:33:06.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T05:42:38.000000Z\",\"updated_at\":\"2025-12-30T06:22:08.000000Z\"}}', NULL, '2025-12-29 23:33:06', '2025-12-29 23:33:06'),
(138, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T08:22:37.000000Z\",\"updated_at\":\"2025-12-30T08:22:37.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T06:33:06.000000Z\",\"updated_at\":\"2025-12-30T06:33:06.000000Z\"}}', NULL, '2025-12-30 01:22:37', '2025-12-30 01:22:37'),
(139, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T08:32:00.000000Z\",\"updated_at\":\"2025-12-30T08:32:00.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T08:22:37.000000Z\",\"updated_at\":\"2025-12-30T08:22:37.000000Z\"}}', NULL, '2025-12-30 01:32:00', '2025-12-30 01:32:00'),
(140, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T23:50:39.000000Z\",\"updated_at\":\"2025-12-30T23:50:39.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T08:32:00.000000Z\",\"updated_at\":\"2025-12-30T08:32:00.000000Z\"}}', NULL, '2025-12-30 16:50:40', '2025-12-30 16:50:40'),
(141, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-30T23:52:02.000000Z\",\"updated_at\":\"2025-12-30T23:52:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T05:38:57.000000Z\",\"updated_at\":\"2025-12-30T05:38:57.000000Z\"}}', NULL, '2025-12-30 16:52:02', '2025-12-30 16:52:02'),
(142, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T00:25:25.000000Z\",\"updated_at\":\"2025-12-31T00:25:25.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T23:50:39.000000Z\",\"updated_at\":\"2025-12-30T23:50:39.000000Z\"}}', NULL, '2025-12-30 17:25:25', '2025-12-30 17:25:25'),
(143, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T00:26:41.000000Z\",\"updated_at\":\"2025-12-31T00:26:41.000000Z\"},\"old\":{\"last_login\":\"2025-12-30T23:52:02.000000Z\",\"updated_at\":\"2025-12-30T23:52:02.000000Z\"}}', NULL, '2025-12-30 17:26:41', '2025-12-30 17:26:41'),
(144, 'user', 'Sistem membuat akun user ALDI', 'App\\Models\\User', 'created', 23, NULL, NULL, '{\"attributes\":{\"id\":23,\"kelas_id\":null,\"name\":\"ALDI\",\"email\":\"aldi@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$aKg05QVlyZx15ymKHTRZBuc.iE59UFyCmJvuf.KqvqxKLXaU69mSO\",\"role\":\"USTADZ\",\"nis\":null,\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2025-12-31T03:08:01.000000Z\",\"updated_at\":\"2025-12-31T03:08:01.000000Z\"}}', NULL, '2025-12-30 20:08:01', '2025-12-30 20:08:01'),
(145, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/Xcfym7amqbIdB3C6OURFmalylGXL3Qy5INoSJyzl.png\",\"updated_at\":\"2025-12-31T03:52:02.000000Z\"},\"old\":{\"foto\":null,\"updated_at\":\"2025-12-31T03:08:01.000000Z\"}}', NULL, '2025-12-30 20:52:02', '2025-12-30 20:52:02'),
(146, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T03:55:45.000000Z\",\"updated_at\":\"2025-12-31T03:55:45.000000Z\"},\"old\":{\"last_login\":\"2025-12-29T13:40:08.000000Z\",\"updated_at\":\"2025-12-29T13:40:08.000000Z\"}}', NULL, '2025-12-30 20:55:45', '2025-12-30 20:55:45'),
(147, 'user', 'Sistem memperbarui akun user INDRA', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"foto\":\"profile-photos\\/Ev8mn57sf4b4kiEpMEjFqFjZCIpfH42DPzJupVmn.png\",\"updated_at\":\"2025-12-31T03:56:34.000000Z\"},\"old\":{\"foto\":null,\"updated_at\":\"2025-12-31T03:55:45.000000Z\"}}', NULL, '2025-12-30 20:56:35', '2025-12-30 20:56:35'),
(148, 'user', 'Sistem memperbarui akun user ANDRI', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"name\":\"ANDRI\",\"no_hp\":\"085710387661\",\"updated_at\":\"2025-12-31T03:57:05.000000Z\"},\"old\":{\"name\":\"INDRA\",\"no_hp\":null,\"updated_at\":\"2025-12-31T03:56:34.000000Z\"}}', NULL, '2025-12-30 20:57:05', '2025-12-30 20:57:05'),
(149, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T03:57:40.000000Z\",\"updated_at\":\"2025-12-31T03:57:40.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T00:25:25.000000Z\",\"updated_at\":\"2025-12-31T00:25:25.000000Z\"}}', NULL, '2025-12-30 20:57:40', '2025-12-30 20:57:40'),
(150, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T04:05:53.000000Z\",\"updated_at\":\"2025-12-31T04:05:53.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T00:26:41.000000Z\",\"updated_at\":\"2025-12-31T00:26:41.000000Z\"}}', NULL, '2025-12-30 21:05:53', '2025-12-30 21:05:53'),
(151, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$C8L128kMhF9ZIFsmEENWeeteqNpQzIGIAOZFkwek.5c7VE9d07eee\",\"updated_at\":\"2025-12-31T04:10:54.000000Z\"},\"old\":{\"password\":\"$2y$12$quTRFJdvQD7F6MxAgmZsvuoJxwR3jy1Pw2Adb\\/YdtpEwJqVKY5J.e\",\"updated_at\":\"2025-12-31T03:57:40.000000Z\"}}', NULL, '2025-12-30 21:10:54', '2025-12-30 21:10:54'),
(152, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T04:11:22.000000Z\",\"updated_at\":\"2025-12-31T04:11:22.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2025-12-31T03:52:02.000000Z\"}}', NULL, '2025-12-30 21:11:22', '2025-12-30 21:11:22'),
(153, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T06:22:42.000000Z\",\"updated_at\":\"2025-12-31T06:22:42.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T04:11:22.000000Z\",\"updated_at\":\"2025-12-31T04:11:22.000000Z\"}}', NULL, '2025-12-30 23:22:43', '2025-12-30 23:22:43'),
(154, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T11:51:50.000000Z\",\"updated_at\":\"2025-12-31T11:51:50.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T06:22:42.000000Z\",\"updated_at\":\"2025-12-31T06:22:42.000000Z\"}}', NULL, '2025-12-31 04:51:50', '2025-12-31 04:51:50'),
(155, 'user', 'Sistem memperbarui akun user ANDRI', 'App\\Models\\User', 'updated', 21, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T12:10:54.000000Z\",\"updated_at\":\"2025-12-31T12:10:54.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T03:55:45.000000Z\",\"updated_at\":\"2025-12-31T03:57:05.000000Z\"}}', NULL, '2025-12-31 05:10:54', '2025-12-31 05:10:54'),
(156, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T15:21:16.000000Z\",\"updated_at\":\"2025-12-31T15:21:16.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T11:51:50.000000Z\",\"updated_at\":\"2025-12-31T11:51:50.000000Z\"}}', NULL, '2025-12-31 08:21:17', '2025-12-31 08:21:17'),
(157, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T15:21:43.000000Z\",\"updated_at\":\"2025-12-31T15:21:43.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T15:21:16.000000Z\",\"updated_at\":\"2025-12-31T15:21:16.000000Z\"}}', NULL, '2025-12-31 08:21:43', '2025-12-31 08:21:43'),
(158, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T15:40:04.000000Z\",\"updated_at\":\"2025-12-31T15:40:04.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T04:05:53.000000Z\",\"updated_at\":\"2025-12-31T04:05:53.000000Z\"}}', NULL, '2025-12-31 08:40:04', '2025-12-31 08:40:04'),
(159, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T16:00:50.000000Z\",\"updated_at\":\"2025-12-31T16:00:50.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T15:21:43.000000Z\",\"updated_at\":\"2025-12-31T15:21:43.000000Z\"}}', NULL, '2025-12-31 09:00:51', '2025-12-31 09:00:51'),
(160, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T16:03:02.000000Z\",\"updated_at\":\"2025-12-31T16:03:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T15:40:04.000000Z\",\"updated_at\":\"2025-12-31T15:40:04.000000Z\"}}', NULL, '2025-12-31 09:03:02', '2025-12-31 09:03:02'),
(161, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2025-12-31T23:49:18.000000Z\",\"updated_at\":\"2025-12-31T23:49:18.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T16:00:50.000000Z\",\"updated_at\":\"2025-12-31T16:00:50.000000Z\"}}', NULL, '2025-12-31 16:49:18', '2025-12-31 16:49:18'),
(162, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T00:11:02.000000Z\",\"updated_at\":\"2026-01-01T00:11:02.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T16:03:02.000000Z\",\"updated_at\":\"2025-12-31T16:03:02.000000Z\"}}', NULL, '2025-12-31 17:11:02', '2025-12-31 17:11:02'),
(163, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T00:24:20.000000Z\",\"updated_at\":\"2026-01-01T00:24:20.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T23:49:18.000000Z\",\"updated_at\":\"2025-12-31T23:49:18.000000Z\"}}', NULL, '2025-12-31 17:24:20', '2025-12-31 17:24:20'),
(164, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T01:09:53.000000Z\",\"updated_at\":\"2026-01-01T01:09:53.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T00:11:02.000000Z\",\"updated_at\":\"2026-01-01T00:11:02.000000Z\"}}', NULL, '2025-12-31 18:09:53', '2025-12-31 18:09:53'),
(165, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T03:33:08.000000Z\",\"updated_at\":\"2026-01-01T03:33:08.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T00:24:20.000000Z\",\"updated_at\":\"2026-01-01T00:24:20.000000Z\"}}', NULL, '2025-12-31 20:33:09', '2025-12-31 20:33:09'),
(166, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T03:48:30.000000Z\",\"updated_at\":\"2026-01-01T03:48:31.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T01:09:53.000000Z\",\"updated_at\":\"2026-01-01T01:09:53.000000Z\"}}', NULL, '2025-12-31 20:48:31', '2025-12-31 20:48:31'),
(167, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T06:29:12.000000Z\",\"updated_at\":\"2026-01-01T06:29:12.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T03:48:30.000000Z\",\"updated_at\":\"2026-01-01T03:48:31.000000Z\"}}', NULL, '2025-12-31 23:29:13', '2025-12-31 23:29:13'),
(168, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T06:32:02.000000Z\",\"updated_at\":\"2026-01-01T06:32:02.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T03:33:08.000000Z\",\"updated_at\":\"2026-01-01T03:33:08.000000Z\"}}', NULL, '2025-12-31 23:32:02', '2025-12-31 23:32:02'),
(169, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T08:57:57.000000Z\",\"updated_at\":\"2026-01-01T08:57:58.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T06:32:02.000000Z\",\"updated_at\":\"2026-01-01T06:32:02.000000Z\"}}', NULL, '2026-01-01 01:57:58', '2026-01-01 01:57:58'),
(170, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T10:46:14.000000Z\",\"updated_at\":\"2026-01-01T10:46:14.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T08:57:57.000000Z\",\"updated_at\":\"2026-01-01T08:57:58.000000Z\"}}', NULL, '2026-01-01 03:46:15', '2026-01-01 03:46:15'),
(171, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$CLHe7j4r461NF0NEXEJH0OZqh91eINXwZhBTpeYEcbGpHmRzZJE9.\",\"updated_at\":\"2026-01-01T10:55:09.000000Z\"},\"old\":{\"password\":\"$2y$12$C8L128kMhF9ZIFsmEENWeeteqNpQzIGIAOZFkwek.5c7VE9d07eee\",\"updated_at\":\"2025-12-31T04:10:54.000000Z\"}}', NULL, '2026-01-01 03:55:09', '2026-01-01 03:55:09'),
(172, 'user', 'Sistem memperbarui akun user MUNAWIR', 'App\\Models\\User', 'updated', 12, NULL, NULL, '{\"attributes\":{\"password\":\"$2y$12$Uh.5qUgzCH5anrXwjFSr7OIFR4lshbwGJCLznhrE.t9nPe5KpAHxC\",\"updated_at\":\"2026-01-01T10:56:53.000000Z\"},\"old\":{\"password\":\"$2y$12$CLHe7j4r461NF0NEXEJH0OZqh91eINXwZhBTpeYEcbGpHmRzZJE9.\",\"updated_at\":\"2026-01-01T10:55:09.000000Z\"}}', NULL, '2026-01-01 03:56:53', '2026-01-01 03:56:53'),
(173, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T10:58:33.000000Z\",\"updated_at\":\"2026-01-01T10:58:33.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T10:46:14.000000Z\",\"updated_at\":\"2026-01-01T10:46:14.000000Z\"}}', NULL, '2026-01-01 03:58:33', '2026-01-01 03:58:33'),
(174, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T11:06:20.000000Z\",\"updated_at\":\"2026-01-01T11:06:20.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T10:58:33.000000Z\",\"updated_at\":\"2026-01-01T10:58:33.000000Z\"}}', NULL, '2026-01-01 04:06:20', '2026-01-01 04:06:20'),
(175, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T12:27:30.000000Z\",\"updated_at\":\"2026-01-01T12:27:30.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T11:06:20.000000Z\",\"updated_at\":\"2026-01-01T11:06:20.000000Z\"}}', NULL, '2026-01-01 05:27:31', '2026-01-01 05:27:31'),
(176, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T12:30:23.000000Z\",\"updated_at\":\"2026-01-01T12:30:23.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T12:27:30.000000Z\",\"updated_at\":\"2026-01-01T12:27:30.000000Z\"}}', NULL, '2026-01-01 05:30:23', '2026-01-01 05:30:23'),
(177, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T15:21:13.000000Z\",\"updated_at\":\"2026-01-01T15:21:13.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T12:30:23.000000Z\",\"updated_at\":\"2026-01-01T12:30:23.000000Z\"}}', NULL, '2026-01-01 08:21:14', '2026-01-01 08:21:14'),
(178, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T15:34:59.000000Z\",\"updated_at\":\"2026-01-01T15:34:59.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T15:21:13.000000Z\",\"updated_at\":\"2026-01-01T15:21:13.000000Z\"}}', NULL, '2026-01-01 08:34:59', '2026-01-01 08:34:59'),
(179, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T21:18:14.000000Z\",\"updated_at\":\"2026-01-01T21:18:14.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T15:34:59.000000Z\",\"updated_at\":\"2026-01-01T15:34:59.000000Z\"}}', NULL, '2026-01-01 14:18:15', '2026-01-01 14:18:15'),
(180, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T23:38:37.000000Z\",\"updated_at\":\"2026-01-01T23:38:37.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T21:18:14.000000Z\",\"updated_at\":\"2026-01-01T21:18:14.000000Z\"}}', NULL, '2026-01-01 16:38:37', '2026-01-01 16:38:37'),
(181, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-01T23:55:13.000000Z\",\"updated_at\":\"2026-01-01T23:55:13.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T23:38:37.000000Z\",\"updated_at\":\"2026-01-01T23:38:37.000000Z\"}}', NULL, '2026-01-01 16:55:13', '2026-01-01 16:55:13'),
(182, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-02T02:33:12.000000Z\",\"updated_at\":\"2026-01-02T02:33:12.000000Z\"},\"old\":{\"last_login\":\"2026-01-01T23:55:13.000000Z\",\"updated_at\":\"2026-01-01T23:55:13.000000Z\"}}', NULL, '2026-01-01 19:33:12', '2026-01-01 19:33:12'),
(183, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-02T02:35:06.000000Z\",\"updated_at\":\"2026-01-02T02:35:06.000000Z\"},\"old\":{\"last_login\":\"2026-01-02T02:33:12.000000Z\",\"updated_at\":\"2026-01-02T02:33:12.000000Z\"}}', NULL, '2026-01-01 19:35:06', '2026-01-01 19:35:06'),
(184, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-02T06:12:41.000000Z\",\"updated_at\":\"2026-01-02T06:12:41.000000Z\"},\"old\":{\"last_login\":\"2026-01-02T02:35:06.000000Z\",\"updated_at\":\"2026-01-02T02:35:06.000000Z\"}}', NULL, '2026-01-01 23:12:41', '2026-01-01 23:12:41'),
(185, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-02T13:37:20.000000Z\",\"updated_at\":\"2026-01-02T13:37:20.000000Z\"},\"old\":{\"last_login\":\"2026-01-02T06:12:41.000000Z\",\"updated_at\":\"2026-01-02T06:12:41.000000Z\"}}', NULL, '2026-01-02 06:37:21', '2026-01-02 06:37:21'),
(186, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-02T22:16:00.000000Z\",\"updated_at\":\"2026-01-02T22:16:00.000000Z\"},\"old\":{\"last_login\":\"2026-01-02T13:37:20.000000Z\",\"updated_at\":\"2026-01-02T13:37:20.000000Z\"}}', NULL, '2026-01-02 15:16:00', '2026-01-02 15:16:00'),
(187, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-03T01:56:02.000000Z\",\"updated_at\":\"2026-01-03T01:56:02.000000Z\"},\"old\":{\"last_login\":\"2026-01-02T22:16:00.000000Z\",\"updated_at\":\"2026-01-02T22:16:00.000000Z\"}}', NULL, '2026-01-02 18:56:03', '2026-01-02 18:56:03'),
(188, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-03T10:35:08.000000Z\",\"updated_at\":\"2026-01-03T10:35:08.000000Z\"},\"old\":{\"last_login\":\"2026-01-03T01:56:02.000000Z\",\"updated_at\":\"2026-01-03T01:56:02.000000Z\"}}', NULL, '2026-01-03 03:35:08', '2026-01-03 03:35:08'),
(189, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-03T13:25:01.000000Z\",\"updated_at\":\"2026-01-03T13:25:01.000000Z\"},\"old\":{\"last_login\":\"2026-01-03T10:35:08.000000Z\",\"updated_at\":\"2026-01-03T10:35:08.000000Z\"}}', NULL, '2026-01-03 06:25:02', '2026-01-03 06:25:02'),
(190, 'user', 'Sistem membuat akun user Ustadz Test', 'App\\Models\\User', 'created', 24, NULL, NULL, '{\"attributes\":{\"id\":24,\"kelas_id\":null,\"name\":\"Ustadz Test\",\"email\":\"ustadz_test@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$K5eDoFdHzdIoPqUxnMfJDewhVLmRzGXWnGVD6UYFGXfmpEFaSDYwy\",\"role\":\"USTADZ\",\"nis\":null,\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2026-01-03T15:21:55.000000Z\",\"updated_at\":\"2026-01-03T15:21:55.000000Z\"}}', NULL, '2026-01-03 08:21:57', '2026-01-03 08:21:57'),
(191, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-03T22:19:26.000000Z\",\"updated_at\":\"2026-01-03T22:19:26.000000Z\"},\"old\":{\"last_login\":\"2026-01-03T13:25:01.000000Z\",\"updated_at\":\"2026-01-03T13:25:01.000000Z\"}}', NULL, '2026-01-03 15:19:27', '2026-01-03 15:19:27'),
(192, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T01:28:44.000000Z\",\"updated_at\":\"2026-01-04T01:28:44.000000Z\"},\"old\":{\"last_login\":\"2026-01-03T22:19:26.000000Z\",\"updated_at\":\"2026-01-03T22:19:26.000000Z\"}}', NULL, '2026-01-03 18:28:45', '2026-01-03 18:28:45'),
(193, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:12:51.000000Z\",\"updated_at\":\"2026-01-04T09:12:51.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T01:28:44.000000Z\",\"updated_at\":\"2026-01-04T01:28:44.000000Z\"}}', NULL, '2026-01-04 02:12:51', '2026-01-04 02:12:51'),
(194, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:12:53.000000Z\",\"updated_at\":\"2026-01-04T09:12:53.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:12:51.000000Z\",\"updated_at\":\"2026-01-04T09:12:51.000000Z\"}}', NULL, '2026-01-04 02:12:53', '2026-01-04 02:12:53'),
(195, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:12:55.000000Z\",\"updated_at\":\"2026-01-04T09:12:55.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:12:53.000000Z\",\"updated_at\":\"2026-01-04T09:12:53.000000Z\"}}', NULL, '2026-01-04 02:12:55', '2026-01-04 02:12:55'),
(196, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:12:57.000000Z\",\"updated_at\":\"2026-01-04T09:12:57.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:12:55.000000Z\",\"updated_at\":\"2026-01-04T09:12:55.000000Z\"}}', NULL, '2026-01-04 02:12:57', '2026-01-04 02:12:57'),
(197, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:12:59.000000Z\",\"updated_at\":\"2026-01-04T09:12:59.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:12:57.000000Z\",\"updated_at\":\"2026-01-04T09:12:57.000000Z\"}}', NULL, '2026-01-04 02:12:59', '2026-01-04 02:12:59'),
(198, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:13:02.000000Z\",\"updated_at\":\"2026-01-04T09:13:02.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:12:59.000000Z\",\"updated_at\":\"2026-01-04T09:12:59.000000Z\"}}', NULL, '2026-01-04 02:13:02', '2026-01-04 02:13:02'),
(199, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T09:13:04.000000Z\",\"updated_at\":\"2026-01-04T09:13:04.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:13:02.000000Z\",\"updated_at\":\"2026-01-04T09:13:02.000000Z\"}}', NULL, '2026-01-04 02:13:04', '2026-01-04 02:13:04'),
(200, 'user', 'Sistem membuat akun user Ustadz Test', 'App\\Models\\User', 'created', 25, NULL, NULL, '{\"attributes\":{\"id\":25,\"kelas_id\":null,\"name\":\"Ustadz Test\",\"email\":\"ustadz_test@tpq.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$b.uUqVbO6iuwQ0yfx7r2bOxrXwMZil2PUU1\\/\\/OmYVez\\/946O0lNjm\",\"role\":\"USTADZ\",\"nis\":null,\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2026-01-04T12:26:48.000000Z\",\"updated_at\":\"2026-01-04T12:26:48.000000Z\"}}', NULL, '2026-01-04 05:26:49', '2026-01-04 05:26:49'),
(201, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T19:08:30.000000Z\",\"updated_at\":\"2026-01-04T19:08:30.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T09:13:04.000000Z\",\"updated_at\":\"2026-01-04T09:13:04.000000Z\"}}', NULL, '2026-01-04 12:08:30', '2026-01-04 12:08:30'),
(202, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-04T23:40:39.000000Z\",\"updated_at\":\"2026-01-04T23:40:39.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T19:08:30.000000Z\",\"updated_at\":\"2026-01-04T19:08:30.000000Z\"}}', NULL, '2026-01-04 16:40:40', '2026-01-04 16:40:40'),
(203, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-05T07:22:31.000000Z\",\"updated_at\":\"2026-01-05T07:22:31.000000Z\"},\"old\":{\"last_login\":\"2026-01-04T23:40:39.000000Z\",\"updated_at\":\"2026-01-04T23:40:39.000000Z\"}}', NULL, '2026-01-05 00:22:32', '2026-01-05 00:22:32'),
(204, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-05T10:47:39.000000Z\",\"updated_at\":\"2026-01-05T10:47:39.000000Z\"},\"old\":{\"last_login\":\"2026-01-05T07:22:31.000000Z\",\"updated_at\":\"2026-01-05T07:22:31.000000Z\"}}', NULL, '2026-01-05 03:47:40', '2026-01-05 03:47:40'),
(205, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-05T11:55:02.000000Z\",\"updated_at\":\"2026-01-05T11:55:02.000000Z\"},\"old\":{\"last_login\":\"2026-01-05T10:47:39.000000Z\",\"updated_at\":\"2026-01-05T10:47:39.000000Z\"}}', NULL, '2026-01-05 04:55:03', '2026-01-05 04:55:03'),
(206, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-05T23:06:17.000000Z\",\"updated_at\":\"2026-01-05T23:06:17.000000Z\"},\"old\":{\"last_login\":\"2026-01-05T11:55:02.000000Z\",\"updated_at\":\"2026-01-05T11:55:02.000000Z\"}}', NULL, '2026-01-05 16:06:18', '2026-01-05 16:06:18'),
(207, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T04:29:23.000000Z\",\"updated_at\":\"2026-01-06T04:29:23.000000Z\"},\"old\":{\"last_login\":\"2026-01-05T23:06:17.000000Z\",\"updated_at\":\"2026-01-05T23:06:17.000000Z\"}}', NULL, '2026-01-05 21:29:24', '2026-01-05 21:29:24'),
(208, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T07:10:16.000000Z\",\"updated_at\":\"2026-01-06T07:10:16.000000Z\"},\"old\":{\"last_login\":\"2026-01-05T21:29:23.000000Z\",\"updated_at\":\"2026-01-05T21:29:23.000000Z\"}}', NULL, '2026-01-06 07:10:16', '2026-01-06 07:10:16'),
(209, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T07:14:33.000000Z\",\"updated_at\":\"2026-01-06T07:14:33.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T07:10:16.000000Z\",\"updated_at\":\"2026-01-06T07:10:16.000000Z\"}}', NULL, '2026-01-06 07:14:33', '2026-01-06 07:14:33'),
(210, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T07:25:21.000000Z\",\"updated_at\":\"2026-01-06T07:25:21.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T07:14:33.000000Z\",\"updated_at\":\"2026-01-06T07:14:33.000000Z\"}}', NULL, '2026-01-06 07:25:21', '2026-01-06 07:25:21'),
(211, 'user', 'Sistem membuat akun user Fuad', 'App\\Models\\User', 'created', 26, NULL, NULL, '{\"attributes\":{\"id\":26,\"kelas_id\":null,\"name\":\"Fuad\",\"email\":\"fuad@gmail.com\",\"photo\":null,\"email_verified_at\":null,\"password\":\"$2y$12$YcZwH375Rlg6fsi10JgWsex6YRC6vTU7BbD9XOnxecaqdDQDv11p2\",\"role\":\"USTADZ\",\"instansi\":null,\"nis\":null,\"nip\":null,\"pembimbing_nip\":null,\"no_hp\":null,\"alamat\":null,\"foto\":null,\"status\":\"AKTIF\",\"last_login\":null,\"fcm_token\":null,\"remember_token\":null,\"created_at\":\"2026-01-06T08:09:05.000000Z\",\"updated_at\":\"2026-01-06T08:09:05.000000Z\"}}', NULL, '2026-01-06 08:09:05', '2026-01-06 08:09:05'),
(212, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T09:32:00.000000Z\",\"updated_at\":\"2026-01-06T09:32:00.000000Z\"},\"old\":{\"last_login\":null,\"updated_at\":\"2026-01-06T08:09:05.000000Z\"}}', NULL, '2026-01-06 09:32:00', '2026-01-06 09:32:00'),
(213, 'user', 'Sistem memperbarui akun user GALIH', 'App\\Models\\User', 'updated', 22, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T09:38:11.000000Z\",\"updated_at\":\"2026-01-06T09:38:11.000000Z\"},\"old\":{\"last_login\":\"2025-12-31T23:29:12.000000Z\",\"updated_at\":\"2025-12-31T23:29:12.000000Z\"}}', NULL, '2026-01-06 09:38:11', '2026-01-06 09:38:11'),
(214, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T14:26:10.000000Z\",\"updated_at\":\"2026-01-06T14:26:10.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T09:32:00.000000Z\",\"updated_at\":\"2026-01-06T09:32:00.000000Z\"}}', NULL, '2026-01-06 14:26:11', '2026-01-06 14:26:11'),
(215, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T14:38:14.000000Z\",\"updated_at\":\"2026-01-06T14:38:14.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T14:26:10.000000Z\",\"updated_at\":\"2026-01-06T14:26:10.000000Z\"}}', NULL, '2026-01-06 14:38:14', '2026-01-06 14:38:14'),
(216, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T15:07:07.000000Z\",\"updated_at\":\"2026-01-06T15:07:07.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T14:38:14.000000Z\",\"updated_at\":\"2026-01-06T14:38:14.000000Z\"}}', NULL, '2026-01-06 15:07:07', '2026-01-06 15:07:07'),
(217, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T21:23:24.000000Z\",\"updated_at\":\"2026-01-06T21:23:25.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T15:07:07.000000Z\",\"updated_at\":\"2026-01-06T15:07:07.000000Z\"}}', NULL, '2026-01-06 21:23:25', '2026-01-06 21:23:25'),
(218, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T23:40:31.000000Z\",\"updated_at\":\"2026-01-06T23:40:31.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T21:23:24.000000Z\",\"updated_at\":\"2026-01-06T21:23:25.000000Z\"}}', NULL, '2026-01-06 23:40:32', '2026-01-06 23:40:32'),
(219, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-06T23:43:18.000000Z\",\"updated_at\":\"2026-01-06T23:43:18.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T23:40:31.000000Z\",\"updated_at\":\"2026-01-06T23:40:31.000000Z\"}}', NULL, '2026-01-06 23:43:18', '2026-01-06 23:43:18'),
(220, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T00:03:59.000000Z\",\"updated_at\":\"2026-01-07T00:03:59.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T23:43:18.000000Z\",\"updated_at\":\"2026-01-06T23:43:18.000000Z\"}}', NULL, '2026-01-07 00:03:59', '2026-01-07 00:03:59'),
(221, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T00:06:11.000000Z\",\"updated_at\":\"2026-01-07T00:06:11.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T00:03:59.000000Z\",\"updated_at\":\"2026-01-07T00:03:59.000000Z\"}}', NULL, '2026-01-07 00:06:11', '2026-01-07 00:06:11'),
(222, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T00:14:58.000000Z\",\"updated_at\":\"2026-01-07T00:14:58.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T00:06:11.000000Z\",\"updated_at\":\"2026-01-07T00:06:11.000000Z\"}}', NULL, '2026-01-07 00:14:58', '2026-01-07 00:14:58'),
(223, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T00:32:24.000000Z\",\"updated_at\":\"2026-01-07T00:32:24.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T00:14:58.000000Z\",\"updated_at\":\"2026-01-07T00:14:58.000000Z\"}}', NULL, '2026-01-07 00:32:24', '2026-01-07 00:32:24'),
(224, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T00:37:17.000000Z\",\"updated_at\":\"2026-01-07T00:37:17.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T00:32:24.000000Z\",\"updated_at\":\"2026-01-07T00:32:24.000000Z\"}}', NULL, '2026-01-07 00:37:17', '2026-01-07 00:37:17'),
(225, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T01:11:52.000000Z\",\"updated_at\":\"2026-01-07T01:11:52.000000Z\"},\"old\":{\"last_login\":\"2026-01-06T07:25:21.000000Z\",\"updated_at\":\"2026-01-06T07:25:21.000000Z\"}}', NULL, '2026-01-07 01:11:52', '2026-01-07 01:11:52'),
(226, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T01:36:30.000000Z\",\"updated_at\":\"2026-01-07T01:36:30.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T01:11:52.000000Z\",\"updated_at\":\"2026-01-07T01:11:52.000000Z\"}}', NULL, '2026-01-07 01:36:30', '2026-01-07 01:36:30'),
(227, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T03:53:59.000000Z\",\"updated_at\":\"2026-01-07T03:54:00.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T00:37:17.000000Z\",\"updated_at\":\"2026-01-07T00:37:17.000000Z\"}}', NULL, '2026-01-07 03:54:00', '2026-01-07 03:54:00'),
(228, 'user', 'Sistem memperbarui akun user ALDI', 'App\\Models\\User', 'updated', 23, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T04:15:43.000000Z\",\"updated_at\":\"2026-01-07T04:15:43.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T01:36:30.000000Z\",\"updated_at\":\"2026-01-07T01:36:30.000000Z\"}}', NULL, '2026-01-07 04:15:43', '2026-01-07 04:15:43'),
(229, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T07:33:37.000000Z\",\"updated_at\":\"2026-01-07T07:33:37.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T03:53:59.000000Z\",\"updated_at\":\"2026-01-07T03:54:00.000000Z\"}}', NULL, '2026-01-07 07:33:37', '2026-01-07 07:33:37'),
(230, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T09:01:26.000000Z\",\"updated_at\":\"2026-01-07T09:01:26.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T07:33:37.000000Z\",\"updated_at\":\"2026-01-07T07:33:37.000000Z\"}}', NULL, '2026-01-07 09:01:26', '2026-01-07 09:01:26'),
(231, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T10:42:13.000000Z\",\"updated_at\":\"2026-01-07T10:42:13.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T09:01:26.000000Z\",\"updated_at\":\"2026-01-07T09:01:26.000000Z\"}}', NULL, '2026-01-07 10:42:13', '2026-01-07 10:42:13'),
(232, 'user', 'Sistem memperbarui akun user Fuad', 'App\\Models\\User', 'updated', 26, NULL, NULL, '{\"attributes\":{\"last_login\":\"2026-01-07T10:49:03.000000Z\",\"updated_at\":\"2026-01-07T10:49:03.000000Z\"},\"old\":{\"last_login\":\"2026-01-07T10:42:13.000000Z\",\"updated_at\":\"2026-01-07T10:42:13.000000Z\"}}', NULL, '2026-01-07 10:49:04', '2026-01-07 10:49:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log_verifications`
--

CREATE TABLE `activity_log_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hash` varchar(255) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `context_type` varchar(255) NOT NULL,
  `context_key` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `generated_by` bigint(20) UNSIGNED NOT NULL,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log_verifications`
--

INSERT INTO `activity_log_verifications` (`id`, `hash`, `document_number`, `context_type`, `context_key`, `file_name`, `generated_by`, `generated_at`, `created_at`, `updated_at`) VALUES
(2, '04b8e15d-3626-4dab-b893-5988f2b97a34', '', '', '', 'laporan-activity-santri-desember-2025.pdf', 1, '2025-12-12 02:17:54', '2025-12-12 02:17:54', '2025-12-12 02:17:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akhlak_santri`
--

CREATE TABLE `akhlak_santri` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `disiplin` tinyint(3) UNSIGNED NOT NULL COMMENT '1–5',
  `kerajinan` tinyint(3) UNSIGNED NOT NULL COMMENT '1–5',
  `kesopanan` tinyint(3) UNSIGNED NOT NULL COMMENT '1–5',
  `catatan` text DEFAULT NULL,
  `tanggal_penilaian` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `broadcasts`
--

CREATE TABLE `broadcasts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sent_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_private`
--

CREATE TABLE `chat_private` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `type` enum('text','image','audio') NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `gaji`
--

CREATE TABLE `gaji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah_kehadiran` int(11) DEFAULT NULL,
  `nominal_per_pertemuan` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_messages`
--

CREATE TABLE `group_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `status` varchar(255) NOT NULL DEFAULT 'sent',
  `read_by` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`read_by`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_message_reads`
--

CREATE TABLE `group_message_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_message_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hafalan`
--

CREATE TABLE `hafalan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `surah` varchar(255) NOT NULL,
  `ayat_awal` int(11) NOT NULL,
  `ayat_akhir` int(11) NOT NULL,
  `nilai` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hafalan`
--

INSERT INTO `hafalan` (`id`, `santri_id`, `ustadz_id`, `surah`, `ayat_awal`, `ayat_akhir`, `nilai`, `catatan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 22, 23, 'An-Naba', 1, 19, 'Jayyid', 'bacaannya kurang lancar perhatikan panjang pendek', '2025-12-31', '2025-12-31 09:02:15', '2025-12-31 09:02:15'),
(2, 21, 23, 'An-Naba', 1, 4, 'Lancar', 'lancarkan lagi ya ngafal di rumahnya', '2026-01-01', '2025-12-31 17:54:48', '2025-12-31 17:54:48'),
(3, 22, 23, 'An-Naba', 20, 22, 'Kurang Lancar', 'ngaji sama mama ya', '2026-01-01', '2025-12-31 18:09:13', '2025-12-31 18:09:13'),
(4, 21, 23, 'At-Takasur', 1, 5, 'Lancar', 'tingkatkan ya', '2026-01-01', '2025-12-31 23:34:21', '2025-12-31 23:34:21'),
(5, 22, 23, 'An-Naba', 23, 24, 'Sempurna', 'keren anak soleh', '2026-01-01', '2025-12-31 23:37:46', '2025-12-31 23:37:46'),
(6, 22, 23, 'An-Naba', 25, 26, 'Lancar', 'Tingkatkan ya', '2026-01-01', '2026-01-01 04:07:18', '2026-01-01 04:07:18'),
(7, 22, 23, 'An-Naba', 27, 28, 'Lancar', 'Nakal anak ibu', '2026-01-01', '2026-01-01 04:09:44', '2026-01-01 04:09:44'),
(8, 22, 23, 'An-Naba', 29, 34, 'Sangat Lancar', NULL, '2026-01-04', '2026-01-03 23:24:04', '2026-01-03 23:24:04'),
(9, 21, 23, 'At-Takasur', 6, 7, 'Sempurna', NULL, '2026-01-04', '2026-01-04 04:04:17', '2026-01-04 04:04:17'),
(10, 5, 25, 'Ali \'Imran', 1, 1, 'Tidak Lancar', NULL, '2026-01-04', '2026-01-04 06:39:04', '2026-01-04 06:39:04'),
(11, 21, 25, 'At-Takasur', 8, 8, 'Sangat Lancar', NULL, '2026-01-04', '2026-01-04 06:45:08', '2026-01-04 13:16:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `import_logs`
--

CREATE TABLE `import_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `processed` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `infaq`
--

CREATE TABLE `infaq` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_mengajar`
--

CREATE TABLE `jadwal_mengajar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ustadz_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `materi` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `kehadiran_santri`
--

CREATE TABLE `kehadiran_santri` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `jadwal_id` bigint(20) UNSIGNED NOT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu_absen` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kelas` varchar(50) NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `tingkat` varchar(50) DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama_kelas`, `tipe`, `tingkat`, `waktu_mulai`, `waktu_selesai`, `ustadz_id`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KLS-I', 'Kelas Alif Updated', 'TPQ', 'ULA', '16:00:00', '17:30:00', 1, 'Kelas dasar untuk pemula', 'nonaktif', '2025-12-12 15:01:45', '2025-12-14 03:20:11'),
(2, 'KLS-M', 'Kelas Alif Updated', 'TPQ', 'ULA', NULL, NULL, 1, 'Kelas menengah', 'nonaktif', '2025-12-12 15:01:45', '2025-12-17 20:51:57'),
(3, 'KLS-A', 'Kelas Alif', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-13 00:12:22', '2025-12-15 05:26:29'),
(4, 'KLS-C', 'Kelas Ba', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-13 00:27:28', '2025-12-15 05:26:29'),
(5, 'KLS-B', 'Kelas Ba', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-13 21:13:40', '2025-12-15 05:26:29'),
(6, 'KLS-E', 'Kelas Ba', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-14 01:50:45', '2025-12-15 05:26:29'),
(7, 'KLS-F', 'Kelas Ba', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-14 03:06:21', '2025-12-15 05:26:29'),
(8, 'KLS-H', 'Kelas Ba', 'TPQ', 'ULA', NULL, NULL, NULL, NULL, 'AKTIF', '2025-12-14 03:19:32', '2025-12-15 05:26:29'),
(9, 'KLS-J', 'Kelas Ba', NULL, 'ULA', NULL, NULL, 1, NULL, 'aktif', '2025-12-16 07:50:49', '2025-12-16 07:50:49'),
(10, 'KLS-K', 'Kelas Ba', NULL, 'ULA', NULL, NULL, 1, NULL, 'aktif', '2025-12-16 08:06:38', '2025-12-16 08:06:38'),
(11, 'KLS-G', 'Kelas Ba', NULL, 'ULA', NULL, NULL, 1, NULL, 'aktif', '2025-12-17 20:51:33', '2025-12-17 20:51:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_25_060004_create_ustadzs_table', 1),
(5, '2025_11_25_060027_create_kelas_table', 1),
(6, '2025_11_25_060045_create_santris_table', 1),
(7, '2025_11_25_060105_create_jadwal_mengajars_table', 1),
(8, '2025_11_25_060120_create_kehadiran_santris_table', 1),
(9, '2025_11_25_060134_create_progress_hafalans_table', 1),
(10, '2025_11_25_114647_create_personal_access_tokens_table', 1),
(11, '2025_11_27_032931_create_pengajars_table', 1),
(12, '2025_11_27_034514_create_setorans_table', 1),
(13, '2025_11_27_054604_create_presensi_table', 1),
(14, '2025_11_27_054957_create_infaq_table', 1),
(15, '2025_11_27_062748_create_chats_table', 1),
(16, '2025_11_27_064447_create_gajis_table', 1),
(17, '2025_11_27_073734_create_groups_table', 1),
(18, '2025_11_28_021032_create_group_members_table', 1),
(19, '2025_11_28_021252_create_group_messages_table', 1),
(20, '2025_11_29_115306_add_read_by_to_group_messages_table', 1),
(21, '2025_11_30_023247_add_photo_to_users_table', 1),
(22, '2025_11_30_154258_add_status_to_group_messages', 1),
(23, '2025_12_03_231601_add_fields_to_gaji_table', 1),
(24, '2025_12_03_235519_add_fields_to_setoran_table', 1),
(25, '2025_12_04_003608_create_progress_hafalans_table', 1),
(26, '2025_12_04_012051_add_fields_to_kehadiran_santri_table', 1),
(27, '2025_12_04_034442_add_fields_to_users_table', 1),
(28, '2025_12_04_052240_add_user_id_to_santri_table', 1),
(29, '2025_12_06_211348_add_user_id_to_kehadiran_santri_table', 1),
(30, '2025_12_08_060753_create_group_message_reads_table', 1),
(31, '2025_12_08_065800_create_chat_private_table', 1),
(32, '2025_12_09_004855_create_activity_log_table', 2),
(33, '2025_12_09_004856_add_event_column_to_activity_log_table', 2),
(34, '2025_12_09_004857_add_batch_uuid_column_to_activity_log_table', 2),
(35, '2025_12_10_025617_create_akhlak_santri_table', 3),
(36, '2025_12_10_035249_create_nilai_ujian_table', 3),
(37, '2025_12_10_041434_create_user_tokens_table', 3),
(38, '2025_12_11_065832_create_broadcasts_table', 3),
(40, '2025_12_12_070232_add_indexes_to_activity_log_table', 4),
(41, '2025_12_12_085323_create_activity_log_verifications_table', 5),
(42, '2025_12_12_094325_add_document_number_to_activity_log_verifications', 6),
(43, '2025_12_12_094818_create_verification_scans_table', 7),
(44, '2025_12_12_102143_add_context_to_activity_log_verifications', 8),
(45, '2025_12_12_121447_alter_user_tokens_fcm_token_nullable', 9),
(46, '2025_12_12_140804_add_kelas_id_to_users_table', 10),
(47, '2025_12_12_220054_add_status_to_kelas_table', 11),
(48, '2025_12_15_143358_create_import_logs_table', 12),
(49, '2025_12_16_211649_add_index_to_kelas_table', 13),
(50, '2025_12_28_103139_add_password_to_santri_table', 14),
(51, '2025_12_28_132824_add_nis_to_users_table', 15),
(52, '2025_12_29_000001_create_notifications_table', 16),
(53, '2025_12_31_154734_create_hafalan_table', 17),
(54, '2026_01_05_000000_add_indexes_to_presensi_table', 18),
(55, '2026_01_05_034809_add_nip_columns_to_users_table', 19),
(56, '2026_01_06_040428_add_instansi_to_users_table', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_ujian`
--

CREATE TABLE `nilai_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_ujian` varchar(255) NOT NULL,
  `nilai` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('22919252-d78a-4f09-8cfc-d7bc6cbd98ad', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 29-34 telah dicatat. Nilai: Sangat Lancar\\\",\\\"hafalan_id\\\":8}\"', NULL, '2026-01-03 23:24:07', '2026-01-03 23:24:07'),
('2d501fe5-79b6-4c9c-8ef0-7befa05344b4', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 23-24 telah dicatat. Nilai: Sempurna\\\",\\\"hafalan_id\\\":5}\"', NULL, '2025-12-31 23:37:46', '2025-12-31 23:37:46'),
('7c05a8df-27c0-41b2-a290-36f9bfa4d84a', 'hafalan', 'App\\Models\\User', 21, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran At-Takasur ayat 1-5 telah dicatat. Nilai: Lancar\\\",\\\"hafalan_id\\\":4}\"', NULL, '2025-12-31 23:34:25', '2025-12-31 23:34:25'),
('7ea3908e-6830-468b-96d7-296d45ca47df', 'hafalan', 'App\\Models\\User', 21, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 1-4 telah dicatat. Nilai: Lancar\\\",\\\"hafalan_id\\\":2}\"', NULL, '2025-12-31 17:54:53', '2025-12-31 17:54:53'),
('834de277-2653-4f8a-afbd-d69cfafdf00e', 'hafalan', 'App\\Models\\User', 21, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran At-Takasur ayat 6-7 telah dicatat. Nilai: Sempurna\\\",\\\"hafalan_id\\\":9}\"', NULL, '2026-01-04 04:04:20', '2026-01-04 04:04:20'),
('84df153c-96c7-44fe-b919-6d6e456e433c', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 1-19 telah dicatat. Nilai: Jayyid\\\",\\\"hafalan_id\\\":1}\"', NULL, '2025-12-31 09:02:21', '2025-12-31 09:02:21'),
('8f798fc5-d8d9-4539-a1bd-830969208fce', 'hafalan', 'App\\Models\\User', 21, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran At-Takasur ayat 8-9 telah dicatat. Nilai: Sangat Lancar\\\",\\\"hafalan_id\\\":11}\"', NULL, '2026-01-04 06:45:09', '2026-01-04 06:45:09'),
('bfb0ef25-5a81-4d4f-87c3-e381690724b4', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 20-22 telah dicatat. Nilai: Kurang Lancar\\\",\\\"hafalan_id\\\":3}\"', NULL, '2025-12-31 18:09:13', '2025-12-31 18:09:13'),
('d934eedb-bab9-49ab-9747-cd0f115efd14', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 25-26 telah dicatat. Nilai: Lancar\\\",\\\"hafalan_id\\\":6}\"', NULL, '2026-01-01 04:07:20', '2026-01-01 04:07:20'),
('e8cf63dd-28b9-4e3a-87f1-6624d8c50bae', 'hafalan', 'App\\Models\\User', 22, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran An-Naba ayat 27-28 telah dicatat. Nilai: Lancar\\\",\\\"hafalan_id\\\":7}\"', NULL, '2026-01-01 04:09:44', '2026-01-01 04:09:44'),
('f60913fc-a9de-479c-b8f9-f56b82e627c2', 'hafalan', 'App\\Models\\User', 5, '\"{\\\"title\\\":\\\"Setoran Hafalan Baru\\\",\\\"message\\\":\\\"Setoran Ali \'Imran ayat 1-1 telah dicatat. Nilai: Tidak Lancar\\\",\\\"hafalan_id\\\":10}\"', NULL, '2026-01-04 06:39:13', '2026-01-04 06:39:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajars`
--

CREATE TABLE `pengajars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(17, 'App\\Models\\User', 9, 'PostmanRuntime/7.51.0', 'fdc80852ac5b90def7f9b976c4c75ce479dcfaa5f78f414c251ddb47aad6bc1e', '[\"*\"]', '2025-12-17 06:49:29', '2025-12-24 01:04:49', '2025-12-17 01:04:49', '2025-12-17 06:49:29'),
(18, 'App\\Models\\User', 9, 'PostmanRuntime/7.51.0', '7c17fea760ae0692ac4d79a155ae79fe346285c08fa688cb1d56d56f834ab19b', '[\"*\"]', NULL, '2025-12-24 20:43:54', '2025-12-17 20:43:54', '2025-12-17 20:43:54'),
(19, 'App\\Models\\User', 11, 'PostmanRuntime/7.51.0', '6c6ce70addd4a9d8067825c56f2dff93b872a8e8411f556d0bfe1a301464944e', '[\"*\"]', '2025-12-17 22:48:45', '2025-12-24 20:44:12', '2025-12-17 20:44:12', '2025-12-17 22:48:45'),
(20, 'App\\Models\\User', 11, 'PostmanRuntime/7.51.0', '8f585ae778fa5329a25fb2d2ea40383ee8c897ae438b4e5c77fdc6e151ef06bb', '[\"*\"]', '2025-12-18 00:05:36', '2025-12-24 22:49:16', '2025-12-17 22:49:16', '2025-12-18 00:05:36'),
(21, 'App\\Models\\User', 3, 'curl/8.13.0', '2ca128782a29586a8617f0b99c879eebb2f79549f2573b2077e096f16bae2279', '[\"*\"]', '2025-12-18 19:23:56', '2025-12-24 23:58:56', '2025-12-17 23:58:56', '2025-12-18 19:23:56'),
(28, 'App\\Models\\User', 12, 'Dart/3.5 (dart:io)', 'cc1f5f445e03cf8e92c8a08391e3c3fb84cc5b5b7729564f13ebd7d90450d6a1', '[\"*\"]', '2025-12-19 01:22:03', '2025-12-25 20:10:59', '2025-12-18 20:10:59', '2025-12-19 01:22:03'),
(29, 'App\\Models\\User', 18, 'web-session', '2c6125b04c3a90095ccd784f523eeec4d117d654e6edc10361378962376e42bf', '[\"*\"]', NULL, NULL, '2025-12-28 05:36:24', '2025-12-28 05:36:24'),
(30, 'App\\Models\\User', 19, 'web-session', '25e7c5bcbac2f6d7787d33ab4db4f1a82111cfde07ccac3f5158de3c1299d114', '[\"*\"]', NULL, NULL, '2025-12-28 06:20:40', '2025-12-28 06:20:40'),
(31, 'App\\Models\\User', 20, 'web-session', 'd2e8bbff90eb9e9c3d9eccc5e1ff621f791e5e2b20c02ae46035885a13241bcf', '[\"*\"]', NULL, NULL, '2025-12-28 06:25:42', '2025-12-28 06:25:42'),
(32, 'App\\Models\\User', 21, 'web-session', 'af38116753a960a88dfdfc46a376a57d540b42ad53d7c55f96ca36f32217e6a3', '[\"*\"]', NULL, NULL, '2025-12-28 06:29:42', '2025-12-28 06:29:42'),
(33, 'App\\Models\\User', 22, 'web-session', 'be603389f4b12d22f2660aa3e5398dc29ed17a7775498aa8b8e8010837705d92', '[\"*\"]', NULL, NULL, '2025-12-28 06:51:24', '2025-12-28 06:51:24'),
(34, 'App\\Models\\User', 22, 'web-session', '4d880662ccc2562ae86030e974f73813e686499e65f7e4c82fb742a4ff6a8651', '[\"*\"]', NULL, NULL, '2025-12-28 07:10:33', '2025-12-28 07:10:33'),
(35, 'App\\Models\\User', 22, 'web-session', '266acb6956c9282ba1d5adddfa51e7776dc16107c9948ddc00780b403bd39095', '[\"*\"]', NULL, NULL, '2025-12-28 07:13:56', '2025-12-28 07:13:56'),
(36, 'App\\Models\\User', 22, 'web-session', 'c57c0cec71de4c7d4d1d3a2706bcffdd10d6ccfa18b07e4d0512b33edb53e9e4', '[\"*\"]', NULL, NULL, '2025-12-28 15:49:17', '2025-12-28 15:49:17'),
(37, 'App\\Models\\User', 22, 'web-session', 'e9dfd0f03796de8e7df98e6cc6cad86599bbf9ef7ff96b35e50644ab11c86bd8', '[\"*\"]', NULL, NULL, '2025-12-28 16:08:36', '2025-12-28 16:08:36'),
(38, 'App\\Models\\User', 22, 'web-session', 'a50b1825529ece37223127ddca9b4d6c2421cc69b1268baa429a609bb08da7ad', '[\"*\"]', NULL, NULL, '2025-12-28 16:22:02', '2025-12-28 16:22:02'),
(39, 'App\\Models\\User', 22, 'web-session', '1f5d255cc891621522459b1777042c1b3b9869b036e5b197ea440740c4aebfe2', '[\"*\"]', NULL, NULL, '2025-12-28 16:23:21', '2025-12-28 16:23:21'),
(40, 'App\\Models\\User', 22, 'web-session', 'aca0ef50313dcaeb63508cdf70cfdea673b3b17703de853cf653cd164e904b9f', '[\"*\"]', NULL, NULL, '2025-12-28 16:39:33', '2025-12-28 16:39:33'),
(41, 'App\\Models\\User', 22, 'web-session', 'a83f89fbe1aafa9c0e916a21b3ce5dd14e7f12aeb3a0c708fcb2712333e81a11', '[\"*\"]', NULL, NULL, '2025-12-28 16:40:54', '2025-12-28 16:40:54'),
(42, 'App\\Models\\User', 22, 'web-session', '8b78a1c9d0689d6e34f3d16a80910169c05c5f9c880a6ca3bbea9b73f89362ea', '[\"*\"]', NULL, NULL, '2025-12-28 19:49:36', '2025-12-28 19:49:36'),
(43, 'App\\Models\\User', 21, 'web-session', 'b08d359ae2a353f09b4571904fa151274fb55e3f0e5f5987aa923c7ad8356953', '[\"*\"]', NULL, NULL, '2025-12-28 19:58:40', '2025-12-28 19:58:40'),
(44, 'App\\Models\\User', 22, 'web-session', '8b158aabbd2fb0b6b740f3674226e8f00489c02255ae118861259326ceb78e6e', '[\"*\"]', NULL, NULL, '2025-12-28 21:22:30', '2025-12-28 21:22:30'),
(45, 'App\\Models\\User', 22, 'web-session', 'f55b1155dbeac45f9fe260bf1942ba2480ee81b6d83efff79b3b71811b46a06b', '[\"*\"]', NULL, NULL, '2025-12-28 21:24:09', '2025-12-28 21:24:09'),
(46, 'App\\Models\\User', 21, 'web-session', 'f29b0364a13c058cf24b056a5324a292af02087560f1ac04e951ab80e33d4690', '[\"*\"]', NULL, NULL, '2025-12-28 22:31:37', '2025-12-28 22:31:37'),
(47, 'App\\Models\\User', 22, 'web-session', 'a0d3d7caa094cfec86ed066a2b22bbe9d5c47c41c9744216e34f73beae4b8196', '[\"*\"]', NULL, NULL, '2025-12-29 00:06:42', '2025-12-29 00:06:42'),
(48, 'App\\Models\\User', 21, 'web-session', 'be5138a9baf764f38aa9a6d735f06f644b6a323a5c773682ed2a21a0c59fa1ce', '[\"*\"]', NULL, NULL, '2025-12-29 00:35:22', '2025-12-29 00:35:22'),
(49, 'App\\Models\\User', 22, 'web-session', '5c68aff51c7bd7ca0b3d763ac5f21de8580d1c757e79af43cff2d159d871d0d8', '[\"*\"]', NULL, NULL, '2025-12-29 03:33:22', '2025-12-29 03:33:22'),
(50, 'App\\Models\\User', 22, 'web-session', '9a581e75242cbca362b657db4a922f4ab7fafe1552296bdb922919d439094c36', '[\"*\"]', NULL, NULL, '2025-12-29 05:56:55', '2025-12-29 05:56:55'),
(51, 'App\\Models\\User', 21, 'web-session', '8a4911dc2d14f3204ab820b0c4178f4399314ce3a575ac01877680ca5215cdae', '[\"*\"]', NULL, NULL, '2025-12-29 06:06:18', '2025-12-29 06:06:18'),
(52, 'App\\Models\\User', 21, 'web-session', '940ce830a5bb5e3f3266a74813e1da40790068a6a135a970a0fe6923011e0cf7', '[\"*\"]', NULL, NULL, '2025-12-29 06:08:04', '2025-12-29 06:08:04'),
(53, 'App\\Models\\User', 12, 'web-session', '49932bd2b79e317a8491c0c3ebb1765a04b24aa1b2dc5ed7d8bfc1c8e8469cda', '[\"*\"]', NULL, NULL, '2025-12-29 06:09:51', '2025-12-29 06:09:51'),
(54, 'App\\Models\\User', 21, 'web-session', '9b98cafd07afff638eb477872277ead1fe7c5ca4294172fe1a0886504d9e9d00', '[\"*\"]', NULL, NULL, '2025-12-29 06:10:20', '2025-12-29 06:10:20'),
(55, 'App\\Models\\User', 21, 'web-session', '10c3696ad58897624ac84caa5d31fd4b36cc3d743c0bdaf60ed6e26a1e3b116b', '[\"*\"]', NULL, NULL, '2025-12-29 06:15:51', '2025-12-29 06:15:51'),
(56, 'App\\Models\\User', 12, 'web-session', '5de452024b138fa1ded08aad6f52f1907fb2ade93e5c53654b4d53395c2afd05', '[\"*\"]', NULL, NULL, '2025-12-29 06:22:23', '2025-12-29 06:22:23'),
(57, 'App\\Models\\User', 12, 'web-session', 'a4fac69875addc8499202f3b38ecaff62abb231453574d348be253d395a4f57d', '[\"*\"]', NULL, NULL, '2025-12-29 06:22:34', '2025-12-29 06:22:34'),
(58, 'App\\Models\\User', 12, 'web-session', '4cdb869507d118f59389c8f76cea672b8ab17c57c9a0da81d08b0c92e609d413', '[\"*\"]', NULL, NULL, '2025-12-29 06:37:24', '2025-12-29 06:37:24'),
(59, 'App\\Models\\User', 12, 'web-session', '998e539c74b751cdd724e9f47fd7e5b1846f565f02cc0f23d414d3d4aa97a5f2', '[\"*\"]', NULL, NULL, '2025-12-29 06:37:54', '2025-12-29 06:37:54'),
(60, 'App\\Models\\User', 12, 'web-session', '988d605a408290934c9d86d317daabc514dfa38f91725267b9858a3d59d06f71', '[\"*\"]', NULL, NULL, '2025-12-29 06:38:46', '2025-12-29 06:38:46'),
(61, 'App\\Models\\User', 22, 'web-session', '8b9076bf52aa1fbac4739d89ab582ad1c99bca94b24d44a6740dceade4021012', '[\"*\"]', NULL, NULL, '2025-12-29 06:39:17', '2025-12-29 06:39:17'),
(62, 'App\\Models\\User', 21, 'web-session', '00a138b1053812b73d2d4af7ba89f8721c83ff64cd8beb760fec5ce630b61e2a', '[\"*\"]', NULL, NULL, '2025-12-29 06:40:08', '2025-12-29 06:40:08'),
(63, 'App\\Models\\User', 12, 'web-session', 'ea22d54a5ddbbfdec4681b22785e839aed3e432b5a15c557f825bb2cabb398a6', '[\"*\"]', NULL, NULL, '2025-12-29 06:41:24', '2025-12-29 06:41:24'),
(64, 'App\\Models\\User', 12, 'web-session', '4a0b065ffb37bf7cf4c652610bfa2b0f210e2c5ead81b630f01c6cabc88ddf37', '[\"*\"]', NULL, NULL, '2025-12-29 06:42:30', '2025-12-29 06:42:30'),
(65, 'App\\Models\\User', 12, 'web-session', '41789e660446f4d7e1994840f7eff6355f3df4881a8391e8e876f355235ab4df', '[\"*\"]', NULL, NULL, '2025-12-29 06:45:55', '2025-12-29 06:45:55'),
(66, 'App\\Models\\User', 12, 'web-session', '6f2ca72fa322cd28a35428286804f856db09a8d3282198a215928d9d8939b519', '[\"*\"]', NULL, NULL, '2025-12-29 06:46:23', '2025-12-29 06:46:23'),
(67, 'App\\Models\\User', 12, 'web-session', 'd568074bc5b53fb2ef389c28cc709842f9f7b8b8cf8d608627cf02e3facfe067', '[\"*\"]', NULL, NULL, '2025-12-29 06:46:57', '2025-12-29 06:46:57'),
(68, 'App\\Models\\User', 12, 'web-session', 'dca93657797bce84bddfd6e2501fa494c945d172bae7b6c2f5c2a4e7e4aa6f9b', '[\"*\"]', NULL, NULL, '2025-12-29 22:36:54', '2025-12-29 22:36:54'),
(69, 'App\\Models\\User', 12, 'web-session', '91f6de46bbca28b1c0e6eacb07d805c54cb69e52c039318e4eba001fade74cd4', '[\"*\"]', NULL, NULL, '2025-12-29 22:37:22', '2025-12-29 22:37:22'),
(70, 'App\\Models\\User', 22, 'web-session', '30d9094b887e16ce12b7a324214dd71ba8292876f4c5991873dfe028c375ce5d', '[\"*\"]', NULL, NULL, '2025-12-29 22:38:57', '2025-12-29 22:38:57'),
(71, 'App\\Models\\User', 12, 'web-session', '539fbab09cf87a0d0f4bb74c47e2768fb632f61625b0e67bf87bd901a91826a0', '[\"*\"]', NULL, NULL, '2025-12-29 22:42:38', '2025-12-29 22:42:38'),
(72, 'App\\Models\\User', 12, 'web-session', 'd63099655baa36763069314028586cf044e2e92d858b2eedf0cfad9abda5debb', '[\"*\"]', NULL, NULL, '2025-12-29 23:33:06', '2025-12-29 23:33:06'),
(73, 'App\\Models\\User', 12, 'web-session', '74cfd008474df589d9e4e08d6b657347478ff2118e21c71c3b87d37335572c0d', '[\"*\"]', NULL, NULL, '2025-12-30 01:22:37', '2025-12-30 01:22:37'),
(74, 'App\\Models\\User', 12, 'web-session', 'c784e0bce116bde582467b967b24adc2c8480eb17d845b8f0699e7917083bc59', '[\"*\"]', NULL, NULL, '2025-12-30 01:32:00', '2025-12-30 01:32:00'),
(75, 'App\\Models\\User', 12, 'web-session', '90dec16ea4697de04f8d9605e8ea8c3961148888eec417828406c2131d64e3a9', '[\"*\"]', NULL, NULL, '2025-12-30 16:50:39', '2025-12-30 16:50:39'),
(76, 'App\\Models\\User', 22, 'web-session', 'f46697a14fdacc52d13e14a0cdf057f1c9bf4b02258386c1c48888b1b687e6e7', '[\"*\"]', NULL, NULL, '2025-12-30 16:52:02', '2025-12-30 16:52:02'),
(77, 'App\\Models\\User', 12, 'web-session', '95cc55f44a1c86d42a56d52d35d7cb4741b5e391e501df93cd27c8beb4771611', '[\"*\"]', NULL, NULL, '2025-12-30 17:25:25', '2025-12-30 17:25:25'),
(78, 'App\\Models\\User', 22, 'web-session', 'df9d0db70a99d6ffbc2d623ea02216d85ae154f1e5fe50a186e12586cb8a9a27', '[\"*\"]', NULL, NULL, '2025-12-30 17:26:41', '2025-12-30 17:26:41'),
(79, 'App\\Models\\User', 23, 'web-session', 'bebe9ec43eb30c8566214e8cb5eb9271bca1e9490df668542795a751d3142a90', '[\"*\"]', NULL, NULL, '2025-12-30 20:08:01', '2025-12-30 20:08:01'),
(80, 'App\\Models\\User', 21, 'web-session', '3cd2eac7c12e0fdb659845975528e32d552fa018a32c1522c7408955445f3ffe', '[\"*\"]', NULL, NULL, '2025-12-30 20:55:45', '2025-12-30 20:55:45'),
(81, 'App\\Models\\User', 12, 'web-session', '69f9ff45b382858230fef861221c412208f978c557462670f53a090eb396e571', '[\"*\"]', NULL, NULL, '2025-12-30 20:57:40', '2025-12-30 20:57:40'),
(82, 'App\\Models\\User', 22, 'web-session', 'ecf9d076361deb69d45691fe0ee5e847340e5346f3778fd78df1ccedc0179915', '[\"*\"]', NULL, NULL, '2025-12-30 21:05:53', '2025-12-30 21:05:53'),
(83, 'App\\Models\\User', 23, 'web-session', 'fc4ae98d776e619ddbe22c27d75e320f46199fa6fed8a3f5a32dc28980185643', '[\"*\"]', NULL, NULL, '2025-12-30 21:11:22', '2025-12-30 21:11:22'),
(84, 'App\\Models\\User', 23, 'web-session', '304723548b1c4de80c5d74763d677dcee2850ece7b36671ef1940374036d4522', '[\"*\"]', '2025-12-30 23:32:25', NULL, '2025-12-30 23:22:42', '2025-12-30 23:32:25'),
(85, 'App\\Models\\User', 23, 'web-session', 'bebc0b8dd03876ab5c5d43e837e70aa10934a3e9f19e319b1dd192ce5a3e06dc', '[\"*\"]', NULL, NULL, '2025-12-31 04:51:50', '2025-12-31 04:51:50'),
(86, 'App\\Models\\User', 21, 'web-session', '5f7e7d4bf2c1023bcab10f41cf97a7f48a3b2ca9f83fbc28bd53a37839bb1e65', '[\"*\"]', NULL, NULL, '2025-12-31 05:10:54', '2025-12-31 05:10:54'),
(87, 'App\\Models\\User', 23, 'web-session', '3fae595db8d25c2b2c31dafd7583da9cfc417da74e54899b86a2f8038d9fb2b2', '[\"*\"]', NULL, NULL, '2025-12-31 08:21:15', '2025-12-31 08:21:15'),
(88, 'App\\Models\\User', 23, 'web-session', 'd9d3dced23a4d924d9e2f1bb5f08c9163c9815b3c69b5d0ca79df2b2da1c57ce', '[\"*\"]', NULL, NULL, '2025-12-31 08:21:43', '2025-12-31 08:21:43'),
(89, 'App\\Models\\User', 22, 'web-session', '760400ffe4bd9547ac8e70824d7dfd559c59894288014ace8da60da1a4607e9f', '[\"*\"]', NULL, NULL, '2025-12-31 08:40:04', '2025-12-31 08:40:04'),
(90, 'App\\Models\\User', 23, 'web-session', '9cfe0964b883a9bf92d38580e8badf5c2fbdecbb1ff0040af4bb3c3359cba312', '[\"*\"]', NULL, NULL, '2025-12-31 09:00:49', '2025-12-31 09:00:49'),
(91, 'App\\Models\\User', 22, 'web-session', '8010b264bd97531213df8e58e3effbc7395d67bf7eb8afa2f94fb8c34ed7c519', '[\"*\"]', NULL, NULL, '2025-12-31 09:03:02', '2025-12-31 09:03:02'),
(92, 'App\\Models\\User', 23, 'web-session', '9efc9cb8c74f4b0733109bfc4a25e94ae598818b09f39ee70206b90d2cd1a2eb', '[\"*\"]', NULL, NULL, '2025-12-31 16:49:17', '2025-12-31 16:49:17'),
(93, 'App\\Models\\User', 22, 'web-session', 'e965a8bdd621df7f2b187e4da2515aee325a2359d86afb3ae75e9ed6626dfc19', '[\"*\"]', NULL, NULL, '2025-12-31 17:11:02', '2025-12-31 17:11:02'),
(94, 'App\\Models\\User', 23, 'web-session', '8274dc3497b58bbbfdb5c228a4d2a11b718587a988e62d222a8ba8c0e39904b8', '[\"*\"]', NULL, NULL, '2025-12-31 17:24:20', '2025-12-31 17:24:20'),
(95, 'App\\Models\\User', 22, 'web-session', '27ecddbda3b66d24ea9f34d12b7a7328c7bd23709ec10f94b89e7fd63dd528c7', '[\"*\"]', NULL, NULL, '2025-12-31 18:09:53', '2025-12-31 18:09:53'),
(96, 'App\\Models\\User', 23, 'web-session', '5bdb14b1c384f8e86ce43bb1756417e6994863168fc9037d891b8cf03865d6a0', '[\"*\"]', NULL, NULL, '2025-12-31 20:33:08', '2025-12-31 20:33:08'),
(97, 'App\\Models\\User', 22, 'web-session', '08b6736bc465c139b275ad64fe426b6fdf561742ba701331f654b31d1121664a', '[\"*\"]', NULL, NULL, '2025-12-31 20:48:30', '2025-12-31 20:48:30'),
(98, 'App\\Models\\User', 22, 'web-session', '256ef750aba96505313a5b44a1705ce9fb9ad8bf6571c3ebfd29a304afe18f38', '[\"*\"]', NULL, NULL, '2025-12-31 23:29:12', '2025-12-31 23:29:12'),
(99, 'App\\Models\\User', 23, 'web-session', '8532fdd18f2d1f3df0533c58ef67fe8784083adeea1793aadcb3aa2e3465d24a', '[\"*\"]', NULL, NULL, '2025-12-31 23:32:02', '2025-12-31 23:32:02'),
(100, 'App\\Models\\User', 23, 'web-session', '93e4d0c522a319238ba22eacbd5f33e86a45485b5611498b2aaf14e1f2cf4265', '[\"*\"]', NULL, NULL, '2026-01-01 01:57:57', '2026-01-01 01:57:57'),
(101, 'App\\Models\\User', 23, 'web-session', 'f4a41c84b7725d392d62ce1e6707c7025d5804e56e5f92caf448d9d7822ffbaf', '[\"*\"]', NULL, NULL, '2026-01-01 03:46:14', '2026-01-01 03:46:14'),
(102, 'App\\Models\\User', 23, 'web-session', '7491943aac716edefa7b20d9da88f8e9fff57080c9d56ce45fefa93d2e76bf33', '[\"*\"]', NULL, NULL, '2026-01-01 03:58:33', '2026-01-01 03:58:33'),
(103, 'App\\Models\\User', 23, 'web-session', '57ca8a4c7e7d4f498576d504b01871a18274ed55ecf850965ff8a7b1eb874665', '[\"*\"]', NULL, NULL, '2026-01-01 04:06:20', '2026-01-01 04:06:20'),
(104, 'App\\Models\\User', 23, 'web-session', 'b7ce01567700f16e3a20186936c7298824791bba1c13dde20b939306855910f5', '[\"*\"]', NULL, NULL, '2026-01-01 05:27:30', '2026-01-01 05:27:30'),
(105, 'App\\Models\\User', 23, 'web-session', 'cf08c3e53858a903da2cb4bfcc210fc3b02391ce04e669081628e41af590cc09', '[\"*\"]', NULL, NULL, '2026-01-01 05:30:23', '2026-01-01 05:30:23'),
(106, 'App\\Models\\User', 23, 'web-session', '97f01175fc721bc108ac26ba8d5f0a66d0d4917bff7dc9c061d6715dd6229c94', '[\"*\"]', NULL, NULL, '2026-01-01 08:21:13', '2026-01-01 08:21:13'),
(107, 'App\\Models\\User', 23, 'web-session', '12e3ffe30b903da7effdfc15b99c2099fc11098ba4d1d2c4f7c8e9725a952a5c', '[\"*\"]', '2026-01-01 08:50:39', NULL, '2026-01-01 08:34:59', '2026-01-01 08:50:39'),
(108, 'App\\Models\\User', 23, 'web-session', 'b1aba1dc71c2c40dc7d5a5ba7b75f51631f30f176280a85f80d1aa1c0dca1fcf', '[\"*\"]', NULL, NULL, '2026-01-01 14:18:14', '2026-01-01 14:18:14'),
(109, 'App\\Models\\User', 23, 'web-session', '5f60e5bb58205e030d9b14b69612ffbbea985aa38021d3085a56a904be660a05', '[\"*\"]', '2026-01-01 16:47:36', NULL, '2026-01-01 16:38:37', '2026-01-01 16:47:36'),
(110, 'App\\Models\\User', 23, 'web-session', '8ff84283e00067abd62f1fd6b66e18ad092042756d3695386235ad63ffbf5ac0', '[\"*\"]', NULL, NULL, '2026-01-01 16:55:13', '2026-01-01 16:55:13'),
(111, 'App\\Models\\User', 23, 'web-session', '3739b77999f8bdf76a4383f0e9fd9884bb749b93dbccf06b9ad69bf9bd3b03b3', '[\"*\"]', NULL, NULL, '2026-01-01 19:33:12', '2026-01-01 19:33:12'),
(112, 'App\\Models\\User', 23, 'web-session', '69d61807d74f399b3456386d772da0daa90311c0c856513b6f9df8c2d20093e2', '[\"*\"]', '2026-01-01 20:49:58', NULL, '2026-01-01 19:35:06', '2026-01-01 20:49:58'),
(113, 'App\\Models\\User', 23, 'web-session', '9a96abf70f0879341bfe0d5718e291ba40c0eae0f4bcccdefcc1c2724e1531af', '[\"*\"]', NULL, NULL, '2026-01-01 23:12:41', '2026-01-01 23:12:41'),
(114, 'App\\Models\\User', 23, 'web-session', '35b556856d7bd467f6edf483b775fd4afffcfd47d18cc057c18574907b77fc35', '[\"*\"]', NULL, NULL, '2026-01-02 06:37:20', '2026-01-02 06:37:20'),
(115, 'App\\Models\\User', 23, 'web-session', 'b73e134ff1efb86a09d076b301510ac709e1ff73fe7dcac6103724959c303820', '[\"*\"]', '2026-01-02 21:41:01', NULL, '2026-01-02 15:15:59', '2026-01-02 21:41:01'),
(116, 'App\\Models\\User', 23, 'web-session', 'a599cbde2c9939c039a1b5969e656468458c8dc7791eab88690a45a860fd6f29', '[\"*\"]', NULL, NULL, '2026-01-02 18:56:02', '2026-01-02 18:56:02'),
(117, 'App\\Models\\User', 23, 'web-session', 'a9ccf176b8ccfa5523b43f5f6a8bc50d32057299dcb6af3fc95c9fb38a311660', '[\"*\"]', NULL, NULL, '2026-01-03 03:35:07', '2026-01-03 03:35:07'),
(118, 'App\\Models\\User', 23, 'web-session', '375e4f297fb27c94491194ed1f5382abc6324e35a40194580eaee1b66de8b26b', '[\"*\"]', '2026-01-03 07:40:46', NULL, '2026-01-03 06:25:01', '2026-01-03 07:40:46'),
(119, 'App\\Models\\User', 24, 'web-session', '401587b6a4bb07e59288495a57d759649d49fe7594d38cf01f1d9a86e49ab98d', '[\"*\"]', NULL, NULL, '2026-01-03 08:21:58', '2026-01-03 08:21:58'),
(120, 'App\\Models\\User', 23, 'web-session', '6fb9935055e59f1970eabced06dfa9fc9f4d61297869bb65baa50f1820449d20', '[\"*\"]', NULL, NULL, '2026-01-03 15:19:26', '2026-01-03 15:19:26'),
(121, 'App\\Models\\User', 23, 'web-session', '4c9442b6943412751324e30c964420706cbe7d4df39119c882cd5974c955485f', '[\"*\"]', NULL, NULL, '2026-01-03 18:28:44', '2026-01-03 18:28:44'),
(122, 'App\\Models\\User', 23, 'web-session', '7ae962697a3f1cc429fa4fd00dc0635a51ca4a0d3f58b05e3bfeb145a9316fd4', '[\"*\"]', NULL, NULL, '2026-01-04 02:12:50', '2026-01-04 02:12:50'),
(123, 'App\\Models\\User', 23, 'web-session', 'db5f1a320e0919f70e1914089a728ecf1167b37f0083856f150e477a201be857', '[\"*\"]', NULL, NULL, '2026-01-04 02:12:53', '2026-01-04 02:12:53'),
(124, 'App\\Models\\User', 23, 'web-session', '3a5d12bef4adc4d49c63ee2113abbc53ffe8c2bc5ea942262c9fd1a88964e5bb', '[\"*\"]', NULL, NULL, '2026-01-04 02:12:55', '2026-01-04 02:12:55'),
(125, 'App\\Models\\User', 23, 'web-session', '2bfc069ab24a3282edf1c011e54dc48c6a6e03a5da35c0a578e0edaa4b483965', '[\"*\"]', NULL, NULL, '2026-01-04 02:12:57', '2026-01-04 02:12:57'),
(126, 'App\\Models\\User', 23, 'web-session', 'd89ef449604892f51f25c9df50395d154623c2fde3ab5c3a7a5f6249e149f580', '[\"*\"]', NULL, NULL, '2026-01-04 02:12:59', '2026-01-04 02:12:59'),
(127, 'App\\Models\\User', 23, 'web-session', 'a365e3af9da8ab4f2246d5bdfcd4d48a0fba26bf972bb07eb188b2db3ba2fcaa', '[\"*\"]', NULL, NULL, '2026-01-04 02:13:02', '2026-01-04 02:13:02'),
(128, 'App\\Models\\User', 23, 'web-session', 'fc237cfbf5009196488368e7b03ea359f58686259852e8e3e04ceb4e76e4961a', '[\"*\"]', NULL, NULL, '2026-01-04 02:13:04', '2026-01-04 02:13:04'),
(129, 'App\\Models\\User', 25, 'web-session', 'd4944010d3325a532fe4b7d93065c472397e39d41889d2d56266d787347d2451', '[\"*\"]', NULL, NULL, '2026-01-04 05:26:52', '2026-01-04 05:26:52'),
(130, 'App\\Models\\User', 23, 'web-session', '5d7d0718fa93eb3a33e19f0a8db1dab65951f2ee13e4bd3dad257cd66f15dad8', '[\"*\"]', NULL, NULL, '2026-01-04 12:08:29', '2026-01-04 12:08:29'),
(131, 'App\\Models\\User', 23, 'web-session', '1397b1e108a3a18d6a8cddce1d78f3cc555b668b877aad8ec08da46543965e82', '[\"*\"]', NULL, NULL, '2026-01-04 16:40:39', '2026-01-04 16:40:39'),
(132, 'App\\Models\\User', 23, 'web-session', '1241565792d69540af7c005bdf9405a365961f3df18794282333476bbfd20bf3', '[\"*\"]', NULL, NULL, '2026-01-05 00:22:31', '2026-01-05 00:22:31'),
(133, 'App\\Models\\User', 23, 'web-session', 'ac739dff569eef665561612ad2fa3055970d61de4c80ecb44161685642920fbf', '[\"*\"]', NULL, NULL, '2026-01-05 03:47:39', '2026-01-05 03:47:39'),
(134, 'App\\Models\\User', 23, 'web-session', '8248a3cba99ad0e960710d9eaa864b97449d23ffe33429706a8b0581b74e4b11', '[\"*\"]', NULL, NULL, '2026-01-05 04:55:02', '2026-01-05 04:55:02'),
(135, 'App\\Models\\User', 23, 'web-session', '2c2d80abae48f63070654356638d425cd910455159b721172178f2e358d74e38', '[\"*\"]', NULL, NULL, '2026-01-05 16:06:17', '2026-01-05 16:06:17'),
(136, 'App\\Models\\User', 23, 'web-session', 'f60fa1f8c2db5bc7f16f4e33cc1d1f94b1399c5bf12429249f0c425afc2e00ad', '[\"*\"]', NULL, NULL, '2026-01-05 21:29:23', '2026-01-05 21:29:23'),
(137, 'App\\Models\\User', 23, 'web-session', '144981695b760fc5a2167114cb6040055b4c4888089b4492e07754524fe2c572', '[\"*\"]', NULL, NULL, '2026-01-06 07:10:15', '2026-01-06 07:10:15'),
(138, 'App\\Models\\User', 23, 'web-session', 'f89902dc5103d8887270a7160a6963bf8b824d95b5c2599df1a8b26457f4187e', '[\"*\"]', NULL, NULL, '2026-01-06 07:14:33', '2026-01-06 07:14:33'),
(139, 'App\\Models\\User', 23, 'web-session', 'f83770c0f2f12a8d904a529312f502adda37211dbb38a854863812101e199384', '[\"*\"]', NULL, NULL, '2026-01-06 07:25:20', '2026-01-06 07:25:20'),
(140, 'App\\Models\\User', 26, 'web-session', 'bee045ce4e19833fbf69c0f531c5dad428f3e0bcd05a953e250e64db51f006c3', '[\"*\"]', NULL, NULL, '2026-01-06 08:09:06', '2026-01-06 08:09:06'),
(141, 'App\\Models\\User', 26, 'web-session', '399e7b799400f5f5a133a6020fea963ba4bf7a81d386abd9eb2bb152eaeccfe0', '[\"*\"]', NULL, NULL, '2026-01-06 09:31:59', '2026-01-06 09:31:59'),
(142, 'App\\Models\\User', 22, 'web-session', 'e55e8a92177ce1c2e51baea7c9f179d7ad3d65c4e165b86db2f2b048babd616c', '[\"*\"]', NULL, NULL, '2026-01-06 09:38:10', '2026-01-06 09:38:10'),
(143, 'App\\Models\\User', 26, 'web-session', '1bd004db77be3a670b121ac7f99ad4fedabd2a66c25e0be47458f90fda8d2f0c', '[\"*\"]', NULL, NULL, '2026-01-06 14:26:10', '2026-01-06 14:26:10'),
(144, 'App\\Models\\User', 26, 'web-session', '63ea163bb8d83afbb03a81ba24a678bf5111dcaac8c05adc7aa5201b04da8d49', '[\"*\"]', NULL, NULL, '2026-01-06 14:38:14', '2026-01-06 14:38:14'),
(145, 'App\\Models\\User', 26, 'web-session', '43c6d88c7856990c90067fa956a532af32ac52122a2900eaa263729d25e8048f', '[\"*\"]', NULL, NULL, '2026-01-06 15:07:07', '2026-01-06 15:07:07'),
(146, 'App\\Models\\User', 26, 'web-session', 'bc3af456cacd7ad36af353e2b5bfd6acf9c15492987944c3a8a59d6846ea7c9f', '[\"*\"]', NULL, NULL, '2026-01-06 21:23:24', '2026-01-06 21:23:24'),
(147, 'App\\Models\\User', 26, 'web-session', '2327e48ed26f0b62f87de6b4aacf9635d62bde388157a92cd8ef46fe6c58ee34', '[\"*\"]', NULL, NULL, '2026-01-06 23:40:31', '2026-01-06 23:40:31'),
(148, 'App\\Models\\User', 26, 'web-session', '7e6402260119072cd7c17496ccd3b573c75f5e6ccd2c8fe445741d3ed463b1ce', '[\"*\"]', NULL, NULL, '2026-01-06 23:43:18', '2026-01-06 23:43:18'),
(149, 'App\\Models\\User', 26, 'web-session', '97183ce7478855363202c0bb6e02b4d39810f458f1d876ab9ed6ca5d3b531a69', '[\"*\"]', NULL, NULL, '2026-01-07 00:03:59', '2026-01-07 00:03:59'),
(150, 'App\\Models\\User', 26, 'web-session', 'bb83cc51bca35ba22484b5c62ce125b354958f0de7e87de38e77835bbff117a6', '[\"*\"]', NULL, NULL, '2026-01-07 00:06:11', '2026-01-07 00:06:11'),
(151, 'App\\Models\\User', 26, 'web-session', 'bc80c591141f302ecccc31ff1f2002996d15611c0e90fd54c52c94a4b0fc4228', '[\"*\"]', NULL, NULL, '2026-01-07 00:14:58', '2026-01-07 00:14:58'),
(152, 'App\\Models\\User', 26, 'web-session', '06292ee650be08220919611d683b210fa3ef66636873ffa9158881507499cc77', '[\"*\"]', NULL, NULL, '2026-01-07 00:32:24', '2026-01-07 00:32:24'),
(153, 'App\\Models\\User', 26, 'web-session', '751ba098063fa76a289626fcda554e4fa7980419a9d392aff2e78a0d2c086438', '[\"*\"]', NULL, NULL, '2026-01-07 00:37:17', '2026-01-07 00:37:17'),
(154, 'App\\Models\\User', 23, 'web-session', 'efa7ad3aeac1a680c32934a2b5eb02ec5ae617a089edfa5a948f3412db4afd71', '[\"*\"]', NULL, NULL, '2026-01-07 01:11:52', '2026-01-07 01:11:52'),
(155, 'App\\Models\\User', 23, 'web-session', '323217dad0a9e3db87e4853fd04c085d52927fa8c9a1a25d21baad3bd3b3346d', '[\"*\"]', NULL, NULL, '2026-01-07 01:36:30', '2026-01-07 01:36:30'),
(156, 'App\\Models\\User', 26, 'web-session', 'c568eba88e47e44f3b724de26552e54a7931ecbcb39d9d21aa4b5992212529f6', '[\"*\"]', NULL, NULL, '2026-01-07 03:53:59', '2026-01-07 03:53:59'),
(157, 'App\\Models\\User', 23, 'web-session', '4d0b3db1af232fe01cd13616783f7c6ee02281eeaf76f707a04930d3f2c7df0a', '[\"*\"]', NULL, NULL, '2026-01-07 04:15:43', '2026-01-07 04:15:43'),
(158, 'App\\Models\\User', 26, 'web-session', '014593d32e10d69d42c99c3f3ce4f0900573e593fae886c1dfddb5071bb965c8', '[\"*\"]', NULL, NULL, '2026-01-07 07:33:37', '2026-01-07 07:33:37'),
(159, 'App\\Models\\User', 26, 'web-session', '889e40f67515b94deb707fe9722886702717a28fc22b033c959e29ec1cd7a462', '[\"*\"]', NULL, NULL, '2026-01-07 09:01:26', '2026-01-07 09:01:26'),
(160, 'App\\Models\\User', 26, 'web-session', 'fe9d7328fa37580da4face242a76d588092dfc7faba4cb704b4e1c9b1e7129ed', '[\"*\"]', NULL, NULL, '2026-01-07 10:42:12', '2026-01-07 10:42:12'),
(161, 'App\\Models\\User', 26, 'web-session', '725fdc185a3d1eee83775719b4bacb9e0b7e8026583b6f67468f2c54db0d335a', '[\"*\"]', NULL, NULL, '2026-01-07 10:49:03', '2026-01-07 10:49:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time DEFAULT NULL,
  `tipe` enum('masuk','pulang') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `status_presensi` enum('HADIR','TERLAMBAT','IZIN','SAKIT','ALPHA') NOT NULL DEFAULT 'HADIR',
  `is_late` tinyint(1) NOT NULL DEFAULT 0,
  `qr_code` varchar(255) DEFAULT NULL,
  `metode` varchar(255) NOT NULL DEFAULT 'manual',
  `jadwal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `user_id`, `ustadz_id`, `tanggal`, `jam`, `tipe`, `foto`, `latitude`, `longitude`, `status_presensi`, `is_late`, `qr_code`, `metode`, `jadwal_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, '2025-12-10', NULL, 'masuk', NULL, NULL, NULL, 'HADIR', 0, NULL, 'manual', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `progress_hafalan`
--

CREATE TABLE `progress_hafalan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `juz` tinyint(3) UNSIGNED DEFAULT NULL,
  `surat` varchar(100) DEFAULT NULL,
  `ayat_mulai` int(10) UNSIGNED DEFAULT NULL,
  `ayat_selesai` int(10) UNSIGNED DEFAULT NULL,
  `nilai` enum('A','B','C','D') DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `progress_hafalans`
--

CREATE TABLE `progress_hafalans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nama_panggilan` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `no_hp_orang_tua` varchar(30) DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`id`, `nis`, `password`, `nama_lengkap`, `nama_panggilan`, `jenis_kelamin`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `nama_ayah`, `nama_ibu`, `no_hp_orang_tua`, `tanggal_masuk`, `status_aktif`, `kelas_id`, `created_at`, `updated_at`, `user_id`) VALUES
(2, 'NIS-2025-0006', '$2y$12$3Fxj03o1mLbMBsCP1FyKreSLhihbMaLu9JX7EO.4trayMjvoGjN4O', 'Test Santri', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-12-12 23:40:11', '2025-12-28 03:36:46', 6),
(3, 'NIS-2025-0007', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'Test Santri', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-12-13 20:51:31', '2025-12-28 03:39:12', 7),
(4, 'NIS-2025-0008', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'Test Santri', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-12-14 01:48:48', '2025-12-28 03:39:12', 8),
(5, 'NIS-2025-0009', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'Test Santri', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-12-14 03:00:14', '2025-12-28 03:39:12', 9),
(6, '', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'Santri Dummy', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '2025-12-28 03:39:12', 3),
(8, 'NIS-2025-0011', '$2y$12$0aACYmYWwz.vnFg39FFs6uGSMlxUD5RuBLpBa3ANFkTyTHYTykbOi', 'Test Santri', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '2025-12-17 20:43:38', '2025-12-28 03:36:33', 11),
(9, 'NIS-2025-0014', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'TEST SANTRI', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-27 03:10:12', '2025-12-28 03:39:12', 14),
(10, 'NIS-2025-0015', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'TEST', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-27 06:31:21', '2025-12-28 03:39:12', 15),
(11, 'NIS-2025-0016', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'SANTRI BARU', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-27 07:40:06', '2025-12-28 03:39:12', 16),
(12, 'NIS-2025-0017', '$2y$12$Nt9eYe0yFpqxcKM0t.HtbOL65BOz7fGBTTR1u8t1rRv2xWrDcGioO', 'TEST2', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-27 07:54:41', '2025-12-28 03:39:12', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AzyGCy48fMOIqfy2sBaDlot6AgqfdGMF3qepFqYh', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYnFOc25rTk1QOTM5djBJSEtvSHNsOXJzb05GcFFVWmlwbWlVd0lTZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767609655),
('bXsa9a3XAruKmxXcIJaefQyyH8XT3mouY4GBkbVE', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMGtvRE1CNlNZeDQ2RWdBcmR4ekpyeVZWMWROZWRGdjZaN1VFcDZXeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767609909),
('Cw7zlt20j13mkm24JZHkLsGRCj2AvHf8ej1cE3An', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkdicEFyS3RPMHp0ck12aUxqZHNjMEZ4OU5aS1lic1l1NVNJZ25DNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767609110),
('Dp26jRkKfQB2JWePkrLdgNbX0ys3Zyv0t6fIilmT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHQ2V0RqZUpDeHhXNUR4czBJbmdzQ3cxNDZqQ3ozOVFiRDEwUzJxMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czoxMzoicmVnaXN0ZXIuZm9ybSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767597986),
('EeoqO12BT3AXUbpNx4ZoZQZHnnsRcgG7Jg9XFi4s', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYU5ncWFtMDYxZzhjUTc0Zm9zeW1hVnZ2dUtTUWpYY0Y5a2c4ajBJQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzA6Imh0dHA6Ly9wYXVzZWxlc3MtcGV0ZXItbm9uc29saWNpdG91c2x5Lm5ncm9rLWZyZWUuZGV2L3VzdGFkei9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTY6InVzdGFkei5kYXNoYm9hcmQiO31zOjk6ImFwaV90b2tlbiI7czo1MjoiMTMyfE5ib3N3emNiMXVUenJDYlVTcllNZ3lkdmc4N1BKRzA2N2lUYlpGZmFhODhkOTIxMSI7czo0OiJ1c2VyIjthOjc6e3M6MjoiaWQiO2k6MjM7czo0OiJuYW1lIjtzOjQ6IkFMREkiO3M6NToiZW1haWwiO3M6MTQ6ImFsZGlAZ21haWwuY29tIjtzOjQ6InJvbGUiO3M6NjoiVVNUQURaIjtzOjM6Im5pcyI7TjtzOjM6Im5pcCI7TjtzOjQ6ImZvdG8iO3M6NTk6InByb2ZpbGUtcGhvdG9zL1hjZnltN2FtcWJJZEIzQzZPVVJGbWFseWxHWEwzUXk1SU5vU0p5emwucG5nIjt9fQ==', 1767597788),
('F0vD5KoCzIhGUFiiulyUC7PW7aHGHxuAQPT8VKm8', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGN1b1hPWHg3SGIwcnZCamFVWFpIV3RJMlNLZXJGRW1zR2gxckZmMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9fQ==', 1767609441),
('FMlViJjWPdXsFXKVMwX1RY58HKnbT9Pf4RcXxbi1', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkxQblI0VzVwOUlqN0JRN3BhaDQ4aFhQY2Faa0VlRVJORk1mY054YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1767608735),
('hX233qT6pqqSdcFQnduz7fAaZf2fbA7huKh5mJvE', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNXlDUTlWMm1xeXRUNHhqU2RYZEE1R0hqd0JiczhoUDFJSlBuMzdDSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767608738),
('KrsrfD0SLdL7bAESIcDOkhd58z82fSlEmnhQPJeZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieFIzVUNUeWNYTEV0ZHV6YTBmWklISzZKaGhabUlCbmgyZFVpaUh5QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767609812),
('qruXj9Av83EXAFUSsK5ROkVzx0k9eqm66nz08wjm', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkoycXdxUXVnalNoY3gzeElWM0lRY1dYSFlKVFF3bW5PdjRWeVNBeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9fQ==', 1767609785),
('RZfw2Xss9WGqKgy6bshYSSimDt7nAmoAHrwvjTK8', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1Rucnl1VFpUTVlqQktDSnVwSXVpeElXNEpRdHhGMkU0SVFuYngyayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767608737),
('TkBnyrvnLA2yhWL2xJzHryddxreGv4miJKh7SZdf', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHZ3ajJieGZMMVNiWWMyak9abEtFaXBmTUM5OEJxb1RGV3lMTHhiZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kYXJrLXBpbGxvd3Mtc3RvcC5sb2NhLmx0L2xvZ2luIjtzOjU6InJvdXRlIjtzOjEwOiJsb2dpbi5mb3JtIjt9fQ==', 1767609613),
('V5q1ltQDGBeAvbouzJ178GojeN0Fe9hAiz334aLD', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQTZzdjloSUFveU1IZzFKdVNRSzFoMmxCM24xWDBvUXE3YnhIeGhDcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767609496),
('waVaCP94ZGmDY371QQXG3RGd8Dv4h8ftUoi4l28i', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHFsSEFwT2UwUnh4cHFialdZYmtra3BmTlNqOVJTRWM0Wnp6UloyQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMDoibG9naW4uZm9ybSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767597867);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setoran`
--

CREATE TABLE `setoran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ustadz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `juz` int(11) DEFAULT NULL,
  `halaman` int(11) DEFAULT NULL,
  `ayat_mulai` varchar(255) DEFAULT NULL,
  `ayat_selesai` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'SANTRI',
  `instansi` varchar(255) DEFAULT NULL,
  `nis` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `pembimbing_nip` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `last_login` timestamp NULL DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `kelas_id`, `name`, `email`, `photo`, `email_verified_at`, `password`, `role`, `instansi`, `nis`, `nip`, `pembimbing_nip`, `no_hp`, `alamat`, `foto`, `status`, `last_login`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Admin TPQ', 'admin@tpq.test', NULL, NULL, '$2y$12$8Gqflo//7ssGMPz5KPqzFOl2T8KN6OTRQzNI3zLQmjZdhCf4GouuC', 'ADMIN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2025-12-15 16:35:11', NULL, NULL, '2025-12-12 02:16:49', '2025-12-15 16:35:11'),
(2, NULL, 'Test Santri', 'santri1@test.com', NULL, NULL, '$2y$12$9h7U9vhnWQHn8CmxzXrXnO81weO0GGqkFHcJk5/4DCvD1eQ.euGvy', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'profile/693c11fa9a964.jpg', 'aktif', '2025-12-12 05:54:18', NULL, NULL, '2025-12-12 05:11:05', '2025-12-12 06:00:42'),
(3, NULL, 'Ustadz Ahmad', 'ustadz@tpq.test', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ustadz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2025-12-17 23:58:56', NULL, NULL, '2025-12-13 05:59:24', '2025-12-17 23:58:56'),
(4, 2, 'Test Santri', 'santri2@test.com', NULL, NULL, '$2y$12$SOCO9glyL6K5ltr1riaIFuK2oNyfTG3Ut3v6yKoqyD/GIteK7BEGu', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-12 23:34:55', NULL, NULL, '2025-12-12 23:34:55', '2025-12-12 23:34:55'),
(5, 2, 'Test Santri', 'santri3@test.com', NULL, NULL, '$2y$12$5gpWUp23G5GmTTND12IqdepjS3XQP6Vzbf.Z1ZUmGMY3VUDmKO35u', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-12 23:37:42', NULL, NULL, '2025-12-12 23:37:42', '2025-12-12 23:37:42'),
(6, 2, 'Test Santri', 'santri4@test.com', NULL, NULL, '$2y$12$zV8uMvNvoS6XLSe3EafBEuI.dqJsQx0/.hI3NqAz.ziK4AkYuk4Je', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'profile/693e1c490217f.jpg', 'aktif', '2025-12-13 19:09:38', NULL, NULL, '2025-12-12 23:40:11', '2025-12-13 19:09:38'),
(7, 2, 'Test Santri', 'santri5@test.com', NULL, NULL, '$2y$12$KGcTUnc4iiu4IN82EuEt.ezq/lhfwD3.UvJdURps0n5c/IiCg/wPi', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'profile/693e7a26d8ce7.jpg', 'aktif', '2025-12-14 01:49:02', NULL, NULL, '2025-12-13 20:51:31', '2025-12-14 01:49:47'),
(8, 2, 'Test Santri', 'santri6@test.com', NULL, NULL, '$2y$12$ls8qQRUxjvtzkmv8fX8iXufkNYuTgYJfDHAgq1gy1WjpJwqyu0rOq', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-14 01:48:46', NULL, NULL, '2025-12-14 01:48:47', '2025-12-14 01:48:47'),
(9, 2, 'Test Santri', 'santri7@test.com', NULL, NULL, '$2y$12$s5hLIdWZGEUF3phC2ks0n.f0lZDJQB7DRO3PeVc7QS9FqOyfsb.E2', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'profile/6941630f2de34.jpg', 'aktif', '2025-12-17 20:43:53', NULL, NULL, '2025-12-14 03:00:13', '2025-12-17 20:43:53'),
(11, 2, 'Test Santri', 'santri8@test.com', NULL, NULL, '$2y$12$.PEnwtHPqDE.hXXHHkF9CuSXRjf4hIEzj3gn7EU1hD8zKmQFs5rjy', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'profile/69437a0807f8a.jpg', 'aktif', '2025-12-17 22:49:16', NULL, NULL, '2025-12-17 20:43:37', '2025-12-17 22:49:16'),
(12, NULL, 'MUNAWIR', 'santrineumi@gmail.com', NULL, NULL, '$2y$12$Uh.5qUgzCH5anrXwjFSr7OIFR4lshbwGJCLznhrE.t9nPe5KpAHxC', 'admin', NULL, NULL, NULL, NULL, '085710387661', NULL, 'profile-photos/g3idPjoQU1c9s3jiX982m4aaD0zoPpycbipP1DHs.png', 'aktif', '2025-12-30 20:57:40', NULL, NULL, '2025-12-18 05:29:03', '2026-01-01 03:56:53'),
(14, NULL, 'TEST SANTRI', 'testsantri2@gmail.com', NULL, NULL, '$2y$12$YSckDJ6f2nsQkXp72NDyse7upIt1uCKy2c3eAXpszPXRASSFplOB2', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-27 03:10:10', NULL, NULL, '2025-12-27 03:10:11', '2025-12-27 03:10:11'),
(15, NULL, 'TEST', 'test@gmail.com', NULL, NULL, '$2y$12$9wL2CZZiv0amisu5SXX.5.m41fkwj3pGLTMKKojC6I2SCHgoKOxjW', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-27 06:31:21', NULL, NULL, '2025-12-27 06:31:21', '2025-12-27 06:31:21'),
(16, NULL, 'SANTRI BARU', 'santri_baru_2025@gmail.com', NULL, NULL, '$2y$12$sAcmvdy/JSxwZsdjnlWrGu8sMqMVWesaxbwfh51rQq6ynL.3.lLgO', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-27 07:40:06', NULL, NULL, '2025-12-27 07:40:06', '2025-12-27 07:40:06'),
(17, NULL, 'TEST2', 'baru123@test.com', NULL, NULL, '$2y$12$ip0FoNlEuD.blLF4WaaJieVe2PddtuMrGQDi/FyK0nuvoe5NaftXe', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, 'default/profile.png', 'aktif', '2025-12-27 07:54:41', NULL, NULL, '2025-12-27 07:54:41', '2025-12-27 07:54:41'),
(18, NULL, 'MUNAWIR', 'daarulgusmikalhufadz@gmail.com', NULL, NULL, '$2y$12$fmTd4RJyePFoWsyYaWplqOZCv1KiZpU3TnxNw5gUlUtaTgMrQQuPS', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', NULL, NULL, NULL, '2025-12-28 05:36:22', '2025-12-28 05:36:22'),
(19, NULL, 'MUNAWIR', 'arkan98store@gmail.com', NULL, NULL, '$2y$12$EA6TCF3/1oNlGiMmELBpiOx.aBsINZKhenN4S.mvfdRPJMJhzQ/Ke', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', NULL, NULL, NULL, '2025-12-28 06:20:40', '2025-12-28 06:20:40'),
(20, NULL, 'AKBAR', 'santi@gmail.com', NULL, NULL, '$2y$12$8g70c9b82x75fLPXga8cy.UHULFz2Vmm9IoV6aC7T4s2tu8MsNgVe', 'SANTRI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', NULL, NULL, NULL, '2025-12-28 06:25:42', '2025-12-28 06:25:42'),
(21, NULL, 'ANDRI', 'indra@gmail.com', NULL, NULL, '$2y$12$yknc16yuxWdnDgnlzy/29OwdP9LMj3UBTFOTIhvVIo0eHDrwmeVfa', 'SANTRI', NULL, 'NIS-2025-0016', NULL, NULL, '085710387661', NULL, 'profile-photos/Ev8mn57sf4b4kiEpMEjFqFjZCIpfH42DPzJupVmn.png', 'AKTIF', '2025-12-31 05:10:54', NULL, NULL, '2025-12-28 06:29:42', '2025-12-31 05:10:54'),
(22, NULL, 'GALIH', 'irfan@gmail.com', NULL, NULL, '$2y$12$rbX6WCh/E1V7DJ7rUzdY8uiuL/9wIev2PkQ7h08j.ZQPc.CX174y.', 'SANTRI', NULL, 'NIS-2025-0017', NULL, NULL, NULL, NULL, 'profile-photos/KcAL3k0cJIbmJfqkaVNMJgX8vXviaN3CrMMvGJ7X.png', 'AKTIF', '2026-01-06 09:38:11', NULL, NULL, '2025-12-28 06:51:24', '2026-01-06 09:38:11'),
(23, NULL, 'ALDI', 'aldi@gmail.com', NULL, NULL, '$2y$12$aKg05QVlyZx15ymKHTRZBuc.iE59UFyCmJvuf.KqvqxKLXaU69mSO', 'USTADZ', NULL, NULL, NULL, NULL, NULL, NULL, 'profile-photos/Xcfym7amqbIdB3C6OURFmalylGXL3Qy5INoSJyzl.png', 'AKTIF', '2026-01-07 04:15:43', NULL, NULL, '2025-12-30 20:08:01', '2026-01-07 04:15:43'),
(24, NULL, 'Ustadz Test', 'ustadz_test@gmail.com', NULL, NULL, '$2y$12$K5eDoFdHzdIoPqUxnMfJDewhVLmRzGXWnGVD6UYFGXfmpEFaSDYwy', 'USTADZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', NULL, NULL, NULL, '2026-01-03 08:21:55', '2026-01-03 08:21:55'),
(25, NULL, 'Ustadz Test', 'ustadz_test@tpq.com', NULL, NULL, '$2y$12$b.uUqVbO6iuwQ0yfx7r2bOxrXwMZil2PUU1//OmYVez/946O0lNjm', 'USTADZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', NULL, NULL, NULL, '2026-01-04 05:26:48', '2026-01-04 05:26:48'),
(26, NULL, 'Fuad', 'fuad@gmail.com', NULL, NULL, '$2y$12$YcZwH375Rlg6fsi10JgWsex6YRC6vTU7BbD9XOnxecaqdDQDv11p2', 'USTADZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AKTIF', '2026-01-07 10:49:03', NULL, NULL, '2026-01-06 08:09:05', '2026-01-07 10:49:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `fcm_token`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '2025-12-12 05:17:21', '2025-12-12 05:17:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ustadz`
--

CREATE TABLE `ustadz` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(30) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_mulai_mengajar` date DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ustadz`
--

INSERT INTO `ustadz` (`id`, `user_id`, `nama`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `no_hp`, `alamat`, `tanggal_mulai_mengajar`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ustadz Ahmad', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-13 05:59:46', '2025-12-13 05:59:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verification_scans`
--

CREATE TABLE `verification_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_log_verification_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`),
  ADD KEY `activity_log_created_at_index` (`created_at`),
  ADD KEY `activity_log_event_index` (`event`),
  ADD KEY `activity_log_causer_id_index` (`causer_id`),
  ADD KEY `activity_log_subject_type_index` (`subject_type`);

--
-- Indeks untuk tabel `activity_log_verifications`
--
ALTER TABLE `activity_log_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_log_verifications_hash_unique` (`hash`),
  ADD UNIQUE KEY `activity_log_verifications_document_number_unique` (`document_number`),
  ADD UNIQUE KEY `activity_log_verifications_context_unique` (`context_type`,`context_key`),
  ADD KEY `activity_log_verifications_generated_by_foreign` (`generated_by`);

--
-- Indeks untuk tabel `akhlak_santri`
--
ALTER TABLE `akhlak_santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `1` (`santri_id`),
  ADD KEY `akhlak_santri_tanggal_penilaian_index` (`tanggal_penilaian`);

--
-- Indeks untuk tabel `broadcasts`
--
ALTER TABLE `broadcasts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `broadcasts_sent_by_foreign` (`sent_by`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indeks untuk tabel `chat_private`
--
ALTER TABLE `chat_private`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_private_receiver_id_foreign` (`receiver_id`),
  ADD KEY `chat_private_sender_id_receiver_id_index` (`sender_id`,`receiver_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gaji_ustadz_id_foreign` (`ustadz_id`);

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_members_group_id_foreign` (`group_id`),
  ADD KEY `group_members_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `group_messages`
--
ALTER TABLE `group_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_messages_group_id_foreign` (`group_id`),
  ADD KEY `group_messages_sender_id_foreign` (`sender_id`);

--
-- Indeks untuk tabel `group_message_reads`
--
ALTER TABLE `group_message_reads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_message_reads_group_message_id_user_id_unique` (`group_message_id`,`user_id`),
  ADD KEY `group_message_reads_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hafalan_santri_id_foreign` (`santri_id`),
  ADD KEY `hafalan_ustadz_id_foreign` (`ustadz_id`);

--
-- Indeks untuk tabel `import_logs`
--
ALTER TABLE `import_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `infaq`
--
ALTER TABLE `infaq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `infaq_santri_id_foreign` (`santri_id`);

--
-- Indeks untuk tabel `jadwal_mengajar`
--
ALTER TABLE `jadwal_mengajar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_mengajar_ustadz_id_foreign` (`ustadz_id`),
  ADD KEY `jadwal_mengajar_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kehadiran_santri`
--
ALTER TABLE `kehadiran_santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kehadiran_santri_santri_id_jadwal_id_tanggal_unique` (`santri_id`,`jadwal_id`,`tanggal`),
  ADD KEY `kehadiran_santri_jadwal_id_foreign` (`jadwal_id`),
  ADD KEY `kehadiran_santri_ustadz_id_foreign` (`ustadz_id`),
  ADD KEY `kehadiran_santri_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_kode_kelas_unique` (`kode_kelas`),
  ADD KEY `kelas_status_index` (`status`),
  ADD KEY `kelas_tingkat_index` (`tingkat`),
  ADD KEY `kelas_ustadz_id_index` (`ustadz_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_ujian_santri_id_foreign` (`santri_id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengajars`
--
ALTER TABLE `pengajars`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presensi_ustadz_id_foreign` (`ustadz_id`),
  ADD KEY `presensi_jadwal_id_foreign` (`jadwal_id`),
  ADD KEY `presensi_user_id_tanggal_index` (`user_id`,`tanggal`),
  ADD KEY `presensi_tanggal_index` (`tanggal`),
  ADD KEY `presensi_tipe_index` (`tipe`);

--
-- Indeks untuk tabel `progress_hafalan`
--
ALTER TABLE `progress_hafalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `progress_hafalan_santri_id_foreign` (`santri_id`);

--
-- Indeks untuk tabel `progress_hafalans`
--
ALTER TABLE `progress_hafalans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santri_nis_unique` (`nis`),
  ADD KEY `santri_kelas_id_foreign` (`kelas_id`),
  ADD KEY `santri_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `setoran`
--
ALTER TABLE `setoran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setoran_santri_id_foreign` (`santri_id`),
  ADD KEY `setoran_ustadz_id_foreign` (`ustadz_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nis_unique` (`nis`),
  ADD UNIQUE KEY `users_nip_unique` (`nip`),
  ADD KEY `users_kelas_id_foreign` (`kelas_id`);

--
-- Indeks untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_tokens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `ustadz`
--
ALTER TABLE `ustadz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ustadz_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `verification_scans`
--
ALTER TABLE `verification_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verification_scans_activity_log_verification_id_index` (`activity_log_verification_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT untuk tabel `activity_log_verifications`
--
ALTER TABLE `activity_log_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `akhlak_santri`
--
ALTER TABLE `akhlak_santri`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `broadcasts`
--
ALTER TABLE `broadcasts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `chat_private`
--
ALTER TABLE `chat_private`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `group_messages`
--
ALTER TABLE `group_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `group_message_reads`
--
ALTER TABLE `group_message_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `import_logs`
--
ALTER TABLE `import_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `infaq`
--
ALTER TABLE `infaq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_mengajar`
--
ALTER TABLE `jadwal_mengajar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kehadiran_santri`
--
ALTER TABLE `kehadiran_santri`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengajars`
--
ALTER TABLE `pengajars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `progress_hafalan`
--
ALTER TABLE `progress_hafalan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `progress_hafalans`
--
ALTER TABLE `progress_hafalans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `setoran`
--
ALTER TABLE `setoran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ustadz`
--
ALTER TABLE `ustadz`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `verification_scans`
--
ALTER TABLE `verification_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_log_verifications`
--
ALTER TABLE `activity_log_verifications`
  ADD CONSTRAINT `activity_log_verifications_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `akhlak_santri`
--
ALTER TABLE `akhlak_santri`
  ADD CONSTRAINT `1` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `broadcasts`
--
ALTER TABLE `broadcasts`
  ADD CONSTRAINT `broadcasts_sent_by_foreign` FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chat_private`
--
ALTER TABLE `chat_private`
  ADD CONSTRAINT `chat_private_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_private_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `gaji`
--
ALTER TABLE `gaji`
  ADD CONSTRAINT `gaji_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `group_messages`
--
ALTER TABLE `group_messages`
  ADD CONSTRAINT `group_messages_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `group_message_reads`
--
ALTER TABLE `group_message_reads`
  ADD CONSTRAINT `group_message_reads_group_message_id_foreign` FOREIGN KEY (`group_message_id`) REFERENCES `group_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_message_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hafalan`
--
ALTER TABLE `hafalan`
  ADD CONSTRAINT `hafalan_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hafalan_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `infaq`
--
ALTER TABLE `infaq`
  ADD CONSTRAINT `infaq_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `jadwal_mengajar`
--
ALTER TABLE `jadwal_mengajar`
  ADD CONSTRAINT `jadwal_mengajar_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_mengajar_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kehadiran_santri`
--
ALTER TABLE `kehadiran_santri`
  ADD CONSTRAINT `kehadiran_santri_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_mengajar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kehadiran_santri_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kehadiran_santri_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kehadiran_santri_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `nilai_ujian`
--
ALTER TABLE `nilai_ujian`
  ADD CONSTRAINT `nilai_ujian_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_presensi_santri` FOREIGN KEY (`user_id`) REFERENCES `santri` (`user_id`),
  ADD CONSTRAINT `presensi_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_mengajar` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `presensi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `presensi_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `progress_hafalan`
--
ALTER TABLE `progress_hafalan`
  ADD CONSTRAINT `progress_hafalan_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `santri_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `santri_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `setoran`
--
ALTER TABLE `setoran`
  ADD CONSTRAINT `setoran_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `setoran_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadz` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ustadz`
--
ALTER TABLE `ustadz`
  ADD CONSTRAINT `ustadz_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `verification_scans`
--
ALTER TABLE `verification_scans`
  ADD CONSTRAINT `verification_scans_activity_log_verification_id_foreign` FOREIGN KEY (`activity_log_verification_id`) REFERENCES `activity_log_verifications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
