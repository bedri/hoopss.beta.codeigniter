-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2014 at 01:16 PM
-- Server version: 5.5.31-0ubuntu0.12.04.1
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hoopss_hoopss`
--

-- --------------------------------------------------------

--
-- Table structure for table `android`
--

CREATE TABLE IF NOT EXISTS `android` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link_2` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `android_google_site_links`
--

CREATE TABLE IF NOT EXISTS `android_google_site_links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link` text,
  `enabled` int(1) DEFAULT NULL,
  `ping` double DEFAULT NULL,
  `time` int(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE IF NOT EXISTS `archive` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link_2` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `archive_google_site_links`
--

CREATE TABLE IF NOT EXISTS `archive_google_site_links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link` text,
  `enabled` int(1) DEFAULT NULL,
  `ping` double DEFAULT NULL,
  `time` int(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'T',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `counts`
--

CREATE TABLE IF NOT EXISTS `counts` (
  `id` int(1) DEFAULT NULL,
  `music` int(10) DEFAULT NULL,
  `document` int(10) DEFAULT NULL,
  `video` int(10) DEFAULT NULL,
  `archive` int(10) DEFAULT NULL,
  `youtube` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `document_google_site_links`
--

CREATE TABLE IF NOT EXISTS `document_google_site_links` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `ping` double unsigned NOT NULL,
  `time` int(50) unsigned NOT NULL,
  KEY `id` (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(20) unsigned NOT NULL DEFAULT '0',
  `link` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `keywordbot`
--

CREATE TABLE IF NOT EXISTS `keywordbot` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) DEFAULT NULL,
  `time` int(50) unsigned DEFAULT NULL,
  `rank` int(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword_2` (`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `last_checked_site_id`
--

CREATE TABLE IF NOT EXISTS `last_checked_site_id` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_id` int(10) unsigned NOT NULL,
  `doc_last_id` int(10) unsigned NOT NULL,
  `video_last_id` int(10) unsigned NOT NULL,
  `archive_last_id` int(20) unsigned DEFAULT NULL,
  `torrent_last_id` int(10) unsigned NOT NULL,
  `android_last_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `alignment` varchar(10) DEFAULT NULL,
  `link_url` text,
  `time` int(20) DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `artist` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `track` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `music_google_site_links`
--

CREATE TABLE IF NOT EXISTS `music_google_site_links` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `ping` double unsigned NOT NULL,
  `time` int(50) unsigned NOT NULL,
  KEY `id` (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE IF NOT EXISTS `search_history` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `search_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(50) unsigned NOT NULL,
  `rank` int(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '127.0.0.1',
  `vars` text COLLATE utf8_unicode_ci NOT NULL,
  `idle` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`,`idle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `torrent`
--

CREATE TABLE IF NOT EXISTS `torrent` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `torrent_google_site_links`
--

CREATE TABLE IF NOT EXISTS `torrent_google_site_links` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `enabled` int(1) unsigned NOT NULL,
  `ping` double unsigned NOT NULL,
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sex` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_of_birth` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(4) DEFAULT '0',
  `question` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` int(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`,`username`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(50) unsigned NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `time` int(50) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video_google_site_links`
--

CREATE TABLE IF NOT EXISTS `video_google_site_links` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `ping` double unsigned NOT NULL,
  `time` int(50) unsigned NOT NULL,
  KEY `id` (`id`),
  KEY `link` (`link`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `searched_keyword` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `remote_host` varchar(255) DEFAULT NULL,
  `remote_port` varchar(10) DEFAULT NULL,
  `browser_width` int(10) DEFAULT NULL,
  `browser_height` int(10) DEFAULT NULL,
  `geo_lan` float DEFAULT NULL,
  `geo_lon` float DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_index` (`ip`,`searched_keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
