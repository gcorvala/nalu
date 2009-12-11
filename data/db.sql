
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE DATABASE `db_projet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_projet`;



CREATE TABLE `Comments` (
  `Email` varchar(50) NOT NULL,
  `Text` text NOT NULL,
  `URLFeed` varchar(200) NOT NULL,
  `URLItem` varchar(200) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URLFeed`,`URLItem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `FeedItems` (
  `URLFeed` varchar(200) NOT NULL,
  `URLItem` varchar(200) NOT NULL,
  PRIMARY KEY (`URLFeed`,`URLItem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Feeds` (
  `URL` varchar(200) CHARACTER SET latin1 NOT NULL,
  `Name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `Description` varchar(20) CHARACTER SET latin1 NOT NULL,
  `Link` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `Friends` (
  `EmailA` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EmailB` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Date` datetime NOT NULL,
  `Accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`EmailA`,`EmailB`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Items` (
  `URL` varchar(200) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Date` datetime NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Reads` (
  `Email` varchar(50) NOT NULL,
  `URLItem` varchar(200) NOT NULL,
  `URLFeed` varchar(200) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URLItem`,`URLFeed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Shares` (
  `URLFeed` varchar(200) NOT NULL,
  `URLItem` varchar(200) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Note` text NOT NULL,
  PRIMARY KEY (`URLFeed`,`URLItem`,`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Subscriptions` (
  `Email` varchar(50) NOT NULL,
  `URL` varchar(200) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`Email`,`URL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `Users` (
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Country` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Avatar` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Biography` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `SubscribeDate` datetime NOT NULL,
  `FeedURL` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
