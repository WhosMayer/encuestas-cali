<?php
declare(strict_types=1);

const ROLES = ['administrador', 'ventanilla', 'encuestador', 'calidad', 'enrutador'];
function territorio(): array
{
    static $catalogo;
    return $catalogo ??= json_decode(file_get_contents(__DIR__ . '/territorio.json'), true, 512, JSON_THROW_ON_ERROR);
}

function validarSolicitud(array $entrada): array
{
    $datos = [];
    $errores = [];
    foreach (['nombres', 'apellidos', 'celular', 'direccion', 'zona', 'comuna', 'barrio', 'corregimiento', 'latitud', 'longitud'] as $campo) {
        $datos[$campo] = is_string($entrada[$campo] ?? null) ? trim($entrada[$campo]) : '';
    }

    foreach (['nombres', 'apellidos', 'direccion'] as $campo) {
        if ($datos[$campo] === '' || mb_strlen($datos[$campo]) > 160) {
            $errores[$campo] = 'Escribe un valor de hasta 160 caracteres.';
        }
    }

    if (!preg_match('/^\d{10}$/D', $datos['celular'])) {
        $errores['celular'] = 'Escribe los diez dígitos del celular.';
    }

    if ($datos['zona'] === 'urbana') {
        $datos['corregimiento'] = null;
        $barrios = territorio()['barrios'][$datos['comuna']] ?? [];
        if (!$barrios) {
            $errores['comuna'] = 'Selecciona una comuna de Cali.';
        }
        if (!in_array($datos['barrio'], $barrios, true)) {
            $errores['barrio'] = 'Selecciona un barrio de la comuna elegida.';
        }
    } elseif ($datos['zona'] === 'rural') {
        $datos['comuna'] = $datos['barrio'] = null;
        if (!in_array($datos['corregimiento'], territorio()['corregimientos'], true)) {
            $errores['corregimiento'] = 'Selecciona un corregimiento de Cali.';
        }
    } else {
        $errores['zona'] = 'Selecciona una zona.';
    }

    foreach (['latitud' => 90, 'longitud' => 180] as $campo => $limite) {
        if (!is_numeric($datos[$campo]) || abs((float) $datos[$campo]) > $limite) {
            $errores[$campo] = 'Marca la ubicación en el mapa o introduce una coordenada válida.';
        }
    }
    return [$datos, $errores];
}

function limitesDia(string $fecha): ?array
{
    $dia = DateTimeImmutable::createFromFormat('!Y-m-d', $fecha, new DateTimeZone('America/Bogota'));
    if (!$dia || $dia->format('Y-m-d') !== $fecha) {
        return null;
    }
    return [$dia->format('Y-m-d H:i:s'), $dia->modify('+1 day')->format('Y-m-d H:i:s')];
}
