-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 10:36 AM
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
-- Database: `db_smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `ta_admin`
--

CREATE TABLE `ta_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_nama` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_admin`
--

INSERT INTO `ta_admin` (`admin_id`, `admin_nama`, `admin_password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `ta_alternatif`
--

CREATE TABLE `ta_alternatif` (
  `alternatif_id` int(11) NOT NULL,
  `alternatif_kode` varchar(10) NOT NULL,
  `alternatif_nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_alternatif`
--

INSERT INTO `ta_alternatif` (`alternatif_id`, `alternatif_kode`, `alternatif_nama`) VALUES
(1, 'A1', 'Wedding Package'),
(2, 'A2', 'Birthday Party Package'),
(3, 'A3', 'Gathering & Arisan Package'),
(4, 'A4', 'Outing Class / Study Tour Package'),
(5, 'A5', 'Corporate Event / Team Building Package'),
(6, 'A6', 'Photo & Creative Content Package');

-- --------------------------------------------------------

--
-- Table structure for table `ta_kriteria`
--

CREATE TABLE `ta_kriteria` (
  `kriteria_id` int(11) NOT NULL,
  `kriteria_kode` varchar(10) NOT NULL,
  `kriteria_nama` varchar(150) NOT NULL,
  `kriteria_kategori` varchar(20) NOT NULL,
  `kriteria_bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_kriteria`
--

INSERT INTO `ta_kriteria` (`kriteria_id`, `kriteria_kode`, `kriteria_nama`, `kriteria_kategori`, `kriteria_bobot`) VALUES
(1, 'C1', 'Potensi Pendapatan', 'Benefit', 0.3),
(2, 'C2', 'Frekuensi Permintaan Pasar', 'Benefit', 0.25),
(3, 'C3', 'Keunggulan Diferensiasi Produk', 'Benefit', 0.2),
(4, 'C4', 'Kemudahan Operasional', 'Benefit', 0.15),
(5, 'C5', 'Kesesuaian dengan Target Pasar', 'Benefit', 0.1);

-- --------------------------------------------------------

--
-- Table structure for table `ta_subkriteria`
--

CREATE TABLE `ta_subkriteria` (
  `subkriteria_id` int(11) NOT NULL,
  `subkriteria_kode` varchar(10) NOT NULL,
  `kriteria_kode` varchar(10) NOT NULL,
  `subkriteria_bobot` float NOT NULL,
  `subkriteria_keterangan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_subkriteria`
--

INSERT INTO `ta_subkriteria` (`subkriteria_id`, `subkriteria_kode`, `kriteria_kode`, `subkriteria_bobot`, `subkriteria_keterangan`) VALUES
(1, 'SC1-1', 'C1', 1, 'Sangat Rendah'),
(2, 'SC1-2', 'C1', 2, 'Rendah'),
(3, 'SC1-3', 'C1', 3, 'Sedang'),
(4, 'SC1-4', 'C1', 4, 'Tinggi'),
(5, 'SC1-5', 'C1', 5, 'Sangat Tinggi'),
(6, 'SC2-1', 'C2', 1, 'Sangat Rendah'),
(7, 'SC2-2', 'C2', 2, 'Rendah'),
(8, 'SC2-3', 'C2', 3, 'Sedang'),
(9, 'SC2-4', 'C2', 4, 'Tinggi'),
(10, 'SC2-5', 'C2', 5, 'Sangat Tinggi'),
(11, 'SC3-1', 'C3', 1, 'Sangat Rendah'),
(12, 'SC3-2', 'C3', 2, 'Rendah'),
(13, 'SC3-3', 'C3', 3, 'Sedang'),
(14, 'SC3-4', 'C3', 4, 'Tinggi'),
(15, 'SC3-5', 'C3', 5, 'Sangat Tinggi'),
(16, 'SC4-1', 'C4', 1, 'Sangat Rendah'),
(17, 'SC4-2', 'C4', 2, 'Rendah'),
(18, 'SC4-3', 'C4', 3, 'Sedang'),
(19, 'SC4-4', 'C4', 4, 'Tinggi'),
(20, 'SC4-5', 'C4', 5, 'Sangat Tinggi'),
(21, 'SC5-1', 'C5', 1, 'Sangat Rendah'),
(22, 'SC5-2', 'C5', 2, 'Rendah'),
(23, 'SC5-3', 'C5', 3, 'Sedang'),
(24, 'SC5-4', 'C5', 4, 'Tinggi'),
(25, 'SC5-5', 'C5', 5, 'Sangat Tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `ta_user`
--

CREATE TABLE `ta_user` (
  `user_id` int(11) NOT NULL,
  `user_kode` varchar(10) DEFAULT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ta_user`
--

INSERT INTO `ta_user` (`user_id`, `user_kode`, `user_nama`, `user_password`) VALUES
(1, 'U001', 'user', 'user123'),
(3, 'U002', 'ayu', 'Ayu12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `nilai_id` int(11) NOT NULL,
  `alternatif_kode` varchar(10) NOT NULL,
  `kriteria_kode` varchar(10) NOT NULL,
  `nilai_faktor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_nilai`
--

INSERT INTO `tb_nilai` (`nilai_id`, `alternatif_kode`, `kriteria_kode`, `nilai_faktor`) VALUES
(1, 'A1', 'C1', 5),
(2, 'A1', 'C2', 2),
(3, 'A1', 'C3', 5),
(4, 'A1', 'C4', 2),
(5, 'A1', 'C5', 3),
(6, 'A2', 'C1', 3),
(7, 'A2', 'C2', 3),
(8, 'A2', 'C3', 4),
(9, 'A2', 'C4', 3),
(10, 'A2', 'C5', 4),
(11, 'A3', 'C1', 2),
(12, 'A3', 'C2', 4),
(13, 'A3', 'C3', 3),
(14, 'A3', 'C4', 4),
(15, 'A3', 'C5', 3),
(16, 'A4', 'C1', 2),
(17, 'A4', 'C2', 5),
(18, 'A4', 'C3', 3),
(19, 'A4', 'C4', 4),
(20, 'A4', 'C5', 5),
(21, 'A5', 'C1', 5),
(22, 'A5', 'C2', 2),
(23, 'A5', 'C3', 4),
(24, 'A5', 'C4', 2),
(25, 'A5', 'C5', 3),
(26, 'A6', 'C1', 2),
(27, 'A6', 'C2', 3),
(28, 'A6', 'C3', 4),
(29, 'A6', 'C4', 5),
(30, 'A6', 'C5', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ta_admin`
--
ALTER TABLE `ta_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ta_alternatif`
--
ALTER TABLE `ta_alternatif`
  ADD PRIMARY KEY (`alternatif_id`);

--
-- Indexes for table `ta_kriteria`
--
ALTER TABLE `ta_kriteria`
  ADD PRIMARY KEY (`kriteria_id`);

--
-- Indexes for table `ta_subkriteria`
--
ALTER TABLE `ta_subkriteria`
  ADD PRIMARY KEY (`subkriteria_id`);

--
-- Indexes for table `ta_user`
--
ALTER TABLE `ta_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`nilai_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ta_admin`
--
ALTER TABLE `ta_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ta_alternatif`
--
ALTER TABLE `ta_alternatif`
  MODIFY `alternatif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ta_kriteria`
--
ALTER TABLE `ta_kriteria`
  MODIFY `kriteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ta_subkriteria`
--
ALTER TABLE `ta_subkriteria`
  MODIFY `subkriteria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ta_user`
--
ALTER TABLE `ta_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `nilai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
