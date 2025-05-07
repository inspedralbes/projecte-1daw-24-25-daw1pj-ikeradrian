<?php
    require "connexio.php";
    $consulta = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $codigoConsulta = $_POST['codigoConsulta'];
        $sql = "SELECT cod_incidencia, estat FROM Incidencies WHERE cod_incidencia = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("s", $codigoConsulta);
        $stmt->execute();

        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $stmt->bind_param($cod_incidencia, $estat);
        }

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
    <form method="post" action=""> 
        <label for="codigoConsulta">Especifique su código de consulta</label> <br>
        <input type="text" id="codigoConsulta" name="codigoConsulta" required> <br>
        <input type="submit" value="Consultar">
</body>
</html>