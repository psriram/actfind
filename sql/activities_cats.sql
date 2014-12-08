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
-- Table structure for table `activities_cats`
--

CREATE TABLE IF NOT EXISTS `activities_cats` (
  `activity_id` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
