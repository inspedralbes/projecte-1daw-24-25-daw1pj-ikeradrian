<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../vendor/autoload.php'; // Carrega Composer

use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

// Connexió MongoDB
$client = new MongoDB\Client("mongodb://root:example@mongo:27017");
$collection = $client->gestor_incidencies->access_logs;

// Filtres opcionals
$filters = [];

if (!empty($_GET['data'])) {
    $timestamp = strtotime($_GET['data']);
    if ($timestamp !== false) {
        $filters['data'] = [
            '$gte' => new UTCDateTime($timestamp * 1000),
            '$lt'  => new UTCDateTime(($timestamp + 86400) * 1000)
        ];
    }
}

if (!empty($_GET['usuari'])) {
    $filters['usuari'] = $_GET['usuari'];
}

if (!empty($_GET['pagina'])) {
    $filters['pagina'] = $_GET['pagina'];
}

// Pàgines més visitades
$paginesMesVisitadesCursor = $collection->aggregate([
    ['$group' => ['_id' => '$pagina', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 5]
]);
$paginesMesVisitades = iterator_to_array($paginesMesVisitadesCursor, false);

// Usuaris més actius
$usuarisPipeline = [];
if (!empty($filters)) $usuarisPipeline[] = ['$match' => $filters];
$usuarisPipeline[] = ['$group' => ['_id' => '$usuari', 'visites' => ['$sum' => 1]]];
$usuarisPipeline[] = ['$sort' => ['visites' => -1]];
$usuarisPipeline[] = ['$limit' => 5];

$usuarisMesActiusCursor = $collection->aggregate($usuarisPipeline);
$usuarisMesActius = iterator_to_array($usuarisMesActiusCursor, false);

// Accessos per dia
$accessosPipeline = [];
if (!empty($filters)) $accessosPipeline[] = ['$match' => $filters];
$accessosPipeline[] = [
    '$group' => [
        '_id' => ['$dateToString' => ['format' => "%Y-%m-%d", 'date' => '$data']],
        'total' => ['$sum' => 1]
    ]
];
$accessosPipeline[] = ['$sort' => ['_id' => 1]];

$accessosPerDiaCursor = $collection->aggregate($accessosPipeline);
$accessosPerDia = iterator_to_array($accessosPerDiaCursor, false);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadístiques d'Accés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Estadístiques d'Accés</h1>

        <form method="get" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="data" class="form-label">Data (YYYY-MM-DD):</label>
                    <input type="date" id="data" name="data" class="form-control" value="<?= htmlspecialchars($_GET['data'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="usuari" class="form-label">Usuari:</label>
                    <input type="text" id="usuari" name="usuari" class="form-control" value="<?= htmlspecialchars($_GET['usuari'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="pagina" class="form-label">Pàgina:</label>
                    <input type="text" id="pagina" name="pagina" class="form-control" value="<?= htmlspecialchars($_GET['pagina'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </form>

        <h2>Pàgines més visitades</h2>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Pàgina</th>
                        <th>Visites</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paginesMesVisitades as $pagina): ?>
                        <tr>
                            <td><?= htmlspecialchars($pagina['_id']) ?></td>
                            <td><?= $pagina['visites'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2>Usuaris més actius</h2>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Usuari</th>
                        <th>Visites</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarisMesActius as $usuari): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuari['_id']) ?></td>
                            <td><?= $usuari['visites'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <h2>Accessos per dia</h2>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Data</th>
                        <th>Accessos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accessosPerDia as $acc): ?>
                        <tr>
                            <td><?= $acc['_id'] ?></td>
                            <td><?= $acc['total'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="admin.html" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
