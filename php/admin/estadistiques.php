<?php
session_start();
require '../connexion_mongo.php';
require '../connexio.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

$name = "admin";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Estadistiques";

rellenarMongo($collection, $name, $ip, $hora, $pages);

if (isset($_POST['esborrar_tots'])) {
    $collection->deleteMany([]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

$visitesIndex = $collection->countDocuments([
    'pagina_visitada' => 'Informes de Tècnics i Departaments'
]);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Estadístiques d'accés</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
        h1 { color: #003366; font-weight: 700; }
        .table thead th { background-color: #003366; color: white; }
        .container { max-width: 960px; }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">Estadístiques d'accés</h1>

    <div class="alert alert-info text-center mb-4">
        Nombre d'accessos a la pàgina <strong>Informes de Tècnics i Departaments</strong>: <?= $visitesIndex ?>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>IP</th>
                <th>Hora</th>
                <th>Pàgina visitada</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $documents = $collection->find();
            foreach ($documents as $document): ?>
            <tr>
                <td><?= htmlspecialchars($document['Usuari'] ?? 'x') ?></td>
                <td><?= htmlspecialchars($document['ip_origen'] ?? 'x') ?></td>
                <td><?= htmlspecialchars($document['Data'] ?? 'x') ?></td>
                <td><?= htmlspecialchars($document['pagina visitada'] ?? 'x') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="admin.php" class="btn btn-secondary">Tornar a l'inici</a>
    </div>

    <form method="post" onsubmit="return confirm('Estàs segur que vols esborrar totes les dades?');">
        <button type="submit" name="esborrar_tots" class="btn btn-danger mt-3">
            Esborrar tots els registres
        </button>
    </form>
</div>
</body>
</html>
