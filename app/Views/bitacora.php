<div class="cabecera-pagina">
    <div>
        <p class="sobrelinea">Enrutador</p>
        <h1>Bitácora diaria</h1>
        <p>Solicitudes de todos los puntos de atención.</p>
    </div>
    <form method="get" class="filtro">
    <input type="hidden" name="vista" value="bitacora">
    <label>Fecha <input type="date" name="fecha" value="<?= e(is_string($fecha) ? $fecha : '') ?>" required></label>
    <button>Consultar</button>
    </form>
</div>
<div class="panel tabla">
    <?php if (!$solicitudes && !$mensaje): ?><p>No hay solicitudes en esta fecha.</p><?php endif; ?>
    <?php if ($solicitudes): ?>
        <table>
            <thead><tr><th>Radicado</th><th>Hora</th><th>Punto</th><th>Persona</th><th>Dirección</th><th>Ubicación</th></tr></thead>
            <tbody>
            <?php foreach ($solicitudes as $fila): ?>
                <tr>
                    <td><a class="radicado" href="?<?= e(http_build_query(['vista' => 'detalle', 'id' => $fila['id'], 'fecha' => $fecha])) ?>" aria-label="Ver detalle del radicado <?= e($fila['id']) ?>">#<?= e($fila['id']) ?> <span aria-hidden="true">→</span></a></td>
                    <td><?= e(substr($fila['fecha'], 11, 5)) ?></td>
                    <td><?= e($fila['punto_nombre']) ?></td>
                    <td><?= e($fila['nombres'] . ' ' . $fila['apellidos']) ?></td>
                    <td><?= e($fila['direccion']) ?> <small><?= e($fila['barrio'] ?? $fila['corregimiento']) ?></small></td>
                    <td><?= e($fila['latitud']) ?>, <?= e($fila['longitud']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
