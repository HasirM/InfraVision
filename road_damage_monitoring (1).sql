-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 18, 2024 at 08:26 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `road_damage_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `info` text,
  `duration` varchar(50) DEFAULT NULL,
  `severity` varchar(50) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved') CHARACTER SET utf8mb4 DEFAULT 'Pending',
  `submitted_by` varchar(255) DEFAULT NULL,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `confirm_image` varchar(255) DEFAULT NULL,
  `last_updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('user','admin','govt') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone_number`, `role`, `reset_token`) VALUES
(7, 'admin', 'admin@gmail.com', '$2y$10$WsOiLxDyPSTvOPkwZH9CQ.QnfLFvniqzkU2xwJhYU9IndhjnqUlfe', '7994402014', 'admin', NULL),
(8, 'hasirm', 'hasirahmad124@gmail.com', '$2y$10$XyB66OEQ.zo/SusQ7bufpe9ad.Imls3somwGBFBeKfN714AkpR6cy', '1234567890', 'user', NULL),
(9, 'johnydepp', 'shamilsha1230@gmail.com', '$2y$10$YajXoZVBqjnRjxHkY1jWL.me23yUfW/CaCpRaBB/JXuaTX1zUxZ5q', '1234567890', 'govt', NULL),
(10, 'khais', 'admin1@gmail.com', '$2y$10$azkKtaNTIrWan.KFq4FBa.efwiEXMg1RdkfEQO4db0B37iOz2GmVO', '7896541235', 'user', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
