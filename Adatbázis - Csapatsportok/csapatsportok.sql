-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2023 at 11:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csapatsportok`
--

-- --------------------------------------------------------

--
-- Table structure for table `csapat`
--

CREATE TABLE `csapat` (
  `Csapatszám` int(11) NOT NULL,
  `csapatnév` varchar(128) NOT NULL,
  `Város` varchar(128) NOT NULL,
  `Év` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `csapat`
--

INSERT INTO `csapat` (`Csapatszám`, `csapatnév`, `Város`, `Év`) VALUES
(1, 'Kiskőrös FC', 'Kiskőrös', '2017-07-03'),
(2, 'Szeged FC', 'Szeged', '2018-06-14'),
(3, 'Budapest Vasas FC', 'Budapest', '2010-07-14'),
(4, 'Kecskemét FC', 'Kecskemét', '2018-07-25'),
(5, 'Kiskunfélegyházi FC', 'Kiskunfélegyháza', '2017-08-17'),
(6, 'Dabasi FC', 'Dabas', '2015-06-16'),
(7, 'Ózdi FC', 'Ózd', '2004-02-03'),
(8, 'Nagykőrös FC', 'Nagykőrös', '2017-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `felhasználó`
--

CREATE TABLE `felhasználó` (
  `Felhasználónév` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Név` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Jelszó` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `felhasználó`
--

INSERT INTO `felhasználó` (`Felhasználónév`, `Név`, `Jelszó`) VALUES
('ali_01', 'Aladin Aladár', '$2y$10$bacnskXIFbNA1lSc/0XIsOuPDHa7rheNxv/X/JaFlrW7U90p6JE4W'),
('kErik0', 'Kovács Erik', '$2y$10$dVhCN9l0BdS6c24cKDM.huyHJMXVPM1Jkw4dag1p0clLjwVz/EGUC'),
('kisheni06', 'Kis Henrietta', '$2y$10$mpYZ4q0X5RtQcdIxXZAfiO08KnrpoDn8vH9cr19Gsxs9BZ1SmgZAe'),
('nagyb56', 'Nagy Bianka', '$2y$10$nSEsHGEiO598mMCzxAYvF.M3FVOOly.cJqKgGSRnI1YOLkZGNtdwm'),
('szucsi01', 'Szűcs Ábel', '$2y$10$wabR8fA7EKxh/gOkkzYBzekvltO15qrfWKVaAdX8yFcYpr3zhuEze');

-- --------------------------------------------------------

--
-- Table structure for table `mérkőzések`
--

CREATE TABLE `mérkőzések` (
  `Mérkőzésszám` int(255) NOT NULL,
  `Eredmény` varchar(128) NOT NULL,
  `Dátum` date NOT NULL,
  `Helyszín` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Csapat_1_id` varchar(128) NOT NULL,
  `Csapat_2_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `mérkőzések`
--

INSERT INTO `mérkőzések` (`Mérkőzésszám`, `Eredmény`, `Dátum`, `Helyszín`, `Csapat_1_id`, `Csapat_2_id`) VALUES
(1, 'Nyertes-vesztes', '2023-10-29', 'Siófok', 'Siófok FC', 'Nagykőrös FC'),
(2, 'Vesztes-nyertes', '2023-11-02', 'Siófok', 'Siófok FC', 'Budapest Vasas FC'),
(3, 'Még nincs', '2023-11-23', 'Kiskunfélegyháza', 'Kiskunfélegyházi FC', 'Kecskemét FC'),
(4, 'Még nincs', '2023-12-11', 'Szeged', 'Kiskunfélegyházi FC', 'Siófok FC'),
(5, 'Nyertes-vesztes', '2023-10-18', 'Kiskőrös', 'Ózdi FC', 'Budapest Vasas FC'),
(7, 'nyertes-vesztes', '2023-11-10', 'Kiskőrös', 'Kiskőrösi FC', 'Nagykőrös FC');

-- --------------------------------------------------------

--
-- Table structure for table `tagok`
--

CREATE TABLE `tagok` (
  `Személyiszám` int(11) NOT NULL,
  `Név` varchar(128) NOT NULL,
  `Születésidátum` date NOT NULL,
  `Állampolgárság` varchar(128) NOT NULL,
  `Poszt` varchar(128) NOT NULL,
  `Csapatszám` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `tagok`
--

INSERT INTO `tagok` (`Személyiszám`, `Név`, `Születésidátum`, `Állampolgárság`, `Poszt`, `Csapatszám`) VALUES
(111111, 'Seres Gábor', '2008-04-09', 'román', 'csatár', 3),
(123546, 'Kunu Márió', '2010-08-12', 'román', 'csatár', 4),
(135488, 'Lakatos Brendon', '2008-08-13', 'szerb', 'csatár', 5),
(147658, 'Kis Antal', '2010-07-11', 'román', 'védő', 3),
(147852, 'Kovács Ákos', '2007-08-10', 'magyar', 'védő', 1),
(148752, 'Sebestény Balázs', '2012-06-17', 'magyar', 'kapus', 1),
(222222, 'Kalapos Márió', '2008-08-22', 'román', 'kapus', 4),
(314756, 'Flórián József', '2011-08-03', 'magyar', 'csatár', 6),
(324568, 'Kiss Alfréd', '2007-06-26', 'román', 'kapus', 2),
(324789, 'Török Csaba', '2009-05-15', 'szerb', 'védő', 8),
(324865, 'Elefánt Elek', '2009-09-12', 'szlovák', 'csatár', 6),
(325468, 'Kolontár Kolompár', '2009-09-05', 'magyar', 'csatár', 7),
(348965, 'Hókusz Pókusz', '2008-06-20', 'görög', 'csatár', 1),
(354868, 'Luki Muki', '2007-05-18', 'szlovák', 'kapus', 5),
(354898, 'Magvas Dániel', '2006-06-12', 'magyar', 'csatár', 4),
(358956, 'Kis Barnabás', '2007-11-22', 'szerb', 'csatár', 2),
(397456, 'Lakatos Mátyás', '2009-09-12', 'görög', 'védő', 6),
(426589, 'Kalányos István', '2010-07-12', 'magyar', 'védő', 2),
(456612, 'Szabó Attila', '2013-08-04', 'amerikai', 'csatár', 1),
(479512, 'Mákos Ferenc', '2008-05-03', 'magyar', 'csatár', 8),
(479862, 'Kovács Töhötöm', '2011-04-04', 'görög', 'csatár', 2),
(532548, 'Kovács Árpád', '2007-02-20', 'magyar', 'csatár', 3),
(534684, 'Magyar Ádám', '2011-04-07', 'görög', 'csatár', 5),
(548798, 'Kolompár Aladin', '2009-08-05', 'szerb', 'kapus', 7),
(548956, 'Kopoltyús Elemér', '2007-09-23', 'görög', 'védő', 7),
(651535, 'Szabó Máté', '2008-04-10', 'magyar', 'védő', 4),
(651587, 'Kis Ábdul', '2006-05-13', 'magyar', 'csatár', 7),
(687898, 'Lukács Ferenc', '2009-12-08', 'szlovák', 'védő', 5),
(799865, 'Dzsudzsák Balázs', '2008-05-10', 'román', 'kapus', 6),
(897654, 'Aladin Alfréd', '2007-05-12', 'magyar', 'csatár', 8),
(956214, 'Szív Aladár', '2011-02-19', 'görög', 'kapus', 3),
(984562, 'Lakatos Erik', '2007-09-16', 'görög', 'kapus', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `csapat`
--
ALTER TABLE `csapat`
  ADD PRIMARY KEY (`Csapatszám`);

--
-- Indexes for table `felhasználó`
--
ALTER TABLE `felhasználó`
  ADD PRIMARY KEY (`Felhasználónév`);

--
-- Indexes for table `mérkőzések`
--
ALTER TABLE `mérkőzések`
  ADD PRIMARY KEY (`Mérkőzésszám`);

--
-- Indexes for table `tagok`
--
ALTER TABLE `tagok`
  ADD PRIMARY KEY (`Személyiszám`),
  ADD KEY `Csapatszám` (`Csapatszám`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tagok`
--
ALTER TABLE `tagok`
  ADD CONSTRAINT `tagok_ibfk_1` FOREIGN KEY (`Csapatszám`) REFERENCES `csapat` (`Csapatszám`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
