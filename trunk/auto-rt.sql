-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2012 at 07:17 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
