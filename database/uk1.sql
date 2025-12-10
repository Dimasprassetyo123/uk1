-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2025 at 04:53 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uk1`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album`
--

CREATE TABLE `gallery_album` (
  `AlbumID` int NOT NULL,
  `NamaAlbum` varchar(255) NOT NULL,
  `Deskripsi` text,
  `TanggalDibuat` date DEFAULT (curdate()),
  `UserID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallery_album`
--

INSERT INTO `gallery_album` (`AlbumID`, `NamaAlbum`, `Deskripsi`, `TanggalDibuat`, `UserID`) VALUES
(5, 'Pemandangan', 'Pemandangan di sore hari', '2025-09-18', 4),
(7, 'Gambar ai', 'Gambar ini buatan ai', '2025-09-22', 1),
(8, 'Agus', 'p', '2025-09-22', 5);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_foto`
--

CREATE TABLE `gallery_foto` (
  `FotoID` int NOT NULL,
  `JudulFoto` varchar(255) DEFAULT NULL,
  `DeskripsiFoto` text,
  `TanggalUnggah` date DEFAULT (curdate()),
  `LokasiFile` varchar(255) NOT NULL,
  `AlbumID` int DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `IsPrivate` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallery_foto`
--

INSERT INTO `gallery_foto` (`FotoID`, `JudulFoto`, `DeskripsiFoto`, `TanggalUnggah`, `LokasiFile`, `AlbumID`, `UserID`, `IsPrivate`) VALUES
(8, 'Memandang mu', 'Melihat mu bersamanya', '2025-09-18', '1758176407_gambar1.jpeg', 5, 4, 0),
(11, 'Gambar ai', 'Gambar ini buatan ai', '2025-09-22', '1758504039_ChatGPT Image Sep 11, 2025, 02_30_48 PM.png', 7, 1, 1),
(13, 'Test', 'p', '2025-09-22', '1758510033_Ciuman dari Hijab dengan Hati.png', 8, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_komentarfoto`
--

CREATE TABLE `gallery_komentarfoto` (
  `KomentarID` int NOT NULL,
  `FotoID` int DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `IsiKomentar` text NOT NULL,
  `TanggalKomentar` date DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallery_komentarfoto`
--

INSERT INTO `gallery_komentarfoto` (`KomentarID`, `FotoID`, `UserID`, `IsiKomentar`, `TanggalKomentar`) VALUES
(55, 8, 1, '😍😍😍 Cantik banget masyaaloah', '2025-09-20'),
(56, 8, 1, 'Bagusss', '2025-09-20'),
(57, 8, 1, 'masyaalah', '2025-09-20'),
(58, 11, 5, '😍😍😍 Cantik banget', '2025-09-22'),
(59, 11, 4, 'p', '2025-09-22'),
(60, 13, 4, 'p', '2025-09-22'),
(61, 13, 4, 'p', '2025-09-22'),
(62, 13, 4, 'p', '2025-09-22'),
(63, 11, 6, 'haha kocak', '2025-10-01'),
(66, 13, 4, 'p', '2025-11-25'),
(67, 13, 4, 'p', '2025-11-25'),
(68, 13, 4, 'p', '2025-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_likefoto`
--

CREATE TABLE `gallery_likefoto` (
  `LikeID` int NOT NULL,
  `FotoID` int DEFAULT NULL,
  `UserID` int DEFAULT NULL,
  `TanggalLike` date DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallery_likefoto`
--

INSERT INTO `gallery_likefoto` (`LikeID`, `FotoID`, `UserID`, `TanggalLike`) VALUES
(37, 8, 4, '2025-09-18'),
(41, 8, 1, '2025-09-20'),
(42, 11, 1, '2025-09-22'),
(43, 8, 5, '2025-09-22'),
(45, 11, 5, '2025-09-22'),
(46, 13, 5, '2025-09-22'),
(47, 13, 4, '2025-09-22'),
(49, 11, 6, '2025-10-01'),
(53, 11, 4, '2025-10-27'),
(55, 13, 8, '2025-11-25'),
(56, 11, 8, '2025-11-25'),
(57, 8, 8, '2025-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_user`
--

CREATE TABLE `gallery_user` (
  `UserID` int NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) DEFAULT NULL,
  `Alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gallery_user`
--

INSERT INTO `gallery_user` (`UserID`, `Username`, `Password`, `Email`, `NamaLengkap`, `Alamat`) VALUES
(1, 'dimas', '$2y$10$wWOmHUB9q0uDb6H45gNQjez1HcWd3PtJexB6jjI26vctFpRFVL9Tu', 'dimas@gmail.com', 'Dimas Prassetyo', 'sukahurip'),
(2, 'Faik', '$2y$10$CwuKLCzgcoTN/jcSoivn8.ZxaIGnBxXsCPAENcdsPfto.5DFPsWv6', 'faik@gmail.com', 'Faik Frayoga', 'sukahurip'),
(4, 'Putra', '$2y$10$NcQFvpOiPer2JaNIkODAsuu.OkYzCbDJR0JRYKYP8baszDg1wIt/2', 'putra@gmail.com', 'Putra ciput', 'kuburan'),
(5, 'Agus', '$2y$10$voYk9N7YghlP6efR3O5KPeQ.fZ5B9R7NwErk67uC78q2mUSon8C1W', 'agus@gmail.com', 'Agus Kusmianto', 'Banjar'),
(6, 'Prassetyo', '$2y$10$2e2aJKwoec4sQSsmMJrfuuyE2XVM4Lf3PD/dnTU.bDSbqWxmKEbka', 'prassetyo@gmail.com', 'Dimas Prassetyo', 'banjar'),
(7, 'yanto', '$2y$10$4kgfVWFiziHuYqaOgZF3K.jjJKqMlW17mrh0CiB3TDnV7uDpvMwOq', 'yanto@gmail.com', 'yanto toto', 'ciamis'),
(8, 'guz', '$2y$10$.iDCGdMcGbPm0ou14O86heI21KjqS2D7ZrG.3/vEn57.XTIUtOQt2', 'guz@gmail.com', 'guzhaw', 'banjar');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`AlbumID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `gallery_foto`
--
ALTER TABLE `gallery_foto`
  ADD PRIMARY KEY (`FotoID`),
  ADD KEY `AlbumID` (`AlbumID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `gallery_komentarfoto`
--
ALTER TABLE `gallery_komentarfoto`
  ADD PRIMARY KEY (`KomentarID`),
  ADD KEY `FotoID` (`FotoID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `gallery_likefoto`
--
ALTER TABLE `gallery_likefoto`
  ADD PRIMARY KEY (`LikeID`),
  ADD KEY `FotoID` (`FotoID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `gallery_user`
--
ALTER TABLE `gallery_user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `AlbumID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_foto`
--
ALTER TABLE `gallery_foto`
  MODIFY `FotoID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gallery_komentarfoto`
--
ALTER TABLE `gallery_komentarfoto`
  MODIFY `KomentarID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `gallery_likefoto`
--
ALTER TABLE `gallery_likefoto`
  MODIFY `LikeID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `gallery_user`
--
ALTER TABLE `gallery_user`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD CONSTRAINT `gallery_album_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `gallery_user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_foto`
--
ALTER TABLE `gallery_foto`
  ADD CONSTRAINT `gallery_foto_ibfk_1` FOREIGN KEY (`AlbumID`) REFERENCES `gallery_album` (`AlbumID`) ON DELETE CASCADE,
  ADD CONSTRAINT `gallery_foto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `gallery_user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_komentarfoto`
--
ALTER TABLE `gallery_komentarfoto`
  ADD CONSTRAINT `gallery_komentarfoto_ibfk_1` FOREIGN KEY (`FotoID`) REFERENCES `gallery_foto` (`FotoID`) ON DELETE CASCADE,
  ADD CONSTRAINT `gallery_komentarfoto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `gallery_user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_likefoto`
--
ALTER TABLE `gallery_likefoto`
  ADD CONSTRAINT `gallery_likefoto_ibfk_1` FOREIGN KEY (`FotoID`) REFERENCES `gallery_foto` (`FotoID`) ON DELETE CASCADE,
  ADD CONSTRAINT `gallery_likefoto_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `gallery_user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
