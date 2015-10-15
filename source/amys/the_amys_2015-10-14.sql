# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.45)
# Database: the_amys
# Generation Time: 2015-10-14 16:15:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table amy_values
# ------------------------------------------------------------

DROP TABLE IF EXISTS `amy_values`;

CREATE TABLE `amy_values` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `shortened_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `description` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

LOCK TABLES `amy_values` WRITE;
/*!40000 ALTER TABLE `amy_values` DISABLE KEYS */;

INSERT INTO `amy_values` (`ID`, `full_name`, `shortened_name`, `description`)
VALUES
	(1,'Fearless challengemongering','Challengemongerer','This person fights for what they believe in - constructively, with conviction, and with humility.'),
	(2,'Authenticity','Authentic','This person is their same authentic self at the office as they are at home or in the pub, no matter who\'s around.'),
	(3,'Giving a damn','Gives a damn','This isn’t a “job” for this person; it’s a calling. They\'re driven intrisincally and care deeply about their work.'),
	(4,'Being a kind guru, not a selfish genius','Kind guru','This person shares their expertise generously - enabling the team to flourish.'),
	(5,'Macro-leading, not micro-managing','Macro-leader','This person has a clear vision, and trusts and inspires people to deliver it.'),
	(6,'Collaboration','Collaborator','This person proactively seeks collaboration, leading to thinking which is greater than the sum of its parts.'),
	(7,'Genchi genbutsu','Genchi genbutsu','This person seeks insight for themselves. They don\'t just rely on assumptions and opinions.'),
	(8,'Outcomes over artefacts','Outcomes over artefacts','This person impacts KPIs without creating bloat.'),
	(9,'Weniger aber besser','Weniger aber besser','This person focuses on the essence of the problem and nails it. They do less, but better.');

/*!40000 ALTER TABLE `amy_values` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table awards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `awards`;

CREATE TABLE `awards` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `award_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `giver_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `giver_email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `recipient_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `recipient_email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `amy_value_1` int(11) NOT NULL,
  `amy_value_2` int(11) DEFAULT NULL,
  `amy_value_3` int(11) DEFAULT NULL,
  `explanation` text COLLATE latin1_general_ci NOT NULL,
  `processed_date` timestamp NULL DEFAULT NULL,
  `void_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `amy_value_1` (`amy_value_1`),
  KEY `amy_value_2` (`amy_value_2`),
  KEY `amy_value_3` (`amy_value_3`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

LOCK TABLES `awards` WRITE;
/*!40000 ALTER TABLE `awards` DISABLE KEYS */;

INSERT INTO `awards` (`ID`, `award_date`, `giver_name`, `giver_email`, `recipient_name`, `recipient_email`, `amy_value_1`, `amy_value_2`, `amy_value_3`, `explanation`, `processed_date`, `void_date`)
VALUES
	(1,'2015-09-18 08:46:00','Greg Jenkins','Greg.Jenkins@three.co.uk','Frances Maxwell','Frances.Maxwell@three.co.uk',1,7,NULL,'For doing an awesome job on covering the SMT playback -  and designing the VOLTE interactive app',NULL,NULL),
	(2,'2015-09-18 13:05:00','Matthew Armishaw','Matthew.Armishaw@three.co.uk','Brendan Meachen','Brendan.Meachen@three.co.uk',1,3,8,'During a time when he was being massively overstretched supporting situations in other micro-teams, Brendan \r\nstill delivered what he promised he would. Sounds simple but it’s a rare thing in practice.  He also adapted to \r\ndelivering simple outcomes over complex solution discussions whilst remaining a committed team member and \r\na fearless challengemonger.',NULL,NULL),
	(3,'2015-09-19 09:52:00','Stuart Brown','stuart.brown@three.co.uk','Adrian Crowther','adrian.r.crowther@baesystems.com',2,3,8,'Outstanding delivery in the face of changing & inconsistent requirements. Outstanding ability to keep biting tongue.',NULL,NULL),
	(4,'2015-09-20 09:04:00','Luke Chircop','Luke.Chircop@three.co.uk','Nick Bishop','Nick.Bishop@three.co.uk',3,4,6,'Kicking ass and taking control of the team and topup. Improving our customer experience and business kpis.',NULL,NULL),
	(5,'2015-09-19 13:14:00','Paul Blake','Paul.Blake@three.co.uk','Darren Paterson','Darren.Paterson@three.co.uk',1,2,3,'For challenging SCL\'s diagnostic app in an intelligent, positive way',NULL,NULL),
	(6,'2015-09-19 13:15:00','Paul Blake','Paul.Blake@three.co.uk','Robert Bloomfield','Robert.Bloomfield@three.co.uk',2,3,6,'For your thought leadership in developing  the content driven tool concept',NULL,NULL),
	(7,'2015-09-19 13:16:00','Paul Blake','Paul.Blake@three.co.uk','Andrew Carter','Andrew.Carter@three.co.uk',3,6,8,'For the terrific',NULL,NULL),
	(8,'2015-09-25 14:57:00','John Anderson','jonny.anderson@three.co.uk','Dan Beeston','Daniel.Beeston@three.co.uk',3,4,6,'Took time to walk upstairs (with a dodgy knee), to help me with a maximiser issue that has bugging me all day/all year. Thanks for caring',NULL,NULL),
	(9,'2015-09-21 11:59:00','Rax','Rakesh.Shah@three.co.uk','Adrian Carter','Adrian.Carter@three.co.uk',3,5,NULL,'Hybris upgrade suppport; 4 weekends in a row for ops and Edisson.  Team Player',NULL,NULL),
	(10,'2015-09-20 16:36:00','Rax','Rakesh.Shah@three.co.uk','Nigel Holland','Nigel.Holland@three.co.uk',3,6,8,'Incredible support of online ops manager during an intense release period. Perfect management of incidents.',NULL,NULL),
	(11,'2015-09-28 12:13:00','Chris Chapman','Christopher.Chapman@three.co.uk','Justin Beasley','Justin.Beasley@three.co.uk',4,NULL,NULL,'Gone above and beyond to help me set up a valuable tool for my new function, no request was too much and he has been a pleasure to work with throughout.',NULL,NULL),
	(12,'2015-09-30 12:00:00','Tom Brookes','Tom.Brookes@three.co.uk','Marouf  Al-Rashid','Marouf.Al-Rashid@three.co.uk',0,NULL,NULL,'',NULL,NULL),
	(13,'2015-09-30 12:00:00','Chris Herd','Christopher.Herd@three.co.uk','Martin Grey','Martin.Grey@three.co.uk',3,4,6,'A massive thanks to Martin who went out of his way to help me to tackle a problem I was facing when building a new responsive page. He actively encouraged collaboration and sharing knowledge',NULL,NULL),
	(14,'2015-09-30 12:00:00','Jacqs Harper','Jacqs.Harper@three.co.uk','Andy A\'Court ','Andy.ACourt @three.co.uk',4,NULL,NULL,'For turning an ugly pack into some really good slides',NULL,NULL),
	(15,'2015-09-30 12:00:00','Marcus Woodbridge ','Marcus.Woodbridge@three.co.uk','Frazer Cooper','Frazer.Cooper@three.co.uk',3,4,6,'Going beyond expectations  to provide invaluable  info, off your own back and not being overly precious of anufinished product',NULL,NULL),
	(17,'2015-10-01 12:00:00','Ryan McDonnell','Ryan.McDonnell@three.co.uk','Helen Reeves','Helen.Reeves@three.co.uk',3,6,4,'For being a team player, performing her own role and covering for PO as the same time for such a long period. Holding the fort when without me as a dev manager when I was off for almost three weeks.  And keeping Cooper going almost singlehandedly one day through team holiday and illness.',NULL,NULL),
	(18,'2015-10-01 12:00:00','Helen Reeves','Helen.Reeves@three.co.uk','Assaf Itzkison','Assaf.Itzkison@three.co.uk',3,4,NULL,'Thanks for stepping in last minute and helping Team Cooper sign off the cross sell page, without you we would have been delayed',NULL,NULL),
	(19,'2015-10-01 12:00:00','Vahideh Rahnama','Vahideh.Rahnama@three.co.uk','Ian Buckley','Ian.Buckley@three.co.uk',3,4,NULL,'Thanks for fixingf the samsung mifi \"dev\" so quickly for BA. Your help  is much appreciated and now we can sell it correctly. Thank you  ',NULL,NULL),
	(20,'2015-10-01 12:00:00','Gregory Bissett','Gregory.Bissett@three.co.uk','Vincent Butcher','Vincent.Butcher@three.co.uk',2,3,4,'For being a brilliant (but grumpy) old shit. Never too busy to help and constantly proves hes a superb team member',NULL,NULL),
	(21,'2015-10-01 12:00:00','Justin Beasley','Justin.Beasley@three.co.uk','Jamie Barker','Jamie.Barker@three.co.uk',0,NULL,NULL,'For your awesome help with our new device support pages; for going above and beyond and always being generous with your time and willingness to share knowledge. Well deserved.',NULL,NULL),
	(22,'2015-10-01 12:00:00','Vahideh Rahnama','Vahideh.Rahnama@three.co.uk','Martin Grey','Martin.Grey@three.co.uk',3,4,NULL,'Martin thank you so much on the ?. Page, despite the fact you are so busy, much appreciated',NULL,NULL),
	(23,'2015-10-01 12:00:00','Vahideh Rahnama','Vahideh.Rahnama@three.co.uk','Stephen Seage','Stephen.Seage@three.co.uk',3,4,NULL,'Thank you for helping me with the reporting and being patient in showing me how to do it',NULL,NULL),
	(24,'2015-10-01 12:00:00','Frances Maxwell ','Frances.Maxwell@three.co.uk','Ara Avakian','Ara.Avakian@three.co.uk',1,7,9,'For Being a fearless challengemongerer on Package Hub - not just wireframe as the solution you\'ve been given, buit seeking insight for yourself and coming up with great MVPs.',NULL,NULL),
	(25,'2015-10-01 12:00:00','Frances Maxwell ','Frances.Maxwell@three.co.uk','Stuart Brown','Stuart.Brown@three.co.uk',4,3,6,'For being a continued asset to Team Loud with your thoughtful, collaborative and intelligent contributions. You remain patient and  helpful in challenging circumstances and across, making time for us all. ',NULL,NULL),
	(27,'2015-10-14 17:14:42','Ryan McDonnell','Ryan.McDonnell@three.co.uk','Justin Beasley','Justin.Beasley@three.co.uk',3,4,NULL,'',NULL,NULL);

/*!40000 ALTER TABLE `awards` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
