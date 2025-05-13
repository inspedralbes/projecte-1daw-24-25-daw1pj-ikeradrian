<?php 
require "../connexio.php";
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes de Tècnics i Departaments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        h1, h2 {
            color: #003366;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .priority-header {
            background-color: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: bold;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">

        <h1 class="text-center mb-5">Informe de Tècnics</h1>

        <?php

        $sql = "
            SELECT 
                t.nom_tecnic AS tecnic,
                i.cod_incidencia,
                i.data,
                i.prioritat,
                SUM(CAST(a.temps_dedicat AS UNSIGNED)) AS temps_total
            FROM Actuacions a
            JOIN Tecnics t ON a.cod_tecnic = t.cod_tecnic
            JOIN Incidencies i ON a.cod_incidencia = i.cod_incidencia
            WHERE i.estat != 'Tancada'
            GROUP BY t.nom_tecnic, i.cod_incidencia, i.data, i.prioritat
            ORDER BY t.nom_tecnic, 
                     FIELD(i.prioritat, 'Alta', 'Mitjana', 'Baixa'), 
                     i.data;
        ";

        $result = $connexion->query($sql);

        $dades = [];
        while ($row = $result->fetch_assoc()) {
            $tecnic = $row['tecnic'];
            $prioritat = $row['prioritat'] ?? 'Sense prioritat';
            $dades[$tecnic][$prioritat][] = $row;
        }

        foreach ($dades as $tecnic => $prioritats) {
            echo "<div class='card p-4'>";
            echo "<h2 class='card-title'>Tècnic: $tecnic</h2>";

            foreach (['Alta', 'Mitjana', 'Baixa', 'Sense prioritat'] as $nivell) {
                if (isset($prioritats[$nivell])) {
                    echo "<div class='priority-header'>Prioritat: $nivell</div><ul class='list-group mb-3'>";
                    foreach ($prioritats[$nivell] as $incidencia) {
                        echo "<li class='list-group-item'>";
                        echo "Incidència #{$incidencia['cod_incidencia']} - Inici: {$incidencia['data']} - Temps total: {$incidencia['temps_total']} min";
                        echo "</li>";
                    }
                    echo "</ul>";
                }
            }

            echo "</div>";
        }
        ?>

        <h1 class="text-center mt-5 mb-4">Consum per Departaments</h1>
        <div class="row">

        <?php
        $sql2 = "
            SELECT 
                d.nom_depart AS departament,
                COUNT(i.cod_incidencia) AS total_incidencies,
                IFNULL(SUM(CAST(a.temps_dedicat AS UNSIGNED)), 0) AS temps_total
            FROM Departament d
            LEFT JOIN Incidencies i ON i.departament = d.cod_depart
            LEFT JOIN Actuacions a ON i.cod_incidencia = a.cod_incidencia
            GROUP BY d.nom_depart;
        ";

        $result2 = $connexion->query($sql2);

        while ($row = $result2->fetch_assoc()) {
            echo "<div class='col-md-6'>";
            echo "<div class='card p-4'>";
            echo "<h5 class='card-title'>Departament: {$row['departament']}</h5>";
            echo "<p>Incidències reportades: {$row['total_incidencies']}</p>";
            echo "<p>Temps total dedicat: {$row['temps_total']} min</p>";
            echo "</div></div>";
        }

        $connexion->close();
        ?>
        </div>

        <div class="text-center mt-4">
            <a href="admin.html" class="btn btn-secondary">Tornar al menú</a>
        </div>
    </div>
</body>
</html>
