CREATE DATABASE  IF NOT EXISTS `results` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `results`;
-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: results
-- ------------------------------------------------------
-- Server version	8.0.27

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
-- Table structure for table `tbracedeleted`
--

DROP TABLE IF EXISTS `tbracedeleted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbracedeleted` (
  `idRaceDeleted` int NOT NULL AUTO_INCREMENT,
  `id` int DEFAULT NULL,
  `relay` bit(1) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `link` mediumtext,
  `category` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `trackStreet` varchar(255) DEFAULT NULL,
  `idCompetition` int DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `discipline` varchar(50) DEFAULT NULL,
  `skateType` varchar(45) DEFAULT 'inline',
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  `round` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRaceDeleted`)
) ENGINE=InnoDB AUTO_INCREMENT=24886 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbracedeleted`
--

LOCK TABLES `tbracedeleted` WRITE;
/*!40000 ALTER TABLE `tbracedeleted` DISABLE KEYS */;
INSERT INTO `tbracedeleted` VALUES (24875,14295,_binary '\0','10000m',NULL,'Senior','m',NULL,'Road',229,'Pascal','long','quads','2021-01-29 14:45:20','2022-08-17 11:33:52',NULL,1,NULL),(24876,25037,_binary '\0','100000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:44','2022-08-27 14:29:44',376,0,NULL),(24877,25038,_binary '\0','22000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24878,25039,_binary '\0','44000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24879,25040,_binary '\0','44000 m',NULL,'senior','w',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24880,25041,_binary '\0','66000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24881,25042,_binary '\0','66000 m',NULL,'senior','w',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24882,25044,_binary '\0','88000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24883,25043,_binary '\0','95500 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24884,25045,_binary '\0','97000 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL),(24885,25046,_binary '\0','98500 m',NULL,'senior','m',NULL,'road',430,NULL,NULL,'inline','2022-08-27 14:29:45','2022-08-27 14:29:45',376,0,NULL);
/*!40000 ALTER TABLE `tbracedeleted` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-30 13:47:47
