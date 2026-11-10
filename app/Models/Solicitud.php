<?php
declare(strict_types=1);

final class Solicitud
{
    public function guardar(array $datos, array $usuario): string
    {
        $db = conectar();
        $consulta = $db->prepare(
            'INSERT INTO solicitudes (nombres, apellidos, celular, direccion, zona, comuna, barrio, corregimiento,
             latitud, longitud, fecha, creado_por, punto)
             VALUES (:nombres, :apellidos, :celular, :direccion, :zona, :comuna, :barrio, :corregimiento,
             :latitud, :longitud, :fecha, :creado_por, :punto)'
        );
        $consulta->execute($datos + [
            'fecha' => date('Y-m-d H:i:s'),
            'creado_por' => $usuario['id'],
            'punto' => $usuario['punto'],
        ]);
        return $db->lastInsertId();
    }

    public function delDia(array $limites): array
    {
        $consulta = conectar()->prepare(
            'SELECT s.id, s.fecha, s.nombres, s.apellidos, s.direccion, s.barrio,
                    s.corregimiento, s.latitud, s.longitud, p.nombre AS punto_nombre
             FROM solicitudes s JOIN puntos p ON p.comuna = s.punto
             WHERE s.fecha >= ? AND s.fecha < ? ORDER BY s.fecha DESC, s.id DESC'
        );
        $consulta->execute($limites);
        return $consulta->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $consulta = conectar()->prepare(
            'SELECT s.id, s.fecha, s.nombres, s.apellidos, s.celular, s.direccion,
                    s.comuna, s.barrio, s.corregimiento, s.latitud, s.longitud, p.nombre AS punto_nombre
             FROM solicitudes s JOIN puntos p ON p.comuna = s.punto WHERE s.id = ?'
        );
        $consulta->execute([$id]);
        return $consulta->fetch() ?: null;
    }
}
