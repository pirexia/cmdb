<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center">Nueva Contraseña</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); endif; ?>
                        
                        <form method="post">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                            
                            <div class="mb-3">
                                <label>Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control" 
                                    required minlength="8"
                                    placeholder="Mínimo 8 caracteres">
                            </div>
                            
                            <div class="mb-3">
                                <label>Confirmar Contraseña</label>
                                <input type="password" name="confirm_password" class="form-control" 
                                    required minlength="8"
                                    placeholder="Repite la contraseña">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="/auth/login" class="text-decoration-none">
                                ← Volver al Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>