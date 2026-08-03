-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 22, 2026 at 12:23 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_devoirs_primaires`
--

-- --------------------------------------------------------

--
-- Table structure for table `devoir`
--

DROP TABLE IF EXISTS `devoir`;
CREATE TABLE IF NOT EXISTS `devoir` (
  `id_devoir` int auto increment primary key,
  `nom` varchar(100)NOT NULL,
  `classe` varchar(50),
  `matiere` varchar(50),
  `titre` varchar(150),
  `livre` varchar(150),
  `page` varchar(20),
  `exercices` varchar(50),
  `description` text,
  `date_devoir` timestamp DEFAULT current_timestamp(),
  `date_remise` date
);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
