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
-- Table structure for table `tbdevlog`
--

DROP TABLE IF EXISTS `tbdevlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbdevlog` (
  `idTbDevLog` int NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `status` varchar(45) DEFAULT 'planned' COMMENT 'waiting / in progress / done',
  `image` text,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idTbDevLog`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbdevlog`
--

LOCK TABLES `tbdevlog` WRITE;
/*!40000 ALTER TABLE `tbdevlog` DISABLE KEYS */;
INSERT INTO `tbdevlog` VALUES (3,'New Developer blog','I created this developer blog where i will post about new features','done','/img/code.jpg','2022-08-24 21:27:56','2022-08-24 21:41:17'),(4,'Paypal Donations button','From now on we accept donations to cover the server costs. Scroll down to see it','done','/img/donate.jpg','2022-08-25 16:59:03','2022-08-25 16:59:52'),(5,'Analytics V2','The analytics page got complete documentation and many bug fixes','done','/img/Analytics-explanation.jpg','2022-08-26 04:07:13','2022-08-26 04:07:13'),(6,'User athlete link approval','Athlete user links can now get approved by administrators to allow users to change their athlete profile to their likings','done','','2022-08-26 04:08:33','2022-08-26 06:03:32'),(7,'Social media on Athlete Profile page','The athletes pages can now show linhks to social media and a short text about the skater','done','/img/social.jpg','2022-08-26 06:03:32','2022-08-26 06:03:55'),(8,'User editable Athletes','Verified users can now edit their athletes pages information without confirmation','done','/img/change-athlete.jpg','2022-08-26 06:06:06','2022-08-26 06:06:34'),(9,'Year search implemented','You can now search for years in the search bar and be able to see all competition from one year in the competitions page','done',NULL,'2022-08-26 18:33:16','2022-08-26 18:33:16'),(10,'unchecked bug fix','athletes got marked as unchecked when loaded into race tables. Now fixed','done',NULL,'2022-08-26 18:40:48','2022-08-26 18:40:58'),(11,'Uploader and date visible in competition','Now you can see who and when competitions got uploaded','done',NULL,'2022-08-26 19:03:46','2022-08-26 19:03:46'),(12,'Competitions page display bug fixed','Competitions now get displayed properly even on mobile','done',NULL,'2022-08-26 19:07:59','2022-08-26 19:07:59'),(17,'Feature request added','You can now anonumously request features on this site','done',NULL,'2022-08-27 02:14:58','2022-08-27 02:14:58'),(18,'Manage your uploaded competitions and races','You can now manage your uploaded competitions and races in the your content section on the import results page','done','/img/your-content.jpg','2022-08-27 17:05:43','2022-08-27 17:05:43'),(19,'API Keys','The API is now locked for calls from outside the website. I added api keys to accsess the api from outside. Contact me if you want one','done',NULL,'2022-08-27 20:25:56','2022-08-27 20:25:56');
/*!40000 ALTER TABLE `tbdevlog` ENABLE KEYS */;
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
