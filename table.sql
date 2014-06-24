-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2014 at 05:05 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ChrisAndKirstin`
--

-- --------------------------------------------------------

--
-- Table structure for table `RSVP`
--

CREATE TABLE `RSVP` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `attendance_details` varchar(255) NOT NULL,
  `attendance` tinyint(1) NOT NULL,
  `plus_one` tinyint(1) NOT NULL,
  `notes` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
