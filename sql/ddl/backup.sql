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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answer` (
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
  CONSTRAINT `questionid` FOREIGN KEY (`questionid`) REFERENCES `question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,1,'doe','Nu fick jag leveransbesked från posten!',0,0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answercomment`
--

DROP TABLE IF EXISTS `answercomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answercomment` (
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
  CONSTRAINT `answerid` FOREIGN KEY (`answerid`) REFERENCES `answer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answercomment`
--

LOCK TABLES `answercomment` WRITE;
/*!40000 ALTER TABLE `answercomment` DISABLE KEYS */;
INSERT INTO `answercomment` VALUES (1,1,'bjos19','Vilken lycka, jag har inte fått min :/',0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `answercomment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
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
  CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'bjos19','N&auml;r kommer min PS5','N&auml;r f&aring;r jag min ps5  &Auml;r det n&aring;gon annan som f&aring;tt sin?',NULL,1,'2021-01-12 23:32:08','2021-01-12 23:36:54',NULL);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questioncomment`
--

DROP TABLE IF EXISTS `questioncomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questioncomment` (
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
  CONSTRAINT `commentquestionid` FOREIGN KEY (`commentquestionid`) REFERENCES `question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questioncomment`
--

LOCK TABLES `questioncomment` WRITE;
/*!40000 ALTER TABLE `questioncomment` DISABLE KEYS */;
INSERT INTO `questioncomment` VALUES (1,1,'doe','Nej jag har inte fått min iallafall',0,'2021-01-12 23:32:08',NULL,NULL);
/*!40000 ALTER TABLE `questioncomment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tagquestionid` int NOT NULL,
  `text` text COLLATE utf8mb4_swedish_ci,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagquestionid_idx` (`tagquestionid`),
  CONSTRAINT `tagquestionid` FOREIGN KEY (`tagquestionid`) REFERENCES `question` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,1,'Ps5',NULL,'2021-01-12 23:36:54',NULL),(2,1,'villha',NULL,'2021-01-12 23:36:54',NULL);
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
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
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'bjos19','$2y$10$F3h89c1tc/KHZ0P1EgBeNeV09OXiDgDpfFerBhqFEiwJN1AxBZI3e',NULL,NULL,'bjos19@student.bth.se','admin','2021-01-12 23:32:08',NULL,NULL,0,0),(2,'doe','$2y$10$OLLVEziRMxZ2thPbvRbwhuL6tIIdoYGKKlXMD./ptyVgeJl98Q6Nq',NULL,NULL,'doe@doe.doe','user','2021-01-12 23:32:08',NULL,NULL,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
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
