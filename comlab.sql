-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 04:56 AM
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
-- Database: `comlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `full_name` varchar(50) NOT NULL,
  `facultyid` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`full_name`, `facultyid`, `password`, `pending`) VALUES
('test', 'test', '$2y$10$3deHPVjkjILRy5goNaeoBepXZUpdVPbyRYDCboBZg3X8XN8OEo.Hu');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `full_name` varchar(50) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`full_name`, `studentid`, `password`, `pending`) VALUES
('test', 'test', '$2y$10$7nnccHk7Egz3Eg8fvo8KgezxuT.y0zr8Z3cIPrysJZYbWYCZIXrey'),
('test', 'testtest', '$2y$10$Bts70pDqvyBhB4GiG8QGhejBxGqx07WO4LwMsnwlpXhN/iFcRvTie');

--
-- Indexes for dumped tables
--

CREATE TABLE `admin` (
  `full_name` varchar(50) NOT NULL,
  `adminid` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `admin` (`adminid`, `full_name`, `password`) VALUES
('09-02-2023', 'christian leguiz', '$2y$10$xpSND96frzdSPtTlkKeZIOF91Qr3YT7nrURkObO7xRKoK2ofVjhDu'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`facultyid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
