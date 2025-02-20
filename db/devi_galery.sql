-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Feb 2025 pada 04.59
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
-- Database: `devi_galery`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `album`
--

CREATE TABLE `album` (
  `album_id` int(11) NOT NULL,
  `nama_album` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `album`
--

INSERT INTO `album` (`album_id`, `nama_album`, `deskripsi`, `tanggal_dibuat`, `user_id`) VALUES
(1, 'desain', 'inspirasi dekorasi', '2025-01-16', 2),
(2, 'skincare', 'kumpulan skincare dan makeup', '2025-02-05', 1),
(3, 'pakaian', 'ini inspirasi outfit aku', '2025-02-05', 1),
(4, 'quotes', 'kata-kata menginspirasi', '2025-01-16', 1),
(5, 'favorit', 'ini kumpulan favorit aku', '2025-01-16', 1),
(12, 'Florist', 'Kumpulan florist yang cantik', '2025-02-18', 4),
(14, 'tes', 'haihai', '2025-02-19', 5),
(16, 'NYOBA', 'nyobaa', '2025-02-19', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto`
--

CREATE TABLE `foto` (
  `foto_id` int(11) NOT NULL,
  `judul_foto` varchar(255) NOT NULL,
  `deskripsi_foto` text NOT NULL,
  `tanggal_unggah` date NOT NULL,
  `lokasi_file` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `foto`
--

INSERT INTO `foto` (`foto_id`, `judul_foto`, `deskripsi_foto`, `tanggal_unggah`, `lokasi_file`, `album_id`, `user_id`) VALUES
(3, 'Referensi pakaian', 'Ini contoh pakaian yang harus kalian cobaa!!', '2025-02-05', '821710258-contoh foto.PNG', 3, 1),
(4, 'Dekorasi rumah', 'contoh dekorasi rumah minimalis namun elegan', '2025-01-16', '710126782-dekorasi rumah.jpg', 1, 2),
(5, 'Skincare', 'tahapan skincare', '2025-01-16', '1283269616-skincare.jpg', 2, 1),
(6, 'Motivasi', 'ini contoh kalimat yang menginspirasi', '2025-01-16', '193834325-quotes.jpg', 4, 1),
(7, 'Makanan', 'dessert box favorit akuu', '2025-01-16', '1372440286-dessert box.jpg', 5, 1),
(10, 'Rumah Minimalis ', 'desain rumah 1 dan 2 lantai', '2025-01-22', '794980882-rumah.jpg', 1, 2),
(14, 'Dekorasi kamar', 'Ini contoh kamar tema pinkkyy', '2025-01-29', '508759507-Small Room Makeover.jpg', 1, 2),
(15, 'Makeup', 'skin prep dan makeup', '2025-02-19', '67730510-makeup.jpg', 2, 1),
(16, 'kitchen decor', 'ini dekorasi dapur yang bagus', '2025-01-30', '1533351665-Kitchen decor.jpg', 1, 2),
(24, 'Buket bunga', 'Buket bunga yang ada di Florist Bandung', '2025-02-19', '1441162975-Buket-bunga.jpg', 12, 4),
(25, 'tes', 'tes foto', '2025-02-19', '563760474-contoh desain.jpg', 14, 5),
(27, 'tess', 'bdhfb', '2025-02-19', '624553444-bunga.jpg', 16, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_foto`
--

CREATE TABLE `komentar_foto` (
  `komentar_id` int(11) NOT NULL,
  `foto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar_foto`
--

INSERT INTO `komentar_foto` (`komentar_id`, `foto_id`, `user_id`, `isi_komentar`, `tanggal_komentar`) VALUES
(1, 14, 4, 'coquette 🎗', '2025-02-18'),
(3, 14, 1, 'lucuu🤎', '2025-02-19'),
(5, 5, 2, 'waww', '2025-02-19'),
(6, 4, 1, 'WAWW', '2025-02-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `like_foto`
--

CREATE TABLE `like_foto` (
  `like_id` int(11) NOT NULL,
  `foto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_like` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `like_foto`
--

INSERT INTO `like_foto` (`like_id`, `foto_id`, `user_id`, `tanggal_like`) VALUES
(2, 25, 5, '2025-02-19'),
(3, 16, 5, '2025-02-19'),
(4, 14, 1, '2025-02-19'),
(5, 15, 1, '2025-02-19'),
(6, 6, 1, '2025-02-19'),
(9, 5, 2, '2025-02-19'),
(10, 6, 5, '2025-02-19'),
(11, 14, 2, '2025-02-19'),
(12, 10, 9, '2025-02-19'),
(13, 16, 9, '2025-02-19'),
(14, 4, 1, '2025-02-19'),
(15, 24, 1, '2025-02-20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `foto_id` int(11) NOT NULL,
  `send_id` int(11) NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`notif_id`, `user_id`, `message`, `foto_id`, `send_id`, `status`, `tanggal`) VALUES
(49, 1, 'devi menyukai foto Anda: Motivasi', 6, 2, 'read', '2025-02-17 05:39:39'),
(50, 4, 'rahmi menyukai foto Anda: Buket Mawar', 21, 1, 'read', '2025-02-18 05:48:15'),
(51, 2, 'aca menyukai foto Anda: Dekorasi kamar', 14, 4, 'read', '2025-02-18 05:50:37'),
(52, 2, 'aca mengomentari foto \'Dekorasi kamar\': coquette 🎗', 14, 4, 'read', '2025-02-18 12:51:17'),
(53, 1, 'aca mengomentari foto \'jsj\': 🤎', 22, 4, 'read', '2025-02-18 12:56:37'),
(54, 1, 'devi menyukai foto Anda: jsj', 22, 2, 'read', '2025-02-18 05:57:00'),
(55, 4, 'devi menyukai foto Anda: Buket Mawar', 21, 2, 'read', '2025-02-18 20:46:49'),
(56, 2, 'a menyukai foto Anda: kitchen decor', 16, 5, 'read', '2025-02-18 21:24:51'),
(57, 2, 'rahmi menyukai foto Anda: Dekorasi kamar', 14, 1, 'read', '2025-02-18 21:27:49'),
(58, 2, 'rahmi mengomentari foto \'Dekorasi kamar\': lucuu🤎', 14, 1, 'read', '2025-02-19 03:33:53'),
(59, 4, 'rahmi juga mengomentari foto \'Dekorasi kamar\': lucuu🤎', 14, 1, 'unread', '2025-02-19 03:33:53'),
(60, 5, 'devi menyukai foto Anda: abc', 26, 2, 'read', '2025-02-18 21:37:42'),
(61, 5, 'rahmi mengomentari foto \'abc\': cantikkk bunganya', 26, 1, 'read', '2025-02-19 03:38:07'),
(62, 1, 'devi menyukai foto Anda: Skincare', 5, 2, 'read', '2025-02-18 21:59:29'),
(63, 1, 'devi mengomentari foto \'Skincare\': waww', 5, 2, 'read', '2025-02-19 03:59:38'),
(64, 1, 'a menyukai foto Anda: Motivasi', 6, 5, 'read', '2025-02-18 22:19:26'),
(65, 2, 'ardi menyukai foto Anda: Rumah Minimalis ', 10, 9, 'read', '2025-02-19 00:09:21'),
(66, 2, 'ardi menyukai foto Anda: kitchen decor', 16, 9, 'read', '2025-02-19 00:09:32'),
(67, 2, 'rahmi menyukai foto Anda: Dekorasi rumah', 4, 1, 'unread', '2025-02-19 00:52:38'),
(68, 2, 'rahmi mengomentari foto \'Dekorasi rumah\': WAWW', 4, 1, 'unread', '2025-02-19 06:52:46'),
(69, 4, 'rahmi menyukai foto Anda: Buket bunga', 24, 1, 'unread', '2025-02-19 20:19:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `nama_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`role_id`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `verifikasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `nama_lengkap`, `alamat`, `foto`, `role_id`, `verifikasi`) VALUES
(1, 'rahmi', '9e1fd6d432770487d35ab2cef8dba2aa', 'rahmi@gmail.com', 'Rahmi', 'Bandung', '861547264-akufotocewe1.jpg', 2, 1),
(2, 'devi', '0e9a9bdfdefedd4235121dfe052d3508', 'devi@gmail.com', 'Devi', 'Bandung', '1939924755-akufotocewe2.jpg', 2, 1),
(3, 'admin', '6e7906b7fb3f8e1c6366c0910050e595', 'tes@gmail.com', 'Huzaimah', 'Bandung', '2059690931-akufotocewe2.jpg', 1, 1),
(4, 'aca', 'bd87652b118cbb4d8a21c32f65890198', 'aca@gmail.com', 'Khanza', 'Bandung', '1370418147-akufotocewe2.jpg', 2, 1),
(5, 'alya', 'e2fc714c4727ee9395f324cd2e7f331f', 'a@gmail.com', 'a', 'a', '106045576-akufotocowo1.jpg', 2, 1),
(6, 'b', 'd4b7c284882ca9e208bb65e8abd5f4c8', 'a@gmail.com', 'b', 'b', '2146272572-akufotocowo2.jpg', 2, 1),
(7, 'c', '1cdac5ad084879e80e5b67c51baa9095', 'a@gmail.com', 'c', 'c', '1762781113-akufotocewe1.jpg', 2, 1),
(8, 'riri', 'c740d6848b6a342dcc26c177ea2c49fe', 'dwiyanti@riri', 'Riri Dwiyanti', 'jalan kenanga', '175593509-akufotocewe1.jpg', 2, 1),
(9, 'ardi', '0264391c340e4d3cbba430cee7836eaf', 'ardi@gmail.com', 'ardi', 'jalan kenanga', '1965838195-akufotocowo2.jpg', 2, 1),
(10, 'tess', '28b662d883b6d76fd96e4ddc5e9ba780', 'a@gmail.com', 'tes', 'tes', '1431425544-akufotocewe1.jpg', 2, 1),
(11, 'd', '8277e0910d750195b448797616e091ad', 'a@gmail.com', 'saskia', 'tes', '347546179-akufotocewe2.jpg', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `userID` (`user_id`);

--
-- Indeks untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`foto_id`),
  ADD KEY `albumID` (`album_id`,`user_id`),
  ADD KEY `userID` (`user_id`);

--
-- Indeks untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `fotoID` (`foto_id`,`user_id`),
  ADD KEY `userID` (`user_id`);

--
-- Indeks untuk tabel `like_foto`
--
ALTER TABLE `like_foto`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `fotoID` (`foto_id`,`user_id`),
  ADD KEY `userID` (`user_id`),
  ADD KEY `foto_id` (`foto_id`,`user_id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `notifikasi_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `id_role` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `foto`
--
ALTER TABLE `foto`
  MODIFY `foto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `like_foto`
--
ALTER TABLE `like_foto`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD CONSTRAINT `komentar_foto_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_foto_ibfk_2` FOREIGN KEY (`foto_id`) REFERENCES `foto` (`foto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `like_foto`
--
ALTER TABLE `like_foto`
  ADD CONSTRAINT `like_foto_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_foto_ibfk_2` FOREIGN KEY (`foto_id`) REFERENCES `foto` (`foto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
