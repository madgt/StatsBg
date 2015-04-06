# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: BggStatistics
# Generation Time: 2015-04-06 16:08:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Collection
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Collection`;

CREATE TABLE `Collection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameName` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bggId` int(11) DEFAULT NULL,
  `numOfPlays` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table Players
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Players`;

CREATE TABLE `Players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userId` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table Plays
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Plays`;

CREATE TABLE `Plays` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `playId` int(11) DEFAULT NULL,
  `gameId` int(11) DEFAULT NULL,
  `numberOfPlayers` int(11) DEFAULT NULL,
  `comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table Points
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Points`;

CREATE TABLE `Points` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `playId` int(11) DEFAULT NULL,
  `playerId` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `role` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=806 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table Priority
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Priority`;

CREATE TABLE `Priority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table Wishlist
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Wishlist`;

CREATE TABLE `Wishlist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameName` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bggId` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
