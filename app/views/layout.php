<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMDB IT - <?= $title ?? 'Inicio' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php $this->load->view('partials/header') ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('partials/sidebar') ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mt-3">
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mt-3">
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?= $content ?>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <?php if (isset($extra_js)): ?>
        <script src="/assets/js/<?= $extra_js ?>"></script>
    <?php endif; ?>
</body>
</html>