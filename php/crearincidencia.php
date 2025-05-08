<?php 
    require "connexio.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $Departament = $connexion->real_escape_string($_POST['Departament']);
        $Data = date('Y-m-d H:i:s');
        $Descripcio = $connexion->real_escape_string($_POST['Descripcio']);

        $sql = "INSERT INTO Incidencies (departament, data, descripcio) VALUES (?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("sss", $Departament, $Data, $Descripcio);
        $stmt->execute();

        $missatge = "Incidència guardada correctament.";
    }
    $connexion->close();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">Crear nova incidència</h2>

        <?php if (!empty($missatge)) echo "<div class='alert alert-success'>$missatge</div>"; ?>

        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="Departament" class="form-label">Departament de la incidència:</label>
                <input type="text" class="form-control" id="Departament" name="Departament" required>
            </div>

            <div class="mb-3">
                <label for="Descripcio" class="form-label">Descripció:</label>
                <input type="text" class="form-control" id="Descripcio" name="Descripcio" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Enviar</button>
        </form>

        <div class="mt-4">
            <a href="usuario.html" class="btn btn-outline-secondary">⬅ Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
