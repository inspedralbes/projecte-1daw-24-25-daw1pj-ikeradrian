<?php
require "../connexio.php";

$missatge = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_incidencia = $_GET['cod_incidencia'] ?? "";

    if (!$cod_incidencia) {
        die("Codi d'incidència no proporcionat.");
    }

    $sql_nom = "SELECT nom_tecnic FROM Incidencies WHERE cod_incidencia = ?";
    $stmt_nom = $connexion->prepare($sql_nom);
    $stmt_nom->bind_param("s", $cod_incidencia);
    $stmt_nom->execute();
    $result_nom = $stmt_nom->get_result();

    if ($result_nom->num_rows === 0) {
        die("No s'ha trobat la incidència.");
    }

    $row_nom = $result_nom->fetch_assoc();
    $nom_tecnic = $row_nom['nom_tecnic'];
    $sql_tecnic = "SELECT cod_tecnic FROM Tecnics WHERE nom_tecnic = ?";
    $stmt_tecnic = $connexion->prepare($sql_tecnic);
    $stmt_tecnic->bind_param("s", $nom_tecnic);
    $stmt_tecnic->execute();
    $result_tecnic = $stmt_tecnic->get_result();

    if ($result_tecnic->num_rows === 0) {
        die("No s'ha trobat el tècnic amb nom: $nom_tecnic");
    }

    $row_tecnic = $result_tecnic->fetch_assoc();
    $cod_tecnic = $row_tecnic['cod_tecnic'];
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
    $stmt_nom->close();
    $stmt_tecnic->close();
}

$connexion->close();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Registrar Actuació</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">Registrar una actuació tècnica</h2>

        <?php if (!empty($missatge)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($missatge, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
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
            <a href="elegirincidencia.php" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>

</body>
</html>
