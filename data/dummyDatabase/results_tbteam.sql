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
-- Table structure for table `tbteam`
--

DROP TABLE IF EXISTS `tbteam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbteam` (
  `idTeam` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `image` text,
  `description` text,
  `website` text,
  `instagram` text,
  `facebook` text,
  `youtube` text,
  PRIMARY KEY (`idTeam`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbteam`
--

LOCK TABLES `tbteam` WRITE;
/*!40000 ALTER TABLE `tbteam` DISABLE KEYS */;
INSERT INTO `tbteam` VALUES (1,'Powerslide','/img/teams/Powerslide.jpg','We make the best speed inline skating hardware available so you can have the best inline racing experience possible. Incorporating only the highest quality materials, and innovative technologies, including heat moldable carbon boots, specialized adult and kids racing products, comfy PainFree shell designs, stiff triple x-truded Triskate frames, next level Trinity Mounting features, record breaking 125mm wheels and super-precise Wicked bearings. Our new collection is our best ever, packed with innovation and passion.','https://powerslide.com/','https://www.instagram.com/ps_matter/','https://www.facebook.com/powerslideworld','https://www.youtube.com/powerslideinlineskates'),(2,'Bont Skate',NULL,'Bont is the world’s largest manufacturer of inline skates. We design, manufacture, and have perfected a range of inline skates for beginners through to speed skates for elite skaters. Additionally, as a manufacturer, we can create custom speed skates in as little as eight weeks!','https://europe.bont.com/pages/inline-skates','https://www.instagram.com/bont_inline/','https://www.facebook.com/Bontskates/','https://www.youtube.com/channel/UCvddzNHsIcXMqq4GUc4_0ZA');
/*!40000 ALTER TABLE `tbteam` ENABLE KEYS */;
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
