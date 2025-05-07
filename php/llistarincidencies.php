<?php

//Sempre volem tenir una connexió a la base de dades, així que la creem al principi del fitxer
require_once 'connexio.php';
// Un cop inclòs el fitxer connexio.php, ja podeu utilitzar la variable $conn per a fer les consultes a la base de dades.

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Llistat d'incidències</h1>
    <?php

    $sql = "SELECT cod_incidencia FROM Incidencies";
    $result = $connexion->query($sql);

    // Comprovar si hi ha resultats
    if ($result && $result->num_rows > 0) {
        // Mostrar resultats
        while ($row = $result->fetch_assoc()) {
            $cod_incidencia = htmlspecialchars($row["cod_incidencia"] ?? "");
            $estat = htmlspecialchars($row["estat"] ?? "");
            echo "<p>Codi: $cod_incidencia — Estat: $estat ";
            echo "<a href='esborrar.php?cod_incidencia=$cod_incidencia'>Esborrar</a></p>";
        }

    } else {
        echo "<p>No hi ha dades a mostrar.</p>";
    }

    // Tancar la connexió
    $connexion->close();
    ?>

    <div id="menu">
        <hr>
        <a href="index.html">
            <button>Página de inicio</button>
        </a>
        <a href="crearincidencia.php">
            <button>Crear incidència</button>
        </a>
    </div>

</body>

</html>