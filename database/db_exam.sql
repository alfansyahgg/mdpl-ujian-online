-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 09:04 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id_dosen` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`id_dosen`, `user_id`, `nama`) VALUES
(1001, 1, 'Rahmat Rahmatan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_hasil_ujian`
--

CREATE TABLE `tb_hasil_ujian` (
  `id_hasil` int(5) NOT NULL,
  `id_module` int(5) NOT NULL,
  `nis` int(5) NOT NULL,
  `nilai` double NOT NULL,
  `jawaban` varchar(100) NOT NULL,
  `tanggal_input` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_hasil_ujian`
--

INSERT INTO `tb_hasil_ujian` (`id_hasil`, `id_module`, `nis`, `nilai`, `jawaban`, `tanggal_input`) VALUES
(0, 32855, 16425, 66.666666666667, 'A,A,B', '2021-12-21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mata_pelajaran`
--

CREATE TABLE `tb_mata_pelajaran` (
  `id_matpel` int(5) NOT NULL,
  `matpel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_mata_pelajaran`
--

INSERT INTO `tb_mata_pelajaran` (`id_matpel`, `matpel`) VALUES
(1, 'IPS'),
(2, 'IPA'),
(3, 'Matematika'),
(4, 'Bahasa Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_modul_soal`
--

CREATE TABLE `tb_modul_soal` (
  `id_module` int(5) NOT NULL,
  `nama_module` varchar(30) NOT NULL,
  `matpel` varchar(50) NOT NULL,
  `waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_modul_soal`
--

INSERT INTO `tb_modul_soal` (`id_module`, `nama_module`, `matpel`, `waktu`) VALUES
(15147, 'Ujian Tengah Semester', '3', 120),
(32855, 'Ulangan Harian', '3', 120),
(59982, 'Ujian IPS', '1', 60);

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` int(10) NOT NULL,
  `user_id` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` enum('A','B','C','D') NOT NULL,
  `angkatan` char(4) NOT NULL DEFAULT '1970'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `user_id`, `nama`, `kelas`, `angkatan`) VALUES
(16425, 2, 'Wawansyah', 'A', '1970');

-- --------------------------------------------------------

--
-- Table structure for table `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` int(5) NOT NULL,
  `id_module` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `soal` text NOT NULL,
  `jawaban` text NOT NULL,
  `pilihan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_soal`
--

INSERT INTO `tb_soal` (`id_soal`, `id_module`, `id_user`, `soal`, `jawaban`, `pilihan`) VALUES
(11, 32855, 1, 'Berapakah Hasil 2 x 3 ?', 'A', '6,5,3'),
(12, 32855, 1, 'Berapakah Hasil 6 + 2?', 'C', '6,5,8'),
(13, 32855, 1, '9 + 9 ?', 'B', '12,18,23'),
(14, 59982, 1, 'Indonesia Merdeka pada tahun?', 'C', '2001,2002,1945'),
(15, 59982, 1, 'Soekarno lahir di kota?', 'A', 'Blitar,Blora,Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('siswa','dosen','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`) VALUES
(1, 'rahmat@gmail.com', '202cb962ac59075b964b07152d234b70', 'dosen'),
(2, 'wawan@gmail.com', '202cb962ac59075b964b07152d234b70', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_hasil_ujian`
--
ALTER TABLE `tb_hasil_ujian`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indexes for table `tb_mata_pelajaran`
--
ALTER TABLE `tb_mata_pelajaran`
  ADD PRIMARY KEY (`id_matpel`);

--
-- Indexes for table `tb_modul_soal`
--
ALTER TABLE `tb_modul_soal`
  ADD PRIMARY KEY (`id_module`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_mata_pelajaran`
--
ALTER TABLE `tb_mata_pelajaran`
  MODIFY `id_matpel` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_modul_soal`
--
ALTER TABLE `tb_modul_soal`
  MODIFY `id_module` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96517;

--
-- AUTO_INCREMENT for table `tb_soal`
--
ALTER TABLE `tb_soal`
  MODIFY `id_soal` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD CONSTRAINT `tb_dosen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
