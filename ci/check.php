<?php
declare(strict_types=1);

$archivos = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__), FilesystemIterator::SKIP_DOTS));
foreach ($archivos as $archivo) {
    if ($archivo->getExtension() === 'php') {
        passthru(escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($archivo->getPathname()), $estado);
        if ($estado !== 0) {
            exit($estado);
        }
    }
}

require dirname(__DIR__) . '/app/dominio.php';
$entrada = [
    'nombres' => 'Persona', 'apellidos' => 'Prueba', 'celular' => '3000000000',
    'direccion' => 'Dirección ficticia', 'zona' => 'urbana', 'comuna' => '17',
    'barrio' => 'El Ingenio', 'latitud' => '3.38', 'longitud' => '-76.54',
];
[$urbana, $errores] = validarSolicitud($entrada);
[$rural, $erroresRurales] = validarSolicitud(array_replace($entrada, ['zona' => 'rural', 'corregimiento' => 'Pance']));
[, $invalidos] = validarSolicitud(array_replace($entrada, ['comuna' => '23', 'latitud' => '91', 'celular' => '123']));
[, $barrioAjeno] = validarSolicitud(array_replace($entrada, ['comuna' => '1']));
$pruebas = [
    'Solicitud urbana válida' => !$errores && $urbana['corregimiento'] === null,
    'Solicitud rural sin comuna ni barrio' => !$erroresRurales && $rural['comuna'] === null && $rural['barrio'] === null,
    'Señala coordenadas, comuna y celular inválidos' => isset($invalidos['latitud'], $invalidos['comuna'], $invalidos['celular']),
    'Rechaza un barrio de otra comuna' => isset($barrioAjeno['barrio']),
    'Cambio de mes en bitácora' => limitesDia('2026-11-30') === ['2026-11-30 00:00:00', '2026-12-01 00:00:00'],
    'Rechaza una fecha que no existe' => limitesDia('2026-11-31') === null,
];
foreach ($pruebas as $nombre => $ok) {
    if (!$ok) {
        fwrite(STDERR, "ERROR: $nombre\n");
        exit(1);
    }
    echo "OK: $nombre\n";
}
