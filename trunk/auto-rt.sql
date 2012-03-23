-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2012 at 08:10 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `retweeter`
--

INSERT INTO `retweeter` (`id`, `username`, `status`, `access`, `access_secret`) VALUES
(4, 'yudir', 1, '49005834-5EF0g851EBUA22Ybhb49uO0hOCddXkb0QW1RU10IC', 'TkjaehCf5Pwnc2JYMZHCSaZYKfcpqnIM3EzscMbb24');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `source_hashtag`
--

INSERT INTO `source_hashtag` (`id`, `retweeter_id`, `username`, `hashtag`, `last_tweet_id`, `status`) VALUES
(2, 4, 'dindaf', '#tesretweeter,#akuneksperimen', '1', 1);
