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
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `user_id` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `uid` varchar(50) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  `access_level` enum('member','admin') NOT NULL DEFAULT 'member',
  `sn_type` enum('googleplus','facebook','twitter','linkedin') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
