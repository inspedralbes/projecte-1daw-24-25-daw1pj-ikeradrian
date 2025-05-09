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

CREATE TABLE `Actuacions` (
  `cod_incidencia` int(30) NOT NULL,
  `cod_actuacio` int(255) NOT NULL,
  `cod_tecnic` int(255) NOT NULL,
  `data_actuacio` date NOT NULL,
  `temps_dedicat` varchar(255) NOT NULL,
  `descripcio` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `Departament`
--

CREATE TABLE `Departament` (
  `cod_depart` int(30) NOT NULL,
  `nom_depart` varchar(255) NOT NULL,
  `consum_depart` varchar(255) NOT NULL,
  `temps_dedicat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO Departament (cod_depart, nom_depart, consum_depart, temps_dedicat) VALUES (1, "RRHH", 0, 0);
INSERT INTO Departament (cod_depart, nom_depart, consum_depart, temps_dedicat) VALUES (2, "Contabilidad", 0, 0);
INSERT INTO Departament (cod_depart, nom_depart, consum_depart, temps_dedicat) VALUES (3, "Marketing", 0, 0);
INSERT INTO Departament (cod_depart, nom_depart, consum_depart, temps_dedicat) VALUES (4, "Direccion", 0, 0);
INSERT INTO Departament (cod_depart, nom_depart, consum_depart, temps_dedicat) VALUES (5, "Informatica", 0, 0);








-- --------------------------------------------------------

--
-- Estructura de la taula `Incidencies`
--

CREATE TABLE `Incidencies` (
  `cod_incidencia` int(30) NOT NULL,
  `cod_tecnic` int(255) DEFAULT NULL,
  `departament` varchar(255) NOT NULL,
  `estat` varchar(255) NOT NULL DEFAULT 'Oberta',
  `data` datetime NOT NULL,
  `descripcio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `Informes`
--

CREATE TABLE `Informes` (
  `cod_incidencia` int(30) NOT NULL,
  `cod_tecnic` int(255) NOT NULL,
  `data_incidencia` date NOT NULL,
  `temps_dedicat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `Tecnics`
--

CREATE TABLE `Tecnics` (
  `cod_tecnic` int(30) NOT NULL,
  `total_incidencies` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO Tecnics (cod_tecnic, total_incidencies) VALUES (1, 0);
INSERT INTO Tecnics (cod_tecnic, total_incidencies) VALUES (2, 0);
INSERT INTO Tecnics (cod_tecnic, total_incidencies) VALUES (3, 0);
INSERT INTO Tecnics (cod_tecnic, total_incidencies) VALUES (4, 0);
INSERT INTO Tecnics (cod_tecnic, total_incidencies) VALUES (5, 0);


-- --------------------------------------------------------

--
-- Estructura de la taula `Usuaris`
--

CREATE TABLE `Usuaris` (
  `id` int(30) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `departament` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `Actuacions`
--
ALTER TABLE `Actuacions`
  ADD PRIMARY KEY (`cod_actuacio`);

--
-- Índexs per a la taula `Departament`
--
ALTER TABLE `Departament`
  ADD PRIMARY KEY (`cod_depart`);

--
-- Índexs per a la taula `Incidencies`
--
ALTER TABLE `Incidencies`
  ADD PRIMARY KEY (`cod_incidencia`);

--
-- Índexs per a la taula `Informes`
--
ALTER TABLE `Informes`
  ADD PRIMARY KEY (`cod_incidencia`);

--
-- Índexs per a la taula `Tecnics`
--
ALTER TABLE `Tecnics`
  ADD PRIMARY KEY (`cod_tecnic`);

--
-- Índexs per a la taula `Usuaris`
--
ALTER TABLE `Usuaris`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

ALTER TABLE `Actuacions`
  MODIFY `cod_actuacio` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `Incidencies`
--
ALTER TABLE `Incidencies`
  MODIFY `cod_incidencia` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `Informes`
--
ALTER TABLE `Informes`
  MODIFY `cod_incidencia` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `Usuaris`
--
ALTER TABLE `Usuaris`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;
COMMIT;