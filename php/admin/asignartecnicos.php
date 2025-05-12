<?php 
require "../connexio.php"; // Asegúrate de que la conexión a la base de datos sea correcta

// Variable para mostrar el mensaje de éxito o error
$missatge = "";

// Si se ha enviado el formulario para asignar un técnico
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_Tecnico = $_POST['ID_Tecnico'];
    $ID_Incidencia = $_POST['ID_Incidencia'];

    // Actualizar la incidencia con el técnico seleccionado
    $sql1 = "UPDATE Incidencies SET cod_tecnic = ? WHERE cod_incidencia = ?";
    $stmt1 = $connexion->prepare($sql1);
    $stmt1->bind_param("ss", $ID_Tecnico, $ID_Incidencia);

    if ($stmt1->execute()) {
        $missatge = "Tècnic assignat correctament.";
    } else {
        $missatge = "Error al assignar el tècnic.";
    }

    $stmt1->close();
}

// Obtener las incidencias y técnicos disponibles
$sql = "SELECT cod_incidencia, departament, estat, descripcio, cod_tecnic FROM Incidencies";
$result = $connexion->query($sql);

// Obtener técnicos disponibles
$sql_tecnics = "SELECT cod_tecnic, nom_tecnic FROM Tecnics";
$tecnics_result = $connexion->query($sql_tecnics);

// Cerrar la conexión después de todas las consultas
$connexion->close();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor d'Incidències - Assignar Tècnic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-3">Gestor d'Incidències</h1>
        <h2 class="text-center mb-4">Assignar tècnic a una incidència</h2>

        <!-- Mostrar mensaje de confirmación -->
        <?php if (!empty($missatge)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($missatge) ?></div>
        <?php endif; ?>

        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-bordered align-middle bg-white rounded">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Codi Incidència</th>
                        <th scope="col">Departament</th>
                        <th scope="col">Estat</th>
                        <th scope="col">Descripció</th>
                        <th scope="col">Tècnic Actual</th>
                        <th scope="col" class="text-center">Assignar Tècnic</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Si hay resultados de incidencias, mostrarlas
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $cod_incidencia = htmlspecialchars($row["cod_incidencia"]);
                            $departament = htmlspecialchars($row["departament"]);
                            $estat = htmlspecialchars($row["estat"]);
                            $descripcio = htmlspecialchars($row["descripcio"]);
                            $cod_tecnic = htmlspecialchars($row["cod_tecnic"]);
                    ?>
                    <tr>
                        <td><?= $cod_incidencia ?></td>
                        <td><?= $departament ?></td>
                        <td><?= $estat ?></td>
                        <td><?= $descripcio ?></td>
                        <td><?= $cod_tecnic ? $cod_tecnic : 'No assignat' ?></td>
                        <td class="text-center">
                            <!-- Formulario para asignar un tècnic -->
                            <form method="POST">
                                <input type="hidden" name="ID_Incidencia" value="<?= $cod_incidencia ?>">
                                <select class="form-select" name="ID_Tecnico" required>
                                    <option value="" disabled selected>Selecciona tècnic</option>
                                    <!-- Aquí cargamos los técnicos disponibles -->
                                    <?php
                                    // Verificar si hay técnicos disponibles
                                    if ($tecnics_result && $tecnics_result->num_rows > 0) {
                                        while ($tecnic = $tecnics_result->fetch_assoc()) {
                                            $id_tecnic = htmlspecialchars($tecnic["cod_tecnic"]);
                                            $nom_tecnic = htmlspecialchars($tecnic["nom_tecnic"]);
                                            echo "<option value='$id_tecnic' " . ($cod_tecnic == $id_tecnic ? 'selected' : '') . ">$nom_tecnic</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-warning mt-2 w-100">Modificar</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hi ha incidències per mostrar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="admin.html" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
