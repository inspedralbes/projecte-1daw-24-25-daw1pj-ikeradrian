DROP TABLE IF EXISTS `Actuacions`;
CREATE TABLE `Actuacions` (
  `cod_incidencia` int NOT NULL,
  `cod_actuacio` int NOT NULL AUTO_INCREMENT,
  `cod_tecnic` int NOT NULL,
  `data_actuacio` date NOT NULL,
  `temps_dedicat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcio` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_actuacio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Departament`;
CREATE TABLE `Departament` (
  `cod_depart` int NOT NULL,
  `nom_depart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `consum_depart` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `temps_dedicat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_depart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Departament` (`cod_depart`, `nom_depart`, `consum_depart`, `temps_dedicat`) VALUES
(1,	'RRHH',	'0',	'0'),
(2,	'Contabilidad',	'0',	'0'),
(3,	'Marketing',	'1',	'0'),
(4,	'Direccion',	'0',	'0'),
(5,	'Informatica',	'0',	'0');

DROP TABLE IF EXISTS `Incidencies`;
CREATE TABLE `Incidencies` (
  `cod_incidencia` int NOT NULL AUTO_INCREMENT,
  `nom_tecnic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departament` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Oberta',
  `data` datetime NOT NULL,
  `prioritat` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_incidencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Incidencies` (`cod_incidencia`, `nom_tecnic`, `departament`, `estat`, `data`, `prioritat`, `descripcio`) VALUES
(1,	'Ohian Sancet',	'3',	'Oberta',	'2025-05-12 11:32:52',	NULL,	'dnasdajdnajdnaskjd\\r\\n');

DROP TABLE IF EXISTS `Informes`;
CREATE TABLE `Informes` (
  `cod_incidencia` int NOT NULL AUTO_INCREMENT,
  `cod_tecnic` int NOT NULL,
  `data_incidencia` date NOT NULL,
  `temps_dedicat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_incidencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Tecnics`;
CREATE TABLE `Tecnics` (
  `cod_tecnic` int NOT NULL,
  `nom_tecnic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_tecnic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Tecnics` (`cod_tecnic`, `nom_tecnic`) VALUES
(1,	'Jesus Rodriguez'),
(2,	'Francisco Alarcon'),
(3,	'Aitor Ruibal'),
(4,	'Ohian Sancet'),
(5,	'Lamine Yamal');

DROP TABLE IF EXISTS `Usuaris`;
CREATE TABLE `Usuaris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `departament` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;