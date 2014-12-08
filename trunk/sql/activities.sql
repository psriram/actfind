-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: remote-mysql3.servage.net
-- Generation Time: Sep 06, 2014 at 04:57 PM
-- Server version: 5.5.25
-- PHP Version: 5.2.42-servage30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prejobman`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `activity_id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `ac_name` varchar(200) DEFAULT NULL,
  `ac_description` varchar(200) DEFAULT NULL,
  `ac_lat` float(20,12) DEFAULT NULL,
  `ac_lon` float(20,12) DEFAULT NULL,
  `ac_address` varchar(255) DEFAULT NULL,
  `ac_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ac_updated` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
