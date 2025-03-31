<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Público - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Inventario de Activos de IT</h1>
        
        <div class="row mb-4">
            <!-- Tarjetas de Resumen -->
            <div class="col-md-4 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total de Objetos</h5>
                        <p class="display-4"><?= $total_objetos ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Activos</h5>
                        <p class="display-4"><?= $objetos_activos ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Próximos Vencimientos</h5>
                        <p class="display-4"><?= count($proximos_vencimientos) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listado de Próximos Vencimientos -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Próximas Fechas Clave</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach ($proximos_vencimientos as $vencimiento): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><?= htmlspecialchars($vencimiento->nombre) ?></h6>
                                <small class="text-muted"><?= $vencimiento->tipo_fecha ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning"><?= date('d/m/Y', strtotime($vencimiento->fecha)) ?></span>
                                <div class="text-muted small"><?= $vencimiento->dias_restantes ?> días restantes</div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>