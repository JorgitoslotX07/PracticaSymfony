CREATE DATABASE  IF NOT EXISTS `practicasymfony` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `practicasymfony`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: practicasymfony
-- ------------------------------------------------------
-- Server version	8.4.5

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
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
                             `id` int NOT NULL AUTO_INCREMENT,
                             `nombre` varchar(255) NOT NULL,
                             `email` varchar(255) NOT NULL,
                             `telefono` varchar(20) DEFAULT NULL,
                             `tipo` enum('hotel','pista','complemento') NOT NULL,
                             `activo` tinyint(1) NOT NULL DEFAULT '1',
                             `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (2,'Toni','tjorda04@gmail.com','639825353','pista',1,'2025-06-13 22:56:38','2025-06-15 16:43:11');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
                        `id` int unsigned NOT NULL AUTO_INCREMENT,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` json NOT NULL,
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin1@example.com','[\"ROLE_ADMIN\", \"ROLE_USER\"]','$2y$13$GxjuVbzxK3pcKt8rxce3Let94pcRU5KxBzmNIV7rv3.Vqb.ly2XRm'),(2,'admin2@example.com','[\"ROLE_ADMIN\", \"ROLE_USER\"]','$2y$12$W0bPqw5IVChD6D/UxV69huA6tSfxKyqLmqTQClzV1a1VaP39JQ3kO'),(3,'user@example.com','[\"ROLE_USER\"]','$2y$12$VwQ0j7e6uMxiI5jRrlID6uYKOl6aHDqT.NgS4Xfjq4msxwCrF93Eu'),(4,'admin4@example.com','[\"ROLE_USER\"]','$2y$13$p2A02Fhy62Zt.r37ernhpOkG0CRs4nlBC5Nnz1CJhSPv/8hGB07.G'),(7,'admin10@example.com','[\"ROLE_USER\"]','$2y$13$x3Jr5C./EXcviSEuejP.F.palmTv1JFjwywjCVnH7uZG2w7LTiX.K');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-15 17:39:26
