-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2020 at 05:34 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `busmate`
--
CREATE DATABASE IF NOT EXISTS `busmate` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `busmate`;

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

DROP TABLE IF EXISTS `bus`;
CREATE TABLE IF NOT EXISTS `bus` (
  `bus_id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `bus_incharge` varchar(40) COLLATE utf8_bin NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `busmateadmin`
--

DROP TABLE IF EXISTS `busmateadmin`;
CREATE TABLE IF NOT EXISTS `busmateadmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `missedthebus`
--

DROP TABLE IF EXISTS `missedthebus`;
CREATE TABLE IF NOT EXISTS `missedthebus` (
  `requestid` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(30) NOT NULL,
  `stop_name` varchar(30) NOT NULL,
  `stop_id` int(11) NOT NULL,
  `requested_bus_id` int(11) NOT NULL,
  `acceptance_status` varchar(20) DEFAULT NULL,
  `request_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`requestid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
CREATE TABLE IF NOT EXISTS `route` (
  `bus_id` int(11) NOT NULL,
  `stop_id` int(11) NOT NULL,
  `stop_number` int(11) NOT NULL,
  `no_of_bus` int(11) NOT NULL,
  PRIMARY KEY (`bus_id`,`stop_id`),
  KEY `fk1` (`stop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `stop`
--

DROP TABLE IF EXISTS `stop`;
CREATE TABLE IF NOT EXISTS `stop` (
  `stop_id` int(11) NOT NULL AUTO_INCREMENT,
  `stop_name` varchar(40) COLLATE utf8_bin NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  PRIMARY KEY (`stop_id`),
  UNIQUE KEY `stop_name` (`stop_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_loginid` varchar(40) COLLATE utf8_bin NOT NULL,
  `passhash` varchar(128) COLLATE utf8_bin NOT NULL,
  `stop_id` int(11) NOT NULL,
  `pref_bus_id` int(11) NOT NULL,
  `student_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `student_contact` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`stop_id`) REFERENCES `stop` (`stop_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
