<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/dominio.php';

$clave = getenv('ENCUESTAS_DEMO_PASSWORD');
if (!is_string($clave) || strlen($clave) < 10) {
    fwrite(STDERR, "Define ENCUESTAS_DEMO_PASSWORD con al menos diez caracteres.\n");
    exit(1);
}

$db = conectar();
$guardar = $db->prepare('INSERT INTO usuarios (usuario, clave, rol, punto) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE id = id');
foreach (ROLES as $rol) {
    $guardar->execute([$rol, password_hash($clave, PASSWORD_DEFAULT), $rol, $rol === 'ventanilla' ? 17 : null]);
}
foreach ([1, 6, 7, 13, 14, 20, 21] as $punto) {
    $guardar->execute(['ventanilla' . $punto, password_hash($clave, PASSWORD_DEFAULT), 'ventanilla', $punto]);
}
echo "Cuentas de demostración disponibles. Las cuentas existentes conservan su clave.\n";
