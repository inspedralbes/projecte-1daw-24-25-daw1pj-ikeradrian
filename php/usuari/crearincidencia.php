<?php 
require "../connexio.php";
require '../connexion_mongo.php';
$name = "usuari";
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");
$pages = "Creació d'incidència";
rellenarMongo($collection, $name, $ip, $hora, $pages);

$departaments = [];
$result = $connexion->query("SELECT cod_depart, nom_depart FROM Departament");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $departaments[] = $row;
    }
}

$missatge = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $Departament = $connexion->real_escape_string($_POST['Departament']);
    $Data = date('Y-m-d H:i:s');
    $Descripcio = $connexion->real_escape_string($_POST['Descripcio']);


    $sql = "INSERT INTO Incidencies (departament, data, descripcio) VALUES (?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sss", $Departament, $Data, $Descripcio);
    $stmt->execute();


    $cod_incidencia = $stmt->insert_id; 
    
    $sql2 = "UPDATE Departament SET consum_depart = (consum_depart + 1) WHERE cod_depart = ?";
    $stmt2 = $connexion->prepare($sql2);
    $stmt2->bind_param("s", $Departament);
    $stmt2->execute();


    $missatge = "Incidència guardada correctament. Codi d'incidència: $cod_incidencia";
}

$connexion->close();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f8f9fa;
            font-size: 1.15rem;
        }
        h1, h2 {
            font-family: 'Merriweather', serif;
        }
        h1 {
            color: #003366;
            font-size: 2.75rem;
            font-weight: 700;
        }
        h2 {
            color: #666;
            font-size: 1.75rem;
            font-weight: 400;
        }
        .form-control {
            font-size: 1.1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }
        .btn-submit {
            font-weight: 600;
            font-size: 1.15rem;
            padding: 0.75rem;
            border-radius: 0.75rem;
            background-color: #198754;
            color: white;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            opacity: 0.95;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-back {
            font-weight: 600;
            font-size: 1rem;
            padding: 0.65rem 1.25rem;
            border-radius: 0.65rem;
            background-color: #6c757d;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            opacity: 0.9;
        }
        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.25rem;
            }
            .form-control,
            .btn-submit {
                font-size: 1rem;
            }
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container text-center py-5">
        <h1 class="mb-3">Gestor d'Incidències</h1>
        <h2 class="mb-4">Crear nova incidència</h2>

        <?php if (!empty($missatge)) echo "<div class='alert alert-success mt-3'>$missatge</div>"; ?>

        <form method="post" class="text-start mx-auto mt-4" style="max-width: 500px;">
            <div class="mb-3">
                <label for="Departament" class="form-label">Departament de la incidència:</label>
                <select class="form-control" id="Departament" name="Departament" required>
                    <option value="" disabled selected>Selecciona un departament</option>
                    <?php foreach ($departaments as $d): ?>
                        <option value="<?= htmlspecialchars($d['cod_depart']) ?>">
                            <?= htmlspecialchars($d['nom_depart']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Descripcio" class="form-label">Descripció:</label>
                <textarea class="form-control" id="Descripcio" name="Descripcio" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-submit w-100">Enviar</button>
        </form>

        <div class="mt-4">
            <a href="usuario.php" class="btn btn-back">Tornar a l'inici</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
