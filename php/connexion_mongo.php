<?php
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;
$url = "mongodb+srv://a24ikelopgom:Dzsi7L4hfy9Y3niO@grupo4.vmvzio9.mongodb.net/?retryWrites=true&w=majority&appName=Grupo4";
$client = new Client($url);
function rellenarMongo($client, $name, $ip, $hora, $pages) {
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



$client = new Client($url);
$collection = $client->demo->users;
$documents = $collection->find();
?>