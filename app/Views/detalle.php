<p><a href="?<?= e(http_build_query(['vista' => 'bitacora', 'fecha' => $fecha])) ?>">← Volver a la bitácora</a></p>
<?php if ($detalle): ?>
    <h1>Radicado #<?= e($detalle['id']) ?></h1>
    <dl class="panel ficha">
        <div><dt>Persona</dt><dd><?= e($detalle['nombres'] . ' ' . $detalle['apellidos']) ?></dd></div>
        <div><dt>Celular</dt><dd><?= e($detalle['celular']) ?></dd></div>
        <div><dt>Fecha y hora</dt><dd><?= e($detalle['fecha']) ?></dd></div>
        <div><dt>Punto de atención</dt><dd><?= e($detalle['punto_nombre']) ?></dd></div>
        <div><dt>Dirección</dt><dd><?= e($detalle['direccion']) ?></dd></div>
        <div><dt>Zona de la visita</dt><dd><?= e($detalle['comuna'] ? 'Comuna ' . $detalle['comuna'] . ' · ' . $detalle['barrio'] : $detalle['corregimiento']) ?></dd></div>
        <div><dt>Coordenadas</dt><dd><?= e($detalle['latitud']) ?>, <?= e($detalle['longitud']) ?></dd></div>
    </dl>
<?php endif; ?>
