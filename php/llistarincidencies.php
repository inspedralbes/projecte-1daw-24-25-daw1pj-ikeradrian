<?php
require_once 'connexio.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-primary text-center mb-4">Gestor d'Incidències</h1>
    <h2 class="text-secondary text-center mb-4">Llistat d'incidències</h2>

    <?php
    $sql = "SELECT cod_incidencia, estat FROM Incidencies";
    $result = $connexion->query($sql);

    if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Codi Incidència</th>
                        <th scope="col">Estat</th>
                        <th scope="col">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $cod_incidencia = htmlspecialchars($row["cod_incidencia"]);
                        $estat = htmlspecialchars($row["estat"]);
                    ?>
                        <tr>
                            <td><?= $cod_incidencia ?></td>
                            <td><?= $estat ?></td>
                            <td>
                                <a href="esborrar.php?cod_incidencia=<?= $cod_incidencia ?>" class="btn btn-sm btn-outline-danger">Esborrar</a>
                            </td>
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
        <a href="usuario.html" class="btn btn-outline-secondary me-2">Inici</a>
        <a href="crearincidencia.php" class="btn btn-outline-success">Crear nova incidència</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
