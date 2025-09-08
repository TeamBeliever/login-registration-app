-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 12:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_card` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(200) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `dob`, `gender`, `username`, `password`, `id_card`, `profile_pic`, `role`) VALUES
(1, 'madhav', '07620682564', 'puyadmadhav9@gmail.com', '1994-11-14', 'Male', 'mad', '$2y$10$gqWfqlMm1BrFqa73d/XHjuyunBV7HrmKQ1hc3gfu5DM.LsC5eNvAy', '12345', 'uploads/1756791647_my pic.pdf', 'admin'),
(5, 'sunil', '9838747833', 'sunil@gmail.com', '2025-09-25', 'Male', 'sunil1234', '$2y$10$iGt6imDJ4dpmnLCNF3FeQuxdVGK6nh9irbOZXZUx1nzFk9DL9vADm', '123', 'uploads/1756884393_my pic.pdf', 'user'),
(9, 'deepak', '9158560517', 'example@gmail.com', '2025-09-09', 'Male', 'deep', '$2y$10$dNmeFWVY7K62xxxZWIhfkuFN2/qkvp829nJJu3nP/QMWXxymHkjyO', 'uploads/1756899185_my photo.jpg', 'uploads/1756899185_my photo.jpg', 'user'),
(10, 'shivani', '9156738847', 'example@gmail.com', '2025-09-09', 'Female', 'shivani123', '$2y$10$7n3MLw9yaA6pxV9THa8pieZOTDDWnraEvKKeJV4c3PadsMDgfWC6W', 'uploads/1756900004_my photo.jpg', 'uploads/1756900004_my photo.jpg', 'user'),
(11, 'sham', '9377784733', 'example@gmail.com', '2025-09-09', 'Male', 'sham1234', '$2y$10$Svrry77Lc63wOVv2Wq9VAeaF21MdmpH8iAEpd/3ysssL49RDh3zc.', 'uploads/1756900561_my photo.jpg', 'uploads/1756900561_my photo.jpg', 'user'),
(12, 'shital', '8737737744', 'shital@gmail.com', '2025-09-21', 'Female', 'shital123', '$2y$10$qCB0Wpqo/66uRDiBfN0yVuNVUeSmg02KNFdDH8SFXIdmEMIQTC4Me', 'uploads/1756986163_my photo.jpg', 'uploads/1756986163_my photo.jpg', 'user'),
(13, 'anil', '9736737838', 'anil@gmail.com', '2025-09-28', 'Male', 'anil123', '$2y$10$.SxeiydpB6C6BR7Aja6.7erpci8SNMOTs7R8oNWRl4G7JxxkmJIVi', 'uploads/1757138782_my photo.jpg', 'uploads/1757138782_my photo.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
