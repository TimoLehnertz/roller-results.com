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
-- Table structure for table `tb_analyticsselectpreset`
--

DROP TABLE IF EXISTS `tb_analyticsselectpreset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_analyticsselectpreset` (
  `idAnalyticsSelectPreset` int NOT NULL AUTO_INCREMENT,
  `distances` text,
  `comps` text,
  `gender` varchar(45) DEFAULT NULL,
  `categories` text,
  `disciplines` text,
  `minPlace` int DEFAULT NULL,
  `maxPlace` int DEFAULT NULL,
  `locations` text,
  `fromDate` date DEFAULT NULL,
  `toDate` date DEFAULT NULL,
  `limit` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `ids` text,
  `joinMethode` varchar(10) DEFAULT NULL,
  `owner` int DEFAULT NULL,
  `public` tinyint DEFAULT NULL,
  `countries` text,
  PRIMARY KEY (`idAnalyticsSelectPreset`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_analyticsselectpreset`
--

LOCK TABLES `tb_analyticsselectpreset` WRITE;
/*!40000 ALTER TABLE `tb_analyticsselectpreset` DISABLE KEYS */;
INSERT INTO `tb_analyticsselectpreset` VALUES (27,'.','WM|EM','.','Senior','.',1,100,'.','1900-01-01','2050-01-01',50,'Senior  Wm / Em top 100','.','and',18,0,'.'),(28,'.','WM|EM','.','Junior','.',1,10,'.','1900-01-01','2018-01-01',50,'France','.','and',18,0,'France');
/*!40000 ALTER TABLE `tb_analyticsselectpreset` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-30 13:47:48
