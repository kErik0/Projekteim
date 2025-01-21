-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 04:50 PM
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
-- Database: `de-doublerik`
--

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(128) NOT NULL,
  `nev` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefonszam` varchar(128) NOT NULL,
  `jelszo` varchar(128) NOT NULL,
  `iranyitoszam` int(128) NOT NULL,
  `varos` varchar(128) NOT NULL,
  `utca` varchar(128) NOT NULL,
  `hazszam` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `felhasznalo`
--

INSERT INTO `felhasznalo` (`id`, `felhasznalonev`, `nev`, `email`, `telefonszam`, `jelszo`, `iranyitoszam`, `varos`, `utca`, `hazszam`) VALUES
(1, 'admin', 'Admin Jóska', 'admin@gmail.com', '06702926969', '$2y$10$RwxkSzwXdAgpbYoOu8kTvecdTrg3wZ.fqI.OFVqz/iPQx8TVd34MO', 6900, 'Kuka', 'Szemet', 10),
(2, 'kErik0', 'Kovács Erik', 'kovacs.erik626@gmail.com', '063012345678', '$2y$10$CvkF5nD.6bcC/wl8jgmtl.kdP/o/Kh5TybPKj3f9gn4T9gnUQMK4y', 6969, 'Kaki69', 'Pisike', 69),
(3, 'kismisi02', 'Kis asd', 'kismisi@gmail.com', '06123456789', '$2y$10$hDLRoMnvQzaKJX.UdOsrS.7t/aZbFfPhgmoha5aC5PoC269C.uqQ6', 69659, 'Kucsma', 'Bor', 33),
(5, 'kisheni01', 'Kis Henrietta', 'kisheni@gmail.com', '063012345678', '$2y$10$nlKtluuxWPuZRFSaoO6k1.wbO0NOyBBcfYwXt2Z/bAp5Ua7yk4eUm', 6000, 'Ózd', 'Sinter', 2),
(11, 'Ricky', 'Albert Erik', 'alberterik.tibor@gmail.com', '06702923621', '$2y$10$qt7rIhxc.MQYv078WflCQOktm86Ei4PoXQWwHoznoCVkWqKmRnog.', 6922, 'Földeák', 'Zárda', 33);

-- --------------------------------------------------------

--
-- Table structure for table `ital_ohaj`
--

CREATE TABLE `ital_ohaj` (
  `id` int(11) NOT NULL,
  `nev` varchar(30) DEFAULT NULL,
  `kiszereles` varchar(10) DEFAULT NULL,
  `ar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `ital_ohaj`
--

INSERT INTO `ital_ohaj` (`id`, `nev`, `kiszereles`, `ar`) VALUES
(2, 'Viz', '1 liter', 100),
(3, 'Kalinka', '20', 5000),
(4, 'Kevert', '1', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `kuponok`
--

CREATE TABLE `kuponok` (
  `id` int(11) NOT NULL,
  `kod` varchar(10) DEFAULT NULL,
  `ertek` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `kuponok`
--

INSERT INTO `kuponok` (`id`, `kod`, `ertek`) VALUES
(1, 'KUPON20', 20),
(3, 'kupon50', 50),
(4, 'kupon30', 30);

-- --------------------------------------------------------

--
-- Table structure for table `termekek`
--

CREATE TABLE `termekek` (
  `id` int(11) NOT NULL,
  `azonosito` varchar(128) NOT NULL,
  `nev` varchar(128) NOT NULL,
  `ar` int(128) NOT NULL,
  `akcios_ar` int(128) NOT NULL,
  `mennyiseg` int(128) NOT NULL,
  `tipus` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `termekek`
--

INSERT INTO `termekek` (`id`, `azonosito`, `nev`, `ar`, `akcios_ar`, `mennyiseg`, `tipus`) VALUES
(1, 'kobanyai', 'kőbányai', 300, 240, 0, 'sor'),
(2, 'dreher', 'dreher', 390, 0, 0, 'sor'),
(4, 'heineken', 'heineken', 480, 0, 0, 'sor'),
(5, 'csiki', 'csíki sör', 470, 400, 0, 'sor'),
(6, 'stella', 'stella', 425, 400, 0, 'sor'),
(7, 'tuborg', 'tuborg', 350, 0, 0, 'sor'),
(8, 'lowen', 'löwenbrau', 390, 312, 0, 'sor'),
(9, 'juhasztr', 'Juhász Testvérek (rosé)', 2500, 0, 0, 'bor'),
(10, 'frittmanio', 'Frittmann Irsai Olivér (fehér)', 2450, 0, 0, 'bor'),
(11, 'irsaiony', 'Israi Olivér Nyakas (fehér)', 2690, 0, 0, 'bor'),
(12, 'vargamv', 'Varga Merlot édes (vörös)', 1800, 0, 0, 'bor'),
(13, 'lafieev', 'LaFiesta Édes Élmény (vörös)', 800, 0, 0, 'bor'),
(14, 'lafieef', 'LaFiesta Édes Élmény (fehér)', 800, 0, 0, 'bor'),
(15, 'egribvv', 'Egri Bikavér (vörös)', 1000, 300, 0, 'bor'),
(16, 'szentik', 'Szent István Korona (fehér)', 700, 0, 0, 'bor'),
(17, 'jager', 'Jägermeister', 5500, 0, 0, 'rovid'),
(18, 'jackd', 'Jack Daniels', 9000, 0, 0, 'rovid'),
(19, 'jimb', 'Jim Beam', 5400, 0, 0, 'rovid'),
(20, 'bombay', 'Bombay Sapphire', 7000, 0, 0, 'rovid'),
(21, 'absolute', 'Absolute Blue', 6000, 2000, 0, 'rovid'),
(22, 'malibu', 'Malibu', 7000, 0, 0, 'rovid'),
(23, 'hubi', 'St. Hubertus', 6800, 0, 0, 'rovid'),
(24, 'unicum', 'Zwack Unicum', 9000, 0, 0, 'rovid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ital_ohaj`
--
ALTER TABLE `ital_ohaj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kuponok`
--
ALTER TABLE `kuponok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termekek`
--
ALTER TABLE `termekek`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ital_ohaj`
--
ALTER TABLE `ital_ohaj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kuponok`
--
ALTER TABLE `kuponok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `termekek`
--
ALTER TABLE `termekek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
