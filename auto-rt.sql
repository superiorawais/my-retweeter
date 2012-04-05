-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2012 at 05:37 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retweeter`
--

INSERT INTO `retweeter` (`id`, `username`, `status`, `access`, `access_secret`) VALUES
(1, 'tes1_myrt', 1, '535698480-RwW23B3PSpiio04UxnIy1KrIrSC1eHwfKJPa0YGm', 'P3faRGrryDBKBWdVcIlMWqVGYCGPeY7NsB6Rp12yRm4');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retweeter_tweet`
--

INSERT INTO `retweeter_tweet` (`id`, `retweeter_id`, `tweet_id`, `text`, `date`) VALUES
(1, 1, '187915590629982208', 'mati kau', '2012-04-05 21:52:29'),
(2, 1, '187915857651961858', 'sok cobain #teseksperimen', '2012-04-05 21:53:33');

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
  `last_tweet_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `source_all`
--

INSERT INTO `source_all` (`id`, `retweeter_id`, `username`, `status`, `last_tweet_id`) VALUES
(3, 1, 'tes2_myrt', 1, '187915857651961858');

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
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `source_hashtag`
--

INSERT INTO `source_hashtag` (`id`, `retweeter_id`, `username`, `hashtag`, `last_tweet_id`, `status`) VALUES
(1, 1, 'tes2_myrt', '#teseksperimen', '187915857651961858', 1);

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
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `source_time`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweet_error`
--

