<?php
require "../connexio.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_incidencia = $_POST['cod_incidencia'];
    $cod_tecnic = $_POST['cod_tecnic'];
    $estat = $connexion->real_escape_string($_POST['estat']);
    $descripcio = $connexion->real_escape_string($_POST['descripcio']);

    $sql = "UPDATE Incidencies SET cod_tecnic = ?, estat = ?, descripcio = ? WHERE cod_incidencia = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ssss", $cod_tecnic, $estat, $descripcio, $cod_incidencia);
    $stmt->execute();
    $connexion->close();
}

$name = "tecnic";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Modificar incidència";
rellenarMongo($name, $ip, $hora, $pages);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">Modificar una incidència</h2>

        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="cod_incidencia" class="form-label">ID d'incidència</label>
                <input type="text" class="form-control" id="cod_incidencia" name="cod_incidencia" required>
            </div>
            <div class="mb-3">
                <label for="cod_tecnic" class="form-label">ID del tècnic</label>
                <input type="text" class="form-control" id="cod_tecnic" name="cod_tecnic" required>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Estat de la incidència</label>

                <div class="form-check">
                    <input type="radio" class="form-check-input" id="obert" name="estat" value="Oberta" required>
                    <label for="obert" class="form-check-label">Oberta</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="asignat" name="estat" value="Asignada">
                    <label for="asignat" class="form-check-label">Assignada</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="treballant" name="estat" value="En progres">
                    <label for="treballant" class="form-check-label">En progrés</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="tancat" name="estat" value="Tancada">
                    <label for="tancat" class="form-check-label">Tancada</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcio" class="form-label">Descripció</label>
                <input type="text" class="form-control" id="descripcio" name="descripcio" required>
            </div>

            <button type="submit" class="btn btn-outline-primary w-100">Actualitzar incidència</button>
        </form>

        <div class="mt-4">
            <a href="tecnic.php" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
