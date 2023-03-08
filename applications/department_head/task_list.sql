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
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `description`, `status`, `emp_id`, `date_created`) VALUES
(5, 5, 'adithya task1', 'new 1', 3, '', '2023-02-09 16:36:03'),
(6, 5, 'sample task1', 'sample task done', 5, '', '2023-02-09 16:42:10'),
(7, 5, 'sampletask2', 'sample task 2 done', 5, '', '2023-02-09 16:43:04'),
(8, 5, 'sample task3', 'sample task 3 on progress', 3, '', '2023-02-09 16:49:48'),
(9, 3, 'new task 6', 'new 6', 0, '', '2023-02-09 17:55:02'),
(10, 5, 'task2', 'new task 2', 3, '', '2023-02-09 18:47:59'),
(11, 5, 'task4', 'new2', 3, '', '2023-02-09 18:49:53'),
(12, 5, 'task4', 'new4', 3, '', '2023-02-09 18:50:52'),
(13, 3, 'task2', 'new8', 3, '', '2023-02-09 18:55:02'),
(14, 7, 'newtask', 'newtask', 3, '', '2023-02-09 21:17:18'),
(15, 5, 'task10', 'new task 10', 3, '', '2023-02-09 21:37:47'),
(17, 7, 'new task2', 'new task2 added', 5, '', '2023-02-10 00:58:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
