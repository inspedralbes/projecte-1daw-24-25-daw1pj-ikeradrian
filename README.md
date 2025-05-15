# Grup 4 – Projecte Web

## Integrants del projecte

- Adrian Maciel – a22adrmacfir@inspedralbes.cat
- Iker López – a24ikelopgom@inspedralbes.cat

## Objectiu del projecte

Desenvolupar una aplicació web que permeti la gestió d'incidències informàtiques dirigida a una institució empresarial.

## Estat del projecte

> El projecte es troba actualment en desenvolupament.

## Enllaços importants

- 📄 **Documentació (PHPDoc):** [https://exemple.com/phpdoc](https://exemple.com/phpdoc)
- 🚀 **Projecte desplegat:** [https://exemple.com](https://exemple.com)

## Estructura de carpetes (arrel del projecte)
index.php → Entrada principal del projecte

/php
├── /css
│ └── style.css → Estils generals
│
├── /admin → Mòdul d'administració
│ ├── admin.php
│ ├── asignartecnicos.php
│ ├── estadistiques.php
│ └── informes.php
│
├── /tecnic → Funcions per a tècnics
│ ├── elegirincidencia.php
│ ├── modificarincidencia.php
│ ├── registrartactuacion.php
│ └── tecnic.php
│
└── /usuari → Funcions per a usuaris normals
├── consultarincidencia.php
├── crearincidencia.php
├── llistarcincidencies.php
└── usuario.php

connexio.php → Connexió MySQL
connexion_mongo.php → Connexió MongoDB
composer.json / composer.lock → Dependències del projecte

## Esquema E-R BBDD
![Esquema E-R BBDD](https://github.com/user-attachments/assets/eed9558d-ea32-4661-a638-a04918c801eb)
