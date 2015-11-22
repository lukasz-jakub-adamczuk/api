-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2015 at 01:29 PM
-- Server version: 5.6.12
-- PHP Version: 5.5.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `renaissance`
--
CREATE DATABASE IF NOT EXISTS `renaissance-dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `renaissance-dev`;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_article_category` smallint(5) unsigned NOT NULL,
  `id_article_template` tinyint(3) unsigned DEFAULT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `old_url` varchar(255) DEFAULT NULL,
  `markup` longtext,
  `markdown` longtext,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `rated` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `idx` smallint(5) unsigned DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE `article_category` (
  `id_article_category` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `abbr` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `idx` tinyint(3) unsigned DEFAULT '0',
  `se` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_article_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_comment`
--

CREATE TABLE `article_comment` (
  `id_article_comment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_article` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_article_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_template`
--

CREATE TABLE `article_template` (
  `id_article_template` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `idx` tinyint(3) unsigned DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_article_template`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_verdict`
--

CREATE TABLE `article_verdict` (
  `id_article_verdict` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_article` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `verdict` text NOT NULL,
  `features` text,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sign` enum('','plus','minus') DEFAULT '',
  `creation_date` datetime NOT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_article_verdict`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `change_log`
--

CREATE TABLE `change_log` (
  `id_change_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_author` int(10) unsigned NOT NULL,
  `id_record` int(10) unsigned NOT NULL,
  `table` varchar(32) NOT NULL,
  `log` longtext NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `type` enum('create','read','update','delete') DEFAULT NULL,
  PRIMARY KEY (`id_change_log`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cup`
--

CREATE TABLE `cup` (
  `id_cup` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `slug` varchar(32) NOT NULL DEFAULT '',
  `description` mediumtext,
  PRIMARY KEY (`id_cup`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cup_battle`
--

CREATE TABLE `cup_battle` (
  `id_cup_battle` date NOT NULL DEFAULT '0000-00-00',
  `id_cup` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `player1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `player2` smallint(5) unsigned NOT NULL DEFAULT '0',
  `score1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `score2` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_cup_battle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cup_player`
--

CREATE TABLE `cup_player` (
  `id_cup_player` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_cup` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `slug` varchar(32) NOT NULL DEFAULT '',
  `description` mediumtext,
  `group` char(1) NOT NULL DEFAULT '',
  `battles` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `points` smallint(5) unsigned NOT NULL DEFAULT '0',
  `won` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lost` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_cup_player`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cup_vote`
--

CREATE TABLE `cup_vote` (
  `id_cup_vote` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` smallint(5) unsigned NOT NULL DEFAULT '0',
  `voting_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_cup_vote`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fragment`
--

CREATE TABLE `fragment` (
  `id_fragment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_fragment_type` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `fragment` text NOT NULL,
  `params` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_fragment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fragment_type`
--

CREATE TABLE `fragment_type` (
  `id_fragment_type` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id_fragment_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_gallery_category` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `slug` varchar(64) DEFAULT NULL,
  `old_url` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_gallery`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_category`
--

CREATE TABLE `gallery_category` (
  `id_gallery_category` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `slug` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_gallery_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_comment`
--

CREATE TABLE `gallery_comment` (
  `id_gallery_comment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_gallery` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_gallery_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_image`
--

CREATE TABLE `gallery_image` (
  `id_gallery_image` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_gallery` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `mime` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id_gallery_image`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lobby`
--

CREATE TABLE `lobby` (
  `id_lobby` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_author` int(10) unsigned NOT NULL,
  `id_object` int(10) unsigned DEFAULT NULL,
  `object` varchar(32) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `markdown` longtext,
  `markup` longtext,
  `creation_date` datetime DEFAULT NULL,
  `type` enum('proposed','approved','rejected') DEFAULT NULL,
  PRIMARY KEY (`id_lobby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id_news` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_author` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL DEFAULT '',
  `old_url` varchar(255) DEFAULT NULL,
  `markup` text,
  `markdown` text,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `comments` tinyint(1) DEFAULT '1',
  `verified` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_news`),
  FULLTEXT KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news_comment`
--

CREATE TABLE `news_comment` (
  `id_news_comment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_news` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_news_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news_image`
--

CREATE TABLE `news_image` (
  `id_news_image` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_news` smallint(5) unsigned NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `mime` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id_news_image`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `object_fragment`
--

CREATE TABLE `object_fragment` (
  `id_object_fragment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_fragment` smallint(5) unsigned NOT NULL,
  `id_object` smallint(5) unsigned NOT NULL,
  `object` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_object_fragment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id_permission` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_permission_group` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `value` enum('c','r','u','d') DEFAULT NULL,
  `idx` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE `permission_group` (
  `id_permission_group` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `idx` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id_permission_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shout`
--

CREATE TABLE `shout` (
  `id_shout` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_author` smallint(5) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(255) NOT NULL DEFAULT '',
  `shout` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_shout`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `id_story` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_story_category` tinyint(3) unsigned NOT NULL,
  `id_article_category` smallint(5) unsigned DEFAULT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `id_template` tinyint(3) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `old_url` varchar(255) DEFAULT NULL,
  `markup` longtext,
  `markdown` longtext,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `rated` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sum` smallint(5) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `idx` smallint(5) unsigned DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_story`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `story_category`
--

CREATE TABLE `story_category` (
  `id_story_category` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `abbr` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `idx` tinyint(3) unsigned DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_story_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `story_comment`
--

CREATE TABLE `story_comment` (
  `id_story_comment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_story` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_story_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trophy`
--

CREATE TABLE `trophy` (
  `id_trophy` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_group` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `threshold` smallint(5) unsigned DEFAULT '0',
  `idx` smallint(5) unsigned DEFAULT '0',
  `type` enum('bronze','silver','gold','platinum') DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_trophy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_group` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `hash` char(40) NOT NULL,
  `secret` char(40) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `last_visit_date` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `sz_perm` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_comment`
--

CREATE TABLE `user_comment` (
  `id_user_comment` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` smallint(5) unsigned NOT NULL,
  `id_author` smallint(5) unsigned NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_user_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id_user_group` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `priority` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id_user_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id_user_meta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` smallint(5) unsigned NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user_meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id_user_permission` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` smallint(5) unsigned NOT NULL,
  `id_permission` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id_user_permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
