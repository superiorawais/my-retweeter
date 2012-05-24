-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2012 at 03:57 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auto-rt`
--

-- --------------------------------------------------------

--
-- Table structure for table `retweeter`
--

DROP TABLE IF EXISTS `retweeter`;
CREATE TABLE IF NOT EXISTS `retweeter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `access` varchar(255) NOT NULL,
  `access_secret` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `retweeter_tweet`
--

DROP TABLE IF EXISTS `retweeter_tweet`;
CREATE TABLE IF NOT EXISTS `retweeter_tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retweeter_id` int(11) NOT NULL,
  `tweet_id` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tweet_id` (`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `source_all`
--

DROP TABLE IF EXISTS `source_all`;
CREATE TABLE IF NOT EXISTS `source_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retweeter_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `rt_type` int(11) NOT NULL DEFAULT '1',
  `last_tweet_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `source_hashtag`
--

DROP TABLE IF EXISTS `source_hashtag`;
CREATE TABLE IF NOT EXISTS `source_hashtag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retweeter_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `hashtag` varchar(255) NOT NULL,
  `last_tweet_id` varchar(255) NOT NULL,
  `rt_type` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `source_time`
--

DROP TABLE IF EXISTS `source_time`;
CREATE TABLE IF NOT EXISTS `source_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retweeter_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `day` smallint(6) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `last_tweet_id` varchar(255) NOT NULL,
  `rt_type` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tweet_error`
--

DROP TABLE IF EXISTS `tweet_error`;
CREATE TABLE IF NOT EXISTS `tweet_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retweeter_id` int(11) NOT NULL,
  `tweet_id` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
