<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Distribución de Estados</h6>
    </div>
    <div class="card-body">
        <?php foreach ($estados as $e): ?>
        <div class="mb-3">
            <div class="d-flex justify-content-between small">
                <span><?= ucfirst($e->estado) ?></span>
                <span><?= $e->total ?> (<?= $e->porcentaje ?>%)</span>
            </div>
            <div class="progress">
                <div class="progress-bar" 
                     style="width: <?= $e->porcentaje ?>%; 
                            background-color: <?= $this->getColor($e->estado) ?>;">
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>