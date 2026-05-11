-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 02:37 AM
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
-- Table structure for table `building_desc`
--

CREATE TABLE `building_desc` (
  `building_id` int(11) NOT NULL,
  `ID_2022` int(11) NOT NULL,
  `pin` bigint(20) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(255) DEFAULT NULL,
  `owner_tin` varchar(255) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `admin_address` varchar(255) DEFAULT NULL,
  `admin_phone` varchar(255) DEFAULT NULL,
  `admin_tin` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `baranggay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `owner_reference_name` varchar(255) DEFAULT NULL,
  `cloa` varchar(255) DEFAULT NULL,
  `lot_no` varchar(255) DEFAULT NULL,
  `survey_no` varchar(255) DEFAULT NULL,
  `block_no` varchar(255) DEFAULT NULL,
  `arp_no` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `building_kind` varchar(255) NOT NULL,
  `structural_type` varchar(255) DEFAULT NULL,
  `building_permit_no` bigint(20) NOT NULL,
  `permit_date_issued` varchar(255) NOT NULL,
  `cct` varchar(255) NOT NULL,
  `cert_completion_date` varchar(255) NOT NULL,
  `cert_occupancy_date` varchar(255) NOT NULL,
  `constructed_date` varchar(255) NOT NULL,
  `occupied_date` varchar(255) NOT NULL,
  `building_age` varchar(255) NOT NULL,
  `storey_no` bigint(20) NOT NULL,
  `area_first_floor` int(11) NOT NULL,
  `area_second_floor` int(11) NOT NULL,
  `area_third_floor` int(11) NOT NULL,
  `area_fourth_floor` int(11) NOT NULL,
  `total_floor_area` bigint(20) NOT NULL,
  `previous_pin` varchar(50) NOT NULL,
  `previous_arp_no` varchar(50) NOT NULL,
  `previous_td` varchar(50) NOT NULL,
  `previous_assessed_value` decimal(10,0) NOT NULL,
  `previous_owner` varchar(50) NOT NULL,
  `previous_effectivity` varchar(50) NOT NULL,
  `recording_person_ID` int(11) NOT NULL,
  `recording_date` varchar(10) NOT NULL,
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building_desc`
--
ALTER TABLE `building_desc`
  ADD PRIMARY KEY (`building_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building_desc`
--
ALTER TABLE `building_desc`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
