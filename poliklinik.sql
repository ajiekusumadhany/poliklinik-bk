-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Nov 2024 pada 07.35
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
-- Database: `poliklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`) VALUES
(32, 'Dr. Raka Pratama, Sp.PD', 'Jl. Mawar No. 10, Bandung', '081256829034'),
(33, 'Dr. Maya Santoso, Sp.KJ', 'Dr. Maya Santoso, Sp.KJ', '085789368236'),
(34, 'Dr. Andi Raharjo, Sp.A', 'Dr. Andi Raharjo, Sp.A', '089689367333'),
(35, 'Dr. Karina Wijaya, Sp.M', 'Jl. Kenanga No. 8, Yogyakarta', '082167999362'),
(36, 'Dr. Jaka Aditya, Sp.OG', 'Dr. Jaka Aditya, Sp.OG', '087867833925'),
(37, 'Dr. Zerin Valtara', 'Jl. Gajah Mada No. 7, Semarang', '082241928547'),
(38, 'Dr. Ahmad Setiawan', 'Jl. Mawar No. 123, Jakarta Selatan', '081234567890'),
(39, 'Dr. Sarah Wijaya', 'Jl. Melati No. 45, Jakarta Pusat', '082345678901'),
(40, 'Dr. Budi Santoso', 'Jl. Anggrek No. 67, Bandung', '083456789012'),
(41, 'Dr. Maya Putri', 'Jl. Dahlia No. 89, Surabaya', '084567890123'),
(42, 'Dr. Rudi Hartono', 'Jl. Kenanga No. 12, Yogyakarta', '085678901234'),
(44, 'Dr. Eko Prasetyo', 'Jl. Cempaka No. 56, Malang', '087890123456'),
(45, 'Dr. Lina Kusuma', 'Jl. Flamboyan No. 78, Medan', '088901234567'),
(46, 'Dr. Hadi Wijaya', 'Jl. Bougenville No. 90, Palembang', '089012345678'),
(47, 'Dr. Siti Rahayu', 'Jl. Teratai No. 23, Makassar', '081123456789'),
(48, 'Dr. Irfan Malik', 'Jl. Lotus No. 45, Denpasar', '082234567890'),
(49, 'Dr. Nina Sari', 'Jl. Gardenia No. 67, Padang', '083345678901'),
(50, 'Dr. Denny Pratama', 'Jl. Jasmine No. 89, Manado', '084456789012'),
(51, 'Dr. Ratna Dewi', 'Jl. Kamboja No. 12, Balikpapan', '085567890123'),
(52, 'Dr. Fajar Ramadhan', 'Jl. Sakura No. 34, Samarinda', '086678901234');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_hp`) VALUES
(4, 'Budi Wicaksono', 'Jl. Kebon Sirih No. 5, Jakarta', '081234567890'),
(5, 'Rina Anggraeni', 'Jl. Diponegoro No. 10, Bandung', '085798765432'),
(6, 'Vanna Indira', 'Jl. Gajah Mada No. 15, Surabaya', '089612345678'),
(7, 'Nia Hapsari', 'Jl. Malioboro No. 8, Yogyakarta', '082156781234'),
(8, 'Ayne Luvella', 'Jl. Pemuda No. 12, Semarang', '087890123456'),
(9, 'Ahmad Rizki', 'Jl. Merdeka No. 123, Jakarta Selatan', '081234567890'),
(10, 'Siti Nurhaliza', 'Jl. Sudirman No. 45, Jakarta Pusat', '082345678909'),
(11, 'Budi Santoso', 'Jl. Gatot Subroto No. 67, Jakarta Timur', '083456789012'),
(12, 'Dewi Lestari', 'Jl. Thamrin No. 89, Jakarta Barat', '084567890123'),
(13, 'Muhammad Fahri', 'Jl. Asia Afrika No. 12, Bandung', '085678901234'),
(14, 'Rina Wijaya', 'Jl. Diponegoro No. 34, Surabaya', '086789012345'),
(15, 'Andi Prasetyo', 'Jl. Pahlawan No. 56, Semarang', '087890123456'),
(16, 'Nina Kartika', 'Jl. Ahmad Yani No. 78, Yogyakarta', '088901234567'),
(17, 'Doni Kusuma', 'Jl. Veteran No. 90, Malang', '089012345678'),
(18, 'Eva Susanti', 'Jl. Pemuda No. 23, Solo', '081123456789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periksa`
--

CREATE TABLE `periksa` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pasien` int(11) UNSIGNED DEFAULT NULL,
  `id_dokter` int(11) UNSIGNED DEFAULT NULL,
  `tgl_periksa` datetime DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `obat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `periksa`
--

INSERT INTO `periksa` (`id`, `id_pasien`, `id_dokter`, `tgl_periksa`, `catatan`, `obat`) VALUES
(5, 6, 35, '2024-11-07 12:36:00', 'Infeksi virus, demam tinggi.', 'Neoferol'),
(6, 8, 33, '2024-11-05 09:44:00', 'Kecemasan & sulit tidur.', 'Calmadon'),
(7, 4, 34, '2024-11-04 11:45:00', 'Banyak minum air', 'Panacevex'),
(8, 7, 36, '2024-11-03 22:00:00', 'Tekanan darah tinggi', 'Cardiprex'),
(9, 5, 32, '2024-11-01 12:50:00', 'Alergi ', 'Histaminol '),
(11, 15, 46, '2024-11-07 12:35:00', 'Sakit Kepala', 'Paracetamol');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(10, 'ajiekusumadhany', '$2y$10$jPMVz4eSpdDjdZDZrbjUx.gs9jL5Wq8hDGXq4i242k3/pL.22.yha'),
(11, 'admin', '$2y$10$HHW.PKdu8ntBlEfu7URrmusnNmKuYZ.c/PFf1yVnH9OC5lClQvmKK'),
(12, 'adfggg', '$2y$10$kQQZW6IdYJN0zwU39qX/K.9UO.c/A7KBGfnxa8u6i1rd8RqjMlbeG'),
(13, 'aaaaa', '$2y$10$tQ8nTl6a8q5AxYlDwzDhC.Mi76q47VKICDSJxKuUhS8yuQ8TKFnji'),
(14, 'abcdefgh', 'e8dc4081b13434b45189a720b77b6818');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `periksa_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
