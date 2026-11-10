<?php
declare(strict_types=1);

final class SesionController
{
    public function entrar(array $entrada): bool
    {
        $nombre = is_string($entrada['usuario'] ?? null) ? trim($entrada['usuario']) : '';
        $clave = is_string($entrada['clave'] ?? null) ? $entrada['clave'] : '';
        $cuenta = (new Usuario())->buscar($nombre);
        if (!$cuenta || !password_verify($clave, $cuenta['clave'])) {
            return false;
        }

        unset($cuenta['clave']);
        session_regenerate_id(true);
        $_SESSION['usuario'] = $cuenta;
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        return true;
    }

    public function salir(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
