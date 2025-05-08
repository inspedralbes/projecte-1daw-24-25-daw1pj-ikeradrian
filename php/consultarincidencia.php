<?php
require "connexio.php";
$consulta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoConsulta = $_POST['codigoConsulta'];
    $sql = "SELECT estat FROM Incidencies WHERE cod_incidencia = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $codigoConsulta);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $estat = "";
        $stmt->bind_result($estat);
        $stmt->fetch();
        $consulta = "<div class='alert alert-success mt-4'>La incidència <strong>$codigoConsulta</strong> està <strong>$estat</strong>.</div>";
    } else {
        $consulta = "<div class='alert alert-danger mt-4'>⚠ No hi ha cap incidència amb aquest codi.</div>";
    }

    $stmt->close();
}
$connexion->close();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Incidència</title>
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
            background-color: #0dcaf0;
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
        <h2 class="mb-4">Consultar incidència</h2>

        <?php if (!empty($consulta)) echo $consulta; ?>

        <form method="post" class="text-start mx-auto mt-4" style="max-width: 500px;">
            <div class="mb-3">
                <label for="codigoConsulta" class="form-label">Codi de consulta:</label>
                <input type="text" class="form-control" id="codigoConsulta" name="codigoConsulta" required>
            </div>
            <button type="submit" class="btn btn-submit w-100">Consultar</button>
        </form>

        <div class="mt-4">
            <a href="usuario.html" class="btn btn-back">Tornar a l'inici</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
