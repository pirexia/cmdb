<form method="post" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Información Básica</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre*</label>
                        <input type="text" class="form-control" id="nombre" name="objeto[nombre]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo">Tipo*</label>
                        <select class="form-control" id="tipo" name="objeto[tipo]" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($tipos as $key => $value): ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Más campos del formulario... -->
            
            <?php $this->load->view('partials/ip_form') ?>
            <?php $this->load->view('partials/caracteristicas_form') ?>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>