CREATE DATABASE IF NOT EXISTS talleres;
USE talleres;

CREATE TABLE IF NOT EXISTS `ponentes` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(40) DEFAULT NULL,
    `apellidos` varchar(40) DEFAULT NULL,
    `imagen` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
    `tags` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
    `redes` text,
    CONSTRAINT pk_ponentes PRIMARY KEY (`id`)
)
ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` bigint(20) AUTO_INCREMENT NOT NULL,
    `nombre` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `apellidos` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
    `confirmado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
    `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `token_esp` timestamp NULL DEFAULT NULL,

    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- inserciones
INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `confirmado`, `token`, `token_exp`) VALUES (NULL, '', '', 'admin@gmail.com', '$2y$10$vVIyox7hapBPd68pbH6VUevDQKFsWhP48JVrndlm5d/LfZX3rijym', 'admin', 'si', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzcwNTQ4MzgsImV4cCI6MTY3NzA1ODQzOCwiZGF0YSI6WyIiXX0.SRvkmpr0_ukbLblqBSfDPk1xSLuzPTgqsRFgjsdRpF4', '0000-00-00 00:00:00');

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `confirmado`, `token`, `token_exp`) VALUES (NULL, '', '', 'confirmado@gmail.com', '$2y$10$FkBDwDtsI9R32r4JtD83Sez2K5ETgr8j9fIXtkHu3MILaRJ43E27C', 'user', 'si', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzcwOTE0NTYsImV4cCI6MTY3NzA5NTA1NiwiZGF0YSI6WyIiXX0.g5J5NuHIshg8CYv1p_a_wCDsLylH_YL9S-cVt9vCLLc', '0000-00-00 00:00:00')

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `confirmado`, `token`, `token_exp`) VALUES (NULL, '', '', 'por_confirmar@gmail.com', '$2y$10$ruUESDnVN7fAnbhQnI2tu.lmbSfF2yrmMA2ru/kg62a2L8O5pQMyO', 'user', 'no', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzcwOTA0MjEsImV4cCI6MTY3NzA5NDAyMSwiZGF0YSI6WyIiXX0.70jTOtg6ziSK36mFNQzOtW0iAZqYggCzeX8nViRiIR0', '0000-00-00 00:00:00');



INSERT INTO `ponentes` (`id`, `nombre`, `apellidos`, `imagen`, `tags`, `redes`) VALUES (NULL, 'Juan', 'Torres', 'tio.png', NULL, 'juan_ponente@gmail.com');

INSERT INTO `ponentes` (`id`, `nombre`, `apellidos`, `imagen`, `tags`, `redes`) VALUES (NULL, 'Ana', 'Ruiz Puertas', 'tia.png', 'cocina', NULL);

