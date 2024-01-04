/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `alarm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alarm` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_start` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` json DEFAULT NULL,
  `telegram` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alarm_user_fk` (`user_id`),
  CONSTRAINT `alarm_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `alarm_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alarm_notification` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` json DEFAULT NULL,
  `point` point NOT NULL /*!80003 SRID 4326 */,
  `telegram` tinyint(1) NOT NULL DEFAULT '0',
  `date_at` datetime NOT NULL,
  `date_utc_at` datetime NOT NULL,
  `closed_at` datetime DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alarm_id` bigint unsigned DEFAULT NULL,
  `position_id` bigint unsigned DEFAULT NULL,
  `trip_id` bigint unsigned DEFAULT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `latitude` double GENERATED ALWAYS AS (round(st_latitude(`point`),5)) STORED,
  `longitude` double GENERATED ALWAYS AS (round(st_longitude(`point`),5)) STORED,
  PRIMARY KEY (`id`),
  SPATIAL KEY `alarm_notification_point_spatialindex` (`point`),
  KEY `alarm_notification_latitude_index` (`latitude`),
  KEY `alarm_notification_longitude_index` (`longitude`),
  KEY `alarm_notification_alarm_fk` (`alarm_id`),
  KEY `alarm_notification_position_fk` (`position_id`),
  KEY `alarm_notification_trip_fk` (`trip_id`),
  KEY `alarm_notification_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `alarm_notification_alarm_fk` FOREIGN KEY (`alarm_id`) REFERENCES `alarm` (`id`) ON DELETE SET NULL,
  CONSTRAINT `alarm_notification_position_fk` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE SET NULL,
  CONSTRAINT `alarm_notification_trip_fk` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON DELETE SET NULL,
  CONSTRAINT `alarm_notification_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `alarm_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alarm_vehicle` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alarm_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alarm_vehicle_alarm_fk` (`alarm_id`),
  KEY `alarm_vehicle_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `alarm_vehicle_alarm_fk` FOREIGN KEY (`alarm_id`) REFERENCES `alarm` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alarm_vehicle_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` json DEFAULT NULL,
  `point` point NOT NULL /*!80003 SRID 4326 */,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `country_id` bigint unsigned NOT NULL,
  `state_id` bigint unsigned NOT NULL,
  `latitude` double GENERATED ALWAYS AS (round(st_latitude(`point`),5)) STORED,
  `longitude` double GENERATED ALWAYS AS (round(st_longitude(`point`),5)) STORED,
  PRIMARY KEY (`id`),
  KEY `city_name_index` (`name`),
  SPATIAL KEY `city_point_spatialindex` (`point`),
  KEY `city_latitude_index` (`latitude`),
  KEY `city_longitude_index` (`longitude`),
  KEY `city_country_fk` (`country_id`),
  KEY `city_state_fk` (`state_id`),
  CONSTRAINT `city_country_fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  CONSTRAINT `city_state_fk` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuration` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuration_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` json DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_code_unique` (`code`),
  KEY `country_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '0',
  `shared_public` tinyint(1) NOT NULL DEFAULT '0',
  `connected_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_serial_unique` (`serial`),
  KEY `device_code_index` (`code`),
  KEY `device_name_index` (`name`),
  KEY `device_model_index` (`model`),
  KEY `device_user_fk` (`user_id`),
  KEY `device_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `device_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `device_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `device_alarm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_alarm` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` json DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device_id` bigint unsigned NOT NULL,
  `telegram` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `device_alarm_device_fk` (`device_id`),
  CONSTRAINT `device_alarm_device_fk` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `device_alarm_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_alarm_notification` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` json DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device_id` bigint unsigned NOT NULL,
  `device_alarm_id` bigint unsigned DEFAULT NULL,
  `position_id` bigint unsigned DEFAULT NULL,
  `trip_id` bigint unsigned DEFAULT NULL,
  `telegram` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `device_alarm_notification_device_fk` (`device_id`),
  KEY `device_alarm_notification_position_fk` (`position_id`),
  KEY `device_alarm_notification_trip_fk` (`trip_id`),
  KEY `device_alarm_notification_device_alarm_fk` (`device_alarm_id`),
  CONSTRAINT `device_alarm_notification_device_alarm_fk` FOREIGN KEY (`device_alarm_id`) REFERENCES `device_alarm` (`id`) ON DELETE SET NULL,
  CONSTRAINT `device_alarm_notification_device_fk` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE,
  CONSTRAINT `device_alarm_notification_position_fk` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE SET NULL,
  CONSTRAINT `device_alarm_notification_trip_fk` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `device_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `device_message` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `sent_at` datetime DEFAULT NULL,
  `response_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_message_device_fk` (`device_id`),
  CONSTRAINT `device_message_device_fk` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `related_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `related_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_name_index` (`name`),
  KEY `file_related_table_related_id_index` (`related_table`,`related_id`),
  KEY `file_user_fk` (`user_id`),
  CONSTRAINT `file_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ip_lock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ip_lock` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `end_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ip_lock_ip_index` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language_code_unique` (`code`),
  UNIQUE KEY `language_locale_unique` (`locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workshop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_at` date NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `distance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `distance_next` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenance_name_index` (`name`),
  KEY `maintenance_user_fk` (`user_id`),
  KEY `maintenance_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `maintenance_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maintenance_item_name_user_id_unique` (`name`,`user_id`),
  KEY `maintenance_item_name_index` (`name`),
  KEY `maintenance_item_user_fk` (`user_id`),
  CONSTRAINT `maintenance_item_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance_maintenance_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_maintenance_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quantity` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `amount_gross` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `amount_net` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `tax_percent` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `subtotal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maintenance_id` bigint unsigned NOT NULL,
  `maintenance_item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maintenance_maintenance_i_maintenance_maintenance_item_unique` (`maintenance_id`,`maintenance_item_id`),
  KEY `maintenance_maintenance_item_maintenance_item_fk` (`maintenance_item_id`),
  CONSTRAINT `maintenance_maintenance_item_maintenance_fk` FOREIGN KEY (`maintenance_id`) REFERENCES `maintenance` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_maintenance_item_maintenance_item_fk` FOREIGN KEY (`maintenance_item_id`) REFERENCES `maintenance_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `position` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `point` point NOT NULL /*!80003 SRID 4326 */,
  `speed` decimal(6,2) unsigned NOT NULL,
  `direction` int unsigned NOT NULL,
  `signal` int unsigned NOT NULL,
  `date_at` datetime NOT NULL,
  `date_utc_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_id` bigint unsigned DEFAULT NULL,
  `device_id` bigint unsigned DEFAULT NULL,
  `timezone_id` bigint unsigned NOT NULL,
  `trip_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `latitude` double GENERATED ALWAYS AS (round(st_latitude(`point`),5)) STORED,
  `longitude` double GENERATED ALWAYS AS (round(st_longitude(`point`),5)) STORED,
  PRIMARY KEY (`id`),
  SPATIAL KEY `position_point_spatialindex` (`point`),
  KEY `position_latitude_index` (`latitude`),
  KEY `position_longitude_index` (`longitude`),
  KEY `position_city_fk` (`city_id`),
  KEY `position_timezone_fk` (`timezone_id`),
  KEY `position_vehicle_fk` (`vehicle_id`),
  KEY `position_device_id_date_utc_at_index` (`device_id`,`date_utc_at`),
  KEY `position_trip_id_date_utc_at_index` (`trip_id`,`date_utc_at`),
  KEY `position_user_id_date_utc_at_index` (`user_id`,`date_utc_at`),
  CONSTRAINT `position_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE SET NULL,
  CONSTRAINT `position_device_fk` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE SET NULL,
  CONSTRAINT `position_timezone_fk` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON DELETE CASCADE,
  CONSTRAINT `position_trip_fk` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON DELETE CASCADE,
  CONSTRAINT `position_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `position_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `queue_fail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `queue_fail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `refuel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refuel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `distance_total` decimal(10,2) unsigned NOT NULL,
  `distance` decimal(6,2) unsigned NOT NULL,
  `quantity` decimal(6,2) unsigned NOT NULL,
  `quantity_before` decimal(6,2) unsigned NOT NULL,
  `price` decimal(7,3) unsigned NOT NULL,
  `total` decimal(6,2) unsigned NOT NULL,
  `point` point NOT NULL /*!80003 SRID 4326 */,
  `date_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `city_id` bigint unsigned DEFAULT NULL,
  `position_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  `latitude` double GENERATED ALWAYS AS (round(st_latitude(`point`),5)) STORED,
  `longitude` double GENERATED ALWAYS AS (round(st_longitude(`point`),5)) STORED,
  PRIMARY KEY (`id`),
  SPATIAL KEY `refuel_point_spatialindex` (`point`),
  KEY `refuel_city_fk` (`city_id`),
  KEY `refuel_position_fk` (`position_id`),
  KEY `refuel_user_fk` (`user_id`),
  KEY `refuel_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `refuel_city_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE SET NULL,
  CONSTRAINT `refuel_position_fk` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE SET NULL,
  CONSTRAINT `refuel_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refuel_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `server` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `port` int unsigned NOT NULL DEFAULT '0',
  `protocol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debug` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `state` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` json DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `country_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state_name_index` (`name`),
  KEY `state_country_fk` (`country_id`),
  CONSTRAINT `state_country_fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timezone` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `zone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geojson` multipolygon NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `timezone_zone_index` (`zone`),
  SPATIAL KEY `timezone_geojson_spatialindex` (`geojson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `trip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trip` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` int unsigned NOT NULL DEFAULT '0',
  `time` int unsigned NOT NULL DEFAULT '0',
  `stats` json DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `start_utc_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `end_utc_at` datetime NOT NULL,
  `shared` tinyint(1) NOT NULL DEFAULT '0',
  `shared_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device_id` bigint unsigned DEFAULT NULL,
  `timezone_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `vehicle_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trip_code_index` (`code`),
  KEY `trip_name_index` (`name`),
  KEY `trip_shared_public_shared_device_id_end_utc_at_index` (`shared_public`,`shared`,`device_id`,`end_utc_at`),
  KEY `trip_device_fk` (`device_id`),
  KEY `trip_timezone_fk` (`timezone_id`),
  KEY `trip_user_fk` (`user_id`),
  KEY `trip_vehicle_fk` (`vehicle_id`),
  CONSTRAINT `trip_device_fk` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE SET NULL,
  CONSTRAINT `trip_timezone_fk` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trip_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trip_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  `telegram` json DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `admin_mode` tinyint(1) NOT NULL DEFAULT '0',
  `manager` tinyint(1) NOT NULL DEFAULT '0',
  `manager_mode` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `language_id` bigint unsigned NOT NULL,
  `timezone_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_language_fk` (`language_id`),
  KEY `user_timezone_fk` (`timezone_id`),
  CONSTRAINT `user_language_fk` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_timezone_fk` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_fail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_fail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_fail_type_index` (`type`),
  KEY `user_fail_ip_index` (`ip`),
  KEY `user_fail_user_fk` (`user_id`),
  CONSTRAINT `user_fail_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_session` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `auth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_session_auth_index` (`auth`),
  KEY `user_session_ip_index` (`ip`),
  KEY `user_session_user_fk` (`user_id`),
  CONSTRAINT `user_session_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone_auto` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `timezone_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_name_index` (`name`),
  KEY `vehicle_timezone_fk` (`timezone_id`),
  KEY `vehicle_user_fk` (`user_id`),
  CONSTRAINT `vehicle_timezone_fk` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicle_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2021_01_14_000000_base',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2021_01_14_000001_seed',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2022_10_04_184500_device_password_port',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2022_10_06_183000_trip_distance_time',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2022_10_06_183000_trip_sleep',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2022_10_07_190000_city_state_country',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2022_10_07_193000_position_city',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2022_10_09_233000_device_timezone',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2022_10_10_153000_point_4326',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2022_10_11_173000_user_admin',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2022_10_16_190000_timezone',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2022_10_16_193000_device_timezone',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2022_10_16_193000_position_date_utc_at',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2022_10_16_193000_position_timezone',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2022_10_17_193000_refuel_units',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2022_10_17_193000_trip_dates_utc_at',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2022_10_17_193000_trip_timezone',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2022_10_17_230000_refuel_quantity_before',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2022_10_17_233000_refuel_price',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2022_11_01_193000_device_timezone_auto',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2022_11_02_180000_timezone_unused',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2022_11_02_183000_timezone_geojson',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2022_11_04_183000_device_connected_at',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2022_11_05_220000_position_trip_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2022_11_07_183000_device_message',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2022_11_08_190000_device_message_response',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2022_11_09_183000_device_phone_number',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2022_11_10_183000_device_alarm',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2022_11_23_220000_device_alarm_keys',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2022_11_23_233000_user_telegram',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2022_11_24_183000_device_alarm_telegram',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2022_11_24_220000_device_alarm_notification_foreign',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2022_11_25_223000_device_alarm_rename',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2022_11_25_224000_device_alarm_multiple',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2022_11_27_190000_timezone_default',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2022_11_27_220000_alarm_notification_date_at',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2022_11_27_223000_alarm_notification_point',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2022_12_02_183000_server',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2022_12_20_183000_vehicle',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2022_12_22_223000_configuration_socket_debug',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2022_12_22_223000_device_port',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2022_12_27_183000_server_debug',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2022_12_29_220000_trip_stats',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2023_01_02_230000_user_preferences',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2023_02_01_230000_trip_shared',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2023_02_07_234500_device_timezone_auto',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2023_03_09_163000_alarm_schedule',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2023_03_22_183000_ip_lock_index',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2023_04_27_203000_position_point_swap',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2023_09_13_223000_maintenance',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2023_09_14_190000_file',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2023_09_15_183000_maintenance_date_at',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2023_09_25_200000_device_shared',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2023_09_27_004500_device_maker_model',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2023_09_27_005000_device_trip_shared_public',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2023_09_27_185000_device_trip_code_uuid',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2023_09_29_185000_position_index',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2023_10_02_185000_position_index',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2023_10_05_185000_user_fail',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2023_10_05_190000_user_session_to_user_fail',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2023_10_05_235000_trip_index',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2023_10_23_235000_maintenance_item',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2023_10_25_003000_maintenance_maintenance_item_amount_gross',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2023_10_31_185000_user_admin_mode',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2023_10_31_185000_user_manager',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2023_11_23_003000_user_timezone_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2023_11_30_003000_refuel_position_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2023_11_30_230000_city_country_id',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2023_11_30_230000_position_state_country',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2023_12_08_133000_language_default',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2023_12_27_203000_point_latitude_longitude',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2024_01_04_193000_refuel_point',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2024_01_04_203000_city_only',1);
