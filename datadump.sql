-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: event_management
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `event_users`
--

DROP TABLE IF EXISTS `event_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_users` (
  `uuid` varchar(100) NOT NULL,
  `user_uuid` varchar(100) NOT NULL,
  `event_uuid` varchar(100) NOT NULL,
  `event_status` enum('GOING','NOTGOING','INTERESTED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_users`
--

LOCK TABLES `event_users` WRITE;
/*!40000 ALTER TABLE `event_users` DISABLE KEYS */;
INSERT INTO `event_users` VALUES ('c30a14e5-b622-46e9-a812-d3669f60260c','523f6434-cc03-4593-ba30-12fb8c22b120','044ec849-1ada-41f8-93a1-4c4c70edf4b2','NOTGOING'),('c5ea8fd2-28e2-4609-afa6-495160189d27','523f6434-cc03-4593-ba30-12fb8c22b120','4fc0f60a-0349-41fe-9de7-c9f1cf4979c7','GOING'),('1ed22d22-91f5-464c-8dcc-b46035386edc','523f6434-cc03-4593-ba30-12fb8c22b120','a2e7649e-bfdb-4882-ae2d-8718deb0ba3f','INTERESTED'),('c30a14e5-b622-46e9-a812-d3669f60260d','d7aafdf1-16b1-474e-8021-5e4ae3371926','044ec849-1ada-41f8-93a1-4c4c70edf4b2','GOING');
/*!40000 ALTER TABLE `event_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `capacity` int NOT NULL,
  `event_date_time` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2025-02-01 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '2025-02-01 00:00:00',
  `location` varchar(50) NOT NULL DEFAULT 'DHAKA',
  `spot_left` int DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES ('044ec849-1ada-41f8-93a1-4c4c70edf4b2','Independence Day','',100,'2025-03-26 00:00:00','2025-01-26 00:00:00','2025-01-26 00:00:00','DHAKA',12),('4fc0f60a-0349-41fe-9de7-c9f1cf4979c7','May Day','',100,'2025-05-01 00:00:00','2025-02-01 00:00:00','2025-02-01 00:00:00','DHAKA',13),('a2e7649e-bfdb-4882-ae2d-8718deb0ba3f','Victory Day','',10,'2025-12-16 00:00:00','2025-02-01 00:00:00','2025-02-01 00:00:00','DHAKA',23);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `uuid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `users_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('523f6434-cc03-4593-ba30-12fb8c22b120','attendee','$2y$10$9RjKbZ5bt/VDEsFnSaDCxeJ0fVkQkivC4RC1mr62QOsDwzhP85oTO','attendee@gmail.com','attendee'),('d7aafdf1-16b1-474e-8021-5e4ae3371926','mahabub','$2y$10$GWEx2Hr0srWJ6sLiEGVpguY4dhVyG4MCof0.cX3f/aMk7E5mooz1a','admin@gmail.com','admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-28 18:28:57
