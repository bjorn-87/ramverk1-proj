-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: ramverk1proj
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ramverk1proj`
--

/*!40000 DROP DATABASE IF EXISTS `ramverk1proj`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ramverk1proj` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `ramverk1proj`;

--
-- Table structure for table `Answer`
--

DROP TABLE IF EXISTS `Answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `questionid` int NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `text` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `accepted` tinyint DEFAULT '0',
  `vote` int DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionid_idx` (`questionid`),
  CONSTRAINT `questionid` FOREIGN KEY (`questionid`) REFERENCES `Question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Answer`
--

LOCK TABLES `Answer` WRITE;
/*!40000 ALTER TABLE `Answer` DISABLE KEYS */;
INSERT INTO `Answer` VALUES (1,1,'doe','Nu fick jag leveransbesked från posten!',0,0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `Answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Answercomment`
--

DROP TABLE IF EXISTS `Answercomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Answercomment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `answerid` int NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `text` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `vote` int DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answerid_idx` (`answerid`),
  CONSTRAINT `answerid` FOREIGN KEY (`answerid`) REFERENCES `Answer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Answercomment`
--

LOCK TABLES `Answercomment` WRITE;
/*!40000 ALTER TABLE `Answercomment` DISABLE KEYS */;
INSERT INTO `Answercomment` VALUES (1,1,'bjos19','Vilken lycka, jag har inte fått min :/',0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `Answercomment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question`
--

DROP TABLE IF EXISTS `Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_swedish_ci,
  `vote` int DEFAULT '0',
  `answers` int DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username_idx` (`username`),
  CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `User` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES (1,'bjos19','N&auml;r kommer min PS5','N&auml;r f&aring;r jag min ps5  &Auml;r det n&aring;gon annan som f&aring;tt sin?',NULL,1,'2021-01-12 23:32:08','2021-01-12 23:36:54',NULL);
/*!40000 ALTER TABLE `Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Questioncomment`
--

DROP TABLE IF EXISTS `Questioncomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Questioncomment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commentquestionid` int NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `text` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `vote` int DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commentquestionid_idx` (`commentquestionid`),
  CONSTRAINT `commentquestionid` FOREIGN KEY (`commentquestionid`) REFERENCES `Question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Questioncomment`
--

LOCK TABLES `Questioncomment` WRITE;
/*!40000 ALTER TABLE `Questioncomment` DISABLE KEYS */;
INSERT INTO `Questioncomment` VALUES (1,1,'doe','Nej jag har inte fått min iallafall',0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `Questioncomment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tags`
--

DROP TABLE IF EXISTS `Tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tagquestionid` int NOT NULL,
  `text` text COLLATE utf8mb4_swedish_ci,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagquestionid_idx` (`tagquestionid`),
  CONSTRAINT `tagquestionid` FOREIGN KEY (`tagquestionid`) REFERENCES `Question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tags`
--

LOCK TABLES `Tags` WRITE;
/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
INSERT INTO `Tags` VALUES (1,1,'Ps5',NULL,'2021-01-12 23:36:54',NULL),(2,1,'villha',NULL,'2021-01-12 23:36:54',NULL);
/*!40000 ALTER TABLE `Tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `surname` varchar(45) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_swedish_ci NOT NULL,
  `role` char(20) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  `ranking` int DEFAULT '0',
  `votes` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'bjos19','$2y$10$F3h89c1tc/KHZ0P1EgBeNeV09OXiDgDpfFerBhqFEiwJN1AxBZI3e',NULL,NULL,'bjos19@student.bth.se','admin','2021-01-12 23:32:08',NULL,NULL,0,0),(2,'doe','$2y$10$OLLVEziRMxZ2thPbvRbwhuL6tIIdoYGKKlXMD./ptyVgeJl98Q6Nq',NULL,NULL,'doe@doe.doe','User','2021-01-12 23:32:08',NULL,NULL,0,0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ramverk1proj'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-13  0:55:39
