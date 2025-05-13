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
        .text-muted {
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container py-5">

        <h1 class="text-center mb-5">Informe de Tècnics</h1>
        <h2 class="mb-4">Tècnics i Incidències</h2>
        <?php
        $sql_tecnics = "
            SELECT 
                t.nom_tecnic AS tecnic,
                i.cod_incidencia,
                i.descripcio,
                i.data,
                i.prioritat
            FROM Tecnics t
            LEFT JOIN Incidencies i ON i.nom_tecnic = t.nom_tecnic
            WHERE i.estat != 'Tancada' OR i.estat IS NULL
            ORDER BY t.nom_tecnic, FIELD(i.prioritat, 'Alta', 'Mitjana', 'Baixa'), i.data;
        ";

        $result_tecnics = $connexion->query($sql_tecnics);

        $tecnics_data = [];
        while ($row = $result_tecnics->fetch_assoc()) {
            $tecnic = $row['tecnic'];
            if ($row['cod_incidencia']) {
                $tecnics_data[$tecnic][] = $row;
            } else {

                $tecnics_data[$tecnic] = null;
            }
        }


        foreach ($tecnics_data as $tecnic => $incidencies) {
            echo "<div class='card p-4'>";
            echo "<h3 class='card-title'>Tècnic: $tecnic</h3>";

            if ($incidencies) {

                echo "<ul class='list-group'>";
                foreach ($incidencies as $incidencia) {
                    echo "<li class='list-group-item'>";
                    echo "Incidència #{$incidencia['cod_incidencia']} - Descripció: {$incidencia['descripcio']} - Data: {$incidencia['data']} - Prioritat: {$incidencia['prioritat']}";
                    echo "</li>";
                }
                echo "</ul>";
            } else {

                echo "<p class='text-muted'>No té cap incidència assignada.</p>";
            }

            echo "</div>";
        }
        ?>

        <h1 class="text-center mt-5 mb-4">Consum per Departaments</h1>
        <div class="row">

        <?php
     
        $sql_departaments = "
            SELECT 
                d.nom_depart AS departament,
                COUNT(i.cod_incidencia) AS total_incidencies,
                IFNULL(SUM(CAST(d.temps_dedicat AS UNSIGNED)), 0) AS temps_total
            FROM Departament d
            LEFT JOIN Incidencies i ON i.departament = d.cod_depart AND i.estat != 'Tancada'
            GROUP BY d.nom_depart;
        ";

        $result_departaments = $connexion->query($sql_departaments);


        while ($row = $result_departaments->fetch_assoc()) {
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
