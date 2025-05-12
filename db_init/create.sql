-- Aquest script NOMÉS s'executa la primera vegada que es crea el contenidor.
-- Si es vol recrear les taules de nou cal esborrar el contenidor, o bé les dades del contenidor
-- és a dir, 
-- esborrar el contingut de la carpeta db_data 
-- o canviant el nom de la carpeta, però atenció a no pujar-la a git


-- És un exemple d'script per crear una base de dades i una taula
-- i afegir-hi dades inicials

-- Si creem la BBDD aquí podem control·lar la codificació i el collation
-- en canvi en el docker-compose no podem especificar el collation ni la codificació

-- Per assegurar-nes de que la codificació dels caràcters d'aquest script és la correcta
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS a24ikelopgom_Proyecto
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Donem permisos a l'usuari 'usuari' per accedir a la base de dades 'a24ikelopgom_Proyecto'
-- sinó, aquest usuari no podrà veure la base de dades i no podrà accedir a les taules
GRANT ALL PRIVILEGES ON a24ikelopgom_Proyecto.* TO 'usuari'@'%';
FLUSH PRIVILEGES;


-- Després de crear la base de dades, cal seleccionar-la per treballar-hi
USE a24ikelopgom_Proyecto;


-- Base de dades: `a24ikelopgom_Proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `Actuacions`
--

DROP TABLE IF EXISTS `Actuacions`;
CREATE TABLE `Actuacions` (
  `cod_incidencia` int NOT NULL,
  `cod_actuacio` int NOT NULL AUTO_INCREMENT,
  `cod_tecnic` int NOT NULL,
  `data_actuacio` date NOT NULL,
  `temps_dedicat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcio` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_actuacio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Departament`;
CREATE TABLE `Departament` (
  `cod_depart` int NOT NULL,
  `nom_depart` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `consum_depart` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `temps_dedicat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_depart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Departament` (`cod_depart`, `nom_depart`, `consum_depart`, `temps_dedicat`) VALUES
(1,	'RRHH',	'0',	'0'),
(2,	'Contabilidad',	'0',	'0'),
(3,	'Marketing',	'0',	'0'),
(4,	'Direccion',	'0',	'0'),
(5,	'Informatica',	'0',	'0');

DROP TABLE IF EXISTS `Incidencies`;
CREATE TABLE `Incidencies` (
  `cod_incidencia` int NOT NULL AUTO_INCREMENT,
  `nom_tecnic` varchar(255) DEFAULT NULL,
  `departament` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `estat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Oberta',
  `data` datetime NOT NULL,
  `descripcio` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cod_incidencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Informes`;
CREATE TABLE `Informes` (
  `cod_incidencia` int NOT NULL AUTO_INCREMENT,
  `cod_tecnic` int NOT NULL,
  `data_incidencia` date NOT NULL,
  `temps_dedicat` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
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
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `departament` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
