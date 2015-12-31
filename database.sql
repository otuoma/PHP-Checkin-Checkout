-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2015 at 01:38 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `checkincheckout`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkincheckout`
--

CREATE TABLE IF NOT EXISTS `checkincheckout` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_unique_id` varchar(60) NOT NULL,
  `movement_type` varchar(12) NOT NULL,
  `time` date NOT NULL,
  `checkin_person_id` varchar(25) NOT NULL,
  `checkout_person_id` varchar(25) NOT NULL,
  `safety_flag` varchar(1) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `notes` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(60) NOT NULL,
  `description` varchar(100) NOT NULL,
  `item_type` varchar(30) NOT NULL,
  `owner_id` varchar(50) NOT NULL,
  `time` date NOT NULL,
  `location` varchar(15) NOT NULL DEFAULT 'checked_out',
  `staff_id` int(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `notes` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`,`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `value` varchar(50) NOT NULL,
  `notes` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `notes`) VALUES
(1, 'company_name', 'Network Books', 'Information Management Services'),
(2, 'location', 'Nairobi City', ''),
(3, 'address', 'Southlands Estate', ''),
(4, 'email', 'info@networkbooks.co.ke', ''),
(5, 'cellphone', '+254 715 397 755', '');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `second_name` varchar(30) NOT NULL,
  `person_type` varchar(20) NOT NULL,
  `password` varchar(42) NOT NULL,
  `cellphone` int(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `time` date NOT NULL,
  `staff_id` int(30) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'active',
  `permissions` text NOT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT 'default_avatar.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='stores infor for various users on the system' AUTO_INCREMENT=21 ;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`id`, `unique_id`, `email`, `first_name`, `second_name`, `person_type`, `password`, `cellphone`, `address`, `time`, `staff_id`, `status`, `permissions`, `avatar`) VALUES
(12, 'C01s/cty/3012/2011', 'info@networkbooks.co.ke', 'Admin', 'System', 'admin', 'fa9beb99e4029ad5a6615399e7bbae21356086b3', 733233788, 'My address', '2013-03-23', 12, 'active', '', 'default_avatar.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
