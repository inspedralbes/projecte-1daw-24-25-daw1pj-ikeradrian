<?php
require '../connexion_mongo.php';
require '../connexio.php';
$name = "tecnic";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Zona de tècnic";
rellenarMongo($collection, $name, $ip, $hora, $pages);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Tècnic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            font-size: 1.15rem;
        }
        h1 {
            color: #b02a37;
            font-weight: 700;
            font-size: 2.5rem;
        }
        h2 {
            color: #6c757d;
            font-weight: 400;
            font-size: 1.6rem;
        }
        .btn-custom {
            font-size: 1.2rem;
            padding: 0.85rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeUp 0.6s ease-out forwards;
        }
        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.25rem;
            }
            .btn-custom {
                font-size: 1rem;
                padding: 0.75rem 1rem;
            }
            .d-grid.col-6 {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <div class="container text-center py-5">
        <h1 class="mb-3">Zona del Tècnic</h1>
        <h2 class="mb-4">Tria una acció</h2>

        <div class="d-grid gap-4 col-6 mx-auto">
            <a href="elegirincidencia.php" class="btn btn-outline-danger btn-lg border-2 btn-custom fade-in" style="background-color: #f8d7da;">Registrar actuació</a>
            <a href="modificarincidencia.php" class="btn btn-outline-danger btn-lg border-2 btn-custom fade-in" style="background-color: #f8d7da;">Modificar incidència</a>
            <a href="../index.php" class="btn btn-outline-secondary btn-lg border-2 btn-custom fade-in">Tornar enrere</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
