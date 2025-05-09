<?php 
    require "../connexio.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ID_Tecnico = $_POST['ID_Tecnico'];
        $ID_Incidencia = $_POST['ID_Incidencia'];

        $sql1 = "UPDATE Incidencies SET cod_tecnic = ? WHERE cod_incidencia = ?";
        $stmt1 = $connexion->prepare($sql1);
        $stmt1->bind_param("ss", $ID_Tecnico, $ID_Incidencia);
        $stmt1->execute();

        $sql2 = "UPDATE Tecnics SET total_incidencies = (total_incidencies + 1) WHERE cod_tecnic = ?";
        $stmt2 = $connexion->prepare($sql2);
        $stmt2->bind_param("s", $ID_Tecnico);
        $stmt2->execute();
        
        $missatge = "Tecnico asignado correctamente";
    }
    $connexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Asignar tecnicos</title>
</head>
<body class = "bg-light">
    <div class="container text-center py-5">
        <h1 class="text-primary mb-3">Gestor d'Incidències</h1>
        <h2 class="text-secondary mb-4">Asignar técnico a una incidencia</h2>
        <form method="post" class="text-start mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="ID_Incidencia" class="form-label">ID de la incidencia a asignar</label>
                <input type="text" class="form-control" id="ID_Incidencia" name="ID_Incidencia" required>
            </div>

            <div class="mb-3">
                <label for="ID_Tecnico" class="form-label">ID del técnico asignado</label>
                <input type="text" class="form-control" id="ID_Tecnico" name="ID_Tecnico" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Enviar</button>
         </form>
        <div class="mt-4">
             <a href="admin.html" class="btn btn-outline-secondary">Tornar a l'inici</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>