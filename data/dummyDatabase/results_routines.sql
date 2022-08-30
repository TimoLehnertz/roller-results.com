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
CREATE DEFINER=`timo`@`%` FUNCTION `getScore`(place INT) RETURNS double
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
CREATE DEFINER=`timo`@`%` FUNCTION `globeKmToDegree`(km double) RETURNS double
    DETERMINISTIC
BEGIN
RETURN DEGREES(ATAN(km / 6371));
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
CREATE DEFINER=`timo`@`%` FUNCTION `random`(`start` double, `end` double) RETURNS double
    DETERMINISTIC
BEGIN
RETURN RAND() * (`end` - `start`) + `start`;
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
CREATE DEFINER=`timo`@`%` FUNCTION `titleCase`(str VARCHAR(200)) RETURNS text CHARSET utf8mb4
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
CREATE DEFINER=`timo`@`%` FUNCTION `typeWm`() RETURNS varchar(30) CHARSET utf8mb4
    DETERMINISTIC
BEGIN
RETURN "wm";
END ;;
DELIMITER ;

--
-- Temporary view structure for view `vrace`
--

DROP TABLE IF EXISTS `vrace`;
/*!50001 DROP VIEW IF EXISTS `vrace`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vrace` AS SELECT 
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
-- Temporary view structure for view `vsiteviewstoday`
--

DROP TABLE IF EXISTS `vsiteviewstoday`;
/*!50001 DROP VIEW IF EXISTS `vsiteviewstoday`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vsiteviewstoday` AS SELECT 
 1 AS `calls`,
 1 AS `page`,
 1 AS `mobile`,
 1 AS `firstCall`,
 1 AS `lastCall`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vglobalstats`
--

DROP TABLE IF EXISTS `vglobalstats`;
/*!50001 DROP VIEW IF EXISTS `vglobalstats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vglobalstats` AS SELECT 
 1 AS `Calls`,
 1 AS `No dev calls`,
 1 AS `individuals`,
 1 AS `Dev calls`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vcompetition`
--

DROP TABLE IF EXISTS `vcompetition`;
/*!50001 DROP VIEW IF EXISTS `vcompetition`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcompetition` AS SELECT 
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
-- Temporary view structure for view `vlogdays`
--

DROP TABLE IF EXISTS `vlogdays`;
/*!50001 DROP VIEW IF EXISTS `vlogdays`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vlogdays` AS SELECT 
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
-- Temporary view structure for view `vcccountries`
--

DROP TABLE IF EXISTS `vcccountries`;
/*!50001 DROP VIEW IF EXISTS `vcccountries`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcccountries` AS SELECT 
 1 AS `short mass`,
 1 AS `short`,
 1 AS `short total`,
 1 AS `long`,
 1 AS `long athletes`,
 1 AS `country`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vloghours`
--

DROP TABLE IF EXISTS `vloghours`;
/*!50001 DROP VIEW IF EXISTS `vloghours`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vloghours` AS SELECT 
 1 AS `dateTime`,
 1 AS `calls`,
 1 AS `individuals`,
 1 AS `calls per individual`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vathlete`
--

DROP TABLE IF EXISTS `vathlete`;
/*!50001 DROP VIEW IF EXISTS `vathlete`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vathlete` AS SELECT 
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
-- Temporary view structure for view `vdublicates`
--

DROP TABLE IF EXISTS `vdublicates`;
/*!50001 DROP VIEW IF EXISTS `vdublicates`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vdublicates` AS SELECT 
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
-- Temporary view structure for view `vlognodev`
--

DROP TABLE IF EXISTS `vlognodev`;
/*!50001 DROP VIEW IF EXISTS `vlognodev`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vlognodev` AS SELECT 
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
-- Temporary view structure for view `vathletecalc_old`
--

DROP TABLE IF EXISTS `vathletecalc_old`;
/*!50001 DROP VIEW IF EXISTS `vathletecalc_old`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vathletecalc_old` AS SELECT 
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
-- Temporary view structure for view `vuser`
--

DROP TABLE IF EXISTS `vuser`;
/*!50001 DROP VIEW IF EXISTS `vuser`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vuser` AS SELECT 
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
-- Temporary view structure for view `vcompathletemedals`
--

DROP TABLE IF EXISTS `vcompathletemedals`;
/*!50001 DROP VIEW IF EXISTS `vcompathletemedals`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcompathletemedals` AS SELECT 
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
-- Temporary view structure for view `vresult`
--

DROP TABLE IF EXISTS `vresult`;
/*!50001 DROP VIEW IF EXISTS `vresult`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vresult` AS SELECT 
 1 AS `idResult`,
 1 AS `time`,
 1 AS `idPerson`,
 1 AS `idRace`,
 1 AS `place`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vworldmovement`
--

DROP TABLE IF EXISTS `vworldmovement`;
/*!50001 DROP VIEW IF EXISTS `vworldmovement`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vworldmovement` AS SELECT 
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
-- Temporary view structure for view `vcountry`
--

DROP TABLE IF EXISTS `vcountry`;
/*!50001 DROP VIEW IF EXISTS `vcountry`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcountry` AS SELECT 
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
-- Temporary view structure for view `vall`
--

DROP TABLE IF EXISTS `vall`;
/*!50001 DROP VIEW IF EXISTS `vall`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vall` AS SELECT 
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
-- Temporary view structure for view `vathletepublic`
--

DROP TABLE IF EXISTS `vathletepublic`;
/*!50001 DROP VIEW IF EXISTS `vathletepublic`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vathletepublic` AS SELECT 
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
-- Temporary view structure for view `vathletenew`
--

DROP TABLE IF EXISTS `vathletenew`;
/*!50001 DROP VIEW IF EXISTS `vathletenew`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vathletenew` AS SELECT 
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
-- Temporary view structure for view `vcompcountrymedals`
--

DROP TABLE IF EXISTS `vcompcountrymedals`;
/*!50001 DROP VIEW IF EXISTS `vcompcountrymedals`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcompcountrymedals` AS SELECT 
 1 AS `idCompetition`,
 1 AS `country`,
 1 AS `gold`,
 1 AS `silver`,
 1 AS `bronze`,
 1 AS `medalScore`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vcompetitionsmall`
--

DROP TABLE IF EXISTS `vcompetitionsmall`;
/*!50001 DROP VIEW IF EXISTS `vcompetitionsmall`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vcompetitionsmall` AS SELECT 
 1 AS `idCompetition`,
 1 AS `location`,
 1 AS `type`,
 1 AS `raceYear`,
 1 AS `country`,
 1 AS `raceYearNum`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vsiteviews`
--

DROP TABLE IF EXISTS `vsiteviews`;
/*!50001 DROP VIEW IF EXISTS `vsiteviews`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vsiteviews` AS SELECT 
 1 AS `calls`,
 1 AS `page`,
 1 AS `mobile`,
 1 AS `firstCall`,
 1 AS `lastCall`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vrace`
--

/*!50001 DROP VIEW IF EXISTS `vrace`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vrace` AS select `tbrace`.`id` AS `idRace`,`tbrace`.`relay` AS `relay`,`tbrace`.`distance` AS `distance`,`tbrace`.`link` AS `link`,`tbrace`.`category` AS `category`,`tbrace`.`gender` AS `gender`,`tbrace`.`remark` AS `remark`,`tbrace`.`trackStreet` AS `trackStreet`,`tbrace`.`idCompetition` AS `idCompetition`,`tbrace`.`source` AS `source`,`tbrace`.`discipline` AS `discipline`,`tbrace`.`skateType` AS `skateType`,`comp`.`raceYear` AS `raceYear`,`comp`.`location` AS `location`,`comp`.`country` AS `country`,`comp`.`type` AS `type`,(count(0) - 1) AS `resultCount` from ((`tbrace` join `tbcompetition` `comp` on((`comp`.`idCompetition` = `tbrace`.`idCompetition`))) join `tbresult` `res` on((`res`.`idRace` = `tbrace`.`id`))) group by `tbrace`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vsiteviewstoday`
--

/*!50001 DROP VIEW IF EXISTS `vsiteviewstoday`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vsiteviewstoday` AS select count(0) AS `calls`,substr(`vlognodev`.`to`,(locate('roller-results.com',`vlognodev`.`to`) + 18),100) AS `page`,concat(((sum(`vlognodev`.`isMobile`) / sum(if((`vlognodev`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,min(`vlognodev`.`timestamp`) AS `firstCall`,max(`vlognodev`.`timestamp`) AS `lastCall` from `vlognodev` where ((`vlognodev`.`to` like '%roller-results.com%') and (`vlognodev`.`timestamp` >= curdate()) and (`vlognodev`.`timestamp` < (curdate() + interval 1 day))) group by `page` order by `calls` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vglobalstats`
--

/*!50001 DROP VIEW IF EXISTS `vglobalstats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vglobalstats` AS select (select count(0) from `tblog`) AS `Calls`,(select count(0) from `tblog` where (`tblog`.`isDev` = 0)) AS `No dev calls`,(select count(distinct `tblog`.`userId`) from `tblog` where (`tblog`.`isDev` = 0)) AS `individuals`,(select count(0) from `tblog` where (`tblog`.`isDev` = 1)) AS `Dev calls` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcompetition`
--

/*!50001 DROP VIEW IF EXISTS `vcompetition`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcompetition` AS select `tbcompetition`.`idCompetition` AS `idCompetition`,`tbcompetition`.`startDate` AS `startDate`,`tbcompetition`.`endDate` AS `endDate`,`tbcompetition`.`location` AS `location`,`tbcompetition`.`description` AS `description`,`tbcompetition`.`type` AS `type`,`tbcompetition`.`image` AS `image`,`tbcompetition`.`gpx` AS `gpx`,`tbcompetition`.`raceYear` AS `raceYear`,`tbcompetition`.`country` AS `country`,min(`country`.`alpha-2`) AS `alpha-2`,`tbcompetition`.`raceYearNum` AS `raceYearNum`,`tbcompetition`.`latitude` AS `latitude`,`tbcompetition`.`longitude` AS `longitude`,max(`race`.`link`) AS `hasLink` from ((`tbcompetition` left join `vrace` `race` on((`race`.`idCompetition` = `tbcompetition`.`idCompetition`))) join `tbcountry` `country` on((`country`.`name` = convert(`tbcompetition`.`country` using utf8mb4)))) group by `tbcompetition`.`idCompetition` order by `tbcompetition`.`raceYearNum` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vlogdays`
--

/*!50001 DROP VIEW IF EXISTS `vlogdays`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vlogdays` AS select date_format(`tblog`.`timestamp`,'%Y-%m-%d') AS `date`,count(0) AS `calls`,count(distinct `tblog`.`userId`) AS `individuals`,concat(((sum(`tblog`.`isMobile`) / sum(if((`tblog`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,sum(`tblog`.`isMobile`) AS `mobileCalls`,(count(0) / count(distinct `tblog`.`userId`)) AS `calls per individual`,count(distinct `tblog`.`user`) AS `different users online`,(select count(0) from `tbuser` where (date_format(`tbuser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new users`,(select group_concat(`tbuser`.`username` separator ',') from `tbuser` where (date_format(`tbuser`.`rowCreated`,'%Y-%m-%d') = `date`)) AS `new usernames` from `tblog` where (`tblog`.`isDev` = 0) group by `date` order by max(`tblog`.`timestamp`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcccountries`
--

/*!50001 DROP VIEW IF EXISTS `vcccountries`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcccountries` AS select sum(if(((`vall`.`place` between 1 and 3) and (`vall`.`discipline` like '%short mass%')),1,0)) AS `short mass`,sum(if(((`vall`.`place` between 1 and 3) and (`vall`.`discipline` like 'short')),1,0)) AS `short`,sum(if(((`vall`.`place` between 1 and 3) and (`vall`.`discipline` like '%short%')),1,0)) AS `short total`,sum(if(((`vall`.`place` between 1 and 3) and (`vall`.`discipline` like '%long%')),1,0)) AS `long`,group_concat(if((`vall`.`place` between 1 and 3),concat(`vall`.`fullname`,' in ',`vall`.`distance`,', '),''),'' separator '') AS `long athletes`,`vall`.`country` AS `country` from `vall` where ((`vall`.`type` like 'WM') and (`vall`.`category` like 'Junior') and (`vall`.`raceYear` > '2014') and (`vall`.`trackStreet` like 'Track') and (not((`vall`.`distance` like '%Mixed%'))) and (not((`vall`.`distance` like '%Team%'))) and (not((`vall`.`distance` like '%Relay%')))) group by `vall`.`country` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vloghours`
--

/*!50001 DROP VIEW IF EXISTS `vloghours`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vloghours` AS select concat(year(`tblog`.`timestamp`),'-',month(`tblog`.`timestamp`),'-',dayofmonth(`tblog`.`timestamp`),':',hour(`tblog`.`timestamp`)) AS `dateTime`,count(0) AS `calls`,count(distinct `tblog`.`userId`) AS `individuals`,(count(0) / count(distinct `tblog`.`userId`)) AS `calls per individual` from `tblog` where (`tblog`.`isDev` = 0) group by `dateTime` order by max(`tblog`.`timestamp`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vathlete`
--

/*!50001 DROP VIEW IF EXISTS `vathlete`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vathlete` AS select `tbathlete`.`id` AS `idAthlete`,`tbathlete`.`lastname` AS `lastname`,`tbathlete`.`firstname` AS `firstname`,`tbathlete`.`gender` AS `gender`,`tbathlete`.`country` AS `country`,`tbathlete`.`linkCollection` AS `linkCollection`,`tbathlete`.`mail` AS `mail`,`tbathlete`.`comment` AS `comment`,`tbathlete`.`club` AS `club`,`tbathlete`.`team` AS `team`,`tbathlete`.`image` AS `image`,`tbathlete`.`birthYear` AS `birthYear`,`tbathlete`.`LVKuerzel` AS `LVKuerzel`,`tbathlete`.`source` AS `source`,`tbathlete`.`birthdate` AS `birthdate`,`tbathlete`.`remark` AS `remark`,`tbathlete`.`license` AS `license`,`tbathlete`.`facebook` AS `facebook`,`tbathlete`.`instagram` AS `instagram`,`tbathlete`.`isPlaceholder` AS `isPlaceholder`,`tbathlete`.`score` AS `score`,`tbathlete`.`scoreShort` AS `scoreShort`,`tbathlete`.`scoreLong` AS `scoreLong`,`tbathlete`.`bronze` AS `bronze`,`tbathlete`.`silver` AS `silver`,`tbathlete`.`gold` AS `gold`,`tbathlete`.`topTen` AS `topTen`,`tbathlete`.`medalScore` AS `medalScore`,`tbathlete`.`raceCount` AS `raceCount`,`tbathlete`.`minAge` AS `minAge`,`tbathlete`.`bestDistance` AS `bestDistance`,`tbathlete`.`checked` AS `checked`,`tbathlete`.`creator` AS `creator` from `tbathlete` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vdublicates`
--

/*!50001 DROP VIEW IF EXISTS `vdublicates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vdublicates` AS select `vall`.`raceYear` AS `raceYear`,`vall`.`type` AS `type`,`vall`.`location` AS `location`,`vall`.`country` AS `country`,`vall`.`relay` AS `relay`,`vall`.`category` AS `category`,`vall`.`gender` AS `gender`,`vall`.`distance` AS `distance`,`vall`.`firstname` AS `firstname`,`vall`.`lastname` AS `lastname`,`vall`.`trackStreet` AS `trackStreet`,count(0) AS `count` from `vall` group by `vall`.`raceYear`,`vall`.`type`,`vall`.`location`,`vall`.`country`,`vall`.`relay`,`vall`.`category`,`vall`.`gender`,`vall`.`distance`,`vall`.`firstname`,`vall`.`lastname`,`vall`.`trackStreet` having (count(0) > 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vlognodev`
--

/*!50001 DROP VIEW IF EXISTS `vlognodev`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vlognodev` AS select `tblog`.`idTbLog` AS `idTbLog`,`tblog`.`userId` AS `userId`,`tblog`.`from` AS `from`,`tblog`.`to` AS `to`,`tblog`.`ip` AS `ip`,`tblog`.`location` AS `location`,`tblog`.`timestamp` AS `timestamp`,`tblog`.`device` AS `device`,`tblog`.`isDev` AS `isDev`,`tblog`.`user` AS `user`,`tblog`.`isMobile` AS `isMobile` from `tblog` where (`tblog`.`isDev` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vathletecalc_old`
--

/*!50001 DROP VIEW IF EXISTS `vathletecalc_old`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vathletecalc_old` AS select `athlete`.`id` AS `idAthlete`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` < 11),1,0),0)) AS `topTen`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 3),1,0),0)) AS `bronze`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 2),1,0),0)) AS `silver`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` = 1),1,0),0)) AS `gold`,sum(if((`comp`.`type` = `TYPEWM`()),if((`result`.`place` < 4),(4 - `result`.`place`),0),0)) AS `medalScore`,sum(if((`comp`.`type` = `TYPEWM`()),`GETSCORE`(`result`.`place`),0)) AS `score`,sum(if(((`comp`.`type` = `TYPEWM`()) and (`race`.`discipline` like '%short%')),`GETSCORE`(`result`.`place`),0)) AS `scoreShort`,sum(if(((`comp`.`type` = `TYPEWM`()) and (`race`.`discipline` like '%lon%')),`GETSCORE`(`result`.`place`),0)) AS `scoreLong`,ifnull(find_in_set(round(`athlete`.`score`,6),(select group_concat(round(`at1`.`score`,6) order by `at1`.`score` DESC separator ',') from `tbathlete` `at1`)),1000000) AS `rank`,ifnull(find_in_set(round(`athlete`.`scoreShort`,6),(select group_concat(round(`at1`.`scoreShort`,6) order by `at1`.`scoreShort` DESC separator ',') from `tbathlete` `at1`)),1000000) AS `rankShort`,ifnull(find_in_set(round(`athlete`.`scoreLong`,6),(select group_concat(round(`at1`.`scoreLong`,6) order by `at1`.`scoreLong` DESC separator ',') from `tbathlete` `at1`)),1000000) AS `rankLong`,count(0) AS `raceCount`,(select `abc`.`distance` from (select sum(`GETSCORE`(`res1`.`place`)) AS `raceScore`,`race1`.`distance` AS `distance` from ((`tbathlete` `athlete1` join `tbresult` `res1` on((`res1`.`idPerson` = `athlete1`.`id`))) join `tbrace` `race1` on((`race1`.`id` = `res1`.`idRace`))) where (`athlete1`.`id` = `athlete`.`id`) group by `race1`.`id` order by `raceScore` desc) `abc` limit 1) AS `bestDistance` from (((`tbathlete` `athlete` left join `tbresult` `result` on((`result`.`idPerson` = `athlete`.`id`))) left join `tbrace` `race` on((`result`.`idRace` = `race`.`id`))) left join `tbcompetition` `comp` on((`race`.`idCompetition` = `comp`.`idCompetition`))) where (`result`.`idPerson` between 1136 and 1200) group by `athlete`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vuser`
--

/*!50001 DROP VIEW IF EXISTS `vuser`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vuser` AS select `tbuser`.`iduser` AS `idUser`,`tbuser`.`username` AS `username`,`tbuser`.`email` AS `email`,`tbuser`.`image` AS `image`,`tbuser`.`idrole` AS `idRole`,`tbuser`.`registerCountry` AS `registerCountry`,`tbuser`.`athlete` AS `athlete`,`tbuser`.`athleteChecked` AS `athleteChecked`,`tbuser`.`rowCreated` AS `rowCreated`,count(0) AS `calls` from (`tbuser` join `tblog` on((`tblog`.`user` = `tbuser`.`iduser`))) group by `tbuser`.`iduser` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcompathletemedals`
--

/*!50001 DROP VIEW IF EXISTS `vcompathletemedals`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcompathletemedals` AS select `comp`.`idCompetition` AS `idCompetition`,`athlete`.`idAthlete` AS `idAthlete`,`athlete`.`firstname` AS `firstName`,concat(`athlete`.`firstname`,' ',`athlete`.`lastname`) AS `fullname`,`athlete`.`lastname` AS `lastName`,`athlete`.`country` AS `country`,`athlete`.`image` AS `image`,`athlete`.`gender` AS `gender`,sum((case when (`res`.`place` = 1) then 1 end)) AS `gold`,sum((case when (`res`.`place` = 2) then 1 end)) AS `silver`,sum((case when (`res`.`place` = 3) then 1 end)) AS `bronze`,sum((case when (`res`.`place` = 1) then 3 when (`res`.`place` = 2) then 2 when (`res`.`place` = 3) then 1 end)) AS `medalScore` from (((`vresult` `res` join `vrace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vathlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vcompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `athlete`.`idAthlete`,`comp`.`idCompetition` order by `gold` desc,`silver` desc,`bronze` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vresult`
--

/*!50001 DROP VIEW IF EXISTS `vresult`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vresult` AS select `tbresult`.`id` AS `idResult`,`tbresult`.`timeDate` AS `time`,`tbresult`.`idPerson` AS `idPerson`,`tbresult`.`idRace` AS `idRace`,`tbresult`.`place` AS `place` from `tbresult` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vworldmovement`
--

/*!50001 DROP VIEW IF EXISTS `vworldmovement`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vworldmovement` AS select `comp`.`idCompetition` AS `idCompetition`,group_concat(distinct `athlete`.`fullname` separator ',') AS `athleteNames`,group_concat(distinct `athlete`.`idAthlete` separator ',') AS `athleteIds`,ifnull(convert(`comp`.`startDate` using utf32),convert(concat(`comp`.`raceYear`,'-01-01 00:00:00') using utf32)) AS `date`,`compcountry`.`alpha-3` AS `competitionCountry`,`compcountry`.`name` AS `competitionCountryName`,`comp`.`type` AS `competitionType`,`comp`.`location` AS `competitionLocation`,sum((case when (`res`.`place` = 1) then 1 else 0 end)) AS `gold`,sum((case when (`res`.`place` = 2) then 1 else 0 end)) AS `silver`,sum((case when (`res`.`place` = 3) then 1 else 0 end)) AS `bronze`,ifnull(`comp`.`latitude`,`compcountry`.`latitude`) AS `compLatitude`,ifnull(`comp`.`longitude`,`compcountry`.`longitude`) AS `compLongitude`,`athletecountry`.`alpha-3` AS `athleteCountry`,`athletecountry`.`name` AS `athleteCountryName`,`athletecountry`.`radius` AS `athleteCountryRadius`,`athletecountry`.`color` AS `athleteCountryColor`,`athletecountry`.`latitude` AS `athleteLatitude`,`athletecountry`.`longitude` AS `athleteLongitude`,count(distinct `athlete`.`idAthlete`) AS `athleteCount` from (((((`vresult` `res` join `vathletepublic` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vrace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vcompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) join `tbcountry` `compcountry` on((`compcountry`.`name` = convert(`comp`.`country` using utf8mb4)))) join `tbcountry` `athletecountry` on((`athletecountry`.`name` = `athlete`.`country`))) group by `comp`.`idCompetition`,`date`,`competitionCountry`,`athleteCountry` order by `date` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcountry`
--

/*!50001 DROP VIEW IF EXISTS `vcountry`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcountry` AS select `vathlete`.`country` AS `country`,count(0) AS `members`,sum(`vathlete`.`medalScore`) AS `medalScore`,sum(`vathlete`.`gold`) AS `gold`,sum(`vathlete`.`silver`) AS `silver`,sum(`vathlete`.`bronze`) AS `bronze`,sum(`vathlete`.`topTen`) AS `topTen`,sum(`vathlete`.`raceCount`) AS `raceCount`,sum(`vathlete`.`score`) AS `score`,sum(`vathlete`.`scoreShort`) AS `scoreShort`,sum(`vathlete`.`scoreLong`) AS `scoreLong`,(select count(0) from `vcompetitionsmall` where (`vcompetitionsmall`.`country` = convert(`vathlete`.`country` using utf32))) AS `copmetitionCount` from `vathlete` group by `vathlete`.`country` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vall`
--

/*!50001 DROP VIEW IF EXISTS `vall`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vall` AS select `comp`.`raceYear` AS `raceYear`,`comp`.`location` AS `location`,`comp`.`type` AS `type`,`comp`.`startDate` AS `startDate`,`comp`.`endDate` AS `endDate`,`athlete`.`country` AS `country`,`race`.`relay` AS `relay`,`race`.`distance` AS `distance`,`race`.`category` AS `category`,`race`.`gender` AS `gender`,`race`.`link` AS `link`,`race`.`discipline` AS `discipline`,`race`.`trackStreet` AS `trackStreet`,`res`.`place` AS `place`,`res`.`time` AS `time`,`athlete`.`firstname` AS `firstname`,`athlete`.`lastname` AS `lastname`,concat(`athlete`.`firstname`,' ',`athlete`.`lastname`) AS `fullname`,`athlete`.`idAthlete` AS `idAthlete`,`comp`.`idCompetition` AS `idCompetition`,`race`.`idRace` AS `idRace`,`res`.`idResult` AS `idResult` from (((`vresult` `res` join `vrace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vathlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vcompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vathletepublic`
--

/*!50001 DROP VIEW IF EXISTS `vathletepublic`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vathletepublic` AS select `tbathlete`.`id` AS `idAthlete`,`tbathlete`.`lastname` AS `lastname`,`tbathlete`.`firstname` AS `firstname`,`tbathlete`.`gender` AS `gender`,`tbathlete`.`country` AS `country`,`tbathlete`.`comment` AS `comment`,`tbathlete`.`club` AS `club`,`tbathlete`.`team` AS `team`,`tbathlete`.`image` AS `image`,`tbathlete`.`birthYear` AS `birthYear`,`tbathlete`.`facebook` AS `facebook`,`tbathlete`.`instagram` AS `instagram`,`tbathlete`.`minAge` AS `minAge`,`tbathlete`.`raceCount` AS `raceCount`,concat(`tbathlete`.`firstname`,' ',`tbathlete`.`lastname`) AS `fullname` from `tbathlete` where (`tbathlete`.`raceCount` > 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vathletenew`
--

/*!50001 DROP VIEW IF EXISTS `vathletenew`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vathletenew` AS select `athlete`.`id` AS `idAthlete`,`athlete`.`lastname` AS `lastname`,`athlete`.`firstname` AS `firstname`,`athlete`.`gender` AS `gender`,`athlete`.`country` AS `country`,`athlete`.`linkCollection` AS `linkCollection`,`athlete`.`comment` AS `comment`,`athlete`.`club` AS `club`,`athlete`.`team` AS `team`,`athlete`.`image` AS `image`,`athlete`.`birthYear` AS `birthYear`,`athlete`.`LVKuerzel` AS `LVKuerzel`,`athlete`.`source` AS `source`,`athlete`.`remark` AS `remark`,`athlete`.`license` AS `license`,`athlete`.`facebook` AS `facebook`,`athlete`.`instagram` AS `instagram`,`athlete`.`isPlaceholder` AS `isPlaceholder`,`athlete`.`bestDistance` AS `bestDistance`,sum(if(((`res`.`place` = 1) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `goldMedals`,sum(if(((`res`.`place` = 2) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `silverMedals`,sum(if(((`res`.`place` = 3) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),1,0)) AS `bronzeMedals`,sum(if(((`res`.`place` <= 3) and (0 <> find_in_set(`comp`.`type`,'WM,EM'))),(4 - `res`.`place`),0)) AS `medalScore`,count(0) AS `raceCount` from (((`tbathlete` `athlete` join `tbresult` `res` on((`res`.`idPerson` = `athlete`.`id`))) join `tbrace` `race` on((`race`.`id` = `res`.`idRace`))) join `tbcompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `athlete`.`id` order by `medalScore` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcompcountrymedals`
--

/*!50001 DROP VIEW IF EXISTS `vcompcountrymedals`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcompcountrymedals` AS select `comp`.`idCompetition` AS `idCompetition`,`athlete`.`country` AS `country`,ceiling(sum((case when (`res`.`place` = 1) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `gold`,ceiling(sum((case when (`res`.`place` = 2) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `silver`,ceiling(sum((case when (`res`.`place` = 3) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `bronze`,ceiling(sum((case when (`res`.`place` = 1) then if((`race`.`distance` like '%relay%'),0.333333,1) when (`res`.`place` = 2) then if((`race`.`distance` like '%relay%'),0.333333,1) when (`res`.`place` = 3) then if((`race`.`distance` like '%relay%'),0.333333,1) end))) AS `medalScore` from (((`vresult` `res` join `vrace` `race` on((`race`.`idRace` = `res`.`idRace`))) join `vathlete` `athlete` on((`athlete`.`idAthlete` = `res`.`idPerson`))) join `vcompetition` `comp` on((`comp`.`idCompetition` = `race`.`idCompetition`))) group by `comp`.`idCompetition`,`athlete`.`country` order by `gold` desc,`silver` desc,`bronze` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vcompetitionsmall`
--

/*!50001 DROP VIEW IF EXISTS `vcompetitionsmall`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vcompetitionsmall` AS select `tbcompetition`.`idCompetition` AS `idCompetition`,`tbcompetition`.`location` AS `location`,`tbcompetition`.`type` AS `type`,`tbcompetition`.`raceYear` AS `raceYear`,`tbcompetition`.`country` AS `country`,`tbcompetition`.`raceYearNum` AS `raceYearNum` from `tbcompetition` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vsiteviews`
--

/*!50001 DROP VIEW IF EXISTS `vsiteviews`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`timo`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `vsiteviews` AS select count(0) AS `calls`,substr(`vlognodev`.`to`,(locate('roller-results.com',`vlognodev`.`to`) + 18),100) AS `page`,concat(((sum(`vlognodev`.`isMobile`) / sum(if((`vlognodev`.`isMobile` is null),0,1))) * 100),'%') AS `mobile`,min(`vlognodev`.`timestamp`) AS `firstCall`,max(`vlognodev`.`timestamp`) AS `lastCall` from `vlognodev` where (`vlognodev`.`to` like '%roller-results.com%') group by `page` order by `calls` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Dumping events for database 'results'
--


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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_athleteCareer`(IN in_idAthlete INT, IN in_compSet TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_athleteFull`(IN in_idSet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_athletePrivateFull`(IN in_idSet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_checkCompetitionAndBelow`(IN in_idCompetition INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_countryCareer`(IN in_country varchar(200), IN in_compSet TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_countryCareerNew`(IN in_country varchar(200), IN in_comps TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_countryCareerSimple`(IN in_country varchar(200), IN in_compSet TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_deleteCompetition`(IN in_idCompetition INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_deleteRace`(IN in_idRace INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_doublicateAthleteNames`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthleteBestTimes`(IN in_idAthlete INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthleteCompetitions`(IN in_id INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthleteNew`(IN in_idAthlete INT, IN in_comps char(200))
BEGIN

CASE WHEN
	(SELECT count(*) FROM
		(((`TbAthlete` `athlete`
        JOIN `TbResult` `res` ON ((`res`.`idPerson` = `athlete`.`id`)))
        JOIN `TbRace` `race` ON ((`race`.`id` = `res`.`idRace`)))
        JOIN `TbCompetition` `comp` ON ((`comp`.`idCompetition` = `race`.`idCompetition`)))
		where athlete.id = in_idAthlete AND find_in_set(comp.type, in_comps)) = 0
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthleteRacesFromCompetition`(IN in_person INT, IN in_competition INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthletes`(distances_in TEXT, comps_in TEXT, gender_in TEXT, categories_in TEXT, discipline_in TEXT, minPlace_in INT, maxPlace_in INT, locations_in TEXT, fromDate_in DATE, toDate_in DATE, ids_in TEXT, `limit_in` INT, countries_in TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthletesNew`(IN in_comps  char(200), IN in_limit INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getAthleteVideos`(IN in_idAthlete INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCompAthleteMedals`(IN in_idComp INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCompCountryMedals`(IN in_idComp INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCompetitionsNew`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCompNew`(IN in_idComp INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountries`(IN in_countrySet TEXT, IN in_compSet TEXT, IN in_medalTypes TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountriesNew`(IN in_comps char(200))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryAthletes`(IN in_country varchar(130), IN in_compSet TEXT, IN in_medalTypes TEXT, IN in_limit INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryAthletesNew`(IN in_country char(200), IN in_comps char(200))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryBestTimes`(IN in_country varchar(200))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryCompetitions`(IN in_country varchar(100))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryNew`(IN in_country char(200))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getCountryRacesFromCompetition`(IN in_country varchar(200), IN in_competition INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getRaceNew`(IN in_idRace INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getRaceResults`(IN in_idRace INT)
BEGIN
SELECT
result.*

,athlete.*
#,race.*
#,comp.*

FROM vResult as result
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getRaceResultsNew`(IN in_idRace INT, IN in_comps char(200))
BEGIN
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
            ) AND find_in_set(comp.type, in_comps) OR res.idRace = in_idRace
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getRacesFromCompetition`(IN in_id INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_getRacesFromCompetitionNew`(IN in_id INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_hallOfFame`(IN in_compSet TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_moveAthlete`(IN deleteId INT, IN in_toId INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_namesToTitleCase`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_prozent_of_belegt_country`(IN in_place INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchAthlete`(IN IN_firstName TEXT, IN IN_lastName TEXT, IN IN_gender TEXT, IN IN_country TEXT, IN IN_alias TEXT, IN IN_aliasGroup TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchCompetitionLocation`(IN in_name varchar(500))
BEGIN
SELECT 
/**idCompetition,
`type`,
location,
raceYear*/
*
FROM TbCompetition WHERE location LIKE concat("%",in_name,"%") OR country LIKE concat("%",in_name,"%")
ORDER BY startDate DESC;
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchCompetitionType`(IN in_type varchar(500))
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchCountry`(IN in_name varchar(500))
BEGIN
SELECT country
FROM TbAthlete

GROUP BY country
HAVING country LIKE CONCAT("%", in_name, "%");
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchPerson`(IN in_name varchar(500))
BEGIN
SELECT
*
FROM vAthlete WHERE CONCAT(lastname, " ",  firstname) LIKE CONCAT("%", in_name, "%") OR CONCAT(firstname, " ",  lastname) LIKE CONCAT("%", in_name, "%")
ORDER BY score desc;
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchTeams`(IN in_team TEXT)
BEGIN
SELECT * FROM TbTeam WHERE `name` LIKE CONCAT(in_team, "%");
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_searchYear`(IN in_year INT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_selectResultDublicates`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_teamAdvantage`(distance_in TEXT, maxPlace INT, competitions_in TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_teamAdvantageDetails`(distance_in TEXT, maxPlace INT, competitions_in TEXT)
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_update`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_updateCategory`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_updateRaceCount`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_updateRaceDisciplines`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_updateSkateType`()
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
CREATE DEFINER=`timo`@`%` PROCEDURE `sp_updateTimes`()
BEGIN
update TbResult set timeDate = str_to_date(zeit_Kon, "%H:%i:%s,%f") where timeDate IS NULl and zeit_Kon is not null;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-30 13:47:50
