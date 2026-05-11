-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 02:52 AM
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
-- Database: `faas_building`
--

-- --------------------------------------------------------

--
-- Table structure for table `structural_material`
--

CREATE TABLE `structural_material` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `roof` varchar(255) DEFAULT NULL,
  `first_floor_flooring` varchar(255) DEFAULT NULL,
  `second_floor_flooring` varchar(255) DEFAULT NULL,
  `third_floor_flooring` varchar(255) DEFAULT NULL,
  `fourth_floor_flooring` varchar(255) DEFAULT NULL,
  `first_floor_wall` varchar(255) DEFAULT NULL,
  `second_floor_wall` varchar(255) DEFAULT NULL,
  `third_floor_wall` varchar(255) DEFAULT NULL,
  `fourth_floor_wall` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `structural_material`
--
ALTER TABLE `structural_material`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `structural_material`
--
ALTER TABLE `structural_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
