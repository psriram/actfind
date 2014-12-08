-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2014 at 08:55 PM
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
  `xtras` text,
  `place_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `user_id`, `ac_name`, `ac_description`, `ac_lat`, `ac_lon`, `ac_address`, `ac_created`, `ac_updated`, `status`, `xtras`, `place_id`) VALUES
('1CC203D8-B10A-4105-C944-FEC03C3F91AC', '96962943-750F-868B-CE96-E3102B4BD862', 'Soccer Field 8', 'Soccer Field 8 Soccer Field 8 Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Fie', 37.681755065918, -121.890228271484, '2698 Gapwall Court, Pleasanton, CA 94566, USA', '2014-09-23 23:41:45', '2014-09-23 22:27:32', 1, '{"ac_images":["image 1"],"phone":"4085052726","email":"naveenkhanchandani@gmail.com","website":"http:\\/\\/www.ci.dublin.ca.us\\/Facilities.aspx?Page=detail&RID=13","googleplus":"https:\\/\\/plus.google.com\\/113395815990484960711\\/about?hl=en-US","skype":"skid","facebookURL":"fburl","whatsapp":"1","whatsapp_phone":"4085052726","customfield1":"abc","customfield2":"xyz","customfield3":"nmo","customfield4":"pqr","customfield5":"stu"}', 'ChIJX4Mpg2jpj4ARQrJ8AHmNxJc'),
('5D69D805-DA96-E415-C444-FA4C5C3CD58A', '96962943-750F-868B-CE96-E3102B4BD862', 'Emerald Glen Park', 'dsf', 37.711193084717, -121.875343322754, 'Gleason Drive, Dublin, CA 94568, USA', '2014-09-23 23:42:14', '2014-09-23 22:28:02', 1, '{"ac_images":["dfdfdfd"],"phone":"(925) 556-4500","email":"","website":"http:\\/\\/www.ci.dublin.ca.us\\/Facilities.aspx?Page=detail&RID=13","googleplus":"https:\\/\\/plus.google.com\\/103274081757916658639\\/about?hl=en-US","skype":"","facebookURL":"","whatsapp_phone":"","customfield1":"dfdf","customfield2":"dfdfdf","customfield3":"dfdfdfd"}', 'ChIJSeT1Icruj4AR5EVB6BpMg7M'),
('98082CDA-197C-8FB2-3F6E-789B89681854', '96962943-750F-868B-CE96-E3102B4BD862', 'Soccer Field 8', 'Soccer Field 8 Soccer Field 8 Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Field 8Soccer Field 8 Soccer Fie', 37.681755065918, -121.890228271484, '2698 Gapwall Court, Pleasanton, CA 94566, USA', '2014-09-23 23:40:34', '2014-09-23 22:26:21', 1, '{"ac_images":["image 1"],"phone":"4085052726","email":"naveenkhanchandani@gmail.com","website":"http:\\/\\/www.ci.dublin.ca.us\\/Facilities.aspx?Page=detail&RID=13","googleplus":"https:\\/\\/plus.google.com\\/113395815990484960711\\/about?hl=en-US","skype":"skid","facebookURL":"fburl","whatsapp":"1","whatsapp_phone":"4085052726","customfield1":"abc","customfield2":"xyz","customfield3":"nmo","customfield4":"pqr","customfield5":"stu"}', 'ChIJX4Mpg2jpj4ARQrJ8AHmNxJc');

-- --------------------------------------------------------

--
-- Table structure for table `activities_cats`
--

CREATE TABLE IF NOT EXISTS `activities_cats` (
  `activity_id` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities_cats`
--

INSERT INTO `activities_cats` (`activity_id`, `category_id`) VALUES
('1CC203D8-B10A-4105-C944-FEC03C3F91AC', 1),
('5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1),
('98082CDA-197C-8FB2-3F6E-789B89681854', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `user_id` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `uid` varchar(50) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1',
  `access_level` enum('member','admin') NOT NULL DEFAULT 'member',
  `sn_type` enum('googleplus','facebook','twitter','linkedin','email') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`user_id`, `email`, `password`, `gender`, `name`, `uid`, `link`, `picture`, `created_dt`, `status`, `access_level`, `sn_type`) VALUES
('789DEC94-C832-E473-D048-4A97D7043D89', 'psriram20@gmail.com', NULL, 'female', 'Preethi Sriram', '116186854425802195485', 'https://plus.google.com/116186854425802195485', 'https://lh4.googleusercontent.com/-H02qnDXZL4k/AAAAAAAAAAI/AAAAAAAABBI/gyJcJkA1ML0/photo.jpg?sz=50', '2014-09-28 19:52:15', 1, 'member', 'googleplus'),
('96962943-750F-868B-CE96-E3102B4BD862', 'manishkk74@gmail.com', NULL, 'male', 'Manish Khanchandani', '112913147917981568678', 'https://plus.google.com/+ManishKhanchandani74', 'https://lh6.googleusercontent.com/-nLg0dFRo0DQ/AAAAAAAAAAI/AAAAAAAAGQs/AO_UIb6UHAM/photo.jpg', '2014-09-23 18:11:37', 1, 'member', 'googleplus');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`, `parent_id`) VALUES
(1, 'Soccer', 0),
(2, 'Karate', 0);

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

--
-- Dumping data for table `club_reviews`
--

INSERT INTO `club_reviews` (`review_id`, `activity_id`, `show_review`, `author_name`, `rating`, `details`, `review_date`, `language_review`) VALUES
('30AF116F-CA93-388D-9A30-EBF1DD7CE03E', '5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1, 'Pleasure Unique', 5, 'Really nice', '2014-08-16 09:41:03', 'en'),
('7E02B131-4D61-4448-A194-8D4CCB4D5A2E', '5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1, 'Joseph Gregory', 5, 'Playground for small children was great, even had water sprayers they could run around in.', '2012-04-19 09:40:52', 'en'),
('9077DBD2-8274-1A08-9FE4-51B66B6608F9', '5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1, 'Caron Furtado', 5, '', '2014-09-15 10:02:15', 'en'),
('9A21CD64-FCDA-D949-B850-009F46EAD389', '5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1, 'A Google User', 4, '', '2012-05-14 11:12:08', 'en'),
('DAECB734-2F85-F9C8-5F50-858340FD53A3', '5D69D805-DA96-E415-C444-FA4C5C3CD58A', 1, 'A Google User', 5, '', '2012-03-04 17:46:16', 'en');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
