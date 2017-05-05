-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2017 at 02:06 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crowdfunding`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `uname` varchar(45) NOT NULL,
  `logdata` varchar(45) DEFAULT NULL,
  `logtype` varchar(45) DEFAULT NULL,
  `logtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`uname`, `logdata`, `logtype`, `logtime`) VALUES
('klakhani', 'jazz', 'search', '2017-05-04 18:41:39'),
('klakhani', 'p', 'search', '2017-05-04 18:51:40'),
('klakhani', 'k', 'search', '2017-05-04 18:51:41'),
('klakhani', 'dance', 'search', '2017-05-04 18:53:23'),
('klakhani', 'kmodi', 'profilevisit', '2017-05-04 18:57:41'),
('klakhani', 'jshah', 'search', '2017-05-04 19:18:13'),
('klakhani', 'jshah', 'profilevisit', '2017-05-04 19:18:18'),
('klakhani', 'iojewfijweifjiewrferwfj', 'search', '2017-05-04 19:21:43'),
('klakhani', 'iojewfijweifjiewrferwfj', 'search', '2017-05-04 19:25:37'),
('klakhani', 'Kunal', 'search', '2017-05-04 19:34:08'),
('klakhani', 'kmodi', 'profilevisit', '2017-05-04 19:34:13'),
('klakhani', 'p5', 'search', '2017-05-04 19:39:37'),
('klakhani', 'pname', 'search', '2017-05-04 19:50:17'),
('klakhani', 'p6', 'search', '2017-05-04 19:51:14'),
('klakhani', 'p6', 'search', '2017-05-04 19:51:46'),
('klakhani', 'p6', 'visit', '2017-05-04 19:51:48'),
('klakhani', 'p6', 'visit', '2017-05-04 19:52:45'),
('klakhani', 'kmodi', 'profilevisit', '2017-05-04 19:52:55'),
('klakhani', 'p5', 'search', '2017-05-04 19:53:00'),
('klakhani', 'sample_project', 'visit', '2017-05-04 19:53:26'),
('klakhani', 'kuu', 'search', '2017-05-04 19:54:50'),
('klakhani', '', 'search', '2017-05-04 19:57:55'),
('klakhani', '', 'search', '2017-05-04 19:58:33'),
('klakhani', '', 'search', '2017-05-04 19:58:46'),
('klakhani', 'p6', 'visit', '2017-05-04 20:01:15'),
('klakhani', 'p6', 'visit', '2017-05-04 20:01:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`uname`,`logtime`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
