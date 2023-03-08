-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2023 at 03:43 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

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
-- Table structure for table `partner_company`
--

CREATE TABLE `partner_company` (
  `id` int(11) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `companyemail` varchar(255) NOT NULL,
  `pcompanycon` varchar(255) NOT NULL,
  `companyaddress` varchar(255) NOT NULL,
  `industry` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pcompany_pic` longblob NOT NULL,
  `pcompany_cover` longblob NOT NULL,
  `package` varchar(11) NOT NULL,
  `code` mediumint(50) NOT NULL,
  `status` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_company`
--

INSERT INTO `partner_company` (`id`, `companyname`, `companyemail`, `pcompanycon`, `companyaddress`, `industry`, `description`, `username`, `password`, `pcompany_pic`, `pcompany_cover`, `package`, `code`, `status`) VALUES
(1, 'keels Super', 'keels@info.com', '0112345678', 'No1, Lotus Avenue, Colombo 10', 'conglomerate', '', 'vin', '1111\r\n', '', '', '', 0, ''),
(2, 'abanz', 'abanz@gmail.com', '0110782934', 'colombo,sri lanka', 'technology', '', 'adminAbanz', '$2y$10$yZdoUWET74jGySLd1BECke.mqtWcQIwS2zILVfnHYay3Qp5bk3Xsa', '', '', '', 0, ''),
(3, 'abanzz', 'abanz@plc.com', '0112345678', 'colombo,sri lanka', 'local', '', 'admin@abanz', '$2y$10$CNKK0p3ktMdWVUHoO.yrwuOnfPjG6odoW8VMhHFjOJlyQC3BZDnkW', '', '', '', 0, ''),
(4, 'vino', 'vino@gmail.com', '07789553', 'fgjivkj', 'bnbknj', '', 'nime', '$2y$10$MzSzYFv3bM1ARmhS7HnzNuM72Hmdgr6fcRfZ2k0sN0Y/sa5FC0V16', '', '', '', 0, ''),
(5, 'Combank', 'com@d.com', '0765432189', 'reid avanue, colombo', 'tech', '', 'vino', '$2y$10$KOeRMwSH3ABCpCXwtGQNoOUwlj7s.RwvLY/RvYs3eYXhrCx3SLay6', '', '', '', 0, ''),
(6, 'ABC limited', 'ABC@abc.com', '0110987654', 'Colombo, sri lanka', 'Technology', '', 'admin@abc', '$2y$10$y5PapyYLEmCI/tlagr5URO8/BeBnkWtlgNpsWRSJBgnXYUyobE/72', '', '', '', 0, ''),
(7, 'ASD', 'asd@gmail.com', '0123456786', 'colombo 07, Sri Lanka', 'Tech', '', 'asd_admin', '$2y$10$mrBeidY8nHnxNroPSdo.neWmFcXpgiiyk2QwesBvwiyUr9NLUamlS', '', '', '', 0, ''),
(8, 'asdf', 'asdfasdf@g.cm', '0987654321', 'galle, sri lanka', 'apperal', '', 'asdf', '$2y$10$IqEEMCdgdf/JoVZQ/uA6p.zdToT/lc36wtELrgOUZll0lRtEN/prW', '', '', '', 0, ''),
(9, 'ABDN', 'abdn@g.com', '0876534876', 'colombo, sri lanka', 'Technology', '', 'abdn', '$2y$10$REFh9PdirZN22OCx5oydUeEou3c12uzM3ic9cPj1kbdOkG2iCMpVG', '', '', '', 0, ''),
(10, 'nime', 'nime@gmail.com', '0778906578', 'flower', 'retail', '', 'vino', '$2y$10$aNVVex0m6rA.3CqKU1.mAOrek/MswNiHdSblfvk12PdJaR/.T5un2', '', '', '', 0, ''),
(11, 'lll', 'ss@dd.ki', '0987654345', 'flower rd, hkmvn,lgogjt', 'oooo', '', 'vinoli2000', '$2y$10$oDy3vmxfql/R7qM0LD7B1.Rp0TwsebnjHTjqDlxfza2Oox.SJ32wu', '', '', '', 0, ''),
(12, 'vinoli and friends', 'vinfre@g.b', '0987654323', 'blah blah blah', 'tech', '', 'adminvino', '$2y$10$0hVuFqOc6S/zoZJ2zv5K2.FKt6zrj93LqRw9Qqw1WfKoVKaS7rYtO', '', '', '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_company`
--
ALTER TABLE `partner_company`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_company`
--
ALTER TABLE `partner_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
