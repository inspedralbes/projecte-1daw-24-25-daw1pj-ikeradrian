<?php 
    require "connexio.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $Departament = $connexion->real_escape_string($_POST['Departament']);
        $Data = date('Y-m-d H:i:s');
        $Descripcio = $connexion->real_escape_string($_POST['Descripcio']);
        if(!empty('$Departament') && !empty('$Descripcio')){
            $sql = "INSERT INTO Incidencies (departament, data, descripcio) 
                VALUES ('$Departament', '$Data', '$Descripcio')";
        }

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
        <input type="text" id="Descripio" name="Descripcio" required> <br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>