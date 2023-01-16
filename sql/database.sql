-- MySQL dump 10.13  Distrib 8.0.31, for Linux (x86_64)
--
-- Host: localhost    Database: ampliffy_test
-- ------------------------------------------------------
-- Server version	8.0.31-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `affected_repositories`
--

DROP TABLE IF EXISTS `affected_repositories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affected_repositories` (
  `commit_id` int NOT NULL,
  `repository_id` int NOT NULL,
  PRIMARY KEY (`commit_id`,`repository_id`),
  KEY `IDX_7E5C68483D5814AC` (`commit_id`),
  KEY `IDX_7E5C684850C9D4F7` (`repository_id`),
  CONSTRAINT `FK_7E5C68483D5814AC` FOREIGN KEY (`commit_id`) REFERENCES `commits` (`id`),
  CONSTRAINT `FK_7E5C684850C9D4F7` FOREIGN KEY (`repository_id`) REFERENCES `repositories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affected_repositories`
--

LOCK TABLES `affected_repositories` WRITE;
/*!40000 ALTER TABLE `affected_repositories` DISABLE KEYS */;
INSERT INTO `affected_repositories` VALUES (24,19),(25,19),(26,17),(26,19),(27,19),(28,19),(29,17),(29,19);
/*!40000 ALTER TABLE `affected_repositories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commits`
--

DROP TABLE IF EXISTS `commits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `repository_id` int DEFAULT NULL,
  `hash` varchar(40) COLLATE utf8mb3_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B327C47050C9D4F7` (`repository_id`),
  CONSTRAINT `FK_B327C47050C9D4F7` FOREIGN KEY (`repository_id`) REFERENCES `repositories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commits`
--

LOCK TABLES `commits` WRITE;
/*!40000 ALTER TABLE `commits` DISABLE KEYS */;
INSERT INTO `commits` VALUES (24,16,'9872e0d1490318742131fe92eb5d10b0ba3f5145','main'),(25,17,'a3e2e0d1490318742131fe92eb5d10b0ba3f5145','main'),(26,18,'a3e2e0d1490318742131fe92eb5d10b0ba3f5145','main'),(27,16,'09a5e0d1490318742131fe92eb5d10b0ba3f5145','main'),(28,17,'0945e0d1490318742131fe92eb5d10b0ba3f5145','main'),(29,18,'ac95e0d1490318742131fe92eb5d10b0ba3f5145','main');
/*!40000 ALTER TABLE `commits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dependency_tree`
--

DROP TABLE IF EXISTS `dependency_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dependency_tree` (
  `repository_id` int NOT NULL,
  `dependency_id` int NOT NULL,
  PRIMARY KEY (`repository_id`,`dependency_id`),
  KEY `IDX_AE9B194250C9D4F7` (`repository_id`),
  KEY `IDX_AE9B1942C2F67723` (`dependency_id`),
  CONSTRAINT `FK_AE9B194250C9D4F7` FOREIGN KEY (`repository_id`) REFERENCES `repositories` (`id`),
  CONSTRAINT `FK_AE9B1942C2F67723` FOREIGN KEY (`dependency_id`) REFERENCES `repositories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dependency_tree`
--

LOCK TABLES `dependency_tree` WRITE;
/*!40000 ALTER TABLE `dependency_tree` DISABLE KEYS */;
INSERT INTO `dependency_tree` VALUES (17,18),(19,16),(19,17);
/*!40000 ALTER TABLE `dependency_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repositories`
--

DROP TABLE IF EXISTS `repositories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `repositories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `composer_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `git_path` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `composer_modified_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repositories`
--

LOCK TABLES `repositories` WRITE;
/*!40000 ALTER TABLE `repositories` DISABLE KEYS */;
INSERT INTO `repositories` VALUES (16,'ampliffy/library_1','/home/wilcar/code/ampliffy/repositories/library_1','library',1673768912),(17,'ampliffy/library_2','/home/wilcar/code/ampliffy/repositories/library_2','library',1673776270),(18,'ampliffy/library_3','/home/wilcar/code/ampliffy/repositories/library_3','library',1673776852),(19,'ampliffy/project_1','/home/wilcar/code/ampliffy/repositories/project_1','project',1673776247);
/*!40000 ALTER TABLE `repositories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-16  3:52:27
