-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for event_management
DROP
DATABASE IF EXISTS `event_management`;
CREATE
DATABASE IF NOT EXISTS `event_management` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE
`event_management`;

-- Dumping structure for table event_management.events
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events`
(
    `uuid`
    varchar
(
    100
) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `name` varchar
(
    100
) NOT NULL,
    `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `capacity` int NOT NULL,
    `event_date_time` datetime NOT NULL,
    `created_at` date NOT NULL DEFAULT '2025-02-01',
    `updated_at` date NOT NULL DEFAULT '2025-02-01',
    `location` varchar
(
    50
) NOT NULL DEFAULT 'DHAKA',
    `spot_left` int DEFAULT NULL,
    PRIMARY KEY
(
    `uuid`
)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_0900_ai_ci;

-- Dumping data for table event_management.events: ~3 rows (approximately)
DELETE
FROM `events`;
INSERT INTO `events` (`uuid`, `name`, `description`, `capacity`, `event_date_time`, `created_at`, `updated_at`,
                      `location`, `spot_left`)
VALUES ('044ec849-1ada-41f8-93a1-4c4c70edf4b2', 'Independence Day',
        'Independence Day is commonly associated with parades, political speeches, fairs, concerts, ceremonies, and various other public and private events celebrating the history and traditions of Bangladesh. TV and radio stations broadcast special programs and patriotic songs in honor of Independence Day. A thirty-one gun salute may be conducted in the morning.[12] The main streets are decorated with national flags. Different political parties and socioeconomic organizations undertake programs to mark the day in a befitting manner, including paying respects at National Martyrs\' Memorial at Savar near Dhaka.[12]', 100, '2025-12-16 00:00:00', '2025-01-26', '2025-01-26', 'DHAKA', 12),
	('4fc0f60a-0349-41fe-9de7-c9f1cf4979c7', 'May Day', '1st may', 100, '2025-02-01 00:00:00', '2025-02-01', '2025-02-01', 'DHAKA', 13),
	('a2e7649e-bfdb-4882-ae2d-8718deb0ba3f', 'Victory Day', 'Victory Day', 10, '2025-02-01 00:00:00', '2025-02-01', '2025-02-01', 'DHAKA', 23);

-- Dumping structure for table event_management.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uuid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `event_uuid` varchar(100) DEFAULT NULL,
  `going` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `users_unique` (`email`),
  KEY `event_uuid` (`event_uuid`),
  CONSTRAINT `event_uuid` FOREIGN KEY (`event_uuid`) REFERENCES `events` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table event_management.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`uuid`, `name`, `password`, `email`, `role`, `event_uuid`, event_status) VALUES
	('523f6434-cc03-4593-ba30-12fb8c22b120', 'attendee', '$2y$10$9RjKbZ5bt/VDEsFnSaDCxeJ0fVkQkivC4RC1mr62QOsDwzhP85oTO', 'attendee@gmail.com', 'attendee', NULL, NULL),
	('d7aafdf1-16b1-474e-8021-5e4ae3371926', 'mahabub', '$2y$10$GWEx2Hr0srWJ6sLiEGVpguY4dhVyG4MCof0.cX3f/aMk7E5mooz1a', 'admin@gmail.com', 'attendee', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
