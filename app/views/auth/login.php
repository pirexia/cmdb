<!DOCTYPE html>
<html>
<head>
    <title>Login - CMDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center">Acceso al Sistema</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label>Usuario</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>