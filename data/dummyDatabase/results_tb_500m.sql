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
-- Table structure for table `tb_500m`
--

DROP TABLE IF EXISTS `tb_500m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_500m` (
  `year` int DEFAULT NULL,
  `competition` varchar(100) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `afterStart1` int DEFAULT NULL,
  `afterStart2` int DEFAULT NULL,
  `afterStart3` int DEFAULT NULL,
  `afterStart4` int DEFAULT NULL,
  `beforeFinish1` int DEFAULT NULL,
  `beforeFinish2` int DEFAULT NULL,
  `beforeFinish3` int DEFAULT NULL,
  `beforeFinish4` int DEFAULT NULL,
  `finish1` int DEFAULT NULL,
  `finish2` int DEFAULT NULL,
  `finish3` int DEFAULT NULL,
  `finish4` int DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_500m`
--

LOCK TABLES `tb_500m` WRITE;
/*!40000 ALTER TABLE `tb_500m` DISABLE KEYS */;
INSERT INTO `tb_500m` VALUES (2019,'WM','m','Sen',1,2,3,4,1,2,3,4,1,2,4,3,'https://www.youtube.com/watch?v=ZYAxG-VKzrM'),(2019,'WM','m','jun',1,2,4,3,2,1,4,3,2,1,4,3,'https://www.youtube.com/watch?v=jWn1--1ep1k'),(2019,'WM','w','Sen',1,4,2,3,1,2,3,4,2,1,3,4,'https://www.youtube.com/watch?v=d_I1HMK03Dk'),(2019,'WM','w','jun',2,3,1,4,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=kgESe6QsgWE'),(2018,'WM','m','Sen',1,3,4,2,1,3,4,2,1,3,4,2,'https://www.youtube.com/watch?v=MDuT9MedIhE'),(2018,'WM','w','Sen',1,4,3,-1,4,3,1,-1,4,3,1,-1,'https://www.youtube.com/watch?v=nopOUxpPzWk'),(2018,'WM','w','jun',1,3,2,4,3,2,1,4,3,2,1,4,'https://www.youtube.com/watch?v=GPChFGsVR-8'),(2018,'WM','m','jun',1,3,4,2,4,1,2,3,4,1,2,3,'https://www.youtube.com/watch?v=WNvzFepRGVE'),(2017,'World Games','m','Sen',1,3,2,4,1,3,2,4,1,3,2,4,'https://www.youtube.com/watch?v=dz2nYHezgkI'),(2017,'World Games','w','Sen',1,3,2,4,1,3,2,4,1,2,3,4,'https://www.youtube.com/watch?v=dz2nYHezgkI'),(2016,'WM','m','Sen',1,3,2,4,3,4,1,2,4,3,1,2,'https://www.youtube.com/watch?v=yLzP9fLFw7c'),(2016,'WM','m','jun',1,2,4,3,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=P0eoPieyEGg'),(2016,'WM','w','Sen',1,2,3,4,2,3,1,4,2,3,1,4,'https://www.youtube.com/watch?v=NnB0iN4jfK8'),(2016,'WM','w','Sen',1,3,4,2,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=oNO81J0bM_c'),(2015,'WM','w','jun',1,2,3,4,1,3,2,4,1,3,2,4,'https://www.youtube.com/watch?v=6IX8fXkjKvU'),(2015,'WM','w','Sen',2,3,4,1,4,1,3,2,4,1,3,2,'https://youtu.be/6IX8fXkjKvU?t=153'),(2015,'WM','m','Sen',1,2,3,4,1,2,3,4,1,2,4,3,'https://www.youtube.com/watch?v=6IX8fXkjKvU'),(2014,'WM','w','jun',2,3,4,1,2,1,3,4,2,1,3,4,'https://www.youtube.com/watch?v=OG7C11AnRWQ'),(2013,'WM','m','Sen',2,4,1,2,3,4,1,2,3,4,1,2,'https://www.youtube.com/watch?v=O6ZYvAKvaeI&t=43s'),(2013,'WM','w','Sen',1,2,4,3,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=9scs7H0an2o'),(2013,'WM','m','jun',1,2,4,3,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=nyLJyflUjPM'),(2013,'WM','w','jun',1,3,2,4,3,2,1,4,3,2,1,4,'https://www.youtube.com/watch?v=GPChFGsVR-8'),(2012,'WM','w','jun',2,3,2,4,2,3,2,4,2,3,2,4,'https://www.youtube.com/watch?v=6IX8fXkjKvU'),(2012,'WM','w','jun',2,1,3,4,2,4,1,3,2,4,1,3,'https://www.youtube.com/watch?v=ZN1ADcR01Qw'),(2012,'WM','m','jun',1,2,3,4,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=ZN1ADcR01Qw'),(2012,'WM','m','Sen',1,3,2,4,1,3,2,4,1,3,2,4,'https://www.youtube.com/watch?v=wkGwzmChm-Q&t=295s'),(2011,'WM','w','Sen',1,2,3,4,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=zOh5CFvKAJM'),(2011,'WM','m','Sen',1,2,3,4,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=UkQrxb-iGkI'),(2019,'EM','m','jun',3,1,2,4,3,1,2,4,3,1,2,4,'https://www.youtube.com/watch?v=298i89uy8eA'),(2019,'EM','m','sen',1,2,4,3,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=LGQid8LPhuI'),(2019,'EM','w','sen',1,3,4,2,1,2,4,3,2,1,4,3,'https://www.youtube.com/watch?v=uQkAMtdCLHc'),(2019,'EM','w','jun',1,4,3,2,1,4,3,2,1,4,3,2,'https://www.youtube.com/watch?v=B9XoDsjEaeM'),(2018,'EM','m','Sen',4,2,1,3,4,1,2,3,1,4,2,3,'https://www.youtube.com/watch?v=BWyk890tUQY'),(2018,'EM','w','jun',2,1,3,4,3,2,1,4,3,2,1,4,'https://www.youtube.com/watch?v=JJiWlZLqet4'),(2018,'EM','m','jun',1,2,3,4,2,1,3,4,2,1,3,4,'https://www.youtube.com/watch?v=KKzif94mFhw'),(2017,'EM','m','jun',1,2,3,4,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=hMp95itlAEY'),(2017,'EM','w','jun',1,2,4,3,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=pfJaUoGMQ4E'),(2017,'EM','m','sen',1,2,3,4,1,2,4,3,1,2,4,3,'https://www.youtube.com/watch?v=9pHhcpH2EtI'),(2017,'EM','w','sen',1,2,3,4,1,2,3,4,1,2,3,4,'https://www.youtube.com/watch?v=bO92JIa87Z4'),(0,NULL,NULL,NULL,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,NULL),(0,NULL,NULL,NULL,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,NULL);
/*!40000 ALTER TABLE `tb_500m` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-30 13:47:50
