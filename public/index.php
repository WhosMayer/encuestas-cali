<?php
declare(strict_types=1);

require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/dominio.php';
require __DIR__ . '/../app/Models/Usuario.php';
require __DIR__ . '/../app/Models/Solicitud.php';
require __DIR__ . '/../app/Controllers/SesionController.php';
require __DIR__ . '/../app/Controllers/EncuestasController.php';

date_default_timezone_set('America/Bogota');
session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
header('Cache-Control: no-store');
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));

(new EncuestasController())->atender();
