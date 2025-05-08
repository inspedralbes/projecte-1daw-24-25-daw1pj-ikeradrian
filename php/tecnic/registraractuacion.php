<?php
    require "../connexio.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $cod_incidencia = $_POST['cod_incidencia'];
        $cod_tecnic = $_POST['cod_tecnic'];
        $temps_dedicat = $connexion->real_escape_string($_POST['temps_dedicat']);
        $data = date('Y-m-d H:i:s');
        $descripcio = $connexion->real_escape_string($_POST['descripcio']);

        $sql = "INSERT INTO Actuacions (cod_incidencia, cod_tecnic, data_actuacio, temps_dedicat, descripcio)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sssss", $cod_incidencia, $cod_tecnic, $data, $temps_dedicat, $descripcio);
        $stmt->execute();
    }
    $connexion->close();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Actuació</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">Registrar una actuació tècnica</h2>

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
                <label for="temps_dedicat" class="form-label">Temps dedicat (minuts)</label>
                <input type="text" class="form-control" id="temps_dedicat" name="temps_dedicat" required>
            </div>
            <div class="mb-3">
                <label for="descripcio" class="form-label">Descripció</label>
                <input type="text" class="form-control" id="descripcio" name="descripcio" required>
            </div>
            <button type="submit" class="btn btn-outline-primary w-100">Registrar actuació</button>
        </form>

        <div class="mt-4">
            <a href="tecnic.html" class="btn btn-outline-secondary">🔙 Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
