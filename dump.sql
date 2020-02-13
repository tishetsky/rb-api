-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: rosberry
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `avatars`
--

DROP TABLE IF EXISTS `avatars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avatars` (
  `user_id` char(36) COLLATE utf8_bin NOT NULL,
  `content` blob NOT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `avatars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatars`
--

LOCK TABLES `avatars` WRITE;
/*!40000 ALTER TABLE `avatars` DISABLE KEYS */;
/*!40000 ALTER TABLE `avatars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interests`
--

DROP TABLE IF EXISTS `interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `interest_id` char(36) COLLATE utf8_bin NOT NULL,
  `name` char(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `interest_id` (`interest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interests`
--

LOCK TABLES `interests` WRITE;
/*!40000 ALTER TABLE `interests` DISABLE KEYS */;
/*!40000 ALTER TABLE `interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) COLLATE utf8_bin NOT NULL,
  `username` char(255) COLLATE utf8_bin NOT NULL,
  `password` char(64) COLLATE utf8_bin NOT NULL,
  `name` char(255) COLLATE utf8_bin DEFAULT NULL,
  `age` int(10) unsigned DEFAULT NULL,
  `last_auth` datetime DEFAULT NULL,
  `auth_token` char(100) COLLATE utf8_bin DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `country` char(2) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (13,'120fc4da-4e44-11ea-9eae-000c294454d3','google.com@mail.ru','a8bf93c515b7f44b315f47104d818eb4af549340e1129fae17f873d7675f587a',NULL,NULL,'2020-02-13 15:34:55','0eb835286c959c119be8981f380a8a59fbba0526af5b160179910be93fe2cb69',NULL,NULL,NULL),(14,'52ce1ca4-4e48-11ea-9eae-000c294454d3','google.com@yandex.ru','a8bf93c515b7f44b315f47104d818eb4af549340e1129fae17f873d7675f587a','Mike Tishetsky',35,'2020-02-13 18:14:12','1a79e56feb9395a67f1afc2ef6fee456c3871aaf6a28e1131378ea26cf8e8b9a',NULL,NULL,NULL),(15,'a17c1845-4e5c-11ea-9eae-000c294454d3','test@asdasd','2c6dfc50c35bba695827757e7b3a9c2aee2d4f960b8b61b844a34a7e38f80907','Belt Killer',NULL,'2020-02-13 18:30:50','17a90b60b0c8c121ddf12cb25471f4186574b088b57b03e5493f94bb6eee326e',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_interests`
--

DROP TABLE IF EXISTS `users_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_interests` (
  `user_id` char(36) COLLATE utf8_bin NOT NULL,
  `interest_id` char(36) COLLATE utf8_bin NOT NULL,
  `value` tinyint(3) unsigned NOT NULL,
  KEY `user_id_interest_id` (`user_id`,`interest_id`),
  KEY `interest_id_user_id` (`interest_id`,`user_id`),
  CONSTRAINT `users_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_interests_ibfk_2` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_interests`
--

LOCK TABLES `users_interests` WRITE;
/*!40000 ALTER TABLE `users_interests` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_interests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-13 18:44:58
