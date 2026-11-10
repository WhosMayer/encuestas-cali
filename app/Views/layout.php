<?php
function e(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Encuestas Cali</title>
    <link rel="stylesheet" href="estilos.css?v=2">
    <?php if ($pantalla === 'radicar'): ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
        <script src="mapa.js" defer></script>
    <?php endif; ?>
</head>
<body>
<header>
    <a class="marca" href="<?= $usuario ? '?vista=inicio' : './' ?>">
        <span class="marca-icono" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M20 10c0 5-8 10-8 10S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
        <span>Encuestas Cali<small>Gestión de visitas domiciliarias</small></span>
    </a>
    <?php if ($usuario): ?>
        <nav aria-label="Navegación principal">
            <a href="?vista=inicio" <?= $pantalla === 'inicio' ? 'aria-current="page"' : '' ?>>Inicio</a>
            <?php if ($rol === 'ventanilla'): ?>
                <a href="?vista=radicar" <?= $pantalla === 'radicar' ? 'aria-current="page"' : '' ?>>Radicar solicitud</a>
            <?php elseif ($rol === 'enrutador'): ?>
                <a href="?vista=bitacora" <?= $pantalla === 'bitacora' ? 'aria-current="page"' : '' ?>>Bitácora diaria</a>
            <?php endif; ?>
        </nav>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
            <button name="accion" value="salir">Cerrar sesión</button>
        </form>
    <?php endif; ?>
</header>
<main id="contenido">
    <?php if ($mensaje): ?><p class="error" role="alert"><?= e($mensaje) ?></p><?php endif; ?>
    <?php require __DIR__ . '/' . $pantalla . '.php'; ?>
</main>
</body>
</html>
