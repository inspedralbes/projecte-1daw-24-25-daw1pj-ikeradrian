<?php
session_start();
require '../connexion_mongo.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = "admin";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Estadistiques";
rellenarMongo($name, $ip, $hora, $pages);

require '../vendor/autoload.php'; // Carrega Composer

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

// Connexió MongoDB
$client = new MongoDB\Client("mongodb://root:example@mongo:27017");
$collection = $client->demo->users;

$documents = $collection->find();

foreach ($documents as $document) {
    echo "<p>";
    echo " : " . htmlspecialchars($document['name']);
    echo " ( " . htmlspecialchars($document['ip_origin'] ?? "x") . " )";
    echo htmlspecialchars($document['date'] ?? "x");
    echo " : " . htmlspecialchars($document['pagina_visitada'] ?? "Sense pàgina");

    echo "</p>";

}
