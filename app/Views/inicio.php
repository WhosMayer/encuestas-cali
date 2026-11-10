<section class="portada">
    <p class="sobrelinea">Área de trabajo</p>
    <h1>Inicio</h1>
    <p>Sesión de <?= e(ucfirst($rol)) ?></p>
</section>
<section class="panel tarjeta-modulo">
    <?php if ($rol === 'ventanilla'): ?>
        <h2>Solicitudes de encuesta</h2>
        <p>Registra una solicitud y marca la ubicación de la visita.</p>
        <a class="accion" href="?vista=radicar">Radicar solicitud</a>
    <?php elseif ($rol === 'enrutador'): ?>
        <h2>Consulta de solicitudes</h2>
        <p>Revisa los radicados del día y abre sus detalles.</p>
        <a class="accion" href="?vista=bitacora">Abrir bitácora diaria</a>
    <?php else: ?>
        <p>Sesión iniciada correctamente. Las funciones de este perfil se incorporarán en la siguiente etapa.</p>
    <?php endif; ?>
</section>
