<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow text-center py-5">
            <div class="card-body">
                <h1 class="text-danger">⚠️ Error</h1>
                <p class="lead"><?= htmlspecialchars($mensaje) ?></p>
                <a href="/" class="btn btn-primary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>