-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 23, 2014 at 11:31 PM
-- Server version: 5.6.11-log
-- PHP Version: 5.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `activityfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `club_reviews`
--

CREATE TABLE IF NOT EXISTS `club_reviews` (
  `review_id` varchar(50) NOT NULL,
  `activity_id` varchar(50) NOT NULL,
  `show_review` int(1) NOT NULL DEFAULT '0',
  `author_name` varchar(50) DEFAULT NULL,
  `rating` int(2) DEFAULT NULL,
  `details` text,
  `review_date` datetime DEFAULT NULL,
  `language_review` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
