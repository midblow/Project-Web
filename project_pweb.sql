-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 07:03 PM
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
-- Database: `project_pweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email_admin`) VALUES
(1, 'alfinnashirul', 'fins123', 'professional@gmail.com'),
(2, 'rewin', 'okeoke', 'rewind@gmail.com'),
(3, 'brambo', 'bas123', 'bram@gmail.com');

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
  `metode_pembayaran` enum('bri','bca','mandiri','bni','alfamart','indomart','dana','ovo','shopeepay','linkaja') NOT NULL,
  `id_venue` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `start_date`, `end_date`, `status`, `metode_pembayaran`, `id_venue`) VALUES
(1, 1, '2024-06-07', '2024-06-07', 'confirmed', 'bca', 1),
(72, 2, '2024-06-01', '2024-06-01', 'confirmed', 'alfamart', 1),
(74, 2, '2024-06-09', '2024-06-09', 'confirmed', 'alfamart', 1),
(75, 3, '2024-06-11', '2024-06-12', 'waiting', 'bri', 1),
(76, 3, '2024-06-28', '2024-06-29', 'confirmed', 'mandiri', 1),
(77, 4, '2024-06-23', '2024-06-24', 'waiting', 'linkaja', 1),
(80, 2, '2024-06-25', '2024-06-27', 'waiting', 'mandiri', 1),
(81, 3, '2024-06-02', '2024-06-02', 'waiting', 'indomart', 1),
(82, 4, '2024-06-18', '2024-06-19', 'waiting', 'bri', 1),
(83, 4, '2024-06-06', '2024-06-06', 'waiting', 'shopeepay', 1),
(85, 2, '2024-06-13', '2024-06-14', 'confirmed', 'indomart', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'Jaka', 'dummy@gmail.com', '(+62) 823 4107 8424', 'kerenn', '2024-05-14 20:56:13'),
(23, 'wjdiajwdi', 'gusbram66@gmail.com', '08786444156', '1', '2024-05-20 16:19:52'),
(24, 'rifky1111', 'gusbram66@gmail.com', '08786444153', '1', '2024-05-20 16:20:04'),
(25, 'rifky1111', 'gusbram66@gmail.com', '08786444153', '1', '2024-05-20 16:20:23'),
(26, 'wjdiajwdi', 'gusbram66@gmail.com', '08786444156', '1', '2024-05-20 16:22:12'),
(28, 'rifky1111', 'gusbram66@gmail.com', '123', 'tele', '2024-05-20 16:30:07'),
(29, 'adelolok', 'dehayeka@yahoo.ci.id', '88888', 'aku anak muda', '2024-05-20 16:37:19'),
(30, 'wjdiajwdi', 'gusbram66@gmail.com', '92392', 'wdaw', '2024-05-20 17:30:40'),
(32, 'wjdiajwdi', 'wdaiji@gmail.com', '08786444156', 'apasaja', '2024-05-21 09:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `nama_event` varchar(255) NOT NULL,
  `jenis_event` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `id_event` int(255) NOT NULL,
  `informasi` text NOT NULL,
  `rules` text NOT NULL,
  `rekomendasi` tinyint(1) NOT NULL,
  `gambar` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` enum('waiting','confirmed','rejected') DEFAULT 'waiting',
  `id_venue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`nama_event`, `jenis_event`, `deskripsi`, `id_event`, `informasi`, `rules`, `rekomendasi`, `gambar`, `id_user`, `status`, `id_venue`) VALUES
('Futsala Smala', 'Olahraga, Sport, Turnamen', 'Selamat datang di Turnamen Futsala Smala 2024, sebuah perhelatan akbar yang menggabungkan semangat kompetisi dan persahabatan dalam olahraga futsal. Acara ini diadakan untuk memupuk semangat olahraga di kalangan masyarakat yang diselenggarakan oleh SMAN 5 Mataram.', 1, '1. Kesehatan dan Keamanan Peserta: SOP mengenai pemeriksaan kesehatan peserta dan prosedur tindakan darurat, serta pembatasan peserta jika kondisi fisik mereka memerlukan perhatian khusus.\r\n\r\n2. Tata Tertib dan Aturan Kompetisi: SOP akan mengatur tata tertib acara, aturan kompetisi, dan kode etik yang harus diikuti oleh semua peserta. Ini termasuk hukuman atau sanksi jika aturan dilanggar.\r\n\r\n3. Penyelenggaraan Acara: SOP akan mencakup persiapan dan penyelenggaraan acara, termasuk logistik, jadwal, dan penggunaan fasilitas. Hal ini juga melibatkan perencanaan untuk segala kemungkinan masalah yang mungkin muncul selama acara.', 'Perizinan Acara: Anda perlu mendapatkan izin resmi dari pemerintah setempat, seperti Dinas Pemuda dan Olahraga, untuk mengadakan acara olahraga. Ini mencakup mengajukan proposal acara, membayar biaya perizinan, dan menentukan tanggal serta lokasi yang diizinkan.\r\n\r\nIzin Tempat: Anda harus mengurus izin dari pemilik tempat atau fasilitas olahraga yang akan Anda gunakan. Ini juga melibatkan pembayaran sewa lokasi dan menentukan aturan penggunaan fasilitas.', 0, '../uploads/Futsal.jpg', 2, 'confirmed', 1),
('Senggigi Sunset Jazz', 'Music, Konser', 'Konser SSJ (Senggigi Sunset Jazz) adalah sebuah acara musik tahunan yang diadakan di pantai Senggigi, Lombok, Nusa Tenggara Barat. Konser ini memadukan keindahan alam dengan musik jazz berkualitas, menciptakan pengalaman unik bagi para penonton. Dengan latar belakang matahari terbenam yang memukau dan suara ombak yang menenangkan, konser ini menarik perhatian penggemar jazz dari berbagai daerah. (By Erwin)', 2, '1. Kesehatan dan Keamanan Peserta: SOP mengenai pemeriksaan kesehatan peserta dan prosedur tindakan darurat, serta pembatasan peserta jika kondisi fisik mereka memerlukan perhatian khusus.\r\n2. Tata Tertib dan Aturan Kompetisi: SOP akan mengatur tata tertib acara, aturan kompetisi, dan kode etik yang harus diikuti oleh semua peserta. Ini termasuk hukuman atau sanksi jika aturan dilanggar.\r\n3. Penyelenggaraan Acara: SOP akan mencakup persiapan dan penyelenggaraan acara, termasuk logistik, jadwal, dan penggunaan fasilitas. Hal ini juga melibatkan perencanaan untuk segala kemungkinan masalah yang mungkin muncul selama acara.', 'Perizinan Acara: Anda perlu mendapatkan izin resmi dari pemerintah setempat, seperti Dinas Pemuda dan Olahraga, untuk mengadakan acara olahraga. Ini mencakup mengajukan proposal acara, membayar biaya perizinan, dan menentukan tanggal serta lokasi yang diizinkan.\r\n\r\nIzin Tempat: Anda harus mengurus izin dari pemilik tempat atau fasilitas olahraga yang akan Anda gunakan. Ini juga melibatkan pembayaran sewa lokasi dan menentukan aturan penggunaan fasilitas.', 0, '../uploads/Senggigi_Sunset_Jazz.jpg', 2, 'confirmed', 1),
('Memofest Festival', 'festival', '', 3, '', '', 0, '', 2, 'waiting', 1),
('Konser Dewa 19', 'festivalggg', 'aagg', 4, 'aggg', 'kon', 1, '../uploads/resized_Rectangle 1304.jpg', 2, 'confirmed', 1),
('Event Test 11', '', 'Deskripsi Event 11', 11, '', '', 0, '', 11, 'waiting', 1),
('Event Test 12', '', 'Deskripsi Event 12', 12, '', '', 0, '', 11, 'confirmed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id_invoice` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('bri','bca','mandiri','bni','alfamart','indomart','dana','ovo','shopeepay','linkaja') NOT NULL,
  `service_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id_invoice`, `booking_id`, `date`, `total_amount`, `payment_method`, `service_fee`) VALUES
(1, 1, '2024-06-02', 1050000.00, 'bca', 50000.00),
(3, 80, '2024-06-03', 3050000.00, 'mandiri', 50000.00),
(4, 81, '2024-06-03', 1050000.00, 'indomart', 50000.00),
(5, 76, '2024-06-03', 2050000.00, 'mandiri', 50000.00),
(6, 72, '2024-06-03', 1050000.00, 'alfamart', 50000.00),
(7, 1, '2024-06-03', 1050000.00, 'bca', 50000.00),
(8, 74, '2024-06-03', 1050000.00, 'alfamart', 50000.00),
(9, 85, '2024-06-03', 2050000.00, 'indomart', 50000.00),
(10, 76, '2024-06-03', 2050000.00, 'mandiri', 50000.00);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`id_provider`, `gmail`, `username`, `lembaga`, `password`, `nomorhp`, `alamat`) VALUES
(1, 'gusbram@gmail.com', 'Gusbram ', '', 'gus321', 87722454570, 'Jl. Gelatik'),
(2, 'alfin@gmail.com', 'alfinnashirul', 'PT Darma Sentosa', 'fin123', 81234567, 'JL. Raya Tanjung'),
(3, 'erwin@gmail.com', 'rewind', 'PT. Makmur Jaya Sentosa', 'oke', 83212345678, 'Jl. Kuranji, Gusbram'),
(11, 'provider11@example.com', 'provider11', 'Lembaga Test 11', 'password', 9876543210, 'Alamat Provider 11');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `gmail`, `name`, `password`, `gender`, `nomorhp`, `alamat`) VALUES
(1, 'zainuddin@gmail.com', 'Zainuddin Putera', 'password', 'Laki-laki', 987654321, 'Jl. Utama No. 1'),
(2, 'erwin@gmail.com', 'Erwin', 'oke', 'Laki-laki', 99999, 'rembigan'),
(3, 'alfin@gmail.com', 'alfin', 'alfin', 'Laki-laki', 8786444152, 'rembigan '),
(4, 'gusbram@gmail.com', 'gusbram', 'bram', 'Laki-laki', 8786444156, 'her'),
(5, 'mahal@gmail.com', 'mahal', 'oke', 'Laki-laki', 85512336565, 'Jl. Makanan'),
(6, 'human@gmail.com', 'cewe', 'cewe', 'Perempuan', 8786444156, 'Jj'),
(7, 'iyas@gmail.com', 'iyas', 'iyasgacor11', 'Laki-laki', 8786444156, 'rembiga'),
(8, 'jankrik@gmail.com', 'jang', 'jang', 'Perempuan', 0, 'kota'),
(11, 'testuser@example.com', 'Test User', 'password', 'Laki-laki', 1234567890, 'Alamat Test');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `id_venue` int(10) NOT NULL,
  `nama_venue` varchar(30) DEFAULT NULL,
  `deskripsi_fasilitas` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `penanggung_jawab` varchar(30) DEFAULT NULL,
  `kapasitas` int(30) DEFAULT NULL,
  `harga` int(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `gambar` text NOT NULL,
  `jenis_instansi` enum('Pemerintah','Swasta') DEFAULT NULL,
  `id_provider` int(10) DEFAULT NULL,
  `main_venue` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`id_venue`, `nama_venue`, `deskripsi_fasilitas`, `alamat`, `penanggung_jawab`, `kapasitas`, `harga`, `kota`, `gambar`, `jenis_instansi`, `id_provider`, `main_venue`) VALUES
(1, 'Taman Sangkareang', 'Taman Sangkareang Mataram merupakan salah satu tempat yang sering digunakan untuk berbagai acara seperti kegiatan olahraga, piknik keluarga, festival budaya, dan berbagai kegiatan komunitas.\r\n\r\nFasilitas:\r\n\r\nArea Bermain Anak\r\nJalur Jogging\r\nArea Piknik\r\nKolam Air Mancur\r\nTempat Duduk dan Gazebo\r\nWarung Makanan dan Minuman\r\nTaman Bunga', 'Jl. Kuranji, Gusbram', 'also ', 10000, 1000000, 'Mataram', '../uploads/Sangkareang.jpg', 'Pemerintah', 3, 0),
(2, 'Alcapa', 'a', 'Jl. Kuranji, Gusbram', 'also ', 10000, 1000000, 'Mataram', '../uploads/Rectangle 63 (1).jpg', 'Pemerintah', 3, 0),
(30, 'Taman Sangkareang', 'tu dah', 'Jl. Priskila', 'Alfin Nashirul', 10000, 1000000, 'Mataram', '../uploads/Sangkareang.jpg', 'Pemerintah', 2, 0),
(31, 'Gelanggang Pemuda', 'Bagus bang, cobe jee', 'Jl. Jalalaka', 'Jalalaka', 12000, 12000000, 'Mataram', '../uploads/Rectangle 63 (4).jpg', 'Swasta', 3, 0),
(33, 'Hotel Lombok', 'aaaaa', 'Jl. Priskila', 'Jalalaka', 12000, 12000000, 'Praya', '../uploads/Wedding.jpg', 'Pemerintah', 3, 0),
(34, 'Paralayang, Dalam Kebun', 'Masuk kok keren', 'Jalan Antemi', 'Kebun Batu Jalan Layang Langit', 2500, 12000000, 'Cirebon ', '../uploads/Bram.jpeg.jpeg', 'Swasta', 3, 0),
(35, 'Kins Cooffe Semanggi', 'Tempatnya sangat asri penuh dengan wifi', 'JL. Udayana Mataram', 'Om Agus', 100, 1000000, 'Mataram', '../uploads/Rectangle 63.jpg', 'Swasta', 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_venue` (`id_venue`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `fk_user_id` (`id_user`),
  ADD KEY `fk_id_venue` (`id_venue`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id_invoice`),
  ADD KEY `booking_id` (`booking_id`);

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
  ADD PRIMARY KEY (`id_venue`),
  ADD KEY `fk_provider` (`id_provider`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id_provider` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id_venue` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_venue` FOREIGN KEY (`id_venue`) REFERENCES `venue` (`id_venue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_id_venue` FOREIGN KEY (`id_venue`) REFERENCES `venue` (`id_venue`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`);

--
-- Constraints for table `venue`
--
ALTER TABLE `venue`
  ADD CONSTRAINT `fk_provider` FOREIGN KEY (`id_provider`) REFERENCES `provider` (`id_provider`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
