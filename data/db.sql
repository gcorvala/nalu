
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE DATABASE `db_projet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_projet`;



DROP TABLE IF EXISTS `Comments`;
CREATE TABLE IF NOT EXISTS `Comments` (
  `Email` varchar(200) NOT NULL,
  `Text` text NOT NULL,
  `URLFeed` varchar(400) NOT NULL,
  `URLItem` varchar(400) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URLFeed`,`URLItem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `FeedItems`;
CREATE TABLE IF NOT EXISTS `FeedItems` (
  `URLFeed` varchar(400) NOT NULL,
  `URLItem` varchar(400) NOT NULL,
  PRIMARY KEY (`URLFeed`,`URLItem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Feeds`;
CREATE TABLE IF NOT EXISTS `Feeds` (
  `URL` varchar(400) CHARACTER SET latin1 NOT NULL,
  `Name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Description` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Link` varchar(400) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `Friends`;
CREATE TABLE IF NOT EXISTS `Friends` (
  `EmailA` varchar(200) NOT NULL,
  `EmailB` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Date` datetime NOT NULL,
  `Accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`EmailA`,`EmailB`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Items`;
CREATE TABLE IF NOT EXISTS `Items` (
  `URL` varchar(400) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Date` datetime NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Reads`;
CREATE TABLE IF NOT EXISTS `Reads` (
  `Email` varchar(200) NOT NULL,
  `URLItem` varchar(400) NOT NULL,
  `URLFeed` varchar(400) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URLItem`,`URLFeed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Shares`;
CREATE TABLE IF NOT EXISTS `Shares` (
  `URLFeed` varchar(400) NOT NULL,
  `URLItem` varchar(400) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Note` text NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`URLFeed`,`URLItem`,`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Subscriptions`;
CREATE TABLE IF NOT EXISTS `Subscriptions` (
  `Email` varchar(200) NOT NULL,
  `URL` varchar(400) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `Email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Country` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Avatar` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Biography` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `SubscribeDate` datetime NOT NULL,
  `FeedURL` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
