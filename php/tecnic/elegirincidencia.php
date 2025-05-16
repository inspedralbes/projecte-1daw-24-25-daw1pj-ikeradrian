<?php
require "../connexio.php";
require '../connexion_mongo.php';
$name = "tecnic";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Escollir incidència";
rellenarMongo($client, $name, $ip, $hora, $pages);

$sql = "SELECT cod_incidencia, descripcio, nom_tecnic, prioritat FROM Incidencies";
$resultat = $connexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="mb-4">Listado de Incidencias</h1>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Técnico Asignado</th>
                    <th>Prioridad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultat && $resultat->num_rows > 0): ?>
                    <?php while ($fila = $resultat->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['cod_incidencia']) ?></td>
                            <td><?= nl2br(htmlspecialchars($fila['descripcio'])) ?></td>
                            <td><?= htmlspecialchars($fila['nom_tecnic']) ?></td>
                            <td><?= htmlspecialchars($fila['prioritat'] ?? 'Sin asignar') ?></td>
                            <td>
                                <a href="registraractuacion.php?cod_incidencia=<?= urlencode($fila['cod_incidencia']) ?>" class="btn btn-primary btn-sm">
                                    Registrar actuación
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay incidencias registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-center">
        <a href="tecnic.php" class="btn btn-outline-secondary">Tornar a l'inici</a>
    </div>
</body>
</html>

<?php $connexion->close(); ?>
