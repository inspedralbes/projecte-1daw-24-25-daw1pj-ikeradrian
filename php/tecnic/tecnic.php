<?php
$name = "tecnic";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Zona de tècnic";
rellenarMongo($name, $ip, $hora, $pages);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Tècnic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container text-center py-5">
        <h1 class="text-danger mb-3">Zona del Tècnic</h1>
        <h2 class="text-secondary mb-4">Tria una acció</h2>

        <div class="d-grid gap-4 col-6 mx-auto">
            <a href="elegirincidencia.php" class="btn btn-outline-danger btn-lg border-2" style="background-color: #f8d7da;">Registrar actuació</a>
            <a href="modificarincidencia.php" class="btn btn-outline-danger btn-lg border-2" style="background-color: #f8d7da;">Modificar incidència</a>
            <a href="../index.php" class="btn btn-outline-secondary btn-lg border-2">Tornar enrere</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
