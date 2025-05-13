<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../vendor/autoload.php';
use MongoDB\Client;
use MongoDB\BSON\UTCDateTime;

$client = new Client("mongodb://localhost:27017");
$collection = $client->gestor_incidencies->access_logs;

// Pàgines més visitades
$paginesMesVisitades = $collection->aggregate([
    ['$match' => $filters],
    ['$group' => ['_id' => '$pagina', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 5]
]);

// Usuaris més actius
$usuarisMesActius = $collection->aggregate([
    ['$match' => $filters],
    ['$group' => ['_id' => '$usuari', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 5]
]);

// Accés per dia (gràfic)
$accessosPerDia = $collection->aggregate([
    ['$match' => $filters],
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => "%Y-%m-%d", 'date' => '$data']],
        'total' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]]
]);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Estadístiques d'Accés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center mb-4">Estadístiques d'Accés</h1>

    <form method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($_GET['data'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <input type="text" name="usuari" class="form-control" placeholder="Usuari" value="<?= htmlspecialchars($_GET['usuari'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <input type="text" name="pagina" class="form-control" placeholder="Pàgina" value="<?= htmlspecialchars($_GET['pagina'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h2><?= $totalAccessos ?></h2>
                <p>Accessos totals</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h2><?= iterator_count($usuarisMesActius) ?></h2>
                <p>Usuaris més actius</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h2><?= iterator_count($paginesMesVisitades) ?></h2>
                <p>Pàgines més visitades</p>
            </div>
        </div>
    </div>

    <h3>Pàgines més visitades</h3>
    <table class="table table-striped">
        <thead><tr><th>Pàgina</th><th>Visites</th></tr></thead>
        <tbody>
        <?php foreach ($paginesMesVisitades as $p): ?>
            <tr><td><?= htmlspecialchars($p->_id) ?></td><td><?= $p->visites ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Usuaris més actius</h3>
    <table class="table table-striped">
        <thead><tr><th>Usuari</th><th>Visites</th></tr></thead>
        <tbody>
        <?php foreach ($usuarisMesActius as $u): ?>
            <tr><td><?= htmlspecialchars($u->_id) ?></td><td><?= $u->visites ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Accessos al llarg del temps</h3>
    <canvas id="accessChart" height="100"></canvas>

    <div class="text-center mt-4">
        <a href="admin.html" class="btn btn-secondary">Tornar al menú</a>
    </div>
</div>

<script>
    const ctx = document.getElementById('accessChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?= implode(",", array_map(fn($d) => '"' . $d->_id . '"', iterator_to_array($accessosPerDia))) ?>],
            datasets: [{
                label: 'Accessos',
                data: [<?= implode(",", array_map(fn($d) => $d->total, iterator_to_array($accessosPerDia))) ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
