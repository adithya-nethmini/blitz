-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2023 at 05:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` varchar(255) NOT NULL,
  `user_ids` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(5, 'Sample Project1', 'New project', 3, '2023-02-16', '2023-02-17', 'adi', 'Adithya,clara', '2023-02-07 10:29:10'),
(6, 'pr1', 'new', 3, '2023-02-23', '2023-02-16', 'Adithya', 'ethan,jane', '2023-02-07 12:42:42'),
(7, 'project2', 'new 2', 3, '2023-02-17', '2023-02-18', 'clara', 'adi,Adithya', '2023-02-07 16:32:37'),
(8, 'project3', 'new3', 5, '2023-02-25', '2023-02-28', 'clara', 'jane,nethmini', '2023-02-07 16:40:13'),
(9, 'pro2', 'new4', 0, '2023-02-25', '2023-02-17', 'adi', 'Adithya,ethan', '2023-02-08 12:14:31'),
(10, 'new', 'new3', 3, '2023-02-10', '2023-02-11', 'adi', 'Adithya', '2023-02-08 12:30:56'),
(11, 'project5', 'new pro', 3, '2023-02-17', '2023-02-20', 'adi', 'Adithya', '2023-02-08 12:33:24'),
(12, 'adithya', 'new7', 3, '2023-02-17', '2023-02-18', 'adi', 'Adithya', '2023-02-08 12:36:41'),
(13, 'adi2', 'project', 3, '2023-02-11', '2023-02-22', 'adi', 'Adithya', '2023-02-08 12:39:33'),
(14, 'project3', 'new project on progress', 3, '2023-02-18', '2023-02-22', 'billy', 'nethmini,ethan', '2023-02-09 12:19:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
