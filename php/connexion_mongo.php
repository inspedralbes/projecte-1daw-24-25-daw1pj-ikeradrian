<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

function rellenarMongo($name, $ip, $hora, $pages) {
    $client = new Client("mongodb://root:example@mongo:27017");
    $collection = $client->demo->users;

    $collection->insertOne([
        'name' => $name,
        'ip_origin' => $ip,
        'date' => new UTCDateTime(strtotime($hora) * 1000),
        'pagina_visitada' => $pages
    ]);
}

$name = 'usuari_test';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("Y-m-d H:i:s");
$pages = $_SERVER['REQUEST_URI'] ?? 'index.php';


$client = new Client("mongodb://root:example@mongo:27017");
$collection = $client->demo->users;
$documents = $collection->find();
?>
