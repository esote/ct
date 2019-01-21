-- MySQL dump 10.16  Distrib 10.2.19-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ct
-- ------------------------------------------------------
-- Server version	10.2.19-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `class_id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` text COLLATE utf8_unicode_ci NOT NULL,
  `required` enum('y','n') COLLATE utf8_unicode_ci NOT NULL,
  `required_id` int(3) DEFAULT NULL,
  `hs_terms` int(3) NOT NULL,
  `college_credits` int(3) DEFAULT NULL,
  `area` enum('Health','Art','Business Education','Career Education','Computer Education','FCS','Technology Education','Language Arts','Mathematics','PE','Science','Social Studies','World Languages','Other','Theatre','Music') COLLATE utf8_unicode_ci NOT NULL,
  `college_class` enum('y','n') COLLATE utf8_unicode_ci NOT NULL,
  `ap_class` enum('y','n') COLLATE utf8_unicode_ci NOT NULL,
  `archived` enum('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `credit_reqs`
--

DROP TABLE IF EXISTS `credit_reqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credit_reqs` (
  `req_id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `area` enum('Total','Electives','Art','Business Education','Career Education','Computer Education','FCS','Technology Education','Health','Language Arts','Mathematics','PE','Science','Social Studies','World Languages','Other','Theatre','Music') COLLATE utf8_unicode_ci NOT NULL,
  `total_req` int(3) DEFAULT NULL,
  `hexcolor` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`req_id`),
  UNIQUE KEY `area` (`area`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credit_reqs`
--

LOCK TABLES `credit_reqs` WRITE;
/*!40000 ALTER TABLE `credit_reqs` DISABLE KEYS */;
INSERT INTO `credit_reqs` VALUES (1,'Language Arts',8,'#008000'),(2,'Mathematics',7,'#000000'),(3,'Science',6,'#0000ff'),(4,'Social Studies',6,'#800080'),(5,'Health',1,'#ff4d6a'),(6,'PE',4,'#996633'),(7,'Electives',21,'#1fc3a1'),(8,'Total',53,'');
/*!40000 ALTER TABLE `credit_reqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc_info`
--

DROP TABLE IF EXISTS `misc_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc_info` (
  `misc_id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `value` int(30) DEFAULT NULL,
  PRIMARY KEY (`misc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misc_info`
--

LOCK TABLES `misc_info` WRITE;
/*!40000 ALTER TABLE `misc_info` DISABLE KEYS */;
INSERT INTO `misc_info` VALUES (1,'credits_per_year',16),(2,'years',4);
/*!40000 ALTER TABLE `misc_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relation`
--

DROP TABLE IF EXISTS `relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relation` (
  `user_id` bigint(15) unsigned NOT NULL,
  `class_id` bigint(15) unsigned NOT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `fname` text COLLATE utf8_unicode_ci NOT NULL,
  `lname` text COLLATE utf8_unicode_ci NOT NULL,
  `nickname` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `grad_date` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `counselor` enum('y','n') COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_login` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

