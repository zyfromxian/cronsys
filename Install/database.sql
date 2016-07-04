# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.24)
# Database: cron
# Generation Time: 2016-06-17 06:44:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table run_record
# ------------------------------------------------------------

DROP TABLE IF EXISTS `run_record`;

CREATE TABLE `run_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `run_status` tinyint(4) NOT NULL,
  `use_time` int(11) NOT NULL,
  `err_msg` char(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `task_id_index` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` char(200) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `cmd` varchar(200) NOT NULL DEFAULT '',
  `create_user` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL,
  `is_running` tinyint(4) NOT NULL,
  `last_runtime` int(11) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;

INSERT INTO `task` (`id`, `desc`, `address`, `cmd`, `create_user`, `create_time`, `is_running`, `last_runtime`, `is_open`)
VALUES
	(2,'test','127.0.0.1:4730','*/10 * * * * php /Users/zhaoyong/Web/php/run.php','zhaoyong',1465814638,0,1466145060,1),
	(6,'test','127.0.0.1:4730','*/1 * * * * php /Users/zhaoyong/Web/test.php','zhaoyong',1465814638,1,1466145840,1),
	(7,'test','198.0.0.1:4730','*/1 * * * * php /Users/zhaoyong/Web/php/run.php','zhaoyong',1465814638,0,1465900628,0),
	(8,'test','10.0.0.1:4730','*/1 * * * * php /Users/zhaoyong/Web/php/run.php','zhaoyong',1465814638,0,1465900628,1),
	(9,'test2','127.0.0.1:4730','*/1 * * * * php /Users/zhaoyong/Web/php/run.php','admin',1466047573,1,1466145840,1);

/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
