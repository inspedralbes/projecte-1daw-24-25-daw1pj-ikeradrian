<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Comprova si l'usuari és administrador
//if (!isset($_SESSION['usuari']) || $_SESSION['rol'] !== 'administrador') {
//    header("Location: login.php");
//    exit();
//}

require '../vendor/autoload.php'; // Carrega Composer

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

// Connexió MongoDB
$client = new Client("mongodb://localhost:27017");
$collection = $client->gestor_incidencies->access_logs;

// Filtres opcionals
//$filters = [];

//$timestamp = strtotime($_GET['data']);
//if ($timestamp !== false) {
//    $filters['data'] = [
//        '$gte' => new UTCDateTime($timestamp * 1000),
//        '$lt'  => new UTCDateTime(($timestamp + 86400) * 1000)
//    ];
//}

if (!empty($_GET['usuari'])) {
    $filters['usuari'] = $_GET['usuari'];
}

if (!empty($_GET['pagina'])) {
    $filters['pagina'] = $_GET['pagina'];
}

// Estadístiques
//$totalAccessos = $collection->countDocuments($filters);

// Pàgines més visitades
$paginesMesVisitadesCursor = $collection->aggregate([
    ['$group' => ['_id' => '$pagina', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 5]
]);
$paginesMesVisitades = iterator_to_array($paginesMesVisitadesCursor, false);

// Usuaris més actius
$usuarisMesActiusCursor = $collection->aggregate([
    ['$match' => $filters],
    ['$group' => ['_id' => '$usuari', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 5]
]);
$usuarisMesActius = iterator_to_array($usuarisMesActiusCursor, false);

// Accessos per dia
$accessosPerDiaCursor = $collection->aggregate([
    ['$match' => $filters],
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => "%Y-%m-%d", 'date' => '$data']],
        'total' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]]
]);
$accessosPerDia = iterator_to_array($accessosPerDiaCursor, false);
?>
