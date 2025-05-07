<?php
    require "connexio.php";
    $consulta = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $codigoConsulta = $_POST['codigoConsulta'];
        $sql = "SELECT estat FROM Incidencies WHERE cod_incidencia = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("s", $codigoConsulta);
        $stmt->execute();

        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $estat = "";
            $stmt->bind_result($estat);
            $stmt->FETCH();
            $consulta = "<h3>La incidencia $codigoConsulta está $estat</h3>";
            echo $consulta;
        }
        else{
            $consulta = "<h3>No hay incidencias con este codigo</h3>";
            echo $consulta;
        }
        
        $stmt->close();

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
    <form method="post" action=""> 
        <label for="codigoConsulta">Especifique su código de consulta</label> <br>
        <input type="text" id="codigoConsulta" name="codigoConsulta" required> <br>
        <input type="submit" value="Consultar">
    </form>
</body>
</html>