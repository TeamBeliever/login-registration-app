-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 01:02 PM
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
  `role` enum('user','admin') DEFAULT 'user',
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `Reject_Reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `dob`, `gender`, `username`, `password`, `id_card`, `profile_pic`, `role`, `status`, `Reject_Reason`) VALUES
(1, 'madhav', '7620682564', 'madhav@gmail.com', '1994-11-14', 'Male', 'mad', '$2y$10$1xbVPjo4Uq5dexx3UN0WsuOyE9pbN8aby4QITxB0HAYiYwIbYScjG', 'uploads/1757491884_my aadhar card.jpg', 'uploads/1757491884_my photo.jpg', 'admin', 'Pending', NULL),
(5, 'sunil', '9838747833', 'sunil@gmail.com', '2025-09-25', 'Male', 'sunil1234', '$2y$10$iGt6imDJ4dpmnLCNF3FeQuxdVGK6nh9irbOZXZUx1nzFk9DL9vADm', 'uploads/1757569420_my aadhar card.jpg', 'uploads/1757569420_my photo.jpg', 'user', 'Approved', NULL),
(9, 'deepak', '9158560517', 'example@gmail.com', '2025-09-09', 'Male', 'deep', '$2y$10$dNmeFWVY7K62xxxZWIhfkuFN2/qkvp829nJJu3nP/QMWXxymHkjyO', 'uploads/1756899185_my photo.jpg', 'uploads/1756899185_my photo.jpg', 'user', 'Pending', NULL),
(10, 'shivani', '9156738847', 'example@gmail.com', '2025-09-09', 'Female', 'shivani123', '$2y$10$7n3MLw9yaA6pxV9THa8pieZOTDDWnraEvKKeJV4c3PadsMDgfWC6W', 'uploads/1756900004_my photo.jpg', 'uploads/1756900004_my photo.jpg', 'user', 'Pending', NULL),
(11, 'sham', '9377784733', 'example@gmail.com', '2025-09-09', 'Male', 'sham1234', '$2y$10$Svrry77Lc63wOVv2Wq9VAeaF21MdmpH8iAEpd/3ysssL49RDh3zc.', 'uploads/1756900561_my photo.jpg', 'uploads/1756900561_my photo.jpg', 'user', 'Pending', NULL),
(12, 'shital', '8737737742', 'shital@gmail.com', '2025-09-21', 'Female', 'shital123', '$2y$10$qCB0Wpqo/66uRDiBfN0yVuNVUeSmg02KNFdDH8SFXIdmEMIQTC4Me', 'uploads/1757488491_my photo.jpg', 'uploads/1756986163_my photo.jpg', 'user', 'Approved', NULL),
(13, 'anil', '9736737838', 'anil@gmail.com', '2025-09-28', 'Male', 'anil123', '$2y$10$.SxeiydpB6C6BR7Aja6.7erpci8SNMOTs7R8oNWRl4G7JxxkmJIVi', 'uploads/1757138782_my photo.jpg', 'uploads/1757138782_my photo.jpg', 'user', 'Pending', NULL),
(17, 'ganesh', '8293884478', 'ganesh@123', '2025-09-27', 'Male', 'ganesh123', '$2y$10$frQLmhiug0K5OUivya7Xpe0efELioaqwgzMLCStr0TcTuXPAizHgC', 'uploads/1757488826_my aadhar card.jpg', 'uploads/1757488614_my photo.jpg', 'user', 'Pending', NULL),
(18, 'suhani', '7466646646', 'suhani@gmail.com', '2025-09-08', 'Female', 'suhani123', '$2y$10$2HZa9rxgRaepfG60U.TtT.IebjfDWfH7q/5kLRwgTzxDi5hSnowz2', 'uploads/1757489675_pc wall5.jpg', 'uploads/1757489675_pc wall6.jpg', 'user', 'Pending', NULL),
(19, 'rahul', '7263663636', 'rahul@gmail.com', '2025-09-15', 'Male', 'rahul123', '$2y$10$kQUEogtJORRiWsUY1q5K8ehZK0Boh4HS37Oglwvpk/tpmXb9CiX16', 'uploads/1757491078_my photo.jpg', 'uploads/1757491078_my photo.jpg', 'user', 'Pending', NULL),
(20, 'ram', '8736466735', 'ram@gmail.com', '2024-06-11', 'Male', 'ram123', '$2y$10$e0/WYR/7LaumBhHOOxiCTuwt/oRier96L34FmX8eG6oOS5wxLr2p.', 'uploads/1757491650_my aadhar card.jpg', 'uploads/1757491650_my photo.jpg', 'user', 'Pending', NULL),
(21, 'aniket', '7663666366', 'aniket@gmail.com', '2025-09-03', 'Male', 'aniket123', '$2y$10$rumN/B6LI38RftWhFCIpQOxox4iNbnvTq3bhcDpunGx4DMCpFycXi', 'uploads/1757510426_my aadhar card.jpg', 'uploads/1757510426_my photo.jpg', 'user', 'Rejected', NULL),
(24, 'ramesh123', '9837636631', 'ramesh@gmail.com', '2018-07-17', 'Male', 'ramesh123', '$2y$10$9v.JNTjT8CxLv98LYX9VHefL3JKdjDyST9pvJTMQPxoXqL4NpmGv2', 'uploads/1757522186_my aadhar card.jpg', 'uploads/1757522186_my photo.jpg', 'user', 'Approved', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
