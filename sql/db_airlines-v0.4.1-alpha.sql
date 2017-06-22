-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2017 at 08:10 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_airlines`
--

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` int(24) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `name`, `place`) VALUES
(1, 'Airport01', 'City01'),
(2, 'Airport02', 'City02'),
(3, 'Airport03', 'City03'),
(4, 'Airport04', 'City04'),
(5, 'Airport05', 'City05');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(24) NOT NULL,
  `flight_code` varchar(255) NOT NULL,
  `origin_id` int(24) NOT NULL,
  `destination_id` int(24) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `total_seats` int(3) NOT NULL,
  `price` double NOT NULL,
  `price_w_baggage` double NOT NULL,
  `price_w_all` double NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `flight_code`, `origin_id`, `destination_id`, `departure_time`, `arrival_time`, `total_seats`, `price`, `price_w_baggage`, `price_w_all`, `status`) VALUES
(1, '5J 635', 1, 2, '07:00:00', '08:30:00', 30, 2000, 2300, 2500, '1'),
(2, '5J 636', 2, 1, '08:00:00', '09:30:00', 30, 2000, 2300, 2500, '1');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(24) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `flight_id` int(24) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `address`, `flight_id`, `status`) VALUES
(0, 'none', '', 0, '0'),
(1, 'Hotel1', '098 Some Hotel Address', 2, '1'),
(2, 'Hotel2', '987 Some Hotel Add', 2, '1'),
(3, 'Hotel3', '980 Some Hotel Address', 1, '1'),
(4, 'Hotel4', '789 Some Hotel Address', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(24) NOT NULL,
  `user_id` int(24) NOT NULL,
  `flight_id` int(24) NOT NULL,
  `seat_id` int(24) NOT NULL,
  `hotel_id` int(24) NOT NULL,
  `with_tour` enum('0','1') NOT NULL,
  `flight_type` enum('0','1','2') NOT NULL,
  `credit_card_no` varchar(255) NOT NULL,
  `psgr_name` varchar(255) NOT NULL,
  `psgr_passport` varchar(255) NOT NULL,
  `psgr_passport_expiration` date NOT NULL,
  `psgr_birthdate` date NOT NULL,
  `date_reserved` date NOT NULL,
  `time_reserved` time NOT NULL,
  `departure_date` date NOT NULL,
  `arrival_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `flight_id`, `seat_id`, `hotel_id`, `with_tour`, `flight_type`, `credit_card_no`, `psgr_name`, `psgr_passport`, `psgr_passport_expiration`, `psgr_birthdate`, `date_reserved`, `time_reserved`, `departure_date`, `arrival_date`) VALUES
(1, 2, 1, 1, 0, '1', '1', '2388909703', 'Jefferson Rylee', 'P091234', '2018-06-21', '1999-03-13', '2017-06-21', '18:03:41', '2017-06-21', '2017-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(24) NOT NULL,
  `flight_id` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `flight_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(24) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('admin','normal') NOT NULL,
  `fname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` enum('M','F','O') NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(64) NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  `verification_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `type`, `fname`, `lname`, `birthdate`, `gender`, `address`, `contact`, `status`, `verification_code`) VALUES
(1, 'admin', '$2y$10$UEM/tluGc1DCjlI4pTfnaOF7mNLUpL9O2buf/WQ.KzUN6XlfmR/mK', '', 'admin', '', '', '0000-00-00', '', '', '', '1', ''),
(2, 'rylee', '$2y$10$iRst0pcQjNlXdz9FiYA/VeKyDBrcR86l5OOpIE32CGw1LvPxM.QJW', 'some@gmail.com', 'normal', 'Jefferson', 'Rylee', '1999-03-07', 'M', 'Manila', '09876543210', '1', '467224b89638bd255f06511dffde6ce1'),
(3, 'cayle', '$2y$10$dWW5xpn5i0asP5Cv8xPU3.cpl6frqWzxer2CJTpTotAcHz1lR23Ma', 'rylee.jeff385@gmail.com', 'normal', 'Cayle', 'Gaspar', '1998-06-19', 'M', 'Manila', '+639876543210', '1', 'd34fa3afb4b44d12a613cd7240e846c3'),
(4, 'user', '$2y$10$NsovlheVBXw5VQ8JfBquI.sZJVXTqH9ueANcNwB/gGP8EriOi7ulS', '', 'admin', '', '', '2017-06-22', 'M', '', '', '1', ''),
(5, 'joanne', '$2y$10$7MEJwfKhy2KsgkKygsUcYeTB7EYOPoLxVzQznAF9CMcjEbJr8EtUC', '', 'admin', '', '', '2017-06-22', 'M', '', '', '0', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
