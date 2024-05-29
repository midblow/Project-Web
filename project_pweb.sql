-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 12:41 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('waiting','confirmed','reserved') NOT NULL,
  `metode_pembayaran` enum('bri','bca','mandiri','bni','alfamart','indomart','dana','ovo','shopeepay','linkaja') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `start_date`, `end_date`, `status`, `metode_pembayaran`) VALUES
(23, 3, '2024-05-16', '2024-05-17', 'reserved', 'bri'),
(25, 3, '2024-05-13', '2024-05-15', 'waiting', 'bri'),
(26, 3, '2024-05-30', '2024-05-31', 'waiting', 'bri'),
(27, 2, '2024-05-01', '2024-05-02', 'waiting', 'bri'),
(28, 2, '2024-05-03', '2024-05-04', 'confirmed', 'mandiri'),
(29, 2, '2024-05-05', '2024-05-06', 'waiting', 'linkaja');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Jaka', 'dummy@gmail.com', '(+62) 823 4107 8424', 'kerenn', '2024-05-14 20:56:13'),
(23, 'wjdiajwdi', 'gusbram66@gmail.com', '08786444156', '1', '2024-05-20 16:19:52'),
(24, 'rifky1111', 'gusbram66@gmail.com', '08786444153', '1', '2024-05-20 16:20:04'),
(25, 'rifky1111', 'gusbram66@gmail.com', '08786444153', '1', '2024-05-20 16:20:23'),
(26, 'wjdiajwdi', 'gusbram66@gmail.com', '08786444156', '1', '2024-05-20 16:22:12'),
(27, 'adelolok', 'lolok@gmail.com', '282828', 'jjjj', '2024-05-20 16:26:27'),
(28, 'rifky1111', 'gusbram66@gmail.com', '123', 'tele', '2024-05-20 16:30:07'),
(29, 'adelolok', 'dehayeka@yahoo.ci.id', '88888', 'aku anak muda', '2024-05-20 16:37:19'),
(30, 'wjdiajwdi', 'gusbram66@gmail.com', '92392', 'wdaw', '2024-05-20 17:30:40'),
(31, 'adelolok', 'erwinhd@gmail.com', '92392', 'aku crt\r\n', '2024-05-20 17:31:04'),
(32, 'wjdiajwdi', 'wdaiji@gmail.com', '08786444156', 'apasaja', '2024-05-21 09:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `id_provider` int(10) NOT NULL,
  `gmail` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `lembaga` varchar(200) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nomorhp` bigint(18) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`id_provider`, `gmail`, `username`, `lembaga`, `password`, `nomorhp`, `alamat`) VALUES
(1, 'gusbram@gmail.com', 'Gusbram ', '', 'gus321', 87722454570, 'Jl. Gelatik'),
(3, 'erwin@gmail.com', 'rewindd', 'PT. Makmur Jaya Sentosa', 'okeoke', 83212345678, 'Jl. Kuranji, Gusbram');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `gmail` varchar(30) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `nomorhp` bigint(18) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `gmail`, `name`, `password`, `gender`, `nomorhp`, `alamat`) VALUES
(2, 'erwin@gmail.com', 'Hasil', 'oke321', 'Laki-laki', 99999, 'rembigan'),
(3, 'alfinlol@gmail.com', 'rifky anto', 'heriawati', 'Laki-laki', 8786444152, 'rembigan '),
(4, 'rifky@gmail.com', 'rifky', 'a', 'Laki-laki', 8786444156, 'her'),
(5, 'mahal@gmail.com', 'mahal', 'oke', 'Laki-laki', 85512336565, 'Jl. Makanan'),
(6, 'human@gmail.com', 'cewe', 'cewe', 'Perempuan', 8786444156, 'Jj'),
(7, 'iyas@gmail.com', 'iyas', 'iyasgacor11', 'Laki-laki', 8786444156, 'rembiga'),
(8, 'jankrik@gmail.com', 'jang', 'jang', 'Perempuan', 0, 'kota'),
(9, 'tai@gmail.com', 'tai', '123', 'Laki-laki', 123, 'jerangkik');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `id_venue` int(10) NOT NULL,
  `nama_venue` varchar(30) DEFAULT NULL,
  `deskripsi_fasilitas` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `penanggung_jawab` varchar(30) DEFAULT NULL,
  `kapasitas` int(30) DEFAULT NULL,
  `harga` int(255) DEFAULT NULL,
  `jenis_event` enum('Olahraga','Esport','Wedding','Festival') DEFAULT NULL,
  `jenis_instansi` enum('Pemerintah','Swasta') DEFAULT NULL,
  `tanggal_pesan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`id_venue`, `nama_venue`, `deskripsi_fasilitas`, `alamat`, `penanggung_jawab`, `kapasitas`, `harga`, `jenis_event`, `jenis_instansi`, `tanggal_pesan`) VALUES
(1, 'Kedai Kupi', 'Kupi doang ne\r\n\r\n-Kursi\r\n-Meja', 'Gemeng', 'Herman', 20, 1250000, 'Festival', 'Pemerintah', '2024-05-30 09:51:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id_provider`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id_venue`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id_provider` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id_venue` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
