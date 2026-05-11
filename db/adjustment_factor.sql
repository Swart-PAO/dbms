-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 02:38 AM
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
-- Database: `faas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_factor`
--

CREATE TABLE `adjustment_factor` (
  `adjustment_ID` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `percentage_A` int(11) NOT NULL,
  `percentage_B` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjustment_factor`
--

INSERT INTO `adjustment_factor` (`adjustment_ID`, `description`, `type`, `percentage_A`, `percentage_B`) VALUES
(12, 'Provincial  or National Road', 'Road', 0, 0),
(13, 'For all weather Roads', 'Road', -3, 0),
(14, 'Along Dirt Road', 'Road', -6, 0),
(15, 'For no road outlet', 'Road', -9, 0),
(16, '0 to 1 km', 'Location-W', 0, 5),
(17, 'Over 1 to 3 km', 'Location-W', -2, 0),
(18, 'Over 3 to 6 km', 'Location-W', -4, -2),
(19, 'Over 6 to 9 km', 'Location-W', -6, -4),
(20, 'Over 9 km', 'Location-W', -8, -6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjustment_factor`
--
ALTER TABLE `adjustment_factor`
  ADD PRIMARY KEY (`adjustment_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjustment_factor`
--
ALTER TABLE `adjustment_factor`
  MODIFY `adjustment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
