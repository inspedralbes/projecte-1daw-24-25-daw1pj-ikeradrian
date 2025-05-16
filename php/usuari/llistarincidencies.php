<?php
require_once '../connexio.php';
require '../connexion_mongo.php';
$name = "usuari";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Llistat d'incidències";
rellenarMongo($collection, $name, $ip, $hora, $pages);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f8f9fa;
            font-size: 1.1rem;
        }
        h1, h2 {
            font-family: 'Merriweather', serif;
        }
        h1 {
            color: #003366;
            font-size: 2.5rem;
            font-weight: 700;
        }
        h2 {
            color: #555;
            font-size: 1.75rem;
            font-weight: 400;
        }
        .table th, .table td {
            vertical-align: middle;
            font-size: 1.05rem;
        }
        .btn {
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .btn-outline-danger {
            border-width: 2px;
        }
        .btn-outline-secondary,
        .btn-outline-success {
            border-width: 2px;
            font-size: 1rem;
            padding: 0.6rem 1.25rem;
        }
        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.25rem;
            }
            .table th, .table td {
                font-size: 0.95rem;
            }
            .btn {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="text-center mb-3">Gestor d'Incidències</h1>
    <h2 class="text-center mb-4">Llistat d'incidències</h2>

    <?php
    // Consulta amb JOIN per obtenir també el nom del departament
    $sql = "SELECT i.cod_incidencia, d.nom_depart AS departament, i.estat, i.prioritat, i.descripcio
            FROM Incidencies i
            LEFT JOIN Departament d ON i.departament = d.cod_depart";

    $result = $connexion->query($sql);

    if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white rounded">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Codi Incidència</th>
                        <th scope="col">Departament</th>
                        <th scope="col">Estat</th>
                        <th scope="col">Prioritat</th>
                        <th scope="col" class="text-center">Descripció</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()):
                        $cod_incidencia = htmlspecialchars((string) $row["cod_incidencia"]);
                        $departament = htmlspecialchars((string) ($row["departament"] ?? 'Desconegut'));
                        $estat = htmlspecialchars((string) $row["estat"]);
                        $prioritat = htmlspecialchars((string) ($row["prioritat"] ?? 'Sin assignar'));
                        $descripcio = htmlspecialchars((string) ($row["descripcio"] ?? ''));
                    ?>
                        <tr>
                            <td><?= $cod_incidencia ?></td>
                            <td><?= $departament ?></td>
                            <td><?= $estat ?></td>
                            <td><?= $prioritat ?></td>
                            <td class="text-center"><?= $descripcio ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No hi ha incidències a mostrar.</div>
    <?php endif; ?>

    <?php $connexion->close(); ?>

    <div class="text-center mt-4">
        <a href="usuario.php" class="btn btn-outline-secondary me-2">Inici</a>
        <a href="crearincidencia.php" class="btn btn-outline-success">Crear nova incidència</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
