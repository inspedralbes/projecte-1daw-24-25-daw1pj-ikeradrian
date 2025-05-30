<?php
require 'connexion_mongo.php';
require 'connexio.php';
$name = "client";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Gestor de incidencias";
rellenarMongo($collection, $name, $ip, $hora, $pages);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor d'Incidències - Inici</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f8f9fa;
            font-size: 1.15rem;
        }
        h1, h2 {
            font-family: 'Merriweather', serif;
        }
        h1 {
            color: #003366;
            font-size: 2.75rem;
            font-weight: 700;
        }
        h2 {
            color: #666;
            font-size: 1.75rem;
            font-weight: 400;
        }
        .btn-custom {
            font-weight: 600;
            font-size: 1.2rem;
            padding: 0.85rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-usuari {
            background-color: #005b96;
            color: white;
            border: none;
        }
        .btn-tecnic {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        .btn-admin {
            background-color: #343a40;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            opacity: 0.95;
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
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .invisible {
            visibility: hidden;
        }
    </style>
</head>
<body>
    <div class="container text-center py-5">
        <h1 class="mb-3">Gestor d'Incidències</h1>
        <h2 class="mb-4">Selecciona el teu rol</h2>

        <div class="d-grid gap-3 col-6 mx-auto" id="button-group">
            <a href="usuari/usuario.php" class="btn btn-custom btn-usuari invisible">Sóc Usuari</a>
            <a href="tecnic/tecnic.php" class="btn btn-custom btn-tecnic invisible">Sóc Tècnic</a>
            <a href="admin/admin.php" class="btn btn-custom btn-admin invisible">Sóc Administrador</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('#button-group a');
            buttons.forEach((btn, index) => {
                setTimeout(() => {
                    btn.classList.remove('invisible');
                    btn.classList.add('fade-in');
                }, index * 200); 
            });
        });
    </script>
</body>
</html>
