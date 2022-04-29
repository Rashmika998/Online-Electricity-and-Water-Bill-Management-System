-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 29, 2022 at 09:33 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ocawbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(300) NOT NULL,
  `updated` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_fullname` varchar(50) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `admin_nic` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_contact` varchar(10) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `type` varchar(15) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_fullname` (`admin_fullname`),
  UNIQUE KEY `admin_username` (`admin_username`),
  UNIQUE KEY `admin_nic` (`admin_nic`),
  UNIQUE KEY `admin_email` (`admin_email`),
  UNIQUE KEY `admin_contact` (`admin_contact`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_month`
--

DROP TABLE IF EXISTS `bill_month`;
CREATE TABLE IF NOT EXISTS `bill_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `month` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `current_bill`
--

DROP TABLE IF EXISTS `current_bill`;
CREATE TABLE IF NOT EXISTS `current_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `meter` varchar(20) NOT NULL,
  `units` varchar(30) NOT NULL,
  `charge` varchar(20) NOT NULL,
  `total` varchar(20) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `due` date NOT NULL,
  `status` varchar(20) DEFAULT 'Not Paid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `current_details`
--

DROP TABLE IF EXISTS `current_details`;
CREATE TABLE IF NOT EXISTS `current_details` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_area` varchar(255) NOT NULL,
  `user_premises` varchar(20) NOT NULL,
  `user_account` varchar(20) NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(15) DEFAULT 'Pending',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `current_pay`
--

DROP TABLE IF EXISTS `current_pay`;
CREATE TABLE IF NOT EXISTS `current_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pay_name` varchar(100) NOT NULL,
  `pay_nic` varchar(20) NOT NULL,
  `pay_amount` varchar(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `paid_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image_upload`
--

DROP TABLE IF EXISTS `image_upload`;
CREATE TABLE IF NOT EXISTS `image_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `image` longblob NOT NULL,
  `filetype` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'Pending',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `feedback` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(30) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `date_time` datetime DEFAULT current_timestamp(),
  `view` varchar(10) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `red_bill`
--

DROP TABLE IF EXISTS `red_bill`;
CREATE TABLE IF NOT EXISTS `red_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `user_nic` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_contact` varchar(10) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_email_2` (`user_email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_bill`
--

DROP TABLE IF EXISTS `water_bill`;
CREATE TABLE IF NOT EXISTS `water_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `meter` varchar(20) NOT NULL,
  `units` varchar(30) NOT NULL,
  `charge` float NOT NULL,
  `total` float NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `due` date NOT NULL,
  `status` varchar(20) DEFAULT 'Not Paid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_bill_month`
--

DROP TABLE IF EXISTS `water_bill_month`;
CREATE TABLE IF NOT EXISTS `water_bill_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `month` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_details`
--

DROP TABLE IF EXISTS `water_details`;
CREATE TABLE IF NOT EXISTS `water_details` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_account` varchar(16) NOT NULL,
  `user_meter` varchar(20) NOT NULL,
  `category` varchar(100) NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `status` varchar(15) DEFAULT 'Pending',
  `feedback` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_image_upload`
--

DROP TABLE IF EXISTS `water_image_upload`;
CREATE TABLE IF NOT EXISTS `water_image_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `image` longblob NOT NULL,
  `filetype` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `status` varchar(10) DEFAULT 'Pending',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `feedback` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_notifications`
--

DROP TABLE IF EXISTS `water_notifications`;
CREATE TABLE IF NOT EXISTS `water_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(30) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `date_time` datetime DEFAULT current_timestamp(),
  `view` varchar(10) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_pay`
--

DROP TABLE IF EXISTS `water_pay`;
CREATE TABLE IF NOT EXISTS `water_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pay_name` varchar(100) NOT NULL,
  `pay_nic` varchar(20) NOT NULL,
  `pay_amount` double NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `paid_at` datetime DEFAULT current_timestamp(),
  `arrear` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `water_red_bill`
--

DROP TABLE IF EXISTS `water_red_bill`;
CREATE TABLE IF NOT EXISTS `water_red_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
