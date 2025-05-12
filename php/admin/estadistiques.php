<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadístiques - Gestor d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center py-5">
        <h1 class="mb-4">Estadístiques</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>128</h2>
                    <p>Incidències registrades</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>95</h2>
                    <p>Resoltes pels tècnics</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h2>33</h2>
                    <p>Pendents de resolució</p>
                </div>
            </div>
        </div>
        <a href="admin.html" class="btn btn-secondary mt-4">Tornar al menú</a>
    </div>
</body>
</html>
