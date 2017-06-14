-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2017 at 07:48 PM
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
(1, '5J 635', 1, 2, '07:00:00', '08:30:00', 60, 2000, 2300, 2500, '1'),
(2, '5J 636', 2, 1, '08:00:00', '09:30:00', 60, 2000, 2300, 2500, '1');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(24) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `flight_id` int(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(24) NOT NULL,
  `user_id` int(24) NOT NULL,
  `flight_id` int(24) NOT NULL,
  `seat_id` int(24) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `with_tour` enum('0','1') NOT NULL,
  `flight_type` enum('0','1','2') NOT NULL,
  `psgr_name` varchar(255) NOT NULL,
  `psgr_passport` varchar(255) NOT NULL,
  `psgr_gender` enum('M','F') NOT NULL,
  `psgr_birthdate` date NOT NULL,
  `psgr_address` varchar(255) NOT NULL,
  `psgr_contact` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(128) NOT NULL,
  `flight_id` int(24) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'admin', '$2y$10$d2gFjSmAFMEFa6VcLjDUD.xqcpBffJat0SL/wBdeXsfIInJhuEMKG', '', 'admin', '', '', '0000-00-00', '', '', '', '1', ''),
(2, 'rylee', '$2y$10$iRst0pcQjNlXdz9FiYA/VeKyDBrcR86l5OOpIE32CGw1LvPxM.QJW', 'some@gmail.com', 'normal', 'Jefferson', 'Rylee', '1999-03-07', 'M', 'Manila', '09876543210', '1', '467224b89638bd255f06511dffde6ce1'),
(3, 'cayle', '$2y$10$dWW5xpn5i0asP5Cv8xPU3.cpl6frqWzxer2CJTpTotAcHz1lR23Ma', 'rylee.jeff385@gmail.com', 'normal', 'Cayle', 'Gaspar', '1998-06-19', 'M', 'Manila', '+639876543210', '1', 'd34fa3afb4b44d12a613cd7240e846c3');

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
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
