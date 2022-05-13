-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 13, 2022 at 06:48 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `commenter` varchar(50) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  `datetime` varchar(50) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `tid`, `uid`, `commenter`, `details`, `datetime`) VALUES
(1, 5, 1, 'Admin', 'sadsd', '2022/05/12'),
(2, 5, 1, 'Admin', 'sds', '2022/05/12'),
(3, 5, 1, 'Admin', 'sdsd', 'May 12, 2022 4:23:pm'),
(4, 3, 1, 'Admin', 'dds', '2022/05/13'),
(5, 3, 1, 'Admin', 'dsds', 'May 13, 2022 12:34:am'),
(6, 3, 1, 'Admin', 'SWq', 'May 13, 2022 12:34:am'),
(7, 1, 1, 'Admin', 'yt ', 'May 13, 2022 12:34:am'),
(8, 4, 1, 'Admin', 'Sa', 'May 13, 2022 3:03:am'),
(9, 2, 2, 'Timothy Kumbweza Banda', 'Tgas', 'May 13, 2022 8:36:am');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `due_date` date NOT NULL,
  `status` int(2) NOT NULL,
  `notify` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `uid`, `title`, `description`, `due_date`, `status`, `notify`) VALUES
(1, 1, 'Create Employee API', 'Use ASP.Net Core framework for the API', '2022-05-16', 1, 0),
(2, 2, 'Saw', 'sasdads', '2022-05-19', 0, 0),
(3, 1, 'asas', 'asasas', '2022-05-12', 0, 0),
(4, 1, 'Code PHP', 'dade', '2022-05-31', 0, 0),
(5, 1, 'COD Night', 'Search and Destroy', '2022-05-27', 1, 0),
(7, 2, 'Develop PHP Web App', 'Use Latest PHP version and JS.', '2022-05-27', 0, 0),
(8, 2, 'Fix Car', 'Use Toolkit', '2022-05-12', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `name`) VALUES
(1, 'admin', 'admin', 'Admin'),
(2, 'Timobify', 'Qwerty123.', 'Timothy Kumbweza Banda');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
