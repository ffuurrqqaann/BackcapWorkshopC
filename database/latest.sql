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
  `question_id` int(255) unsigned NOT NULL,
  `option_id` int(255) unsigned NOT NULL,
  `device_id` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ANSWERS_QUESTION` (`question_id`),
  KEY `FK_ANSWERS_RESPONSE` (`option_id`),
  CONSTRAINT `FK_ANSWERS_QUESTION` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `FK_ANSWERS_RESPONSE` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COMMENT='This table contains the answers to the questions';

-- Dumping data for table backcap.answers: ~0 rows (approximately)
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` (`id`, `question_id`, `option_id`, `device_id`) VALUES
	(1, 1, 1, '15364-7133-18106-18092'),
	(3, 1, 1, '15364-7133-18106-18092'),
	(4, 1, 1, '15364-7133-18106-18092'),
	(7, 1, 1, '15364-7133-18106-18092'),
	(8, 1, 1, '15364-7133-18106-18092'),
	(12, 1, 2, '15364-7133-18106-18092'),
	(13, 1, 2, '15364-7133-18106-18092'),
	(15, 1, 1, '15364-7133-18106-18092'),
	(16, 1, 1, '15364-7133-18106-18092'),
	(18, 1, 1, '15364-7133-18106-18092'),
	(19, 1, 1, '15364-7133-18106-18092'),
	(24, 1, 2, '15364-7133-18106-18092'),
	(26, 1, 1, '15364-7133-18106-18092'),
	(27, 1, 1, '15364-7133-18106-18092'),
	(30, 1, 2, '15364-7133-18106-18092'),
	(31, 1, 3, '15364-7133-18106-18092'),
	(33, 1, 2, '15364-7133-18106-18092'),
	(34, 1, 1, '15364-7133-18106-18092');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;


-- Dumping structure for table backcap.options
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='This table contains the options to the questions.';

-- Dumping data for table backcap.options: ~4 rows (approximately)
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` (`id`, `name`) VALUES
	(1, 'Bad'),
	(2, 'Neutral'),
	(3, 'Good');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;


-- Dumping structure for table backcap.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `study_id` int(255) unsigned NOT NULL,
  `text` text NOT NULL,
  `image_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='This table contains all the questions';

-- Dumping data for table backcap.questions: ~2 rows (approximately)
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`, `study_id`, `text`, `image_url`) VALUES
	(1, 1, 'How good is the milk here?', 'milk.jpeg'),
	(2, 1, 'How good is the coffee here?', 'coffee.jpeg');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;


-- Dumping structure for table backcap.responses
CREATE TABLE IF NOT EXISTS `responses` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='This table contains the responses to the questions.';

-- Dumping data for table backcap.responses: ~4 rows (approximately)
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` (`id`, `name`) VALUES
	(1, 'Very Dissatisfied'),
	(2, 'Dissatisfied'),
	(3, 'Neutral'),
	(4, 'Satisfied'),
	(5, 'Very Satisfied');
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;


-- Dumping structure for table backcap.study
CREATE TABLE IF NOT EXISTS `study` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1 COMMENT='This table contains all the study';

-- Dumping data for table backcap.study: ~4 rows (approximately)
/*!40000 ALTER TABLE `study` DISABLE KEYS */;
INSERT INTO `study` (`id`, `name`) VALUES
	(1, 'drink'),
	(5, 'grass'),
	(6, 'exam'),
	(111, 'shop');
/*!40000 ALTER TABLE `study` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
