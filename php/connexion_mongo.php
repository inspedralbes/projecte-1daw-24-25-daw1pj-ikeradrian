<?php
require 'vendor/autoload.php';

use MongoDB\Client;

try {
    $mongoClient = new Client("mongodb://localhost:27017");

    $db = $mongoClient->gestor_incidencies;

    $logsCollection = $db->logs;

} catch (Exception $e) {
    die("Error de connexió amb MongoDB: " . $e->getMessage());
}
?>  