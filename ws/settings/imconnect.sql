-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2013 at 10:31 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `thread` varchar(255) NOT NULL,
  `participants` int(11) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`p_id`, `username`, `thread`, `participants`) VALUES
(1, 'shivam', '1385921668126', 2),
(2, 'testuser', '1385921668126', 2),
(3, 'shivam', '1385921676001', 3),
(4, 'testuser', '1385921676001', 3),
(5, 'admin', '1385921676001', 3);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `thread` varchar(255) NOT NULL,
  `participants` int(11) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  PRIMARY KEY (`thread`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`thread`, `participants`, `messages`, `updated`) VALUES
('1385921668126', 2, '/msgs/1385921668126.msg', 1),
('1385921676001', 3, '/msgs/1385921676001.msg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `activated` tinyint(1) DEFAULT NULL,
  `activationkey` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `activated`, `activationkey`) VALUES
(1, 'admin', 'dev.shivamshah@gmail.com', 'admin123', 1, NULL),
(2, 'shivam', 'shivam_shah@live.com', 'shivam123', 1, NULL),
(3, 'testuser', 'testuser@test.com', 'test123', 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
