<?php 
    require "connexio.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $Departament = $connexion->real_escape_string($_POST['Departament']);
        $Data = date('Y-m-d H:i:s');
        $Descripcio = $connexion->real_escape_string($_POST['Descripcio']);
            $sql = "INSERT INTO Incidencies (departament, data, descripcio) 
                VALUES (?, ?, ?)";
            $stmt = $connexion->prepare($sql);
            $stmt->bind_param("sss", $Departament, $Data, $Descripcio);
            $stmt->execute();
            echo "<h1>Incidencia guardada correctamente</h1>";

    }

    $connexion->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Incidencia </h1>
    <form method="post" action=""> 
        <label for="Departament">Departament de la incidencia:</label> <br>
        <input type="text" id="Departament" name="Departament" required> <br>

        <!-- <label for="Data">Data de la incidencia:</label> <br>
        <input type="date" id="Data" name="Data" required> <br> -->

        <label for="Descripcio">Descripció:</label> <br>
        <input type="text" id="Descripcio" name="Descripcio" required> <br>

        <input type="submit" value="Enviar">
    </form>
    <a href="index.html">
        <button>Página de inicio</button>
    </a>
</body>
</html>