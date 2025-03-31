<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="mb-0">Formulario de Contacto</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['flash_success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['flash_success'] ?></div>
                        <?php unset($_SESSION['flash_success']); endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" 
                                    value="<?= $_POST['nombre'] ?? '' ?>">
                                <?php if (isset($errors['nombre'])): ?>
                                <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                    value="<?= $_POST['email'] ?? '' ?>">
                                <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Mensaje</label>
                                <textarea name="mensaje" class="form-control <?= isset($errors['mensaje']) ? 'is-invalid' : '' ?>" 
                                    rows="5"><?= $_POST['mensaje'] ?? '' ?></textarea>
                                <?php if (isset($errors['mensaje'])): ?>
                                <div class="invalid-feedback"><?= $errors['mensaje'] ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>