-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `com_jbcoats_newsaggregator`;

DROP TABLE IF EXISTS `NA_Category`;
CREATE TABLE `NA_Category` (
  `CategoryID` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `Category` varchar(120) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `NA_Category` (`CategoryID`, `Category`, `Description`) VALUES
(1,	'Technology',	'Technology is important in today\'s world because it serves a variety of functions in many of the most important aspects of modern society, like education, communication, business and scientific progress.'),
(2,	'Food',	'Keep up with the latest recipes, restaurants, and chefs.'),
(3,	'Movies',	'New movie releases available.');

DROP TABLE IF EXISTS `NA_Feed`;
CREATE TABLE `NA_Feed` (
  `FeedID` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `FeedName` varchar(120) DEFAULT NULL,
  `CategoryID` int(100) unsigned DEFAULT NULL,
  `URL` varchar(300) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`FeedID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `NA_Feed_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `NA_Category` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `NA_Feed` (`FeedID`, `FeedName`, `CategoryID`, `URL`, `Description`) VALUES
(1,	'Microsoft',	1,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Microsoft&output=rss',	'All news about Microsoft.'),
(2,	'Google',	1,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Google&output=rss',	'What\'s new about Google.'),
(3,	'Apple',	1,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Apple&output=rss',	'All about Apple.'),
(4,	'Recipes',	2,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Recipes&output=rss',	'See all kinds of recipes.'),
(5,	'Chefs',	2,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Chefs&output=rss',	'News about distinctive chefs.'),
(6,	'Resteraunts',	2,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Resteraunts&output=rss',	'Popular and new resteraunts.'),
(7,	'Commedy',	3,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Commedy+Movies&output=rss',	'News about commedies.'),
(8,	'Action',	3,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Action+Movies&output=rss',	'What action movies are coming out.'),
(9,	'Sci-Fi',	3,	'http://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=Sci-Fi+Movies&output=rss',	'Fantastic and futuristic movies.');

-- 2017-03-11 01:33:53