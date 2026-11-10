<?php
declare(strict_types=1);

final class EncuestasController
{
    public function atender(): void
    {
        $usuario = $_SESSION['usuario'] ?? null;
        $rol = $usuario['rol'] ?? null;
        $modulo = ['ventanilla' => 'radicar', 'enrutador' => 'bitacora'][$rol] ?? 'inicio';
        $pantalla = $usuario ? ($_GET['vista'] ?? $modulo) : 'acceso';
        $permitidas = $usuario ? ['inicio', $modulo] : ['acceso'];
        if ($rol === 'enrutador') {
            $permitidas[] = 'detalle';
        }

        $datos = $errores = $solicitudes = [];
        $detalle = null;
        $mensaje = '';
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $solicitudesModelo = new Solicitud();
        if (!in_array($pantalla, $permitidas, true)) {
            http_response_code(403);
            $pantalla = $usuario ? 'inicio' : 'acceso';
            $mensaje = 'Tu perfil no tiene acceso a esa pantalla.';
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $token = $_POST['csrf'] ?? null;
                if (!is_string($token) || !hash_equals($_SESSION['csrf'], $token)) {
                    http_response_code(403);
                    exit('La sesión del formulario venció. Recarga la página.');
                }

                $accion = $_POST['accion'] ?? null;
                $sesion = new SesionController();
                if ($accion === 'salir' && $usuario) {
                    $sesion->salir();
                    $this->redirigir('./');
                } elseif ($accion === 'entrar' && !$usuario) {
                    if ($sesion->entrar($_POST)) {
                        $this->redirigir('?vista=inicio');
                    }
                    $mensaje = 'Usuario o contraseña incorrectos.';
                } elseif ($accion === 'radicar' && $rol === 'ventanilla' && $usuario['punto']) {
                    $pantalla = 'radicar';
                    [$datos, $errores] = validarSolicitud($_POST);
                    if (!$errores) {
                        $_SESSION['radicada'] = $solicitudesModelo->guardar($datos, $usuario);
                        $this->redirigir('?vista=radicar');
                    }
                } else {
                    http_response_code(403);
                    exit('Tu perfil no tiene permiso para realizar esta acción.');
                }
            }

            if ($pantalla === 'bitacora') {
                $limites = is_string($fecha) ? limitesDia($fecha) : null;
                if ($limites) {
                    $solicitudes = $solicitudesModelo->delDia($limites);
                } else {
                    $fecha = '';
                    $mensaje = 'Selecciona una fecha válida.';
                }
            } elseif ($pantalla === 'detalle') {
                $fecha = is_string($fecha) && limitesDia($fecha) ? $fecha : date('Y-m-d');
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
                $detalle = $id ? $solicitudesModelo->buscar($id) : null;
                if (!$detalle) {
                    http_response_code(404);
                    $mensaje = 'No encontramos ese radicado.';
                }
            }
        } catch (PDOException $error) {
            http_response_code(503);
            error_log($error->getMessage());
            $mensaje = 'No fue posible completar la operación. Vuelve a intentarlo.';
        }

        $radicada = $_SESSION['radicada'] ?? null;
        unset($_SESSION['radicada']);
        require __DIR__ . '/../Views/layout.php';
    }

    private function redirigir(string $url): void
    {
        header('Location: ' . $url, true, 303);
        exit;
    }
}
