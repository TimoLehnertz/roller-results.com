CREATE DATABASE  IF NOT EXISTS `results` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `results`;
-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: www.roller-results.com    Database: results
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

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
-- Table structure for table `TbApiKey`
--

DROP TABLE IF EXISTS `TbApiKey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbApiKey` (
  `key` varchar(100) NOT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `description` text,
  `permissionLevel` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amountUsed` int DEFAULT '0',
  `amountUsedWrongly` int DEFAULT '0',
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbAthlete`
--

DROP TABLE IF EXISTS `TbAthlete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbAthlete` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `linkCollection` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `comment` mediumtext,
  `club` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `birthYear` int DEFAULT NULL,
  `LVKuerzel` varchar(100) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `license` varchar(45) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `isPlaceholder` tinyint DEFAULT NULL,
  `rank` int DEFAULT '1000000',
  `score` double DEFAULT NULL,
  `scoreShort` double DEFAULT '0',
  `scoreLong` double DEFAULT '0',
  `bronze` int DEFAULT '0',
  `silver` int DEFAULT '0',
  `gold` int DEFAULT '0',
  `topTen` int DEFAULT '0',
  `medalScore` int DEFAULT '0',
  `raceCount` int DEFAULT '0',
  `minAge` int DEFAULT NULL COMMENT 'predicted min age calculated by races',
  `rankShort` int DEFAULT NULL,
  `rankLong` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bestDistance` varchar(100) DEFAULT NULL,
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  `description` text,
  `website` text,
  PRIMARY KEY (`id`),
  KEY `lastname` (`lastname`),
  KEY `firstname` (`firstname`),
  KEY `raceCOunt` (`raceCount`),
  KEY `athleteCreator_idx` (`creator`),
  CONSTRAINT `athleteCreator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=9479 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbAthleteAlias`
--

DROP TABLE IF EXISTS `TbAthleteAlias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbAthleteAlias` (
  `idAthleteAlias` int NOT NULL AUTO_INCREMENT,
  `idAthlete` int DEFAULT NULL,
  `alias` varchar(100) NOT NULL,
  `creator` int NOT NULL,
  `aliasGroup` varchar(128) NOT NULL,
  `previous` text,
  PRIMARY KEY (`idAthleteAlias`),
  KEY `idAthlete_idx` (`idAthlete`),
  KEY `idUser_idx` (`creator`),
  KEY `athlete_idx` (`idAthlete`),
  KEY `user_idx` (`creator`),
  CONSTRAINT `athlete` FOREIGN KEY (`idAthlete`) REFERENCES `TbAthlete` (`id`),
  CONSTRAINT `user` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=24275 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbAthleteBackup`
--

DROP TABLE IF EXISTS `TbAthleteBackup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbAthleteBackup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `linkCollection` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `comment` mediumtext,
  `club` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `birthYear` int DEFAULT NULL,
  `LVKuerzel` varchar(100) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `license` varchar(45) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `isPlaceholder` tinyint DEFAULT NULL,
  `rank` int DEFAULT '1000000',
  `score` double DEFAULT NULL,
  `scoreShort` double DEFAULT '0',
  `scoreLong` double DEFAULT '0',
  `bronze` int DEFAULT '0',
  `silver` int DEFAULT '0',
  `gold` int DEFAULT '0',
  `topTen` int DEFAULT '0',
  `medalScore` int DEFAULT '0',
  `raceCount` int DEFAULT '0',
  `minAge` int DEFAULT NULL COMMENT 'predicted min age calculated by races',
  `rankShort` int DEFAULT NULL,
  `rankLong` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bestDistance` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastname` (`lastname`),
  KEY `firstname` (`firstname`),
  KEY `raceCOunt` (`raceCount`)
) ENGINE=InnoDB AUTO_INCREMENT=8414 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbAthleteDummy`
--

DROP TABLE IF EXISTS `TbAthleteDummy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbAthleteDummy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `linkCollection` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `comment` mediumtext,
  `club` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `birthYear` int DEFAULT NULL,
  `LVKuerzel` varchar(100) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `license` varchar(45) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL,
  `isPlaceholder` tinyint DEFAULT NULL,
  `rank` int DEFAULT '1000000',
  `score` double DEFAULT NULL,
  `scoreShort` double DEFAULT '0',
  `scoreLong` double DEFAULT '0',
  `bronze` int DEFAULT '0',
  `silver` int DEFAULT '0',
  `gold` int DEFAULT '0',
  `topTen` int DEFAULT '0',
  `medalScore` int DEFAULT '0',
  `raceCount` int DEFAULT '0',
  `minAge` int DEFAULT NULL COMMENT 'predicted min age calculated by races',
  `rankShort` int DEFAULT NULL,
  `rankLong` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bestDistance` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastname` (`lastname`),
  KEY `firstname` (`firstname`),
  KEY `raceCOunt` (`raceCount`)
) ENGINE=InnoDB AUTO_INCREMENT=8414 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbAthleteHasImage`
--

DROP TABLE IF EXISTS `TbAthleteHasImage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbAthleteHasImage` (
  `idTbAthleteHasImage` int NOT NULL AUTO_INCREMENT,
  `athlete` int DEFAULT NULL,
  `image` text,
  `creator` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idTbAthleteHasImage`),
  KEY `imagexathlete_idx` (`athlete`),
  CONSTRAINT `imagexathlete` FOREIGN KEY (`athlete`) REFERENCES `TbAthlete` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=768 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbCompetition`
--

DROP TABLE IF EXISTS `TbCompetition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbCompetition` (
  `idCompetition` int NOT NULL AUTO_INCREMENT,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gpx` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `raceYear` mediumtext,
  `country` varchar(100) DEFAULT NULL,
  `raceYearNum` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `resultsUrl` varchar(100) DEFAULT NULL,
  `contact` text,
  `name` varchar(100) DEFAULT NULL,
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  PRIMARY KEY (`idCompetition`),
  KEY `indexType` (`type`),
  KEY `type` (`type`),
  KEY `competitionCreator_idx` (`creator`),
  CONSTRAINT `competitionCreator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=454 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbCompetitionDeleted`
--

DROP TABLE IF EXISTS `TbCompetitionDeleted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbCompetitionDeleted` (
  `idCompetitionDeleted` int NOT NULL AUTO_INCREMENT,
  `idCompetition` int DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gpx` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `raceYear` mediumtext,
  `country` varchar(100) DEFAULT NULL,
  `raceYearNum` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `resultsUrl` varchar(100) DEFAULT NULL,
  `contact` text,
  `name` varchar(100) DEFAULT NULL,
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  PRIMARY KEY (`idCompetitionDeleted`)
) ENGINE=InnoDB AUTO_INCREMENT=440 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbCountry`
--

DROP TABLE IF EXISTS `TbCountry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbCountry` (
  `name` varchar(200) DEFAULT NULL,
  `alpha-2` varchar(2) DEFAULT NULL,
  `alpha-3` varchar(3) NOT NULL,
  `country-code` varchar(45) DEFAULT NULL,
  `iso_3166-2` varchar(100) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  `sub-region` varchar(45) DEFAULT NULL,
  `intermediate-region` varchar(45) DEFAULT NULL,
  `region-code` varchar(45) DEFAULT NULL,
  `sub-region-code` varchar(45) DEFAULT NULL,
  `intermediate-region-code` varchar(45) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `area` int DEFAULT NULL,
  `capital` varchar(300) DEFAULT NULL,
  `status` varchar(300) DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `radius` double DEFAULT NULL,
  `color` varchar(10) DEFAULT '#fff',
  PRIMARY KEY (`alpha-3`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbDevLog`
--

DROP TABLE IF EXISTS `TbDevLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbDevLog` (
  `idTbDevLog` int NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `status` varchar(45) DEFAULT 'planned' COMMENT 'waiting / in progress / done',
  `image` text,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idTbDevLog`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbImportProject`
--

DROP TABLE IF EXISTS `TbImportProject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbImportProject` (
  `idImportProject` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `creator` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idImportProject`),
  KEY `projectCreator_idx` (`creator`),
  CONSTRAINT `projectCreator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbLaserLap`
--

DROP TABLE IF EXISTS `TbLaserLap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbLaserLap` (
  `idTbLaserLap` int NOT NULL AUTO_INCREMENT,
  `triggerer` int NOT NULL,
  `millis` int NOT NULL,
  `laserResult` int NOT NULL,
  `remark` text,
  PRIMARY KEY (`idTbLaserLap`),
  KEY `laserResult_idx` (`laserResult`),
  CONSTRAINT `laserResult` FOREIGN KEY (`laserResult`) REFERENCES `TbLaserResults` (`idTbLaserResults`)
) ENGINE=InnoDB AUTO_INCREMENT=609 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbLaserResults`
--

DROP TABLE IF EXISTS `TbLaserResults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbLaserResults` (
  `idTbLaserResults` int NOT NULL AUTO_INCREMENT,
  `distance` int DEFAULT NULL,
  `user` int DEFAULT NULL,
  `laserName` text,
  `athlete` text,
  `uploadDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `remark` text,
  PRIMARY KEY (`idTbLaserResults`)
) ENGINE=InnoDB AUTO_INCREMENT=324 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbLog`
--

DROP TABLE IF EXISTS `TbLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbLog` (
  `idTbLog` int NOT NULL AUTO_INCREMENT,
  `userId` varchar(100) DEFAULT NULL,
  `from` varchar(100) DEFAULT NULL,
  `to` varchar(100) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `device` varchar(500) DEFAULT NULL,
  `isDev` tinyint GENERATED ALWAYS AS (((`ip` = _utf8mb4'::1') or (`ip` like _utf8mb4'192%') or (`ip` = _utf8mb4'78.35.146.37'))) VIRTUAL,
  `user` int DEFAULT NULL,
  `isMobile` tinyint DEFAULT NULL,
  PRIMARY KEY (`idTbLog`),
  KEY `logUser_idx` (`user`),
  CONSTRAINT `logUser` FOREIGN KEY (`user`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=52241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbPass`
--

DROP TABLE IF EXISTS `TbPass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbPass` (
  `idPass` int NOT NULL AUTO_INCREMENT,
  `athlete` int DEFAULT NULL,
  `race` int DEFAULT NULL,
  `fromPlace` int DEFAULT NULL,
  `toPlace` int DEFAULT NULL,
  `lap` double DEFAULT NULL,
  `insideOut` varchar(10) DEFAULT NULL,
  `finishPlace` int DEFAULT NULL,
  `creator` int DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPass`),
  KEY `idAthlete_idx` (`athlete`),
  KEY `idRace_idx` (`race`),
  KEY `creator_idx` (`creator`),
  CONSTRAINT `creator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`),
  CONSTRAINT `idAthlete` FOREIGN KEY (`athlete`) REFERENCES `TbAthlete` (`id`),
  CONSTRAINT `idRace` FOREIGN KEY (`race`) REFERENCES `TbRace` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3334 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbPlaces`
--

DROP TABLE IF EXISTS `TbPlaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbPlaces` (
  `idPlaces` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `image` text,
  `description` text,
  `date_creation_sportland` date DEFAULT NULL,
  `title` text,
  `keywords` text,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `link_sportland` text,
  `surface` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPlaces`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbRace`
--

DROP TABLE IF EXISTS `TbRace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbRace` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `idCompetition_idx` (`idCompetition`),
  KEY `indexDiscipline` (`discipline`),
  KEY `raceCreator_idx` (`creator`),
  CONSTRAINT `idCompetition` FOREIGN KEY (`idCompetition`) REFERENCES `TbCompetition` (`idCompetition`),
  CONSTRAINT `raceCreator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=25612 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbRaceBackup`
--

DROP TABLE IF EXISTS `TbRaceBackup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbRaceBackup` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24660 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbRaceDeleted`
--

DROP TABLE IF EXISTS `TbRaceDeleted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbRaceDeleted` (
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
) ENGINE=InnoDB AUTO_INCREMENT=24892 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbRememberMe`
--

DROP TABLE IF EXISTS `TbRememberMe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbRememberMe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `hash` text NOT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `iduser_idx` (`iduser`),
  CONSTRAINT `iduser` FOREIGN KEY (`iduser`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=484 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbResult`
--

DROP TABLE IF EXISTS `TbResult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbResult` (
  `id` int NOT NULL AUTO_INCREMENT,
  `zeit_Kon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idPerson` int DEFAULT NULL,
  `idRace` int DEFAULT NULL,
  `place` int DEFAULT NULL,
  `tacticalNote` varchar(255) DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeDate` time(3) DEFAULT NULL,
  `countryCountFlag` tinyint DEFAULT '1',
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  `warnings` int DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `points` int DEFAULT NULL,
  `disqualificationTechnical` tinyint DEFAULT NULL,
  `didNotStart` tinyint DEFAULT NULL,
  `falseStart` tinyint DEFAULT NULL,
  `disqualificationSportsFault` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueResult` (`idRace`,`idPerson`) /*!80000 INVISIBLE */,
  KEY `idPerson_idx` (`idPerson`),
  KEY `idRace_idx` (`idRace`),
  KEY `indexPlace` (`place`),
  KEY `indexRace` (`idRace`),
  KEY `resultCreator_idx` (`creator`),
  CONSTRAINT `idPerson1` FOREIGN KEY (`idPerson`) REFERENCES `TbAthlete` (`id`),
  CONSTRAINT `idRace1` FOREIGN KEY (`idRace`) REFERENCES `TbRace` (`id`),
  CONSTRAINT `resultCreator` FOREIGN KEY (`creator`) REFERENCES `TbUser` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=19391126 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbResultBackup`
--

DROP TABLE IF EXISTS `TbResultBackup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbResultBackup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `zeit_Kon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idPerson` int DEFAULT NULL,
  `idRace` int DEFAULT NULL,
  `place` int DEFAULT NULL,
  `tacticalNote` varchar(255) DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeDate` time(3) DEFAULT NULL,
  `countryCountFlag` tinyint DEFAULT '1',
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19373094 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbResultDeleted`
--

DROP TABLE IF EXISTS `TbResultDeleted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbResultDeleted` (
  `idResultDeleted` int NOT NULL AUTO_INCREMENT,
  `id` int DEFAULT NULL,
  `zeit_Kon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idPerson` int DEFAULT NULL,
  `idRace` int DEFAULT NULL,
  `place` int DEFAULT NULL,
  `tacticalNote` varchar(255) DEFAULT NULL,
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timeDate` time(3) DEFAULT NULL,
  `countryCountFlag` tinyint DEFAULT '1',
  `creator` int DEFAULT NULL,
  `checked` tinyint DEFAULT NULL,
  `warnings` int DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `points` int DEFAULT NULL,
  `disqualificationTechnical` tinyint DEFAULT NULL,
  `didNotStart` tinyint DEFAULT NULL,
  `falseStart` tinyint DEFAULT NULL,
  `disqualificationSportsFault` tinyint DEFAULT NULL,
  PRIMARY KEY (`idResultDeleted`)
) ENGINE=InnoDB AUTO_INCREMENT=19380010 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbResult_old`
--

DROP TABLE IF EXISTS `TbResult_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbResult_old` (
  `id` int NOT NULL AUTO_INCREMENT,
  `place` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `zeit_Kon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `zeit_Kon1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idPerson` int DEFAULT NULL,
  `idRace` int DEFAULT NULL,
  `placeNumeric` int DEFAULT NULL,
  `idPerson2` int DEFAULT NULL,
  `idPerson3` int DEFAULT NULL,
  `idPerson4` int DEFAULT NULL,
  `timeDate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tacticalNote` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idPerson2_idx` (`idPerson2`),
  KEY `idPerson3_idx` (`idPerson3`)
) ENGINE=InnoDB AUTO_INCREMENT=19282395 DEFAULT CHARSET=utf32;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbTeam`
--

DROP TABLE IF EXISTS `TbTeam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbTeam` (
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
-- Table structure for table `TbTeamMember`
--

DROP TABLE IF EXISTS `TbTeamMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbTeamMember` (
  `idTbTeamMember` int NOT NULL AUTO_INCREMENT,
  `team` int NOT NULL,
  `athlete` int NOT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  PRIMARY KEY (`idTbTeamMember`),
  KEY `team_idx` (`team`),
  KEY `athlete_idx` (`athlete`),
  CONSTRAINT `AthleteTeam` FOREIGN KEY (`team`) REFERENCES `TbTeam` (`idTeam`),
  CONSTRAINT `Teamathlete` FOREIGN KEY (`athlete`) REFERENCES `TbAthlete` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbTrigger`
--

DROP TABLE IF EXISTS `TbTrigger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbTrigger` (
  `idTrigger` int NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `uploadDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `time` int DEFAULT NULL,
  PRIMARY KEY (`idTrigger`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbUser`
--

DROP TABLE IF EXISTS `TbUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbUser` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `pwdHash` text NOT NULL,
  `registerCountry` varchar(300) DEFAULT NULL,
  `idrole` varchar(45) NOT NULL DEFAULT '0' COMMENT 'Hard colded in roles.php',
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(500) DEFAULT NULL,
  `athlete` int DEFAULT NULL,
  `athleteChecked` tinyint DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`),
  KEY `user-athlete_idx` (`athlete`),
  CONSTRAINT `user-athlete` FOREIGN KEY (`athlete`) REFERENCES `TbAthlete` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TbUserBackup`
--

DROP TABLE IF EXISTS `TbUserBackup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TbUserBackup` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `pwdHash` text NOT NULL,
  `registerCountry` varchar(300) DEFAULT NULL,
  `idrole` varchar(45) NOT NULL DEFAULT '0' COMMENT 'Hard colded in roles.php',
  `rowCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rowUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `iduser_UNIQUE` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tb_500m`
--

DROP TABLE IF EXISTS `Tb_500m`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tb_500m` (
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
-- Table structure for table `Tb_analyticsPreset`
--

DROP TABLE IF EXISTS `Tb_analyticsPreset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tb_analyticsPreset` (
  `idAnalyticsPreset` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `json` text,
  `public` tinyint DEFAULT NULL,
  `owner` int DEFAULT NULL,
  PRIMARY KEY (`idAnalyticsPreset`),
  UNIQUE KEY `unique` (`name`,`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Tb_analyticsSelectPreset`
--

DROP TABLE IF EXISTS `Tb_analyticsSelectPreset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tb_analyticsSelectPreset` (
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
-- Table structure for table `Tb_tmp_res`
--

DROP TABLE IF EXISTS `Tb_tmp_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tb_tmp_res` (
  `idPerson` int NOT NULL,
  `score` double DEFAULT NULL,
  PRIMARY KEY (`idPerson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `vAll`
--

DROP TABLE IF EXISTS `vAll`;
/*!50001 DROP VIEW IF EXISTS `vAll`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vAll` AS SELECT 
 1 AS `raceYear`,
 1 AS `location`,
 1 AS `type`,
 1 AS `startDate`,
 1 AS `endDate`,
 1 AS `country`,
 1 AS `relay`,
 1 AS `distance`,
 1 AS `category`,
 1 AS `gender`,
 1 AS `link`,
 1 AS `discipline`,
 1 AS `trackStreet`,
 1 AS `place`,
 1 AS `time`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `fullname`,
 1 AS `idAthlete`,
 1 AS `idCompetition`,
 1 AS `idRace`,
 1 AS `idResult`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vAthlete`
--

DROP TABLE IF EXISTS `vAthlete`;
/*!50001 DROP VIEW IF EXISTS `vAthlete`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vAthlete` AS SELECT 
 1 AS `idAthlete`,
 1 AS `lastname`,
 1 AS `firstname`,
 1 AS `gender`,
 1 AS `country`,
 1 AS `linkCollection`,
 1 AS `mail`,
 1 AS `comment`,
 1 AS `club`,
 1 AS `team`,
 1 AS `image`,
 1 AS `birthYear`,
 1 AS `LVKuerzel`,
 1 AS `source`,
 1 AS `birthdate`,
 1 AS `remark`,
 1 AS `license`,
 1 AS `facebook`,
 1 AS `instagram`,
 1 AS `isPlaceholder`,
 1 AS `score`,
 1 AS `scoreShort`,
 1 AS `scoreLong`,
 1 AS `bronze`,
 1 AS `silver`,
 1 AS `gold`,
 1 AS `topTen`,
 1 AS `medalScore`,
 1 AS `raceCount`,
 1 AS `minAge`,
 1 AS `bestDistance`,
 1 AS `checked`,
 1 AS `creator`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vAthleteCalc_old`
--

DROP TABLE IF EXISTS `vAthleteCalc_old`;
/*!50001 DROP VIEW IF EXISTS `vAthleteCalc_old`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vAthleteCalc_old` AS SELECT 
 1 AS `idAthlete`,
 1 AS `topTen`,
 1 AS `bronze`,
 1 AS `silver`,
 1 AS `gold`,
 1 AS `medalScore`,
 1 AS `score`,
 1 AS `scoreShort`,
 1 AS `scoreLong`,
 1 AS `rank`,
 1 AS `rankShort`,
 1 AS `rankLong`,
 1 AS `raceCount`,
 1 AS `bestDistance`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vAthleteNew`
--

DROP TABLE IF EXISTS `vAthleteNew`;
/*!50001 DROP VIEW IF EXISTS `vAthleteNew`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vAthleteNew` AS SELECT 
 1 AS `idAthlete`,
 1 AS `lastname`,
 1 AS `firstname`,
 1 AS `gender`,
 1 AS `country`,
 1 AS `linkCollection`,
 1 AS `comment`,
 1 AS `club`,
 1 AS `team`,
 1 AS `image`,
 1 AS `birthYear`,
 1 AS `LVKuerzel`,
 1 AS `source`,
 1 AS `remark`,
 1 AS `license`,
 1 AS `facebook`,
 1 AS `instagram`,
 1 AS `isPlaceholder`,
 1 AS `bestDistance`,
 1 AS `goldMedals`,
 1 AS `silverMedals`,
 1 AS `bronzeMedals`,
 1 AS `medalScore`,
 1 AS `raceCount`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vAthletePublic`
--

DROP TABLE IF EXISTS `vAthletePublic`;
/*!50001 DROP VIEW IF EXISTS `vAthletePublic`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vAthletePublic` AS SELECT 
 1 AS `idAthlete`,
 1 AS `lastname`,
 1 AS `firstname`,
 1 AS `gender`,
 1 AS `country`,
 1 AS `comment`,
 1 AS `club`,
 1 AS `team`,
 1 AS `image`,
 1 AS `birthYear`,
 1 AS `facebook`,
 1 AS `instagram`,
 1 AS `minAge`,
 1 AS `raceCount`,
 1 AS `fullname`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCCCountries`
--

DROP TABLE IF EXISTS `vCCCountries`;
/*!50001 DROP VIEW IF EXISTS `vCCCountries`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCCCountries` AS SELECT 
 1 AS `short mass`,
 1 AS `short`,
 1 AS `short total`,
 1 AS `long`,
 1 AS `long athletes`,
 1 AS `country`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCompAthleteMedals`
--

DROP TABLE IF EXISTS `vCompAthleteMedals`;
/*!50001 DROP VIEW IF EXISTS `vCompAthleteMedals`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCompAthleteMedals` AS SELECT 
 1 AS `idCompetition`,
 1 AS `idAthlete`,
 1 AS `firstName`,
 1 AS `fullname`,
 1 AS `lastName`,
 1 AS `country`,
 1 AS `image`,
 1 AS `gender`,
 1 AS `gold`,
 1 AS `silver`,
 1 AS `bronze`,
 1 AS `medalScore`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCompCountryMedals`
--

DROP TABLE IF EXISTS `vCompCountryMedals`;
/*!50001 DROP VIEW IF EXISTS `vCompCountryMedals`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCompCountryMedals` AS SELECT 
 1 AS `idCompetition`,
 1 AS `country`,
 1 AS `gold`,
 1 AS `silver`,
 1 AS `bronze`,
 1 AS `medalScore`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCompetition`
--

DROP TABLE IF EXISTS `vCompetition`;
/*!50001 DROP VIEW IF EXISTS `vCompetition`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCompetition` AS SELECT 
 1 AS `idCompetition`,
 1 AS `startDate`,
 1 AS `endDate`,
 1 AS `location`,
 1 AS `description`,
 1 AS `type`,
 1 AS `image`,
 1 AS `gpx`,
 1 AS `raceYear`,
 1 AS `country`,
 1 AS `alpha-2`,
 1 AS `raceYearNum`,
 1 AS `latitude`,
 1 AS `longitude`,
 1 AS `hasLink`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCompetitionSmall`
--

DROP TABLE IF EXISTS `vCompetitionSmall`;
/*!50001 DROP VIEW IF EXISTS `vCompetitionSmall`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCompetitionSmall` AS SELECT 
 1 AS `idCompetition`,
 1 AS `location`,
 1 AS `type`,
 1 AS `raceYear`,
 1 AS `country`,
 1 AS `raceYearNum`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vCountry`
--

DROP TABLE IF EXISTS `vCountry`;
/*!50001 DROP VIEW IF EXISTS `vCountry`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vCountry` AS SELECT 
 1 AS `country`,
 1 AS `members`,
 1 AS `medalScore`,
 1 AS `gold`,
 1 AS `silver`,
 1 AS `bronze`,
 1 AS `topTen`,
 1 AS `raceCount`,
 1 AS `score`,
 1 AS `scoreShort`,
 1 AS `scoreLong`,
 1 AS `copmetitionCount`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vDublicates`
--

DROP TABLE IF EXISTS `vDublicates`;
/*!50001 DROP VIEW IF EXISTS `vDublicates`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vDublicates` AS SELECT 
 1 AS `raceYear`,
 1 AS `type`,
 1 AS `location`,
 1 AS `country`,
 1 AS `relay`,
 1 AS `category`,
 1 AS `gender`,
 1 AS `distance`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `trackStreet`,
 1 AS `count`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vGLobalStats`
--

DROP TABLE IF EXISTS `vGLobalStats`;
/*!50001 DROP VIEW IF EXISTS `vGLobalStats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vGLobalStats` AS SELECT 
 1 AS `Calls`,
 1 AS `No dev calls`,
 1 AS `individuals`,
 1 AS `Dev calls`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vLogDays`
--

DROP TABLE IF EXISTS `vLogDays`;
/*!50001 DROP VIEW IF EXISTS `vLogDays`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vLogDays` AS SELECT 
 1 AS `date`,
 1 AS `calls`,
 1 AS `individuals`,
 1 AS `USA calls`,
 1 AS `mobile`,
 1 AS `mobileCalls`,
 1 AS `calls per individual`,
 1 AS `different users online`,
 1 AS `new users`,
 1 AS `new usernames`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vLogDaysNoUSA`
--

DROP TABLE IF EXISTS `vLogDaysNoUSA`;
/*!50001 DROP VIEW IF EXISTS `vLogDaysNoUSA`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vLogDaysNoUSA` AS SELECT 
 1 AS `date`,
 1 AS `calls`,
 1 AS `individuals`,
 1 AS `mobile`,
 1 AS `mobileCalls`,
 1 AS `calls per individual`,
 1 AS `different users online`,
 1 AS `new users`,
 1 AS `new usernames`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vLogHours`
--

DROP TABLE IF EXISTS `vLogHours`;
/*!50001 DROP VIEW IF EXISTS `vLogHours`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vLogHours` AS SELECT 
 1 AS `dateTime`,
 1 AS `calls`,
 1 AS `individuals`,
 1 AS `calls per individual`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vLogNoDev`
--

DROP TABLE IF EXISTS `vLogNoDev`;
/*!50001 DROP VIEW IF EXISTS `vLogNoDev`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vLogNoDev` AS SELECT 
 1 AS `idTbLog`,
 1 AS `userId`,
 1 AS `from`,
 1 AS `to`,
 1 AS `ip`,
 1 AS `location`,
 1 AS `timestamp`,
 1 AS `device`,
 1 AS `isDev`,
 1 AS `user`,
 1 AS `isMobile`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vRace`
--

DROP TABLE IF EXISTS `vRace`;
/*!50001 DROP VIEW IF EXISTS `vRace`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vRace` AS SELECT 
 1 AS `idRace`,
 1 AS `relay`,
 1 AS `distance`,
 1 AS `link`,
 1 AS `category`,
 1 AS `gender`,
 1 AS `remark`,
 1 AS `trackStreet`,
 1 AS `idCompetition`,
 1 AS `source`,
 1 AS `discipline`,
 1 AS `skateType`,
 1 AS `raceYear`,
 1 AS `location`,
 1 AS `country`,
 1 AS `type`,
 1 AS `resultCount`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vResult`
--

DROP TABLE IF EXISTS `vResult`;
/*!50001 DROP VIEW IF EXISTS `vResult`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vResult` AS SELECT 
 1 AS `idResult`,
 1 AS `time`,
 1 AS `idPerson`,
 1 AS `idRace`,
 1 AS `place`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vSiteViews`
--

DROP TABLE IF EXISTS `vSiteViews`;
/*!50001 DROP VIEW IF EXISTS `vSiteViews`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vSiteViews` AS SELECT 
 1 AS `calls`,
 1 AS `page`,
 1 AS `mobile`,
 1 AS `firstCall`,
 1 AS `lastCall`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vSiteViewsToday`
--

DROP TABLE IF EXISTS `vSiteViewsToday`;
/*!50001 DROP VIEW IF EXISTS `vSiteViewsToday`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vSiteViewsToday` AS SELECT 
 1 AS `calls`,
 1 AS `page`,
 1 AS `mobile`,
 1 AS `firstCall`,
 1 AS `lastCall`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vUser`
--

DROP TABLE IF EXISTS `vUser`;
/*!50001 DROP VIEW IF EXISTS `vUser`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vUser` AS SELECT 
 1 AS `idUser`,
 1 AS `username`,
 1 AS `email`,
 1 AS `image`,
 1 AS `idRole`,
 1 AS `registerCountry`,
 1 AS `athlete`,
 1 AS `athleteChecked`,
 1 AS `rowCreated`,
 1 AS `calls`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vWorldMovement`
--

DROP TABLE IF EXISTS `vWorldMovement`;
/*!50001 DROP VIEW IF EXISTS `vWorldMovement`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vWorldMovement` AS SELECT 
 1 AS `idCompetition`,
 1 AS `athleteNames`,
 1 AS `athleteIds`,
 1 AS `date`,
 1 AS `competitionCountry`,
 1 AS `competitionCountryName`,
 1 AS `competitionType`,
 1 AS `competitionLocation`,
 1 AS `gold`,
 1 AS `silver`,
 1 AS `bronze`,
 1 AS `compLatitude`,
 1 AS `compLongitude`,
 1 AS `athleteCountry`,
 1 AS `athleteCountryName`,
 1 AS `athleteCountryRadius`,
 1 AS `athleteCountryColor`,
 1 AS `athleteLatitude`,
 1 AS `athleteLongitude`,
 1 AS `athleteCount`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'results'
--
/*!50003 DROP FUNCTION IF EXISTS `getScore` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `getScore`(place INT) RETURNS double
    DETERMINISTIC
BEGIN
RETURN 1 / POW(place, 1.2) * 30;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `globeKmToDegree` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `globeKmToDegree`(km double) RETURNS double
    DETERMINISTIC
BEGIN
RETURN DEGREES(ATAN(km / 6371));
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `LOCATE_OFFSET` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `LOCATE_OFFSET`(substr text, str text, offset int) RETURNS int
    DETERMINISTIC
BEGIN
DECLARE loc INT DEFAULT 0;
DECLARE i INT DEFAULT 0;
WHILE(i<=offset) DO
	SET loc=LOCATE(substr, str, loc+1);
    IF loc = 0 THEN RETURN 0; END IF;
	SET i=i+1;
END WHILE;
RETURN loc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `nthWord` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `nthWord`(str text, n INT) RETURNS text CHARSET utf8mb4
    DETERMINISTIC
BEGIN
DECLARE strTrim TEXT DEFAULT(trim(str));

DECLARE wordCount INT DEFAULT CHAR_LENGTH(strTrim) - CHAR_LENGTH( REPLACE (strTrim, ' ', '')) + 1;
if n < 0 OR n > wordCount THEN RETURN ""; END IF;

RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(strTrim, ' ',  n), ' ', -1);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `random` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `random`(`start` double, `end` double) RETURNS double
    DETERMINISTIC
BEGIN
RETURN RAND() * (`end` - `start`) + `start`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `remove_accents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `remove_accents`( textvalue VARCHAR(10000) ) RETURNS varchar(10000) CHARSET utf8mb4
    DETERMINISTIC
BEGIN
	SET @textvalue = textvalue;# COLLATE utf8_general_ci;
    # ACCENTS
    SET @withaccents = 'ŠšŽžÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝŸÞàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿþƒ';
    SET @withoutaccents = 'SsZzAAAAAAACEEEEIIIINOOOOOOUUUUYYBaaaaaaaceeeeiiiinoooooouuuuyybf';
    SET @count = LENGTH(@withaccents);

    WHILE @count > 0 DO
        SET @textvalue = REPLACE(@textvalue, SUBSTRING(@withaccents, @count, 1), SUBSTRING(@withoutaccents, @count, 1));
        SET @count = @count - 1;
    END WHILE;

    -- SPECIAL CHARS
    #SET @special = '«»’”“!@#$%¨&()_+=§¹²³£¢¬"`´{[^~}]<,>.:;?/°ºª+|\'';
    #SET @count = LENGTH(@special);
    
    #WHILE @count > 0 do
    #    SET @textvalue = REPLACE(@textvalue, SUBSTRING(@special, @count, 1), '');
    #    SET @count = @count - 1;
    #END WHILE;
    RETURN @textvalue;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `titleCase` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `titleCase`(str VARCHAR(200)) RETURNS text CHARSET utf8mb4
    DETERMINISTIC
BEGIN
RETURN TRIM(
CONCAT_WS(' ',
CONCAT(UPPER(LEFT(SUBSTRING_INDEX(str, ' ',1),1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',1),2))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',2),LENGTH(SUBSTRING_INDEX(str, ' ',1)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',2),3 + LENGTH(SUBSTRING_INDEX(str, ' ',1))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',3),LENGTH(SUBSTRING_INDEX(str, ' ',2)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',3),3 + LENGTH(SUBSTRING_INDEX(str, ' ',2))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',4),LENGTH(SUBSTRING_INDEX(str, ' ',3)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',4),3 + LENGTH(SUBSTRING_INDEX(str, ' ',3))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',5),LENGTH(SUBSTRING_INDEX(str, ' ',4)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',5),3 + LENGTH(SUBSTRING_INDEX(str, ' ',4))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',6),LENGTH(SUBSTRING_INDEX(str, ' ',5)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',6),3 + LENGTH(SUBSTRING_INDEX(str, ' ',5))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',7),LENGTH(SUBSTRING_INDEX(str, ' ',6)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',7),3 + LENGTH(SUBSTRING_INDEX(str, ' ',6))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',8),LENGTH(SUBSTRING_INDEX(str, ' ',7)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',8),3 + LENGTH(SUBSTRING_INDEX(str, ' ',7))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',9),LENGTH(SUBSTRING_INDEX(str, ' ',8)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',9),3 + LENGTH(SUBSTRING_INDEX(str, ' ',8))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',10),LENGTH(SUBSTRING_INDEX(str, ' ',9)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',10),3 + LENGTH(SUBSTRING_INDEX(str, ' ',9))))),
CONCAT(UPPER(MID(SUBSTRING_INDEX(str, ' ',11),LENGTH(SUBSTRING_INDEX(str, ' ',10)) + 2, 1)), LOWER(MID(SUBSTRING_INDEX(str, ' ',11),3 + LENGTH(SUBSTRING_INDEX(str, ' ',10)))))
));
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `typeWm` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  FUNCTION `typeWm`() RETURNS varchar(30) CHARSET utf8mb4
    DETERMINISTIC
BEGIN
RETURN "wm";
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_athleteCareer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_athleteCareer`(IN in_idAthlete INT, IN in_compSet TEXT)
BEGIN

SELECT

race.raceYear
#, SUM(CASE WHEN comp.`type` = typeWm() THEN getScore(res.place) ELSE 0 END) AS score
#, SUM(CASE WHEN comp.`type` = typeWm() AND race.discipline LIKE "%short%" THEN getScore(res.place) ELSE 0 END) AS scoreShort
#, SUM(CASE WHEN comp.`type` = typeWm() AND race.discipline LIKE "%long%" THEN getScore(res.place) ELSE 0 END) AS scoreLong
#, SUM(CASE WHEN comp.`type` = typeWm() THEN 1 ELSE 0 END) AS races
, SUM(IF((FIND_IN_SET(`comp`.`type`, in_compSet)),
    GETSCORE(`res`.`place`),
    #GETSCORE(`res`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
	0)) AS `score`
, SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
	AND (`race`.`discipline` LIKE '%short%')),
	GETSCORE(`res`.`place`),
    #GETSCORE(`res`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
	0)) AS `scoreShort`
, SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
	AND (`race`.`discipline` LIKE '%long%')),
	GETSCORE(`res`.`place`),
    #GETSCORE(`res`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
	0)) AS `scoreLong`
, SUM(CASE WHEN FIND_IN_SET(comp.`type`, in_compSet) THEN 1 ELSE 0 END) AS races

FROM vAthletePublic AS athlete
JOIN vResult as res ON res.idPerson = athlete.idAthlete
JOIN vRace as race ON race.idRace = res.idRace
JOIN vCompetitionSmall as comp ON comp.idCompetition = race.idCompetition
WHERE athlete.idAthlete = in_idAthlete
GROUP BY race.raceYear
ORDER BY race.raceYear;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_athleteFull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_athleteFull`(IN in_idSet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
BEGIN
    SELECT 
        `athlete`.*,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` < 11), 1, 0),
            0)) AS `topTen`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 3), 1, 0),
            0)) AS `bronze`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 2), 1, 0),
            0)) AS `silver`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 1), 1, 0),
            0)) AS `gold`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` < 4),
                (4 - `result`.`place`),
                0),
            0)) AS `medalScore`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_compSet)),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`,
        SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%short%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreShort`,
        SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%lon%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreLong`,
        COUNT(race.id) AS `raceCount`,
        COUNT(DISTINCT comp.idCompetition) AS `competitionCount`,
        (SELECT 
                `abc`.`distance`
            FROM
                (SELECT 
                    SUM(GETSCORE(`res1`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp1`.`type`, in_compSet) + 1), ',', -1)) AS `raceScore`,
                        `race1`.`distance` AS `distance`
                FROM
                    ((`TbAthlete` `athlete1`
                JOIN `TbResult` `res1` ON ((`res1`.`idPerson` = `athlete1`.`id`)))
                JOIN `TbRace` `race1` ON ((`race1`.`id` = `res1`.`idRace`))
                JOIN `TbCompetition` `comp1` ON ((`race1`.`idCompetition` = `comp1`.`idCompetition`)))
                WHERE
                    (`athlete1`.`id` = `athlete`.`idAthlete`)
                GROUP BY `race1`.`distance`
                ORDER BY `raceScore` DESC) `abc`
            LIMIT 1) AS `bestDistance`
    FROM
        (((`vAthletePublic` `athlete`
        LEFT JOIN `TbResult` `result` ON ((`result`.`idPerson` = `athlete`.`idAthlete`)))
        LEFT JOIN `TbRace` `race` ON ((`result`.`idRace` = `race`.`id`)))
        LEFT JOIN `TbCompetition` `comp` ON ((`race`.`idCompetition` = `comp`.`idCompetition`)))
        
        WHERE FIND_IN_SET(athlete.idAthlete, in_idSet) > 0 OR in_idSet = "%"
        
    GROUP BY `athlete`.`idAthlete`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_athletePrivateFull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_athletePrivateFull`(IN in_idSet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
BEGIN
    SELECT 
        `athlete`.*,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` < 11), 1, 0),
            0)) AS `topTen`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 3), 1, 0),
            0)) AS `bronze`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 2), 1, 0),
            0)) AS `silver`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` = 1), 1, 0),
            0)) AS `gold`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_medalTypes)),
            IF((`result`.`place` < 4),
                (4 - `result`.`place`),
                0),
            0)) AS `medalScore`,
        SUM(IF((FIND_IN_SET(`comp`.`type`, in_compSet)),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`,
        SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%short%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreShort`,
        SUM(IF(((FIND_IN_SET(`comp`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%lon%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreLong`,
        COUNT(0) AS `raceCount`,
        COUNT(DISTINCT comp.idCompetition) AS `competitionCount`,
        (SELECT 
                `abc`.`distance`
            FROM
                (SELECT 
                    SUM(GETSCORE(`res1`.`place`)) AS `raceScore`,
                        `race1`.`distance` AS `distance`
                FROM
                    ((`TbAthlete` `athlete1`
                JOIN `TbResult` `res1` ON ((`res1`.`idPerson` = `athlete1`.`id`)))
                JOIN `TbRace` `race1` ON ((`race1`.`id` = `res1`.`idRace`)))
                WHERE
                    (`athlete1`.`id` = `athlete`.`idAthlete`)
                GROUP BY `race1`.`id`
                ORDER BY `raceScore` DESC) `abc`
            LIMIT 1) AS `bestDistance`
    FROM
        (((`vAthlete` `athlete`
        LEFT JOIN `TbResult` `result` ON ((`result`.`idPerson` = `athlete`.`idAthlete`)))
        LEFT JOIN `TbRace` `race` ON ((`result`.`idRace` = `race`.`id`)))
        LEFT JOIN `TbCompetition` `comp` ON ((`race`.`idCompetition` = `comp`.`idCompetition`)))
        
        WHERE FIND_IN_SET(athlete.idAthlete, in_idSet) > 0 OR in_idSet = "%"
        
    GROUP BY `athlete`.`idAthlete`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_checkCompetitionAndBelow` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_checkCompetitionAndBelow`(IN in_idCompetition INT)
BEGIN

UPDATE TbCompetition SET checked = 1 WHERE idCompetition = in_idCompetition;

UPDATE TbRace SET checked = 1 WHERE idCompetition = in_idCompetition;

UPDATE TbAthlete
JOIN TbResult ON TbResult.idPerson = TbAthlete.id
JOIN TbRace ON TbRace.id = TbResult.idRace
SET TbAthlete.checked = 1 WHERE idCompetition = in_idCompetition;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_countryCareer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_countryCareer`(IN in_country varchar(200), IN in_compSet TEXT)
BEGIN
SELECT
comp.raceYear
, SUM(IF(FIND_IN_SET(`comp`.`type`, in_compSet), getScore(res.place) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1), 0)) AS score
, SUM(IF(FIND_IN_SET(`comp`.`type`, in_compSet) AND race.discipline LIKE "%short%", getScore(res.place) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1), 0)) AS scoreShort
, SUM(IF(FIND_IN_SET(`comp`.`type`, in_compSet) AND race.discipline LIKE "%long%", getScore(res.place) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1), 0)) AS scoreLong
, SUM(IF(FIND_IN_SET(`comp`.`type`, in_compSet) AND SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1) != 0, 1, 0)) AS races

FROM vAthletePublic AS athlete
JOIN vResult as res ON res.idPerson = athlete.idAthlete
JOIN vRace as race ON race.idRace = res.idRace
JOIN vCompetitionSmall as comp ON comp.idCompetition = race.idCompetition
WHERE athlete.country = in_country
GROUP BY comp.raceYear
ORDER BY comp.raceYear;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_countryCareerNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_countryCareerNew`(IN in_country varchar(200), IN in_comps TEXT)
BEGIN
SELECT
comp.raceYear
, SUM(getScore(res.place)) AS score
, SUM(IF(race.discipline LIKE "%short%", getScore(res.place), 0)) AS scoreShort
, SUM(IF(race.discipline LIKE "%long%", getScore(res.place), 0)) AS scoreLong
, count(*) AS races

FROM TbAthlete AS athlete
JOIN TbResult as res ON res.idPerson = athlete.id
JOIN TbRace as race ON race.id = res.idRace
JOIN TbCompetition as comp ON comp.idCompetition = race.idCompetition
WHERE athlete.country = in_country AND find_in_set(comp.type, in_comps)
GROUP BY comp.raceYear
ORDER BY comp.raceYear;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_countryCareerSimple` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_countryCareerSimple`(IN in_country varchar(200), IN in_compSet TEXT)
BEGIN
SELECT
race.raceYear
#, SUM(getScore(place)) AS score
, SUM(IF((FIND_IN_SET(`comp`.`type`, in_compSet)),
            GETSCORE(`res`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`comp`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`

FROM vAthletePublic AS athlete
JOIN vResult as res ON res.idPerson = athlete.idAthlete
JOIN vRace as race ON race.idRace = res.idRace
JOIN vCompetitionSmall as comp ON comp.idCompetition = race.idCompetition
WHERE athlete.raceCount > 0 AND athlete.country = in_country AND comp.`type` = typeWm()
GROUP BY race.raceYear
ORDER BY race.raceYear;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_deleteCompetition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_deleteCompetition`(IN in_idCompetition INT)
BEGIN


INSERT INTO TbResultDeleted (SELECT NULL, TbResult.* FROM TbResult JOIN TbRace ON TbRace.id = TbResult.idRace WHERE TbRace.idCompetition = in_idCompetition);

DELETE TbResult FROM TbResult JOIN TbRace ON TbRace.id = TbResult.idRace WHERE TbRace.idCompetition = in_idCompetition;

INSERT INTO TbRaceDeleted (SELECT NULL, TbRace.* FROM TbRace WHERE idCompetition = in_idCompetition);

DELETE FROM TbRace WHERE idCompetition = in_idCompetition;

INSERT INTO TbCompetitionDeleted (SELECT NULL, TbCompetition.* FROM TbCompetition WHERE idCompetition = in_idCompetition);

DELETE FROM TbCompetition WHERE idCompetition = in_idCompetition;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_deleteRace` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_deleteRace`(IN in_idRace INT)
BEGIN

INSERT INTO TbResultDeleted (SELECT NULL, TbResult.* FROM TbResult WHERE idRace = in_idRace);

DELETE FROM TbResult WHERE idRace = in_idRace;

INSERT INTO TbRaceDeleted (SELECT NULL, TbRace.* FROM TbRace WHERE id = in_idRace);

DELETE FROM TbRace WHERE id = in_idRace;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_doublicateAthleteNames` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_doublicateAthleteNames`()
BEGIN
SELECT a1.firstname, a1.lastname
FROM TbAthlete as a1
INNER JOIN TbAthlete as a2
WHERE a1.firstname LIKE a2.firstname AND a1.lastname LIKE a2.lastname AND a1.id != a2.id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthleteBestTimes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthleteBestTimes`(IN in_idAthlete INT)
BEGIN

SELECT CONCAT(trackStreet, " ", distance) AS distance,
IF(discipline LIKE "%short%", TRUE, FALSE) as "isSprint",
min(`time`) AS bestTime,
min(`raceYear`) AS `year`,
(
SELECT race1.idRace FROM vResult as res1
JOIN vRace as race1 ON race1.idRace = res1.idRace
JOIN vAthletePublic as athlete1 ON athlete1.idAthlete = res1.idPerson
WHERE res1.`time` = min(res.`time`) AND athlete1.idAthlete = in_idAthlete# AND race1.raceYear = min(race.`raceYear`)# AND race1.distance = race.distance
LIMIT 1
) AS `idRace`
FROM vResult as res
JOIN vRace as race ON race.idRace = res.idRace
JOIN vAthletePublic as athlete ON athlete.idAthlete = res.idPerson
WHERE athlete.idAthlete = in_idAthlete AND res.`time` IS NOT NULL

GROUP BY athlete.idAthlete, distance, trackStreet, discipline

ORDER BY isSprint, distance;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthleteCompetitions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthleteCompetitions`(IN in_id INT)
BEGIN
SELECT comp.*,
sum(CASE WHEN result.place = 1 THEN 1 ELSE 0 END) as "goldMedals",
sum(CASE WHEN result.place = 2 THEN 1 ELSE 0 END) as "silverMedals",
sum(CASE WHEN result.place = 3 THEN 1 ELSE 0 END) as "bronzeMedals",
min(race.category) AS "category",
min(race.link) as hasLink
FROM TbResult as result
JOIN TbRace as race ON race.id = result.idRace
JOIN TbCompetition as comp ON comp.idCompetition = race.idCompetition

WHERE result.idPerson = in_id
GROUP BY comp.idCompetition
ORDER BY comp.startDate DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthleteNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthleteNew`(IN in_idAthlete INT, IN in_comps char(200))
BEGIN

DECLARE category varchar(10);
IF in_comps LIKE "%JUNIOR%" THEN SET category = "Junior"; ELSE SET category = "Senior"; END IF;
IF in_comps NOT LIKE "%JUNIOR%" AND in_comps NOT LIKE "%Senior%" THEN SET category = "nothing"; END IF;
IF in_comps LIKE "%JUNIOR%" AND in_comps LIKE "%Senior%" THEN SET category = "%"; END IF;

CASE WHEN
	(SELECT count(*) FROM
		(((`TbAthlete` `athlete`
        JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
		where athlete.id = in_idAthlete AND find_in_set(comp.type, in_comps) and race.category LIKE category) = 0
    THEN
		SELECT
        TbAthlete.firstname
        ,TbAthlete.lastname
        ,TbAthlete.gender
        ,TbAthlete.country
        ,TbAthlete.image
        ,TbAthlete.bestDistance
        ,TbAthlete.id
        ,TbAthlete.checked
        ,TbAthlete.creator
        ,TbAthlete.instagram
        ,TbAthlete.facebook
        ,TbAthlete.website
        ,TbAthlete.description
        , 0 as gold
        , 0 as silver
        , 0 as bronze
        , 0 as medalScore
        , 0 as medalScoreLong
        , 0 as medalScoreShort
        FROM TbAthlete WHERE TbAthlete.id = in_idAthlete;
	ELSE

SELECT
		`athlete`.`id` AS `id`,
        `athlete`.`lastname` AS `lastname`,
        `athlete`.`firstname` AS `firstname`,
        `athlete`.`gender` AS `gender`,
        `athlete`.`country` AS `country`,
        `athlete`.`linkCollection` AS `linkCollection`,
        `athlete`.`comment` AS `comment`,
        `athlete`.`club` AS `club`,
        `athlete`.`team` AS `team`,
        `athlete`.`image` AS `image`,
        `athlete`.`birthYear` AS `birthYear`,
        `athlete`.`LVKuerzel` AS `LVKuerzel`,
        `athlete`.`source` AS `source`,
        `athlete`.`remark` AS `remark`,
        `athlete`.`license` AS `license`,
        `athlete`.`facebook` AS `facebook`,
        `athlete`.`instagram` AS `instagram`,
        `athlete`.`description` AS `description`,
        `athlete`.`website` AS `website`,
        `athlete`.`isPlaceholder` AS `isPlaceholder`,
        athlete.checked,
        athlete.creator,
        (Select distance FROM (SELECT sum(getScore(TbResult.place)) as dScore, TbRace.distance FROM
			TbResult JOIN TbRace on TbRace.id = TbResult.idRace
            WHERE TbResult.idPerson = `athlete`.`id` GROUP BY TbRace.distance ORDER BY dScore DESC LIMIT 1) as test) AS `bestDistance`,
        SUM(IF(((`res`.`place` = 1)
                ),
            1,
            0)) AS `gold`,
                    SUM(IF(((`res`.`place` = 2)
                ),
            1,
            0)) AS `silver`,
        SUM(IF(((`res`.`place` = 3)
                ),
            1,
            0)) AS `bronze`,
        SUM(IF(((`res`.`place` <= 3)
                ),
            (4 - `res`.`place`),
            0)) AS `medalScore`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%short%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreShort`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%long%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreLong`,
        COUNT(0) AS `raceCount`
    FROM
        (((`TbAthlete` `athlete`
        JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
    where athlete.id = in_idAthlete AND find_in_set(comp.type, in_comps)
    and race.category LIKE category
    GROUP BY `athlete`.`id`;
    END CASE;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthleteRacesFromCompetition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthleteRacesFromCompetition`(IN in_person INT, IN in_competition INT)
BEGIN

SELECT race.*,
result.place

FROM TbResult AS result
JOIN TbRace AS race ON race.id = result.idRace

WHERE race.idCompetition = in_competition AND result.idPerson = in_person
ORDER BY race.trackStreet DESC, race.discipline DESC, race.distance, race.category, race.gender DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthletes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthletes`(distances_in TEXT, comps_in TEXT, gender_in TEXT, categories_in TEXT, discipline_in TEXT, minPlace_in INT, maxPlace_in INT, locations_in TEXT, fromDate_in DATE, toDate_in DATE, ids_in TEXT, `limit_in` INT, countries_in TEXT)
BEGIN
SELECT
idAthlete,
fullName,
country,
sum(case when place BETWEEN 1 AND 3 then 1 else 0 end) AS "medals",
sum(case when place = 1 then 1 else 0 end) AS "goldMedals",
sum(case when place = 2 then 1 else 0 end) AS "silverMedals",
sum(case when place = 3 then 1 else 0 end) AS "bronzeMedals",
sum(case when place BETWEEN 1 AND 3 then 4 - place else 0 end) AS "medalScore",
count(*) AS "raceCount"
FROM vAll
WHERE
idAthlete RLIKE ids_in
AND gender RLIKE gender_in
AND `type` RLIKE comps_in
AND place BETWEEN minPlace_in AND maxPlace_in
AND startDate BETWEEN fromDate_in AND toDate_in
AND location RLIKE locations_in
AND distance RLIKE distances_in
AND category RLIKE categories_in
AND discipline RLIKE discipline_in
AND country RLIKE countries_in
GROUP BY idAthlete
ORDER BY goldMedals DESC, silverMedals DESC, bronzeMedals DESC
LIMIT limit_in;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthletesNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthletesNew`(IN in_comps  char(200), IN in_limit INT)
BEGIN
SELECT
		`athlete`.`id` AS `id`,
        `athlete`.`lastname` AS `lastname`,
        `athlete`.`firstname` AS `firstname`,
        `athlete`.`gender` AS `gender`,
        `athlete`.`country` AS `country`,
        `athlete`.`linkCollection` AS `linkCollection`,
        `athlete`.`comment` AS `comment`,
        `athlete`.`club` AS `club`,
        `athlete`.`team` AS `team`,
        `athlete`.`image` AS `image`,
        `athlete`.`birthYear` AS `birthYear`,
        `athlete`.`LVKuerzel` AS `LVKuerzel`,
        `athlete`.`source` AS `source`,
        `athlete`.`remark` AS `remark`,
        `athlete`.`license` AS `license`,
        `athlete`.`facebook` AS `facebook`,
        `athlete`.`instagram` AS `instagram`,
        `athlete`.`isPlaceholder` AS `isPlaceholder`,
        `athlete`.`bestDistance` AS `bestDistance`,
        athlete.checked,
        athlete.creator,
        SUM(IF(((`res`.`place` = 1)
                ),
            1,
            0)) AS `gold`,
                    SUM(IF(((`res`.`place` = 2)
                ),
            1,
            0)) AS `silver`,
        SUM(IF(((`res`.`place` = 3)
                ),
            1,
            0)) AS `bronze`,
        SUM(IF(((`res`.`place` <= 3)
                ),
            (4 - `res`.`place`),
            0)) AS `medalScore`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%short%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreShort`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%long%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreLong`,
        COUNT(0) AS `raceCount`
    FROM
        (((`TbAthlete` `athlete`
        JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
    where find_in_set(comp.type, in_comps)
    GROUP BY `athlete`.`id`
    ORDER BY gold DESC, silver DESC, gold DESC
    LIMIT in_limit;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getAthleteVideos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getAthleteVideos`(IN in_idAthlete INT)
BEGIN
SELECT race.*
FROM TbRace as race
JOIN TbResult as res ON res.idRace = race.id
JOIN TbAthlete as athlete on athlete.id = res.idPerson
WHERE link IS NOT NULL AND athlete.id = in_idAthlete;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCompAthleteMedals` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCompAthleteMedals`(IN in_idComp INT)
BEGIN
    SELECT 
        `comp`.`idCompetition` AS `idCompetition`,
        `athlete`.`id` AS `idAthlete`,
        `athlete`.`firstname` AS `firstName`,
        CONCAT(`athlete`.`firstname`,
                ' ',
                `athlete`.`lastname`) AS `fullname`,
        `athlete`.`lastname` AS `lastName`,
        `athlete`.`country` AS `country`,
        `athlete`.`image` AS `image`,
        `athlete`.`gender` AS `gender`,
        SUM((CASE
            WHEN (`res`.`place` = 1) THEN 1
        END)) AS `gold`,
        SUM((CASE
            WHEN (`res`.`place` = 2) THEN 1
        END)) AS `silver`,
        SUM((CASE
            WHEN (`res`.`place` = 3) THEN 1
        END)) AS `bronze`,
        SUM((CASE
            WHEN (`res`.`place` = 1) THEN 3
            WHEN (`res`.`place` = 2) THEN 2
            WHEN (`res`.`place` = 3) THEN 1
        END)) AS `medalScore`
    FROM
        `TbResult` `res`
        JOIN `TbRace` `race` ON `race`.`id` = `res`.`idRace`
        JOIN `TbAthlete` `athlete` ON `athlete`.`id` = `res`.`idPerson`
        JOIN `TbCompetition` `comp` ON `comp`.`idCompetition` = `race`.`idCompetition`
        WHERE comp.idCompetition = in_idComp
    GROUP BY `athlete`.`id` , `comp`.`idCompetition`
    ORDER BY `gold` DESC , `silver` DESC , `bronze` DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCompCountryMedals` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCompCountryMedals`(IN in_idComp INT)
BEGIN
SELECT 
        `comp`.`idCompetition` AS `idCompetition`,
        `athlete`.`country` AS `country`,
        CEILING(SUM((CASE
                    WHEN
                        (`res`.`place` = 1)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                END))) AS `gold`,
        CEILING(SUM((CASE
                    WHEN
                        (`res`.`place` = 2)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                END))) AS `silver`,
        CEILING(SUM((CASE
                    WHEN
                        (`res`.`place` = 3)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                END))) AS `bronze`,
        CEILING(SUM((CASE
                    WHEN
                        (`res`.`place` = 1)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                    WHEN
                        (`res`.`place` = 2)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                    WHEN
                        (`res`.`place` = 3)
                    THEN
                        IF((`race`.`distance` LIKE '%relay%'),
                            0.333333,
                            1)
                END))) AS `medalScore`
    FROM
        (((`TbResult` `res`
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbAthlete` `athlete` ON ((`athlete`.`id` = `res`.`idPerson`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
        WHERE comp.idCompetition = in_idComp
    GROUP BY `comp`.`idCompetition` , `athlete`.`country`
    ORDER BY `gold` DESC , `silver` DESC , `bronze` DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCompetitionsNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCompetitionsNew`()
BEGIN

    SELECT 
        `TbCompetition`.`idCompetition` AS `idCompetition`,
        `TbCompetition`.`startDate` AS `startDate`,
        `TbCompetition`.`endDate` AS `endDate`,
        `TbCompetition`.`location` AS `location`,
        `TbCompetition`.`description` AS `description`,
        `TbCompetition`.`type` AS `type`,
        `TbCompetition`.`image` AS `image`,
        `TbCompetition`.`gpx` AS `gpx`,
        `TbCompetition`.`raceYear` AS `raceYear`,
        `TbCompetition`.`country` AS `country`,
        MIN(`country`.`alpha-2`) AS `alpha-2`,
        `TbCompetition`.`raceYearNum` AS `raceYearNum`,
        `TbCompetition`.`latitude` AS `latitude`,
        `TbCompetition`.`longitude` AS `longitude`,
        MAX(`race`.`link`) AS `hasLink`,
        TbCompetition.creator,
        TbCompetition.checked
    FROM
        ((`TbCompetition`
        LEFT JOIN `TbRace` `race` ON ((`race`.`idCompetition` = `TbCompetition`.`idCompetition`)))
        LEFT JOIN `TbCountry` `country` ON ((`country`.`name` = CONVERT( `TbCompetition`.`country` USING UTF8MB4))))
    GROUP BY `TbCompetition`.`idCompetition`
    ORDER BY `TbCompetition`.`startDate` DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCompNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCompNew`(IN in_idComp INT)
BEGIN
SELECT * FROM TbCompetition WHERE idCompetition = in_idComp;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountries` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountries`(IN in_countrySet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
BEGIN
SELECT 
        `athlete`.`country` AS `country`,
        
        (SELECT count(*) from vAthlete as vAthlete2 Where vAthlete2.country = athlete.country) as members,
        #COUNT(athlete.idAthlete) AS `members`,
        
        
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)),
            IF((`result`.`place` < 11), 1, 0),
            0)) AS `topTen`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)), IF((`result`.`place` < 4), 4 - `result`.`place`, 0), 0)) AS `medalScore`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)), IF((`result`.`place` = 1), 1, 0), 0)) AS `gold`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)), IF((`result`.`place` = 2), 1, 0), 0)) AS `silver`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)), IF((`result`.`place` = 3), 1, 0), 0)) AS `bronze`,
        
        #SUM(`athlete`.`raceCount`) AS `raceCount`,
        
        SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet)),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`,
        SUM(IF(((FIND_IN_SET(`race`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%short%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreShort`,
        SUM(IF(((FIND_IN_SET(`race`.`type`, in_compSet))
                AND (`race`.`discipline` LIKE '%lon%')),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreLong`,
        (SELECT 
                COUNT(0)
            FROM
                `vCompetitionSmall`
            WHERE
                (`vCompetitionSmall`.`country` = CONVERT( `athlete`.`country` USING UTF32))) AS `copmetitionCount`
    FROM
		TbResult as result
        JOIN `vAthlete` as athlete ON athlete.idAthlete = result.idPerson
        JOIN vRace as race ON result.idRace = race.idRace
	WHERE find_in_set(athlete.country, in_countrySet) OR in_countrySet = "%"
    GROUP BY `athlete`.`country`
    ORDER BY score DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountriesNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountriesNew`(IN in_comps char(200))
BEGIN
SELECT 
	`athlete`.`country` AS `country`,
	
	
	COUNT(distinct athlete.id) as members,
	
	SUM(IF(`result`.`place` <= 10, 1, 0)) AS `topTen`,
	SUM(IF(`result`.`place` < 4, 4 - `result`.`place`, 0)) AS `medalScore`,
	SUM(IF(`result`.`place` < 4 AND race.discipline LIKE "%short%", 4 - `result`.`place`, 0)) AS `medalScoreShort`,
	SUM(IF(`result`.`place` < 4 AND race.discipline LIKE "%long%", 4 - `result`.`place`, 0)) AS `medalScoreLong`,
	SUM(IF(`result`.`place` = 1, 1, 0)) AS `gold`,
	SUM(IF(`result`.`place` = 2, 1, 0)) AS `silver`,
	SUM(IF(`result`.`place` = 3, 1, 0)) AS `bronze`,
    
    MIN(comp.raceYear) AS `firstResult`
	
	#SUM(`athlete`.`raceCount`) AS `raceCount`,
    FROM TbAthlete as athlete
	JOIN TbResult as result ON result.idPerson = athlete.id
	JOIN TbRace as race ON race.id = result.idRace
	JOIN TbCompetition as comp ON comp.idCompetition = race.idCompetition
	WHERE find_in_set(comp.type, in_comps)
    GROUP BY `athlete`.`country`
    ORDER BY gold DESC, silver DESC, bronze DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryAthletes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryAthletes`(IN in_country varchar(130), IN in_compSet TEXT, IN in_medalTypes TEXT, IN in_limit INT)
BEGIN
SELECT `athlete`.idAthlete,
		`athlete`.firstname,
        `athlete`.lastname,
        `athlete`.gender,
        `athlete`.country,
        athlete.image,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)),
            IF((`result`.`place` = 3), 1, 0),
            0)) AS `bronze`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)),
            IF((`result`.`place` = 2), 1, 0),
            0)) AS `silver`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_medalTypes)),
            IF((`result`.`place` = 1), 1, 0),
            0)) AS `gold`,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet)),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`
		, SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet) AND race.discipline LIKE "%short%"),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreShort`
            
		, SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet) AND race.discipline LIKE "%long%"),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreLong`
    FROM
        ((`vAthletePublic` `athlete`
        LEFT JOIN `TbResult` `result` ON ((`result`.`idPerson` = `athlete`.`idAthlete`)))
        LEFT JOIN `vRace` `race` ON ((`result`.`idRace` = `race`.`idRace`)))
       WHERE athlete.country = in_country AND NOT lastname LIKE "%placeholder%"
    GROUP BY `athlete`.`idAthlete`
    ORDER BY score desc
    LIMIT in_limit;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryAthletesNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryAthletesNew`(IN in_country char(200), IN in_comps char(200))
BEGIN
SELECT
        `athlete`.`id` AS `id`,
        `athlete`.`lastname` AS `lastname`,
        `athlete`.`firstname` AS `firstname`,
        `athlete`.`gender` AS `gender`,
        `athlete`.`country` AS `country`,
        `athlete`.`linkCollection` AS `linkCollection`,
        `athlete`.`comment` AS `comment`,
        `athlete`.`club` AS `club`,
        `athlete`.`team` AS `team`,
        `athlete`.`image` AS `image`,
        `athlete`.`birthYear` AS `birthYear`,
        `athlete`.`LVKuerzel` AS `LVKuerzel`,
        `athlete`.`source` AS `source`,
        `athlete`.`remark` AS `remark`,
        `athlete`.`license` AS `license`,
        `athlete`.`facebook` AS `facebook`,
        `athlete`.`instagram` AS `instagram`,
        `athlete`.`isPlaceholder` AS `isPlaceholder`,
        `athlete`.`bestDistance` AS `bestDistance`,
        `athlete`.`checked` AS `checked`,
        `athlete`.`creator` AS `creator`,
        0 as score,
        SUM(IF(((`res`.`place` = 1)
                ),
            1,
            0)) AS `gold`,
                    SUM(IF(((`res`.`place` = 2)
                ),
            1,
            0)) AS `silver`,
        SUM(IF(((`res`.`place` = 3)
                ),
            1,
            0)) AS `bronze`,
        SUM(IF(((`res`.`place` <= 3)
                ),
            (4 - `res`.`place`),
            0)) AS `medalScore`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%short%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreShort`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%long%"
                ),
            (4 - `res`.`place`),
            0)) AS `medalScoreLong`,
        COUNT(0) AS `raceCount`
    FROM
        (((`TbAthlete` `athlete`
        JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
    where athlete.country = in_country AND athlete.raceCount > 0 AND find_in_set(comp.type, in_comps)
    GROUP BY `athlete`.`id`
    ORDER BY gold DESC, silver DESC, bronze DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryBestTimes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryBestTimes`(IN in_country varchar(200))
BEGIN

SELECT
CONCAT(trackStreet, " ", race.distance) AS distance,
IF(discipline LIKE "%short%", TRUE, FALSE) as "isSprint",
min(res.`time`) AS bestTime
,MAX(CASE WHEN `time` = bestTimes.bestTime THEN fullname ELSE "" END) AS athleteName
,MIN(CASE WHEN `time` = bestTimes.bestTime THEN idAthlete ELSE 10000000000 END) AS idAthlete
,MIN(CASE WHEN `time` = bestTimes.bestTime THEN race.raceYear ELSE 20000 END) AS `year`,
(
	SELECT race1.idRace
    FROM vResult as res1
	JOIN vRace as race1 ON race1.idRace = res1.idRace
	JOIN vAthletePublic as athlete1 ON athlete1.idAthlete = res1.idPerson
	WHERE res1.`time` = min(res.`time`) AND athlete1.country = in_country AND athlete1.fullname = MAX(CASE WHEN res.`time` = bestTimes.bestTime THEN athlete.fullname ELSE "" END) AND res1.`time` IS NOT NULL# AND race1.distance = race.distance
	LIMIT 1
) AS `idRace`
#,GROUP_CONCAT(bestTimes.bestTime)

FROM vResult as res
JOIN vRace as race ON race.idRace = res.idRace
JOIN vAthletePublic as athlete ON athlete.idAthlete = res.idPerson
LEFT JOIN (
	SELECT
		race2.distance,
		min(res2.`time`) AS bestTime
	FROM vResult as res2
	JOIN vRace as race2 ON race2.idRace = res2.idRace
	JOIN vAthletePublic as athlete2 ON athlete2.idAthlete = res2.idPerson
    
    WHERE athlete2.country = in_country AND res2.`time` IS NOT NULL
	GROUP BY race2.distance, race2.trackStreet
) AS bestTimes ON bestTimes.distance = race.distance

WHERE athlete.country = in_country AND res.`time` IS NOT NULL

GROUP BY  race.distance, race.trackStreet, race.discipline

ORDER BY distance;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryCompetitions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryCompetitions`(IN in_country varchar(100))
BEGIN
SELECT
comp.*,
count(*) as "starters",
sum(CASE WHEN place = 1 THEN 1 ELSE 0 END) as "goldMedals",
sum(CASE WHEN place = 2 THEN 1 ELSE 0 END) as "silverMedals",
sum(CASE WHEN place = 3 THEN 1 ELSE 0 END) as "bronzeMedals",
min(race.link) as hasLink
FROM TbAthlete as athlete
JOIN TbResult as res ON res.idPerson = athlete.id
JOIN TbRace as race ON race.id = res.idRace
JOIN TbCompetition as comp ON comp.idCompetition = race.idCompetition
WHERE athlete.country = in_country
GROUP BY comp.idCompetition
ORDER BY raceYear desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryNew`(IN in_country char(200))
BEGIN
SELECT
	`athlete`.`country` AS `country`,
	COUNT(*) as members,
	0 as topTen,
    0 as medalScore,
    0 as medalScoreShort,
    0 as medalScoreLong,
    0 as gold,
    0 as silver,
    0 as bronze
	
    FROM TbAthlete as athlete
	WHERE athlete.country = in_country
    GROUP BY `athlete`.`country`;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getCountryRacesFromCompetition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getCountryRacesFromCompetition`(IN in_country varchar(200), IN in_competition INT)
BEGIN
SELECT race.*,
min(result.place) as "bestPlace",
count(*) as "sportlers"

FROM TbResult AS result
JOIN TbRace AS race ON race.id = result.idRace
JOIN TbAthlete AS athlete ON athlete.id = result.idPerson

WHERE race.idCompetition = in_competition AND athlete.country = in_country
GROUP BY race.id
ORDER BY race.trackStreet DESC, race.discipline DESC, race.distance, race.category, race.gender DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getRaceNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getRaceNew`(IN in_idRace INT)
BEGIN

SELECT 
race.*,
YEAR(comp.startDate) as raceYear,
comp.location as location
FROM TbRace as race
JOIN TbCompetition as comp ON comp.idcompetition = race.idCompetition
WHERE race.id = in_idRace;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getRaceResults` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getRaceResults`(IN in_idRace INT)
BEGIN
SELECT
result.*
,result.id as idResult
,TbResult.timeDate AS `time`
,athlete.*
#,race.*
#,comp.*

FROM TbResult as result
JOIN vAthletePublic as athlete ON athlete.idAthlete = result.idPerson
#INNER JOIN vCompetition as comp ON comp.idCompetition = race.idCompetition
WHERE result.idRace = in_idRace
ORDER BY result.place ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getRaceResultsNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getRaceResultsNew`(IN in_idRace INT, IN in_comps char(200))
BEGIN
DECLARE category varchar(10);
IF in_comps LIKE "%JUNIOR%" THEN SET category = "Junior"; ELSE SET category = "Senior"; END IF;
IF in_comps NOT LIKE "%JUNIOR%" AND in_comps NOT LIKE "%Senior%" THEN SET category = "nothing"; END IF;
IF in_comps LIKE "%JUNIOR%" AND in_comps LIKE "%Senior%" THEN SET category = "%"; END IF;
SELECT
	raceResult.*,
    athlete.*
    
    FROM TbResult as raceResult
    JOIN (
			SELECT
			`athlete`.`id` AS `idAthlete`,
		`athlete`.`lastname` AS `lastname`,
		`athlete`.`firstname` AS `firstname`,
		`athlete`.`gender` AS `gender`,
		`athlete`.`country` AS `country`,
		`athlete`.`linkCollection` AS `linkCollection`,
		`athlete`.`comment` AS `comment`,
		`athlete`.`club` AS `club`,
		`athlete`.`team` AS `team`,
		`athlete`.`image` AS `image`,
		`athlete`.`birthYear` AS `birthYear`,
		`athlete`.`LVKuerzel` AS `LVKuerzel`,
		`athlete`.`source` AS `source`,
		`athlete`.`remark` AS `remark`,
		`athlete`.`license` AS `license`,
		`athlete`.`facebook` AS `facebook`,
		`athlete`.`instagram` AS `instagram`,
		`athlete`.`isPlaceholder` AS `isPlaceholder`,
		`athlete`.`bestDistance` AS `bestDistance`,
        `athlete`.`checked` AS `checked`,
		SUM(IF(((`res`.`place` = 1) AND find_in_set(comp.type, in_comps)
				),
			1,
			0)) AS `gold`,
					SUM(IF(((`res`.`place` = 2)
				),
			1,
			0)) AS `silver`,
		SUM(IF(((`res`.`place` = 3) AND find_in_set(comp.type, in_comps)
				),
			1,
			0)) AS `bronze`,
		SUM(IF(((`res`.`place` <= 3) AND find_in_set(comp.type, in_comps)
				),
			(4 - `res`.`place`),
			0)) AS `medalScore`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%short%" AND find_in_set(comp.type, in_comps)
				),
			(4 - `res`.`place`),
			0)) AS `medalScoreShort`,
		SUM(IF(((`res`.`place` <= 3) AND race.discipline LIKE "%long%" AND find_in_set(comp.type, in_comps)
				),
			(4 - `res`.`place`),
			0)) AS `medalScoreLong`,
		COUNT(0) AS `raceCount`
	FROM
		(((`TbAthlete` `athlete`
		JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
		JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
		JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
	where athlete.id IN (
		SELECT innerResult.idPerson FROM TbResult as innerResult WHERE innerResult.idRace = in_idRace
    ) AND find_in_set(comp.type, in_comps) AND race.category LIKE category OR res.idRace = in_idRace
	GROUP BY `athlete`.`id`
	ORDER BY `medalScore` DESC
) as athlete ON athlete.idAthlete = raceResult.idPerson
WHERE raceResult.idRace = in_idRace
ORDER BY raceResult.place ASC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getRacesFromCompetition` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getRacesFromCompetition`(IN in_id INT)
BEGIN
SELECT
race.*
,comp.*
FROM vRace AS race
JOIN vCompetition as comp ON comp.idCompetition = race.idCompetition
WHERE race.idCompetition = in_id
ORDER BY race.distance;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_getRacesFromCompetitionNew` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_getRacesFromCompetitionNew`(IN in_id INT)
BEGIN
SELECT race.*

FROM TbRace AS race

WHERE race.idCompetition = in_id
ORDER BY race.trackStreet, race.discipline DESC, race.distance, race.category, race.gender DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_hallOfFame` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_hallOfFame`(IN in_compSet TEXT)
BEGIN
SELECT `athlete`.idAthlete,
		`athlete`.firstname,
        `athlete`.lastname,
        `athlete`.gender,
        `athlete`.country,
        athlete.image,
        SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet)),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `score`
            
		, SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet) AND race.discipline LIKE "%short%"),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreShort`
            
		, SUM(IF((FIND_IN_SET(`race`.`type`, in_compSet) AND race.discipline LIKE "%long%"),
            GETSCORE(`result`.`place`) * SUBSTRING_INDEX(SUBSTRING_INDEX(in_compSet, ',', FIND_IN_SET(`race`.`type`, in_compSet) + 1), ',', -1),
            0)) AS `scoreLong`
    FROM
        ((`vAthletePublic` `athlete`
        LEFT JOIN `TbResult` `result` ON ((`result`.`idPerson` = `athlete`.`idAthlete`)))
        LEFT JOIN `vRace` `race` ON ((`result`.`idRace` = `race`.`idRace`)))
       WHERE athlete.raceCount > 0 #AND race.skateType = "inline"
    GROUP BY `athlete`.`idAthlete`
    ORDER BY score desc
    LIMIT 100;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_moveAthlete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_moveAthlete`(IN deleteId INT, IN in_toId INT)
BEGIN
UPDATE TbResult SET idPerson = in_toId WHERE idPerson = deleteId;
UPDATE TbAthleteHasImage SET athlete = in_toId WHERE athlete = deleteId;
UPDATE TbAthleteAlias SET idAthlete = in_toId WHERE idAthlete = deleteId;

DELETE FROM TbAthlete WHERE id = deleteId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_namesToTitleCase` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_namesToTitleCase`()
BEGIN
UPDATE TbAthlete SET firstName = titleCase(firstName), lastName = titleCase(lastName), country = titleCase(country);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_prozent_of_belegt_country` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_prozent_of_belegt_country`(IN in_place INT)
BEGIN

SELECT count(*) from vRace WHERE discipline LIKE "%short%" INTO @sprintAll;
SELECT count(*) from vRace WHERE discipline LIKE "%long%" INTO @longAll;

SELECT athlete.country,
sum(CASE WHEN vRace.discipline LIKE "%short%" THEN 1 END) AS "sprintAll",
sum(CASE WHEN vRace.discipline LIKE "%long%" THEN 1 END) AS "longAll",

sum(CASE WHEN vRace.discipline LIKE "%short%" THEN 1 END) / @sprintAll * 100 AS "sprint%",
sum(CASE WHEN vRace.discipline LIKE "%long%" THEN 1 END) / @longAll * 100 AS "long%"

FROM vResult
JOIN vAthlete as athlete ON athlete.idAthlete = vResult.idPerson
JOIN vRace ON vRace.idRace = vResult.idrace
WHERE place = in_place
GROUP BY athlete.country
ORDER BY `sprint%` DESC;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchAthlete` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchAthlete`(IN IN_firstName TEXT, IN IN_lastName TEXT, IN IN_gender TEXT, IN IN_country TEXT, IN IN_alias TEXT, IN IN_aliasGroup TEXT)
BEGIN

SELECT 
athlete.firstname,
athlete.lastname,
athlete.country,
athlete.gender,
athlete.id,
athlete.image,
(
IF(alias.idAthlete IS NOT NULL, 50, 0) +
IF(athlete.firstname LIKE IN_firstName, 2, 0) +
IF(athlete.lastname LIKE IN_lastName, 2, 0) +
IF(athlete.lastname LIKE IN_firstName, 0.75, 0) +
IF(athlete.firstname LIKE IN_lastName, 0.75, 0) +
IF(IN_country != "%" AND NOT (country.name LIKE IN_country OR country.`alpha-2` LIKE IN_country OR country.`alpha-3` LIKE IN_country OR country.`country-code` LIKE IN_country), -0.1, 0)) as priority
FROM TbAthlete as athlete
LEFT JOIN TbCountry as country ON country.name = athlete.country
LEFT JOIN (SELECT * FROM TbAthleteAlias WHERE aliasGroup = IN_aliasGroup AND alias = IN_alias) as alias ON alias.idAthlete = athlete.id
WHERE
(athlete.firstname LIKE IN_firstName OR
athlete.lastname LIKE IN_lastName OR
athlete.lastname LIKE IN_firstName OR
athlete.firstname LIKE IN_lastName
AND (country.`name` LIKE IN_country OR country.`alpha-2` LIKE IN_country OR country.`alpha-3` LIKE IN_country OR country.`country-code` LIKE IN_country)
AND athlete.gender LIKE IN_gender
AND lastname NOT LIKE "%placeholder%"
AND firstname != ""
AND lastname != "") OR
alias.idAthlete IS NOT NULL
#HAVING priority >= 2
ORDER BY priority DESC
LIMIT 10;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchAthleteFullname` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchAthleteFullname`(IN in_name TEXT, IN IN_gender TEXT, IN IN_country TEXT, IN IN_alias TEXT, IN IN_aliasGroup TEXT)
BEGIN

DECLARE maxLength INT;

DECLARE search1 varchar(200) DEFAULT nthWord(in_name, 1);
DECLARE search2 varchar(200) DEFAULT nthWord(in_name, 2);
DECLARE search3 varchar(200) DEFAULT nthWord(in_name, 3);
DECLARE search4 varchar(200) DEFAULT nthWord(in_name, 4);

DECLARE search1Like varchar(200) DEFAULT CONCAT("%", search1, "%");
DECLARE search2Like varchar(200) DEFAULT CONCAT("%", search2, "%");
DECLARE search3Like varchar(200) DEFAULT CONCAT("%", search3, "%");
DECLARE search4Like varchar(200) DEFAULT CONCAT("%", search4, "%");

DECLARE search1Soundex varchar(200) DEFAULT CONCAT("%", soundex(search1), "%");
DECLARE search2Soundex varchar(200) DEFAULT CONCAT("%", soundex(search2), "%");
DECLARE search3Soundex varchar(200) DEFAULT CONCAT("%", soundex(search3), "%");
DECLARE search4Soundex varchar(200) DEFAULT CONCAT("%", soundex(search4), "%");

IF LENGTH(search1Like) = 2 THEN SET search1Like = ""; SET search1Soundex = ""; END IF;
IF LENGTH(search2Like) = 2 THEN SET search2Like = ""; SET search2Soundex = ""; END IF;
IF LENGTH(search3Like) = 2 THEN SET search3Like = ""; SET search3Soundex = ""; END IF;
IF LENGTH(search4Like) = 2 THEN SET search4Like = ""; SET search4Soundex = ""; END IF;

#remove names shorter than 4 characters if longer ones exist
SET maxLength = GREATEST(LENGTH(search1), LENGTH(search2), LENGTH(search3), LENGTH(search4));
if(maxLength > 2) THEN
IF LENGTH(search1) < 3 THEN set search1Like = ""; SET search1Soundex = ""; END IF;
IF LENGTH(search2) < 3 THEN set search2Like = ""; SET search2Soundex = ""; END IF;
IF LENGTH(search3) < 3 THEN set search3Like = ""; SET search3Soundex = ""; END IF;
IF LENGTH(search4) < 3 THEN set search4Like = ""; SET search4Soundex = ""; END IF;
END IF;

SELECT
athlete.firstname,
athlete.lastname,
athlete.country,
athlete.gender,
athlete.id,
athlete.image,
(
IF(alias.idAthlete IS NOT NULL, 50, 0) +
#soundex
IF(soundex(firstname) LIKE search1Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search2Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search3Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search4Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search1Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search2Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search3Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search4Soundex, 0.5, 0) +
#like
IF(firstname LIKE search1Like, 0.6, 0) +
IF(firstname LIKE search2Like, 0.6, 0) +
IF(firstname LIKE search3Like, 0.6, 0) +
IF(firstname LIKE search4Like, 0.6, 0) +
IF(lastname LIKE search1Like, 0.6, 0) +
IF(lastname LIKE search2Like, 0.6, 0) +
IF(lastname LIKE search3Like, 0.6, 0) +
IF(lastname LIKE search4Like, 0.6, 0) +
#exact
IF(firstname = search1, 0.1, 0) +
IF(firstname = search2, 0.1, 0) +
IF(firstname = search3, 0.1, 0) +
IF(firstname = search4, 0.1, 0) +
IF(lastname = search1, 0.1, 0) +
IF(lastname = search2, 0.1, 0) +
IF(lastname = search3, 0.1, 0) +
IF(lastname = search4, 0.1, 0) +
IF(IN_country != "%" AND NOT (country.name LIKE IN_country OR country.`alpha-2` LIKE IN_country OR country.`alpha-3` LIKE IN_country OR country.`country-code` LIKE IN_country), -1, 0)) as priority
FROM TbAthlete as athlete
LEFT JOIN TbCountry as country ON country.name = athlete.country
LEFT JOIN (SELECT * FROM TbAthleteAlias WHERE aliasGroup = IN_aliasGroup AND alias = IN_alias) as alias ON alias.idAthlete = athlete.id
WHERE
(
#(firstname LIKE search1Like OR firstname LIKE search2Like OR firstname LIKE search3Like OR firstname LIKE search4Like OR
#lastname LIKE search1Like OR lastname LIKE search2Like OR lastname LIKE search3Like OR lastname LIKE search4Like)
(soundex(firstname) LIKE search1Soundex OR soundex(firstname) LIKE search2Soundex OR soundex(firstname) LIKE search3Soundex OR soundex(firstname) LIKE search4Soundex OR 
soundex(lastname) LIKE search1Soundex OR soundex(lastname) LIKE search2Soundex OR soundex(lastname) LIKE search3Soundex OR soundex(lastname) LIKE search4Soundex)
#AND (country.`name` LIKE IN_country OR country.`alpha-2` LIKE IN_country OR country.`alpha-3` LIKE IN_country OR country.`country-code` LIKE IN_country)
AND (athlete.gender LIKE IN_gender OR IN_gender = "")
AND lastname NOT LIKE "%placeholder%"
AND firstname != ""
AND lastname != "") OR
alias.idAthlete IS NOT NULL
HAVING priority >= 0.5
ORDER BY priority DESC
LIMIT 5;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchCompetitionLocation` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchCompetitionLocation`(IN in_name varchar(500))
BEGIN
SELECT 
/**idCompetition,
`type`,
location,
raceYear*/
*
FROM TbCompetition WHERE SOUNDEX(location) LIKE concat("%", SOUNDEX(in_name),"%") OR SOUNDEX(country) LIKE concat("%", SOUNDEX(in_name),"%")
ORDER BY startDate ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchCompetitionType` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchCompetitionType`(IN in_type varchar(500))
BEGIN
SELECT 
#idCompetition, location, `type`, raceYear
*
FROM TbCompetition WHERE `type` LIKE CONCAT("%", in_type, "%")
ORDER BY startDate DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchCountry` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchCountry`(IN in_name varchar(500))
BEGIN
SELECT country
FROM TbAthlete

GROUP BY country
HAVING SOUNDEX(country) LIKE CONCAT("%", SOUNDEX(in_name), "%");
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchPerson` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchPerson`(IN in_name varchar(500))
BEGIN
DECLARE maxLength INT;
DECLARE search1 varchar(200) DEFAULT nthWord(in_name, 1);
DECLARE search2 varchar(200) DEFAULT nthWord(in_name, 2);
DECLARE search3 varchar(200) DEFAULT nthWord(in_name, 3);
DECLARE search4 varchar(200) DEFAULT nthWord(in_name, 4);

DECLARE search1Like varchar(200) DEFAULT CONCAT("%", search1, "%");
DECLARE search2Like varchar(200) DEFAULT CONCAT("%", search2, "%");
DECLARE search3Like varchar(200) DEFAULT CONCAT("%", search3, "%");
DECLARE search4Like varchar(200) DEFAULT CONCAT("%", search4, "%");

DECLARE search1Soundex varchar(200) DEFAULT CONCAT("%", soundex(search1), "%");
DECLARE search2Soundex varchar(200) DEFAULT CONCAT("%", soundex(search2), "%");
DECLARE search3Soundex varchar(200) DEFAULT CONCAT("%", soundex(search3), "%");
DECLARE search4Soundex varchar(200) DEFAULT CONCAT("%", soundex(search4), "%");

IF LENGTH(search1Like) = 2 THEN SET search1Like = "-"; SET search1Soundex = "-"; END IF;
IF LENGTH(search2Like) = 2 THEN SET search2Like = "-"; SET search2Soundex = "-"; END IF;
IF LENGTH(search3Like) = 2 THEN SET search3Like = "-"; SET search3Soundex = "-"; END IF;
IF LENGTH(search4Like) = 2 THEN SET search4Like = "-"; SET search4Soundex = "-"; END IF;

#remove names shorter than 4 characters if longer ones exist
SET maxLength = GREATEST(LENGTH(search1), LENGTH(search2), LENGTH(search3), LENGTH(search4));
if(maxLength > 2) THEN
IF LENGTH(search1) < 3 THEN set search1Like = "-"; SET search1Soundex = "-"; END IF;
IF LENGTH(search2) < 3 THEN set search2Like = "-"; SET search2Soundex = "-"; END IF;
IF LENGTH(search3) < 3 THEN set search3Like = "-"; SET search3Soundex = "-"; END IF;
IF LENGTH(search4) < 3 THEN set search4Like = "-"; SET search4Soundex = "-"; END IF;
END IF;

SELECT
*,
(#soundex
IF(soundex(firstname) LIKE search1Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search2Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search3Soundex, 0.5, 0) +
IF(soundex(firstname) LIKE search4Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search1Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search2Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search3Soundex, 0.5, 0) +
IF(soundex(lastname) LIKE search4Soundex, 0.5, 0) +
#like
IF(firstname LIKE search1Like, 0.6, 0) +
IF(firstname LIKE search2Like, 0.6, 0) +
IF(firstname LIKE search3Like, 0.6, 0) +
IF(firstname LIKE search4Like, 0.6, 0) +
IF(lastname LIKE search1Like, 0.6, 0) +
IF(lastname LIKE search2Like, 0.6, 0) +
IF(lastname LIKE search3Like, 0.6, 0) +
IF(lastname LIKE search4Like, 0.6, 0) +
#exact
IF(firstname = search1, 1, 0) +
IF(firstname = search2, 1, 0) +
IF(firstname = search3, 1, 0) +
IF(firstname = search4, 1, 0) +
IF(lastname = search1, 1, 0) +
IF(lastname = search2, 1, 0) +
IF(lastname = search3, 1, 0) +
IF(lastname = search4, 1, 0)) as priority
FROM vAthlete WHERE (soundex(firstname) LIKE search1Soundex OR soundex(firstname) LIKE search2Soundex OR soundex(firstname) LIKE search3Soundex OR soundex(firstname) LIKE search4Soundex OR 
soundex(lastname) LIKE search1Soundex OR soundex(lastname) LIKE search2Soundex OR soundex(lastname) LIKE search3Soundex OR soundex(lastname) LIKE search4Soundex)
AND lastname NOT LIKE "placeholder%"
ORDER BY priority desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchTeams` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchTeams`(IN in_team TEXT)
BEGIN
SELECT * FROM TbTeam WHERE SOUNDEX(`name`) LIKE CONCAT(SOUNDEX(in_team), "%");
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_searchYear` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_searchYear`(IN in_year INT)
BEGIN
SELECT *
FROM TbCompetition
WHERE year(startDate) = in_year
ORDER BY startDate desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_selectResultDublicates` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_selectResultDublicates`()
BEGIN
SELECT res.idRace, res.idPerson
FROM TbResult as res
JOIN vRace as race ON race.idRace = res.idRace

WHERE `relay` = FALSE

Group BY race.idRace, res.idPerson Having count(*) > 1;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_teamAdvantage` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_teamAdvantage`(distance_in TEXT, maxPlace INT, competitions_in TEXT)
BEGIN
DROP TABLE IF EXISTS advantage_tmp;
DROP TABLE IF EXISTS advantage_tmp1;

CREATE TEMPORARY TABLE advantage_tmp
	SELECT distance,
	raceYear as year,
	gender,
	category,
	GROUP_CONCAT(IF(place = 1, country, "") SEPARATOR "") as winner,
	GROUP_CONCAT(CONCAT(country, "=", place)) as result,
	(SELECT country FROM vAll as vAll1 WHERE vAll1.idRace = vAll.idRace and place <= maxPlace GROUP BY country HAVING count(*) > 1 AND min(place) = 1 LIMIT 1) as doubleCountry,
	(SELECT country FROM vAll as vAll1 WHERE vAll1.idRace = vAll.idRace and place <= maxPlace GROUP BY country HAVING count(*) > 1 AND min(place) = 1 LIMIT 1) = GROUP_CONCAT(IF(place = 1, country, "") SEPARATOR "") AS succsess
	FROM vAll as vAll
	WHERE distance LIKE distance_in and place <= maxPlace AND FIND_IN_SET(type, competitions_in) > 0
	GROUP BY idRace
	HAVING count(distinct country) < maxPlace AND count(*) >= maxPlace;

CREATE TEMPORARY TABLE advantage_tmp1 SELECT * FROM advantage_tmp;

SET @bestCountry = (SELECT tmp1.doubleCountry FROM (SELECT tmp.doubleCountry, sum(tmp.succsess) as succsess FROM advantage_tmp1 as tmp GROUP BY tmp.doubleCountry ORDER BY succsess DESC LIMIT 1) as tmp1);

#SELECT * FROM advantage_tmp;

SELECT
min(year) as firstYear,
max(year) as lastYear,
count(*) AS races,
sum(succsess) AS teamWins,
count(*) - sum(succsess) AS teamDoesntWin,
CONCAT(ROUND(sum(succsess) / count(*) * 100, 2), "%") AS percentage,
@bestCountry as bestCountry,
CONCAT(ROUND((SELECT count(*) FROM advantage_tmp1 as tmp1 WHERE tmp1.doubleCountry = @bestCountry) / sum(succsess) * 100, 2), "%") AS bestCountryShare
FROM advantage_tmp;


DROP TABLE IF EXISTS advantage_tmp1;
DROP TABLE IF EXISTS advantage_tmp;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_teamAdvantageDetails` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_teamAdvantageDetails`(distance_in TEXT, maxPlace INT, competitions_in TEXT)
BEGIN
SELECT distance,
	raceYear as year,
	gender,
	category,
	GROUP_CONCAT(IF(place = 1, country, "") SEPARATOR "") as winner,
	GROUP_CONCAT(CONCAT(country, "=", place)) as result,
	(SELECT country FROM vAll as vAll1 WHERE vAll1.idRace = vAll.idRace and place <= maxPlace GROUP BY country HAVING count(*) > 1 AND min(place) = 1 LIMIT 1) as doubleCountry,
	(SELECT country FROM vAll as vAll1 WHERE vAll1.idRace = vAll.idRace and place <= maxPlace GROUP BY country HAVING count(*) > 1 AND min(place) = 1 LIMIT 1) = GROUP_CONCAT(IF(place = 1, country, "") SEPARATOR "") AS succsess
	FROM vAll as vAll
	WHERE distance LIKE distance_in and place <= maxPlace AND FIND_IN_SET(type, competitions_in) > 0
	GROUP BY idRace
	HAVING count(distinct country) < maxPlace AND count(*) >= maxPlace;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_update` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_update`()
BEGIN
CALL sp_namesToTitleCase();
CALL sp_updateCategory();
CALL sp_updateRaceCount();
CALL sp_updateSkateType();
CALL sp_updateRaceDisciplines();
CALL sp_updateTimes();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_updateCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_updateCategory`()
BEGIN

UPDATE TbRace 
SET category = "Senior"
WHERE category LIKE "Sen";

UPDATE TbRace 
SET category = "Junior"
WHERE category LIKE "Jun"
OR category = "Junior A";

UPDATE TbRace 
SET category = "Junior B"
WHERE category LIKE "Junior b";

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_updateRaceCount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_updateRaceCount`()
BEGIN
UPDATE TbAthlete SET raceCount = (SELECT count(*) from TbResult WHERE TbResult.idPerson = TbAthlete.id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_updateRaceDisciplines` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_updateRaceDisciplines`()
BEGIN
UPDATE TbRace SET discipline = "long" WHERE
distance LIKE "%20000%"
OR distance LIKE "%10000%"
OR distance LIKE "1400m%"
OR distance LIKE "1200m%"
OR distance LIKE "%15000%"
OR distance LIKE "%1500%"
OR distance LIKE "%2000%"
OR distance LIKE "%marathon%"
OR distance LIKE "%25000%"
OR distance LIKE "%3000%"
OR distance LIKE "%4000%"
OR distance LIKE "%50000%"
OR distance LIKE "%5000%"
OR distance LIKE "%6000%"
OR distance LIKE "%7000%"
OR distance LIKE "%8000%";

UPDATE TbRace SET discipline = "short" WHERE
distance like "100m%"
OR distance like "200m%"
OR distance like "300m%"
OR distance like "500m%"
OR distance like "one lap%"
OR distance like "500d%"
OR distance like "1000m%"
OR distance like "6 laps%";

UPDATE TbRace SET discipline = "short mass" WHERE
distance like "500m%"
OR distance like "one lap"
OR distance like "500d%"
OR distance like "1000m%"
OR distance like "6 laps%";
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_updateSkateType` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_updateSkateType`()
BEGIN

UPDATE TbRace SET skateType = "inline" WHERE skateType IS NULL;

UPDATE TbRace SET skateType = "inline" WHERE skateType LIKE "O";
UPDATE TbRace SET skateType = "quads" WHERE skateType LIKE "T";

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_updateTimes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_updateTimes`()
BEGIN
update TbResult set timeDate = str_to_date(zeit_Kon, "%H:%i:%s,%f") where timeDate IS NULl and zeit_Kon is not null;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vAll`
--

/*!50001 DROP VIEW IF EXISTS `vAll`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vAll` AS select `comp`.`raceYear` AS `raceYear`,`comp`.`location` AS `location`,`comp`.`type` AS `type`,`comp`.`startDate` AS `startDate`,`comp`.`endDate` AS `endDate`,`athlete`.`country` AS `country`,`race`.`relay` AS `relay`,`race`.`distance` AS `distance`,`race`.`category` AS `category`,`race`.`gender` AS `gender`,`race`.`link` AS `link`,`race`.`discipline` AS `discipline`,`race`.`trackStreet` AS `trackStreet`,`res`.`place` AS `place`,`res`.`time` AS `time`,`athlete`.`firstname` AS `firstname`,`athlete`.`lastname` AS `lastname`,concat(`athlete`.`firstname`,' ',`athlete`.`lastname`) AS `fullname`,`athlete`.`idAthlete` AS `idAthlete`,`comp`.`idCompetition` AS `idCompetition`,`race`.`idRace` AS `idRace`,`res`.`idResult` AS `idResult` from (((`vResult` `res` join `vRace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vAthlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vCompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vAthlete`
--

/*!50001 DROP VIEW IF EXISTS `vAthlete`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vAthlete` AS select `TbAthlete`.`id` AS `idAthlete`,`TbAthlete`.`lastname` AS `lastname`,`TbAthlete`.`firstname` AS `firstname`,`TbAthlete`.`gender` AS `gender`,`TbAthlete`.`country` AS `country`,`TbAthlete`.`linkCollection` AS `linkCollection`,`TbAthlete`.`mail` AS `mail`,`TbAthlete`.`comment` AS `comment`,`TbAthlete`.`club` AS `club`,`TbAthlete`.`team` AS `team`,`TbAthlete`.`image` AS `image`,`TbAthlete`.`birthYear` AS `birthYear`,`TbAthlete`.`LVKuerzel` AS `LVKuerzel`,`TbAthlete`.`source` AS `source`,`TbAthlete`.`birthdate` AS `birthdate`,`TbAthlete`.`remark` AS `remark`,`TbAthlete`.`license` AS `license`,`TbAthlete`.`facebook` AS `facebook`,`TbAthlete`.`instagram` AS `instagram`,`TbAthlete`.`isPlaceholder` AS `isPlaceholder`,`TbAthlete`.`score` AS `score`,`TbAthlete`.`scoreShort` AS `scoreShort`,`TbAthlete`.`scoreLong` AS `scoreLong`,`TbAthlete`.`bronze` AS `bronze`,`TbAthlete`.`silver` AS `silver`,`TbAthlete`.`gold` AS `gold`,`TbAthlete`.`topTen` AS `topTen`,`TbAthlete`.`medalScore` AS `medalScore`,`TbAthlete`.`raceCount` AS `raceCount`,`TbAthlete`.`minAge` AS `minAge`,`TbAthlete`.`bestDistance` AS `bestDistance`,`TbAthlete`.`checked` AS `checked`,`TbAthlete`.`creator` AS `creator` from `TbAthlete` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vAthleteCalc_old`
--

/*!50001 DROP VIEW IF EXISTS `vAthleteCalc_old`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vAthleteCalc_old` AS select `athlete`.`id` AS `idAthlete`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` < 11),1,0),0)) AS `topTen`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 3),1,0),0)) AS `bronze`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 2),1,0),0)) AS `silver`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 1),1,0),0)) AS `gold`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` < 4),(4 - `result`.`place`),0),0)) AS `medalScore`,sum(if((`comp`.`type` = `TYPEWM`()),`GETSCORE`(`result`.`place`),0)) AS `score`,sum(if(((`comp`.`type` = `TYPEWM`()) and (`race`.`discipline` like '%short%')),`GETSCORE`(`result`.`place`),0)) AS `scoreShort`,sum(if(((`comp`.`type` = `TYPEWM`()) and (`race`.`discipline` like '%lon%')),`GETSCORE`(`result`.`place`),0)) AS `scoreLong`,ifnull(find_in_set(round(`athlete`.`score`,6),(select group_concat(round(`at1`.`score`,6) order by `at1`.`score` DESC separator ',') from `TbAthlete` `at1`)),1000000) AS `rank`,ifnull(find_in_set(round(`athlete`.`scoreShort`,6),(select group_concat(round(`at1`.`scoreShort`,6) order by `at1`.`scoreShort` DESC separator ',') from `TbAthlete` `at1`)),1000000) AS `rankShort`,ifnull(find_in_set(round(`athlete`.`scoreLong`,6),(select group_concat(round(`at1`.`scoreLong`,6) order by `at1`.`scoreLong` DESC separator ',') from `TbAthlete` `at1`)),1000000) AS `rankLong`,count(0) AS `raceCount`,(select `abc`.`distance` from (select sum(`GETSCORE`(`res1`.`place`)) AS `raceScore`,`race1`.`distance` AS `distance` from ((`TbAthlete` `athlete1` join `TbResult` `res1` on((`res1`.`idPerson` = `athlete1`.`id`))) join `TbRace` `race1` on((`race1`.`id` = `res1`.`idRace`))) where (`athlete1`.`id` = `athlete`.`id`) group by `race1`.`id` order by `raceScore` desc) `abc` limit 1) AS `bestDistance` from (((`TbAthlete` `athlete` left join `TbResult` `result` on((`result`.`idPerson` = `athlete`.`id`))) left join `TbRace` `race` on((`result`.`idRace` = `race`.`id`))) left join `TbCompetition` `comp` on((`race`.`idCompetition` = `comp`.`idCompetition`))) where (`result`.`idPerson` between 1136 and 1200) group by `athlete`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vAthleteNew`
--

/*!50001 DROP VIEW IF EXISTS `vAthleteNew`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vAthleteNew` AS select `athlete`.`id` AS `idAthlete`,`athlete`.`lastname` AS `lastname`,`athlete`.`firstname` AS `firstname`,`athlete`.`gender` AS `gender`,`athlete`.`country` AS `country`,`athlete`.`linkCollection` AS `linkCollection`,`athlete`.`comment` AS `comment`,`athlete`.`club` AS `club`,`athlete`.`team` AS `team`,`athlete`.`image` AS `image`,`athlete`.`birthYear` AS `birthYear`,`athlete`.`LVKuerzel` AS `LVKuerzel`,`athlete`.`source` AS `source`,`athlete`.`remark` AS `remark`,`athlete`.`license` AS `license`,`athlete`.`facebook` AS `facebook`,`athlete`.`instagram` AS `instagram`,`athlete`.`isPlaceholder` AS `isPlaceholder`,`athlete`.`bestDistance` AS `bestDistance`,sum(if(((`res`.`place` = 1) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `goldMedals`,sum(if(((`res`.`place` = 2) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `silverMedals`,sum(if(((`res`.`place` = 3) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `bronzeMedals`,sum(if(((`res`.`place` <= 3) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),(4 - `res`.`place`),0)) AS `medalScore`,count(0) AS `raceCount` from (((`TbAthlete` `athlete` join `TbResult` `res` on((`res`.`idPerson` = `athlete`.`id`))) join `TbRace` `race` on((`race`.`id` = `res`.`idRace`))) join `TbCompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `athlete`.`id` order by `medalScore` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vAthletePublic`
--

/*!50001 DROP VIEW IF EXISTS `vAthletePublic`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vAthletePublic` AS select `TbAthlete`.`id` AS `idAthlete`,`TbAthlete`.`lastname` AS `lastname`,`TbAthlete`.`firstname` AS `firstname`,`TbAthlete`.`gender` AS `gender`,`TbAthlete`.`country` AS `country`,`TbAthlete`.`comment` AS `comment`,`TbAthlete`.`club` AS `club`,`TbAthlete`.`team` AS `team`,`TbAthlete`.`image` AS `image`,`TbAthlete`.`birthYear` AS `birthYear`,`TbAthlete`.`facebook` AS `facebook`,`TbAthlete`.`instagram` AS `instagram`,`TbAthlete`.`minAge` AS `minAge`,`TbAthlete`.`raceCount` AS `raceCount`,concat(`TbAthlete`.`firstname`,' ',`TbAthlete`.`lastname`) AS `fullname` from `TbAthlete` where (`TbAthlete`.`raceCount` > 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCCCountries`
--

/*!50001 DROP VIEW IF EXISTS `vCCCountries`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCCCountries` AS select sum(if(((`vAll`.`place` between 1 and 3) and (`vAll`.`discipline` like '%short mass%')),1,0)) AS `short mass`,sum(if(((`vAll`.`place` between 1 and 3) and (`vAll`.`discipline` like 'short')),1,0)) AS `short`,sum(if(((`vAll`.`place` between 1 and 3) and (`vAll`.`discipline` like '%short%')),1,0)) AS `short total`,sum(if(((`vAll`.`place` between 1 and 3) and (`vAll`.`discipline` like '%long%')),1,0)) AS `long`,group_concat(if((`vAll`.`place` between 1 and 3),concat(`vAll`.`fullname`,' in ',`vAll`.`distance`,', '),''),'' separator '') AS `long athletes`,`vAll`.`country` AS `country` from `vAll` where ((`vAll`.`type` like 'WM') and (`vAll`.`category` like 'Junior') and (`vAll`.`raceYear` > '2014') and (`vAll`.`trackStreet` like 'Track') and (not((`vAll`.`distance` like '%Mixed%'))) and (not((`vAll`.`distance` like '%Team%'))) and (not((`vAll`.`distance` like '%Relay%')))) group by `vAll`.`country` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCompAthleteMedals`
--

/*!50001 DROP VIEW IF EXISTS `vCompAthleteMedals`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCompAthleteMedals` AS select `comp`.`idCompetition` AS `idCompetition`,`athlete`.`idAthlete` AS `idAthlete`,`athlete`.`firstname` AS `firstName`,concat(`athlete`.`firstname`,' ',`athlete`.`lastname`) AS `fullname`,`athlete`.`lastname` AS `lastName`,`athlete`.`country` AS `country`,`athlete`.`image` AS `image`,`athlete`.`gender` AS `gender`,sum((case when (`res`.`place` = 1) then 1 end)) AS `gold`,sum((case when (`res`.`place` = 2) then 1 end)) AS `silver`,sum((case when (`res`.`place` = 3) then 1 end)) AS `bronze`,sum((case when (`res`.`place` = 1) then 3 when (`res`.`place` = 2) then 2 when (`res`.`place` = 3) then 1 end)) AS `medalScore` from (((`vResult` `res` join `vRace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vAthlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vCompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `athlete`.`idAthlete`,`comp`.`idCompetition` order by `gold` desc,`silver` desc,`bronze` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCompCountryMedals`
--

/*!50001 DROP VIEW IF EXISTS `vCompCountryMedals`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCompCountryMedals` AS select `comp`.`idCompetition` AS `idCompetition`,`athlete`.`country` AS `country`,ceiling(sum((case when (`res`.`place` = 1) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `gold`,ceiling(sum((case when (`res`.`place` = 2) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `silver`,ceiling(sum((case when (`res`.`place` = 3) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `bronze`,ceiling(sum((case when (`res`.`place` = 1) then if((`race`.`distance` like '%relay%'),0.333333,1) when (`res`.`place` = 2) then if((`race`.`distance` like '%relay%'),0.333333,1) when (`res`.`place` = 3) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `medalScore` from (((`vResult` `res` join `vRace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vAthlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vCompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `comp`.`idCompetition`,`athlete`.`country` order by `gold` desc,`silver` desc,`bronze` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCompetition`
--

/*!50001 DROP VIEW IF EXISTS `vCompetition`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCompetition` AS select `TbCompetition`.`idCompetition` AS `idCompetition`,`TbCompetition`.`startDate` AS `startDate`,`TbCompetition`.`endDate` AS `endDate`,`TbCompetition`.`location` AS `location`,`TbCompetition`.`description` AS `description`,`TbCompetition`.`type` AS `type`,`TbCompetition`.`image` AS `image`,`TbCompetition`.`gpx` AS `gpx`,`TbCompetition`.`raceYear` AS `raceYear`,`TbCompetition`.`country` AS `country`,min(`country`.`alpha-2`) AS `alpha-2`,`TbCompetition`.`raceYearNum` AS `raceYearNum`,`TbCompetition`.`latitude` AS `latitude`,`TbCompetition`.`longitude` AS `longitude`,max(`race`.`link`) AS `hasLink` from ((`TbCompetition` left join `vRace` `race` on((`race`.`idCompetition` = `TbCompetition`.`idCompetition`))) join `TbCountry` `country` on((`country`.`name` = convert(`TbCompetition`.`country` using utf8mb4)))) group by `TbCompetition`.`idCompetition` order by `TbCompetition`.`raceYearNum` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCompetitionSmall`
--

/*!50001 DROP VIEW IF EXISTS `vCompetitionSmall`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCompetitionSmall` AS select `TbCompetition`.`idCompetition` AS `idCompetition`,`TbCompetition`.`location` AS `location`,`TbCompetition`.`type` AS `type`,`TbCompetition`.`raceYear` AS `raceYear`,`TbCompetition`.`country` AS `country`,`TbCompetition`.`raceYearNum` AS `raceYearNum` from `TbCompetition` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vCountry`
--

/*!50001 DROP VIEW IF EXISTS `vCountry`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vCountry` AS select `vAthlete`.`country` AS `country`,count(0) AS `members`,sum(`vAthlete`.`medalScore`) AS `medalScore`,sum(`vAthlete`.`gold`) AS `gold`,sum(`vAthlete`.`silver`) AS `silver`,sum(`vAthlete`.`bronze`) AS `bronze`,sum(`vAthlete`.`topTen`) AS `topTen`,sum(`vAthlete`.`raceCount`) AS `raceCount`,sum(`vAthlete`.`score`) AS `score`,sum(`vAthlete`.`scoreShort`) AS `scoreShort`,sum(`vAthlete`.`scoreLong`) AS `scoreLong`,(select count(0) from `vCompetitionSmall` where (`vCompetitionSmall`.`country` = convert(`vAthlete`.`country` using utf32))) AS `copmetitionCount` from `vAthlete` group by `vAthlete`.`country` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vDublicates`
--

/*!50001 DROP VIEW IF EXISTS `vDublicates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vDublicates` AS select `vAll`.`raceYear` AS `raceYear`,`vAll`.`type` AS `type`,`vAll`.`location` AS `location`,`vAll`.`country` AS `country`,`vAll`.`relay` AS `relay`,`vAll`.`category` AS `category`,`vAll`.`gender` AS `gender`,`vAll`.`distance` AS `distance`,`vAll`.`firstname` AS `firstname`,`vAll`.`lastname` AS `lastname`,`vAll`.`trackStreet` AS `trackStreet`,count(0) AS `count` from `vAll` group by `vAll`.`raceYear`,`vAll`.`type`,`vAll`.`location`,`vAll`.`country`,`vAll`.`relay`,`vAll`.`category`,`vAll`.`gender`,`vAll`.`distance`,`vAll`.`firstname`,`vAll`.`lastname`,`vAll`.`trackStreet` having (count(0) > 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vGLobalStats`
--

/*!50001 DROP VIEW IF EXISTS `vGLobalStats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vGLobalStats` AS select (select count(0) from `TbLog`) AS `Calls`,(select count(0) from `TbLog` where (`TbLog`.`isDev` = 0)) AS `No dev calls`,(select count(distinct `TbLog`.`userId`) from `TbLog` where (`TbLog`.`isDev` = 0)) AS `individuals`,(select count(0) from `TbLog` where (`TbLog`.`isDev` = 1)) AS `Dev calls` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vLogDays`
--

/*!50001 DROP VIEW IF EXISTS `vLogDays`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vLogDays` AS select date_format(`TbLog`.`timestamp`,'%Y-%m-%d') AS `date`,count(0) AS `calls`,count(distinct `TbLog`.`userId`) AS `individuals`,sum(if((`TbLog`.`location` like '%United States%'),1,0)) AS `USA calls`,concat(((sum(`TbLog`.`isMobile`) / sum(if((`TbLog`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,sum(`TbLog`.`isMobile`) AS `mobileCalls`,(count(0) / count(distinct `TbLog`.`userId`)) AS `calls per individual`,count(distinct `TbLog`.`user`) AS `different users online`,(select count(0) from `TbUser` where (date_format(`TbUser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new users`,(select group_concat(`TbUser`.`username` separator ',') from `TbUser` where (date_format(`TbUser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new usernames` from `TbLog` where (`TbLog`.`isDev` = 0) group by `date` order by max(`TbLog`.`timestamp`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vLogDaysNoUSA`
--

/*!50001 DROP VIEW IF EXISTS `vLogDaysNoUSA`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vLogDaysNoUSA` AS select date_format(`TbLog`.`timestamp`,'%Y-%m-%d') AS `date`,count(0) AS `calls`,count(distinct `TbLog`.`userId`) AS `individuals`,concat(((sum(`TbLog`.`isMobile`) / sum(if((`TbLog`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,sum(`TbLog`.`isMobile`) AS `mobileCalls`,(count(0) / count(distinct `TbLog`.`userId`)) AS `calls per individual`,count(distinct `TbLog`.`user`) AS `different users online`,(select count(0) from `TbUser` where (date_format(`TbUser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new users`,(select group_concat(`TbUser`.`username` separator ',') from `TbUser` where (date_format(`TbUser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new usernames` from `TbLog` where ((`TbLog`.`isDev` = 0) and (not((`TbLog`.`location` like '%United States%')))) group by `date` order by max(`TbLog`.`timestamp`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vLogHours`
--

/*!50001 DROP VIEW IF EXISTS `vLogHours`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vLogHours` AS select concat(year(`TbLog`.`timestamp`),'-',month(`TbLog`.`timestamp`),'-',dayofmonth(`TbLog`.`timestamp`),':',hour(`TbLog`.`timestamp`)) AS `dateTime`,count(0) AS `calls`,count(distinct `TbLog`.`userId`) AS `individuals`,(count(0) / count(distinct `TbLog`.`userId`)) AS `calls per individual` from `TbLog` where (`TbLog`.`isDev` = 0) group by `dateTime` order by max(`TbLog`.`timestamp`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vLogNoDev`
--

/*!50001 DROP VIEW IF EXISTS `vLogNoDev`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vLogNoDev` AS select `TbLog`.`idTbLog` AS `idTbLog`,`TbLog`.`userId` AS `userId`,`TbLog`.`from` AS `from`,`TbLog`.`to` AS `to`,`TbLog`.`ip` AS `ip`,`TbLog`.`location` AS `location`,`TbLog`.`timestamp` AS `timestamp`,`TbLog`.`device` AS `device`,`TbLog`.`isDev` AS `isDev`,`TbLog`.`user` AS `user`,`TbLog`.`isMobile` AS `isMobile` from `TbLog` where (`TbLog`.`isDev` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vRace`
--

/*!50001 DROP VIEW IF EXISTS `vRace`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vRace` AS select `TbRace`.`id` AS `idRace`,`TbRace`.`relay` AS `relay`,`TbRace`.`distance` AS `distance`,`TbRace`.`link` AS `link`,`TbRace`.`category` AS `category`,`TbRace`.`gender` AS `gender`,`TbRace`.`remark` AS `remark`,`TbRace`.`trackStreet` AS `trackStreet`,`TbRace`.`idCompetition` AS `idCompetition`,`TbRace`.`source` AS `source`,`TbRace`.`discipline` AS `discipline`,`TbRace`.`skateType` AS `skateType`,`comp`.`raceYear` AS `raceYear`,`comp`.`location` AS `location`,`comp`.`country` AS `country`,`comp`.`type` AS `type`,(count(0) - 1) AS `resultCount` from ((`TbRace` join `TbCompetition` `comp` on((`comp`.`idCompetition` = `TbRace`.`idCompetition`))) join `TbResult` `res` on((`res`.`idRace` = `TbRace`.`id`))) group by `TbRace`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vResult`
--

/*!50001 DROP VIEW IF EXISTS `vResult`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vResult` AS select `TbResult`.`id` AS `idResult`,`TbResult`.`timeDate` AS `time`,`TbResult`.`idPerson` AS `idPerson`,`TbResult`.`idRace` AS `idRace`,`TbResult`.`place` AS `place` from `TbResult` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vSiteViews`
--

/*!50001 DROP VIEW IF EXISTS `vSiteViews`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vSiteViews` AS select count(0) AS `calls`,substr(`vLogNoDev`.`to`,(locate('roller-results.com',`vLogNoDev`.`to`) + 18),100) AS `page`,concat(((sum(`vLogNoDev`.`isMobile`) / sum(if((`vLogNoDev`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,min(`vLogNoDev`.`timestamp`) AS `firstCall`,max(`vLogNoDev`.`timestamp`) AS `lastCall` from `vLogNoDev` where (`vLogNoDev`.`to` like '%roller-results.com%') group by `page` order by `calls` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vSiteViewsToday`
--

/*!50001 DROP VIEW IF EXISTS `vSiteViewsToday`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vSiteViewsToday` AS select count(0) AS `calls`,substr(`vLogNoDev`.`to`,(locate('roller-results.com',`vLogNoDev`.`to`) + 18),100) AS `page`,concat(((sum(`vLogNoDev`.`isMobile`) / sum(if((`vLogNoDev`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,min(`vLogNoDev`.`timestamp`) AS `firstCall`,max(`vLogNoDev`.`timestamp`) AS `lastCall` from `vLogNoDev` where ((`vLogNoDev`.`to` like '%roller-results.com%') and (`vLogNoDev`.`timestamp` >= curdate()) and (`vLogNoDev`.`timestamp` < (curdate() + interval 1 day))) group by `page` order by `calls` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vUser`
--

/*!50001 DROP VIEW IF EXISTS `vUser`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vUser` AS select `TbUser`.`iduser` AS `idUser`,`TbUser`.`username` AS `username`,`TbUser`.`email` AS `email`,`TbUser`.`image` AS `image`,`TbUser`.`idrole` AS `idRole`,`TbUser`.`registerCountry` AS `registerCountry`,`TbUser`.`athlete` AS `athlete`,`TbUser`.`athleteChecked` AS `athleteChecked`,`TbUser`.`rowCreated` AS `rowCreated`,count(0) AS `calls` from (`TbUser` join `TbLog` on((`TbLog`.`user` = `TbUser`.`iduser`))) group by `TbUser`.`iduser` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vWorldMovement`
--

/*!50001 DROP VIEW IF EXISTS `vWorldMovement`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `vWorldMovement` AS select `comp`.`idCompetition` AS `idCompetition`,group_concat(distinct `athlete`.`fullname` separator ',') AS `athleteNames`,group_concat(distinct `athlete`.`idAthlete` separator ',') AS `athleteIds`,ifnull(convert(`comp`.`startDate` using utf32),concat(`comp`.`raceYear`,'-01-01 00:00:00')) AS `date`,`compCountry`.`alpha-3` AS `competitionCountry`,`compCountry`.`name` AS `competitionCountryName`,`comp`.`type` AS `competitionType`,`comp`.`location` AS `competitionLocation`,sum((case when (`res`.`place` = 1) then 1 else 0 end)) AS `gold`,sum((case when (`res`.`place` = 2) then 1 else 0 end)) AS `silver`,sum((case when (`res`.`place` = 3) then 1 else 0 end)) AS `bronze`,ifnull(`comp`.`latitude`,`compCountry`.`latitude`) AS `compLatitude`,ifnull(`comp`.`longitude`,`compCountry`.`longitude`) AS `compLongitude`,`athleteCountry`.`alpha-3` AS `athleteCountry`,`athleteCountry`.`name` AS `athleteCountryName`,`athleteCountry`.`radius` AS `athleteCountryRadius`,`athleteCountry`.`color` AS `athleteCountryColor`,`athleteCountry`.`latitude` AS `athleteLatitude`,`athleteCountry`.`longitude` AS `athleteLongitude`,count(distinct `athlete`.`idAthlete`) AS `athleteCount` from (((((`vResult` `res` join `vAthletePublic` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vRace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vCompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) join `TbCountry` `compCountry` on((`compCountry`.`name` = convert(`comp`.`country` using utf8mb4)))) join `TbCountry` `athleteCountry` on((`athleteCountry`.`name` = `athlete`.`country`))) group by `comp`.`idCompetition`,`date`,`competitionCountry`,`athleteCountry` order by `date` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-11 12:51:45
