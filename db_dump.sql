-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: das
-- ------------------------------------------------------
-- Server version	8.0.42-0ubuntu0.22.04.1

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
-- Table structure for table `appointment`
--

CREATE DATABASE IF NOT EXISTS das;
use das;

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `clinic_id` int NOT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration_minutes` int DEFAULT '10',
  `price` int NOT NULL,
  `status` enum('booked','cancelled','completed') DEFAULT 'booked',
  `created_by` enum('patient','doctor') NOT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-appointment-user` (`user_id`),
  KEY `fk-appointment-doctor` (`doctor_id`),
  KEY `fk-appointment-clinic` (`clinic_id`),
  CONSTRAINT `fk-appointment-clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinic` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-appointment-doctor` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-appointment-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,2,2,1,'2025-06-24','10:40:00','11:00:00',20,600,'booked','doctor',1750955162,1751038403),(2,3,10,2,'2025-06-28','15:00:00','15:40:00',40,1200,'booked','patient',1751095608,1751098801);
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_email`
--

DROP TABLE IF EXISTS `appointment_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment_email` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appointment_id` int NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `email_content` text,
  `generated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-appointment_email-appointment` (`appointment_id`),
  CONSTRAINT `fk-appointment_email-appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_email`
--

LOCK TABLES `appointment_email` WRITE;
/*!40000 ALTER TABLE `appointment_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_log`
--

DROP TABLE IF EXISTS `appointment_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appointment_id` int NOT NULL,
  `action` varchar(50) DEFAULT NULL,
  `performed_by` int DEFAULT NULL,
  `performed_at` int DEFAULT NULL,
  `details` text,
  PRIMARY KEY (`id`),
  KEY `fk-appointment_log-appointment` (`appointment_id`),
  KEY `fk-appointment_log-user` (`performed_by`),
  CONSTRAINT `fk-appointment_log-appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-appointment_log-user` FOREIGN KEY (`performed_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_log`
--

LOCK TABLES `appointment_log` WRITE;
/*!40000 ALTER TABLE `appointment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('doctor','10',1751039723),('doctor','2',1750492502),('doctor','6',1750824820),('patient','3',1750492502),('superadmin','1',1750492502);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('bookAppointment',2,NULL,NULL,NULL,1750492490,1750492490),('doctor',1,NULL,NULL,NULL,1750492490,1750492490),('manageAll',2,'Full access to system',NULL,NULL,1750492490,1750492490),('patient',1,NULL,NULL,NULL,1750492490,1750492490),('superadmin',1,NULL,NULL,NULL,1750492490,1750492490),('viewPatients',2,NULL,NULL,NULL,1750492490,1750492490);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('patient','bookAppointment'),('superadmin','doctor'),('superadmin','manageAll'),('superadmin','patient'),('doctor','viewPatients');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinic`
--

DROP TABLE IF EXISTS `clinic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinic`
--

LOCK TABLES `clinic` WRITE;
/*!40000 ALTER TABLE `clinic` DISABLE KEYS */;
INSERT INTO `clinic` VALUES (1,'SHRI','A1 ,222,SHRI DHAM','Ahmdabad','Gujrat','421002',1750758406,1750758406),(2,'SSSE','eee sss fedfs fff','38','Maharashtra','421302',1750775189,1750775189),(3,'RAMESH CLINIC','ED rae YERID dd','Colva','Goa','245693',1750775612,1750775612);
/*!40000 ALTER TABLE `clinic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk-doctor-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (2,2,'Neurology','Bachelor of Neurology','3',1750781502,1750781502),(3,10,' Pediatrics','Bachelor of Medicine','4',1751039723,1751039806);
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_clinic`
--

DROP TABLE IF EXISTS `doctor_clinic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_clinic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int NOT NULL,
  `clinic_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-doctor_clinic-doctor` (`doctor_id`),
  KEY `fk-doctor_clinic-clinic` (`clinic_id`),
  CONSTRAINT `fk-doctor_clinic-clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinic` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-doctor_clinic-doctor` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_clinic`
--

LOCK TABLES `doctor_clinic` WRITE;
/*!40000 ALTER TABLE `doctor_clinic` DISABLE KEYS */;
INSERT INTO `doctor_clinic` VALUES (9,10,1),(10,10,2),(11,10,3),(12,2,2),(13,2,3),(14,2,1);
/*!40000 ALTER TABLE `doctor_clinic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_schedule`
--

DROP TABLE IF EXISTS `doctor_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int NOT NULL,
  `day_of_week` enum('Mon','Tue','Wed','Thu','Fri','Sat','Sun') NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_holiday` tinyint(1) DEFAULT '0',
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-doctor_schedule-doctor` (`doctor_id`),
  CONSTRAINT `fk-doctor_schedule-doctor` FOREIGN KEY (`doctor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_schedule`
--

LOCK TABLES `doctor_schedule` WRITE;
/*!40000 ALTER TABLE `doctor_schedule` DISABLE KEYS */;
INSERT INTO `doctor_schedule` VALUES (8,1,'Mon','10:00:00','19:00:00',0,1750867553,1750867553),(9,1,'Tue','10:00:00','19:00:00',0,1750867553,1750867553),(10,1,'Wed','10:00:00','19:00:00',0,1750867553,1750867553),(11,1,'Thu','10:00:00','19:00:00',0,1750867553,1750867553),(12,1,'Fri','10:00:00','19:00:00',0,1750867553,1750867553),(13,1,'Sat','10:00:00','19:00:00',1,1750867553,1750867553),(14,1,'Sun',NULL,NULL,1,1750867553,1750867553),(15,2,'Mon','10:00:00','19:00:00',0,1750868288,1750868288),(16,2,'Tue','10:00:00','19:00:00',0,1750868288,1750868288),(17,2,'Wed','10:00:00','19:00:00',0,1750868288,1750868288),(18,2,'Thu','10:00:00','19:00:00',0,1750868288,1750868288),(19,2,'Fri','10:00:00','19:00:00',0,1750868288,1750868288),(20,2,'Sat',NULL,NULL,1,1750868288,1750868288),(21,2,'Sun',NULL,NULL,1,1750868288,1750868288),(29,10,'Mon',NULL,NULL,1,1751040211,1751040211),(30,10,'Tue',NULL,NULL,1,1751040211,1751040211),(31,10,'Wed','10:00:00','19:00:00',0,1751040211,1751040211),(32,10,'Thu','10:00:00','19:00:00',0,1751040211,1751040211),(33,10,'Fri','10:00:00','19:00:00',0,1751040211,1751040211),(34,10,'Sat','10:00:00','19:00:00',0,1751040211,1751040211),(35,10,'Sun','10:00:00','19:00:00',0,1751040211,1751040211);
/*!40000 ALTER TABLE `doctor_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1750348534),('m130524_201442_init',1750348544),('m140506_102106_rbac_init',1750489565),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1750489565),('m180523_151638_rbac_updates_indexes_without_prefix',1750489565),('m190124_110200_add_verification_token_column_to_user_table',1750348545),('m200409_110543_rbac_update_mssql_trigger',1750489565),('m250623_105926_create_role_column_user_table',1750676609),('m250623_110855_create_clinic_table',1750677268),('m250623_110940_create_doctor_clinic_table',1750677268),('m250623_111048_create_doctor_schedule_table',1750677268),('m250623_111130_create_appointment_table',1750677269),('m250623_111236_create_appointment_email_table',1750677269),('m250623_111326_create_appointment_log_table',1750677270),('m250623_160012_create_doctor_table',1750694517);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role` enum('patient','doctor','superadmin') COLLATE utf8mb3_unicode_ci DEFAULT 'patient',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Adarsh','dtcPRZFHGfqNfJ53BIkNNRL2KOxPnRd4','$2y$13$1hhKSoYRMz9kOO26w/0VHuHB/Zs6168qwdLyxBUTn2ciQUwUSdlf.',NULL,'adarsh.gupta@gmail.com',10,1750400880,1750488764,'8MuNtIOjN4YZiuJHj2ixPBiWLfCkcF6-_1750400880','superadmin'),(2,'docter','_lUXxAVkYetWruXC3gIAHfXzLXcbXKoI','$2y$13$L9UpdJsN.MowmB.NOglR1.w8y24qquzR9qkBjvXO7xazl/dnOeWoO',NULL,'docter@gmail.com',10,1750491121,1750491707,'bEIkTIH-gm9TUvozA95jQuWcqGa66Qgb_1750491121','doctor'),(3,'patient','OhqzGhM1JEFIIFf-rJhgol6dgr9yYcBo','$2y$13$5JsSSnXE8gqtpVPKtEIP3.lCYxBJq2ohRALEItleTRjBW6T9bEljO',NULL,'patient@gmail.com',10,1750491886,1750491938,'gnqZoWNIKOVt8w6kqQ5yzHWog51TCSj3_1750491886','patient'),(6,'doc1','1LtAmQR58oHO-WDFfCFmx2JAgpD_jjsK','$2y$13$u2.jdPU.nMqkRxKHQxXz3O6MCdwnnWq3efCufbcYqtp8tZkxM1r8C',NULL,'doc1@gmail.com',0,1750781502,1750829030,'T7e5BR9uB_O7qDE7ZT5qqA3EmxUDdvwv_1750781502','doctor'),(7,'doctor1','sdECFuWPiYC549iubmg0hmQJaRATQOkx','$2y$13$toB6jt1Pq09SHAYDyi36U.4aDJJRRzsolHAK2yO1dkJNHep/Gh./u',NULL,'doctor1@gmail.com',0,1751039050,1751039050,'O2BHnDutRDZkBIzJeBjOAmiUuekFXi2lvQbWzED943FfMTc1MTAzOTA1MA','doctor'),(9,'johndoe','zwR1Mf31SbOZryqW-T2fL76z0kADZId7','$2y$13$i2ynW6Itp/U/lbefXHW5JuMI/ZLlZ.2W/ncO4dW6rgYPGRTWNq3Ju',NULL,'johndoe@gmail.com',0,1751039365,1751039365,'G7CE71Z9dNXhxUOcplu_WELCh2q8t4HDxfjiNhKmKqlfMTc1MTAzOTM2NQ','doctor'),(10,'john','TmN2zBp5KEkJBrDerfd8Nod7bz4OlGbe','$2y$13$PF8A3OiUR6SOHDwo.DX8Gee78MaXtGQ.sE5BepouBE.1HZslAoRT6',NULL,'john@gmail.com',10,1751039723,1751040013,'pPfhzFltcDZJe55qA_0EMQr7Cb_dE6MstI-FF5P58RhfMTc1MTAzOTcyMw','doctor');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'das'
--

--
-- Dumping routines for database 'das'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-28 14:28:55
