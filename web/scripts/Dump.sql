CREATE DATABASE  IF NOT EXISTS `missions` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `missions`;
-- MySQL dump 10.13  Distrib 8.0.25, for Linux (x86_64)
--
-- Host: localhost    Database: missions
-- ------------------------------------------------------
-- Server version	8.0.25-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assigners`
--

DROP TABLE IF EXISTS `assigners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assigners` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `ordernumber` int NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `ordernumber_UNIQUE` (`ordernumber`),
  KEY `key_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `executers`
--

DROP TABLE IF EXISTS `executers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `executers` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `key_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history` (
  `UID` int NOT NULL AUTO_INCREMENT,
  `ACTIONDATETIME` datetime NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `DESCRIPTION` char(255) NOT NULL,
  `RECORDCONTENT` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `HST_KEY_UID` (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=1410 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inifile`
--

DROP TABLE IF EXISTS `inifile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inifile` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `section` varchar(45) DEFAULT NULL,
  `param` varchar(45) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `visible` int DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mission_fact`
--

DROP TABLE IF EXISTS `mission_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mission_fact` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_UNIQUE` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `missionitems`
--

DROP TABLE IF EXISTS `missionitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `missionitems` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `missionuid` int NOT NULL,
  `num_pp` int NOT NULL,
  `deadline` varchar(100) NOT NULL,
  `assigneruid` int NOT NULL,
  `assigner_name` varchar(45) NOT NULL,
  `executeruid` int NOT NULL,
  `executer_name` varchar(45) NOT NULL,
  `task` varchar(2048) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_UNIQUE` (`uid`),
  KEY `key_mission` (`missionuid`,`num_pp`),
  KEY `key_assigner` (`assigneruid`),
  KEY `key_executer` (`executeruid`),
  CONSTRAINT `fk_missionitems_1` FOREIGN KEY (`missionuid`) REFERENCES `missions` (`uid`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_missionitems_2` FOREIGN KEY (`assigneruid`) REFERENCES `assigners` (`uid`) ON DELETE RESTRICT,
  CONSTRAINT `fk_missionitems_3` FOREIGN KEY (`executeruid`) REFERENCES `executers` (`uid`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `missions`
--

DROP TABLE IF EXISTS `missions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `missions` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `mission_name` varchar(256) NOT NULL,
  `mission_date` date NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `approve_post` varchar(100) NOT NULL,
  `approve_fio` varchar(100) NOT NULL,
  `url` varchar(2048) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mission_name_UNIQUE` (`mission_name`),
  KEY `key_name` (`mission_date`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password_hash` varchar(256) DEFAULT NULL,
  `usertype` int DEFAULT NULL,
  `executerid` int DEFAULT NULL,
  `assignerid` int DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `login` (`login`),
  KEY `idx-username` (`username`),
  KEY `idx-executer` (`executerid`),
  KEY `idx-assigner` (`assignerid`),
  CONSTRAINT `fk_user_1` FOREIGN KEY (`assignerid`) REFERENCES `assigners` (`uid`) ON DELETE RESTRICT,
  CONSTRAINT `fk_user_2` FOREIGN KEY (`executerid`) REFERENCES `executers` (`uid`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workers`
--

DROP TABLE IF EXISTS `workers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workers` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT,
  `workername` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `workername_UNIQUE` (`workername`),
  KEY `KEY_NAME` (`workername`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-29 16:15:58
