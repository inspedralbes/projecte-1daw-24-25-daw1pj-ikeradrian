<?php 
require "../connexio.php"; 
require '../connexion_mongo.php';
$name = "admin";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Asignar tècnics";
rellenarMongo($collection, $name, $ip, $hora, $pages);

$missatge = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_Tecnico = $_POST['nom_tecnico'] ?? ''; 
    $ID_Incidencia = $_POST['ID_Incidencia'];
    $prioritat = $_POST['prioritat'] ?? 'Mitjana'; 


    if (!empty($nom_Tecnico) && !empty($ID_Incidencia)) {

        $sql1 = "UPDATE Incidencies SET nom_tecnic = ?, prioritat = ? WHERE cod_incidencia = ?";
        $stmt1 = $connexion->prepare($sql1);
        $stmt1->bind_param("ssi", $nom_Tecnico, $prioritat, $ID_Incidencia); 

        if ($stmt1->execute()) {
            $missatge = "Tècnic assignat correctament amb la prioritat.";
        } else {
            $missatge = "Error al assignar el tècnic o la prioritat.";
        }

        $stmt1->close();
    } else {
        $missatge = "Tots els camps són obligatoris.";
    }
}


$sql = "SELECT Incidencies.cod_incidencia, Incidencies.departament, Incidencies.estat, Incidencies.descripcio, 
               Incidencies.nom_tecnic, Incidencies.prioritat, Departament.nom_depart 
        FROM Incidencies 
        JOIN Departament ON Incidencies.departament = Departament.cod_depart";
$result = $connexion->query($sql);

$sql_tecnics = "SELECT cod_tecnic, nom_tecnic FROM Tecnics";
$tecnics_result = $connexion->query($sql_tecnics);


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

        <?php if (!empty($missatge)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($missatge, ENT_QUOTES, 'UTF-8') ?></div>
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
                        <th scope="col">Prioritat</th>
                        <th scope="col" class="text-center">Assignar Tècnic</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $cod_incidencia = htmlspecialchars($row["cod_incidencia"] ?? '', ENT_QUOTES, 'UTF-8');
                            $departament = htmlspecialchars($row["nom_depart"] ?? '', ENT_QUOTES, 'UTF-8');
                            $estat = htmlspecialchars($row["estat"] ?? '', ENT_QUOTES, 'UTF-8');
                            $descripcio = htmlspecialchars($row["descripcio"] ?? '', ENT_QUOTES, 'UTF-8');
                            $nom_tecnic = htmlspecialchars($row["nom_tecnic"] ?? '', ENT_QUOTES, 'UTF-8');
                            $prioritat = htmlspecialchars($row["prioritat"] ?? 'Mitjana', ENT_QUOTES, 'UTF-8'); // Si no tiene prioridad, por defecto 'Mitjana'

                    ?>
                    <tr>
                        <td><?= $cod_incidencia ?></td>
                        <td><?= $departament ?></td>
                        <td><?= $estat ?></td>
                        <td><?= $descripcio ?></td>
                        <td><?= $nom_tecnic ? $nom_tecnic : 'No assignat' ?></td>
                        <td><?= $prioritat ?></td>
                        <td class="text-center">
                          
                            <form method="POST">
                                <input type="hidden" name="ID_Incidencia" value="<?= $cod_incidencia ?>">

                            
                                <select class="form-select mb-2" name="nom_tecnico" required>
                                    <option value="" disabled selected>Selecciona tècnic</option>
                              
                                    <?php
                               
                                    if ($tecnics_result && $tecnics_result->num_rows > 0) {
                                   
                                        $tecnics_result->data_seek(0);
                                        while ($tecnic = $tecnics_result->fetch_assoc()) {
                                            $id_tecnic = htmlspecialchars($tecnic["cod_tecnic"] ?? '', ENT_QUOTES, 'UTF-8');
                                            $tecnic_nom = htmlspecialchars($tecnic["nom_tecnic"] ?? '', ENT_QUOTES, 'UTF-8');
                                            
                                           
                                            $selected = ($tecnic_nom == $row["nom_tecnic"]) ? 'selected' : '';
                                            echo "<option value='$tecnic_nom' $selected>$tecnic_nom</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <select class="form-select" name="prioritat" required>
                                    <option value="Molt alta" <?= $prioritat == 'Molt alta' ? 'selected' : '' ?>>Molt alta</option>
                                    <option value="Alta" <?= $prioritat == 'Alta' ? 'selected' : '' ?>>Alta</option>
                                    <option value="Mitjana" <?= $prioritat == 'Mitjana' ? 'selected' : '' ?>>Mitjana</option>
                                    <option value="Baixa" <?= $prioritat == 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                                    <option value="Molt baixa" <?= $prioritat == 'Molt baixa' ? 'selected' : '' ?>>Molt baixa</option>
                                </select>

                                <button type="submit" class="btn btn-warning mt-2 w-100">Modificar</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No hi ha incidències per mostrar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="admin.php" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
