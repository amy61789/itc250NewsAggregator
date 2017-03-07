SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `NA_Categories`;
CREATE TABLE `NA_Categories` (
  `CategoryID` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `Category` varchar(120) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `NA_Categories` (`CategoryID`, `Category`, `Description`) VALUES
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
  CONSTRAINT `NA_Feed_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `NA_Categories` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
