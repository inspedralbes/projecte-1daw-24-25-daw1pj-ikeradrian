<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tècnic - Informes d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Source Sans Pro', sans-serif;
        }
        h1 {
            font-family: 'Merriweather', serif;
            font-size: 2.5rem;
            color: #003366;
            margin-bottom: 1.5rem;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        textarea {
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center">Informes d'Incidències</h1>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="card-title">Incidència #123</h5>
                    <p class="card-text"><strong>Descripció:</strong> Ordinador no s'encén</p>
                    <form>
                        <div class="mb-3">
                            <label for="informe1" class="form-label">Informe tècnic</label>
                            <textarea class="form-control" id="informe1" rows="3" placeholder="Descriu com s'ha resolt..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit">Enviar informe</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="card-title">Incidència #124</h5>
                    <p class="card-text"><strong>Descripció:</strong> Problemes amb la connexió Wi-Fi</p>
                    <form>
                        <div class="mb-3">
                            <label for="informe2" class="form-label">Informe tècnic</label>
                            <textarea class="form-control" id="informe2" rows="3" placeholder="Descriu com s'ha resolt..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit">Enviar informe</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="admin.html" class="btn btn-back">Tornar al menú</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
