<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Próximos Vencimientos</h6>
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <?php foreach ($vencimientos as $v): ?>
            <li class="mb-2">
                <div class="d-flex justify-content-between small">
                    <span><?= htmlspecialchars($v->nombre) ?></span>
                    <span class="text-muted"><?= date('d/m/Y', strtotime($v->fecha)) ?></span>
                </div>
                <div class="progress" style="height: 3px;">
                    <div class="progress-bar bg-warning" style="width: <?= min(100, $v->dias_restantes) ?>%"></div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>