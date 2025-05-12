<?php
require "../connexio.php";

$missatge = "";

$sql_incidencies = "SELECT cod_incidencia, descripcio FROM Incidencies WHERE estat = 'Oberta'";
$result_incidencies = $connexion->query($sql_incidencies);

if (!$result_incidencies) {
    die("Error en la consulta de incidencias: " . $connexion->error);
}

$sql_tecnics = "SELECT cod_tecnic, nom_tecnic FROM Tecnics";
$result_tecnics = $connexion->query($sql_tecnics);

if (!$result_tecnics) {
    die("Error en la consulta de técnicos: " . $connexion->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_incidencia = $_POST['cod_incidencia'];
    $cod_tecnic = $_POST['cod_tecnic'];
    $temps_dedicat = $connexion->real_escape_string($_POST['temps_dedicat']);
    $data = date('Y-m-d H:i:s');
    $descripcio = $connexion->real_escape_string($_POST['descripcio']);

    $sql = "INSERT INTO Actuacions (cod_incidencia, cod_tecnic, data_actuacio, temps_dedicat, descripcio)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssss", $cod_incidencia, $cod_tecnic, $data, $temps_dedicat, $descripcio);
    if ($stmt->execute()) {
        $missatge = "Actuació registrada correctament.";
    } else {
        $missatge = "Error en registrar la actuació.";
    }

    $sql2 = "UPDATE Departament 
             SET temps_dedicat = temps_dedicat + ? 
             WHERE cod_depart = (SELECT departament FROM Incidencies WHERE cod_incidencia = ?)";
    $stmt2 = $connexion->prepare($sql2);
    $stmt2->bind_param("ss", $temps_dedicat, $cod_incidencia);
    $stmt2->execute();

    $stmt->close();
    $stmt2->close();
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

        <?php if (!empty($missatge)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($missatge, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="cod_incidencia" class="form-label">Selecciona incidència</label>
                <select class="form-select" id="cod_incidencia" name="cod_incidencia" required>
                    <option value="" disabled selected>Selecciona una incidència</option>
                    <?php
                    if ($result_incidencies && $result_incidencies->num_rows > 0) {
                        while ($row = $result_incidencies->fetch_assoc()) {
                            $cod_incidencia = htmlspecialchars($row['cod_incidencia'], ENT_QUOTES, 'UTF-8');
                            $descripcio = htmlspecialchars($row['descripcio'], ENT_QUOTES, 'UTF-8');
                            echo "<option value='$cod_incidencia'>$descripcio</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hi ha incidències obertes.</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="cod_tecnic" class="form-label">Selecciona tècnic</label>
                <select class="form-select" id="cod_tecnic" name="cod_tecnic" required>
                    <option value="" disabled selected>Selecciona un tècnic</option>
                    <?php
                    if ($result_tecnics && $result_tecnics->num_rows > 0) {
                        while ($row = $result_tecnics->fetch_assoc()) {
                            $cod_tecnic = htmlspecialchars($row['cod_tecnic'], ENT_QUOTES, 'UTF-8');
                            $nom_tecnic = htmlspecialchars($row['nom_tecnic'], ENT_QUOTES, 'UTF-8');
                            echo "<option value='$cod_tecnic'>$nom_tecnic</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No hi ha tècnics disponibles.</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="temps_dedicat" class="form-label">Temps dedicat (minuts)</label>
                <input type="number" class="form-control" id="temps_dedicat" name="temps_dedicat" required>
            </div>

            <div class="mb-3">
                <label for="descripcio" class="form-label">Descripció</label>
                <textarea class="form-control" id="descripcio" name="descripcio" rows="3" required></textarea>
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
