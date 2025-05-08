<?php
    require "../connexio.php;";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $cod_incidencia = $_POST['cod_incidencia'];
        $cod_tecnic = $_POST['cod_tecnic'];
        $temps_dedicat = $connexion->real_escape_string($_POST['temps_dedicat']);
        $Data = date('Y-m-d H:i:s');
        $descripcio = $connexion->real_escape_string($_POST['descripcio']);
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" class="text-start mx-auto mt-4" style="max-width: 500px;">
        <div class="mb-3">
            <label for="cod_incidencia" class="form-label">Incidencia en la que se realiza la actuacion</label>
            <input type="text" class="form-control" id="cod_incidencia" name="cod_incidencia" required>
        </div>
        <div class="mb-3">
            <label for="cod_tecnic" class="form-label">Tecnico que realiza la actuacion</label>
            <input type="text" class="form-control" id="cod_tecnic" name="cod_tecnic" required>
        </div>
        <div class="mb-3">
            <label for="temps_dedicat" class="form-label">Tiempo dedicado</label>
            <input type="text" class="form-control" id="temps_dedicat" name="temps_dedicat" required>
        </div>
        <div class="mb-3">
            <label for="descripcio" class="form-label">Descripcion</label>
            <input type="text" class="form-control" id="descripcio" name="descripcio" required>
        </div>
    </form>
</body>
</html>