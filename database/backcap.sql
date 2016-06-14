-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.5-10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for backcap
CREATE DATABASE IF NOT EXISTS `backcap` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `backcap`;


-- Dumping structure for table backcap.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `response_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ANSWERS_QUESTION` (`question_id`),
  KEY `FK_ANSWERS_RESPONSE` (`response_id`),
  CONSTRAINT `FK_ANSWERS_QUESTION` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `FK_ANSWERS_RESPONSE` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table contains the answers to the questions';

-- Data exporting was unselected.


-- Dumping structure for table backcap.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `image_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table contains all the questions';

-- Data exporting was unselected.


-- Dumping structure for table backcap.responses
CREATE TABLE IF NOT EXISTS `responses` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table contains the responses to the questions.';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
