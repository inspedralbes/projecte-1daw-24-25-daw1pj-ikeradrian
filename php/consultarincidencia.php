<?php
require "connexio.php";
$consulta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoConsulta = $_POST['codigoConsulta'];
    $sql = "SELECT estat FROM Incidencies WHERE cod_incidencia = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $codigoConsulta);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $estat = "";
        $stmt->bind_result($estat);
        $stmt->fetch();
        $consulta = "<div class='alert alert-success'>✅ La incidència <strong>$codigoConsulta</strong> està <strong>$estat</strong>.</div>";
    } else {
        $consulta = "<div class='alert alert-danger'>⚠ No hi ha cap incidència amb aquest codi.</div>";
    }

    $stmt->close();
}
$connexion->close();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">🔍 Consultar incidència</h2>

        <?php if (!empty($consulta)) echo $consulta; ?>

        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="codigoConsulta" class="form-label">Codi de consulta:</label>
                <input type="text" class="form-control" id="codigoConsulta" name="codigoConsulta" required>
            </div>
            <button type="submit" class="btn btn-info w-100">Consultar</button>
        </form>

        <div class="mt-4">
            <a href="index.html" class="btn btn-outline-secondary">⬅ Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
