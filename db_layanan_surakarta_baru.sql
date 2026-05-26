-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2026 pada 02.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_layanan_surakarta_baru`
--

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
-- Struktur dari tabel `kategori_pengaduans`
--

CREATE TABLE `kategori_pengaduans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `dinas` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konten_webs`
--

CREATE TABLE `konten_webs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_03_15_133013_create_pengaduans_table', 1),
(6, '2026_03_29_140000_add_profile_and_role_columns_to_users_table', 1),
(7, '2026_03_29_140100_create_konten_webs_table', 1),
(8, '2026_03_31_120000_add_identity_columns_to_users_table', 1),
(9, '2026_04_27_000001_add_dinas_columns', 1),
(10, '2026_04_27_000002_create_kategori_pengaduans_table', 1),
(11, '2026_04_29_000003_add_bukti_selesai_to_pengaduans_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduans`
--

CREATE TABLE `pengaduans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `ktp` varchar(16) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `alamat_pelapor` text NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `dinas` varchar(255) DEFAULT NULL,
  `tanggal_kejadian` date NOT NULL,
  `deskripsi` text NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `bukti_selesai` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengaduans`
--

INSERT INTO `pengaduans` (`id`, `user_id`, `nama_pelapor`, `ktp`, `no_telp`, `alamat_pelapor`, `kategori`, `dinas`, `tanggal_kejadian`, `deskripsi`, `latitude`, `longitude`, `foto_bukti`, `bukti_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 'intan', '3301766283930786', '085867829099', 'jbres', 'Jalan Rusak', 'PUPR', '2026-05-25', 'yaaa', '-7.5617503', '110.8218887', 'bukti_pengaduan/hP9XIJmDsojkfEYn8QkkxRhXbbEQNNMfV0LsrPLP.png', 'bukti_selesai_pengaduan/WGeXXfHhn2pGQrpqQWIHmYvysDWYuHSA93UfNmLm.png', 'Selesai', '2026-05-25 13:22:32', '2026-05-25 13:26:19'),
(2, 12, 'intan', '3301766283930786', '085867829099', 'jbres', 'Jalan Rusak', 'PUPR', '2026-05-25', 'yyy', '-7.568643226341683', '110.79442313686255', 'bukti_pengaduan/0Gl3ftCZ9eGsasivDjKyU1NFg1EzXCjjDhsAUeF2.png', NULL, 'Menunggu', '2026-05-25 14:04:10', '2026-05-25 14:04:10'),
(3, 13, 'INTAN FAJAR SRININGSIH', '3690256790256790', '085908026803', 'jebres', 'Jalan Rusak', 'PUPR', '2026-05-26', 'yyyy', '-7.5681239', '110.8336297', 'bukti_pengaduan/N54exbNdYg4hAbbrS9hNr4FykfbYbZhX4IKUuLxe.png', NULL, 'Menunggu', '2026-05-26 00:38:50', '2026-05-26 00:38:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'warga',
  `dinas_role` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nik`, `no_hp`, `alamat`, `role`, `dinas_role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@mail.com', NULL, NULL, NULL, 'admin', NULL, NULL, '$2y$10$uQgN3d2qbiZGCHnB01DG/eEvAdM9/VPa1XxdA06w5ltAu1xRhjPAC', NULL, '2026-05-25 10:36:56', '2026-05-25 10:36:56'),
(2, 'Admin PUPR', 'admin-pupr@mail.com', NULL, NULL, NULL, 'admin', 'PUPR', NULL, '$2y$10$7kEJKZ1Scw5e288d2qIr6OOR3YWf0GrTD7mBA7Fbvj0wGpOXIvuum', 'xRJoMsIVp1lNzjlqs012OwqIRrxsNmQLkS7TYf7vfKptNKPqAxolWnlo4yWJ', '2026-05-25 10:36:56', '2026-05-25 10:36:56'),
(3, 'Admin DLH', 'admin-dlh@mail.com', NULL, NULL, NULL, 'admin', 'DLH', NULL, '$2y$10$0oNa2fHWxROVoAU4YU3.6.uI6WlNEBhF1TNP8orY1VtBlNOI6DPzu', NULL, '2026-05-25 10:36:56', '2026-05-25 10:36:56'),
(4, 'Admin Perhubungan', 'admin-perhubungan@mail.com', NULL, NULL, NULL, 'admin', 'PERHUBUNGAN', NULL, '$2y$10$h8oF52ok8o6tquxkMYn.Pe6qBMxY8wdQpYRPQNGi3qF.l6i4xYo5O', NULL, '2026-05-25 10:36:56', '2026-05-25 10:36:56'),
(8, 'Test User Final', 'reg-clean@example.com', '1234567890123459', '081234567893', 'Jl. Test', 'warga', NULL, NULL, '$2y$10$LbTFBa8hkqQjcupc57x91eVFR/vvUfzY48DbspiCJY5dqPY6o2jLm', NULL, '2026-05-25 10:54:04', '2026-05-25 10:54:04'),
(10, 'Intan', 'Intan04@gmail.com', '0000000000000000', '081234567895', 'Alamat belum diisi', 'warga', NULL, NULL, '.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2026-05-25 11:46:07', '2026-05-25 11:46:07'),
(11, 'New User Flow', 'new-user-flow@example.com', '1234567890123470', '081234567896', 'Jl. Baru', 'warga', NULL, NULL, '$2y$10$yqPBTnS8grNG9kdZrysgJ.rHqGLNqPX6cBBJhanp460ajuL27EFwm', '3ztJ0rKC8sHXB3yg29w5WmMdO65MUEtvWT9wEuS3AdaBI21uUScu9u6B9qeH', '2026-05-25 11:49:35', '2026-05-25 11:49:35'),
(12, 'intan', 'intan02@gmail.com', '3301766283930786', '085867829099', 'jbres', 'warga', NULL, NULL, '$2y$10$g/PNHPYp1Ny5iflQvo3AJuC06YMjwaAM9Mc4VleVRRJPs0lnSdHzm', 'prGCsyqwVxAZ1X3mqabRu60Dz0mY4M1Y2xKEJHipFt8rQiPxJ0Ahsn1HviTV', '2026-05-25 13:17:48', '2026-05-25 13:17:48'),
(13, 'INTAN FAJAR SRININGSIH', 'Intan05@gmail.com', '3690256790256790', '085908026803', 'jebres', 'warga', NULL, NULL, '$2y$10$K/cVYWhS6KoNScjEtyW2Ne3l2cMrgh5.cX4eQZGMbYipxsfYAG16i', NULL, '2026-05-26 00:38:16', '2026-05-26 00:38:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kategori_pengaduans`
--
ALTER TABLE `kategori_pengaduans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_pengaduans_nama_dinas_unique` (`nama`,`dinas`),
  ADD KEY `kategori_pengaduans_created_by_foreign` (`created_by`);

--
-- Indeks untuk tabel `konten_webs`
--
ALTER TABLE `konten_webs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konten_webs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori_pengaduans`
--
ALTER TABLE `kategori_pengaduans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konten_webs`
--
ALTER TABLE `konten_webs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengaduans`
--
ALTER TABLE `pengaduans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategori_pengaduans`
--
ALTER TABLE `kategori_pengaduans`
  ADD CONSTRAINT `kategori_pengaduans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `konten_webs`
--
ALTER TABLE `konten_webs`
  ADD CONSTRAINT `konten_webs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD CONSTRAINT `pengaduans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
