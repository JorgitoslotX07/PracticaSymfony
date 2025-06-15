CREATE
DATABASE  IF NOT EXISTS `practicaSymfony`;
USE `practicaSymfony`;

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `nombre`     varchar(255) NOT NULL,
    `email`      varchar(255) NOT NULL,
    `telefono`   varchar(20)           DEFAULT NULL,
    `tipo`       enum('hotel','pista','complemento') NOT NULL,
    `activo`     tinyint(1) NOT NULL DEFAULT '1',
    `created_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK
TABLES `proveedor` WRITE;
INSERT INTO `proveedor`
VALUES (2, 'Toni', 'tjorda04@gmail.com', '639825353', 'pista', 1, '2025-06-13 22:56:38', '2025-06-15 16:43:11'),
       (3, 'Hotel Sol', 'reservas@hotelsol.com', '934567890', 'hotel', 1, '2025-06-10 10:15:00', '2025-06-14 09:00:00'),
       (4, 'Pistas Deluxe', 'contacto@pistasdeluxe.com', '612345678', 'pista', 1, '2025-06-11 12:30:00',
        '2025-06-14 15:20:00'),
       (5, 'Servicio Plus', 'info@servicioplus.com', '698765432', 'complemento', 1, '2025-06-12 08:45:00',
        '2025-06-15 10:00:00'),
       (6, 'Hotel Brisa', 'info@hotelbrisa.com', '900123456', 'hotel', 0, '2025-06-10 14:00:00', '2025-06-12 18:30:00'),
       (7, 'Pista Center', 'soporte@pistacenter.es', '633112233', 'pista', 1, '2025-06-09 17:45:00',
        '2025-06-13 11:15:00'),
       (8, 'Equipamiento Pro', 'ventas@equippro.com', '655443322', 'complemento', 1, '2025-06-08 16:00:00',
        '2025-06-15 12:45:00');

UNLOCK
TABLES;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`       int unsigned NOT NULL AUTO_INCREMENT,
    `email`    varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
    `roles`    json                                    NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK
TABLES `user` WRITE;
INSERT INTO `user`
VALUES (1, 'admin1@example.com', '[
  \"ROLE_ADMIN\", \"ROLE_USER\"]', '$2y$13$GxjuVbzxK3pcKt8rxce3Let94pcRU5KxBzmNIV7rv3.Vqb.ly2XRm'),
       (2, 'admin2@example.com', '[
         \"ROLE_ADMIN\", \"ROLE_USER\"]', '$2y$12$W0bPqw5IVChD6D/UxV69huA6tSfxKyqLmqTQClzV1a1VaP39JQ3kO'),
       (3, 'user@example.com', '[
         \"ROLE_USER\"]', '$2y$12$VwQ0j7e6uMxiI5jRrlID6uYKOl6aHDqT.NgS4Xfjq4msxwCrF93Eu'),
       (4, 'admin4@example.com', '[
         \"ROLE_USER\"]', '$2y$13$p2A02Fhy62Zt.r37ernhpOkG0CRs4nlBC5Nnz1CJhSPv/8hGB07.G'),
       (7, 'admin10@example.com', '[
         \"ROLE_USER\"]', '$2y$13$x3Jr5C./EXcviSEuejP.F.palmTv1JFjwywjCVnH7uZG2w7LTiX.K');
UNLOCK
TABLES;