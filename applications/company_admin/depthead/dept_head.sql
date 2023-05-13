-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2023 at 11:56 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blitz`
--

-- --------------------------------------------------------

--
-- Table structure for table `dept_head`
--

CREATE TABLE `dept_head` (
  `id` int(11) NOT NULL,
  `employeeid` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactno` varchar(255) NOT NULL,
  `profilepic_m` longblob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dept_head`
--

INSERT INTO `dept_head` (`id`, `employeeid`, `name`, `department`, `email`, `contactno`, `profilepic_m`) VALUES
(17, 'E00003', 'Janani Arunodya', 'Legal', 'jananiarunodya@gmail.com', '0705896321', ''),
(18, 'E00005', 'Arunodya Irugalbandara', 'Finance', 'arunodyapawuluarachchi@gmail.com', '0705698741', ''),
(15, 'E00001', 'Nimesha Pawani', 'Finance', 'nimeshapawani@gmail.com', '0748596321', ''),
(16, 'E00009', 'Vinoli Pabasarini', 'IT', 'vinolirub@gmail.com', '0708529631', ''),
(19, 'E00003', 'Adithya Sithmini', 'Marketing', 'adibandara99@gmail.com', '0715896321', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept_head`
--
ALTER TABLE `dept_head`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dept_head`
--
ALTER TABLE `dept_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
