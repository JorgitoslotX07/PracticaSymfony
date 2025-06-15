CREATE DATABASE  IF NOT EXISTS `practicaSymfony`;
USE `practicaSymfony`;

DROP TABLE IF EXISTS `proveedor`;
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
LOCK TABLES `proveedor` WRITE;
INSERT INTO `proveedor` VALUES (2,'Toni','tjorda04@gmail.com','639825353','pista',1,'2025-06-13 22:56:38','2025-06-15 16:43:11');
UNLOCK TABLES;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
                        `id` int unsigned NOT NULL AUTO_INCREMENT,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` json NOT NULL,
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES (1,'admin1@example.com','[\"ROLE_ADMIN\", \"ROLE_USER\"]','$2y$13$GxjuVbzxK3pcKt8rxce3Let94pcRU5KxBzmNIV7rv3.Vqb.ly2XRm'),(2,'admin2@example.com','[\"ROLE_ADMIN\", \"ROLE_USER\"]','$2y$12$W0bPqw5IVChD6D/UxV69huA6tSfxKyqLmqTQClzV1a1VaP39JQ3kO'),(3,'user@example.com','[\"ROLE_USER\"]','$2y$12$VwQ0j7e6uMxiI5jRrlID6uYKOl6aHDqT.NgS4Xfjq4msxwCrF93Eu'),(4,'admin4@example.com','[\"ROLE_USER\"]','$2y$13$p2A02Fhy62Zt.r37ernhpOkG0CRs4nlBC5Nnz1CJhSPv/8hGB07.G'),(7,'admin10@example.com','[\"ROLE_USER\"]','$2y$13$x3Jr5C./EXcviSEuejP.F.palmTv1JFjwywjCVnH7uZG2w7LTiX.K');
UNLOCK TABLES;