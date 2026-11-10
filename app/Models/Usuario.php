<?php
declare(strict_types=1);

final class Usuario
{
    public function buscar(string $nombre): ?array
    {
        $consulta = conectar()->prepare('SELECT id, usuario, rol, punto, clave FROM usuarios WHERE usuario = ?');
        $consulta->execute([$nombre]);
        return $consulta->fetch() ?: null;
    }
}
