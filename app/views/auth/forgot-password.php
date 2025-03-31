<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center">Recuperar Contraseña</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); endif; ?>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                        <?php unset($_SESSION['success']); endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label>Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" required 
                                    placeholder="Ingresa tu correo registrado">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Enviar Instrucciones</button>
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