-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 04:08 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

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
(2, 'erwin@gmail.com', 'erwin ', '1ee', 'Laki-laki', 8786444152, 'rembigan'),
(3, 'alfinlol@gmail.com', 'rifky anto', 'heriawati', 'Laki-laki', 8786444152, 'rembigan '),
(4, 'rifky@gmail.com', 'rifky', 'a', 'Laki-laki', 8786444156, 'her'),
(5, 'mahal@gmail.com', 'mahal', 'oke', 'Laki-laki', 85512336565, 'Jl. Makanan'),
(6, 'human@gmail.com', 'cewe', 'cewe', 'Perempuan', 8786444156, 'Jj'),
(7, 'iyas@gmail.com', 'iyas', 'iyasgacor11', 'Laki-laki', 8786444156, 'rembiga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
