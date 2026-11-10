<?php
declare(strict_types=1);

function conectar(): PDO
{
    return new PDO(
        getenv('ENCUESTAS_DSN') ?: 'mysql:host=127.0.0.1;dbname=encuestas_cali;charset=utf8mb4',
        getenv('ENCUESTAS_DB_USER') ?: 'root',
        getenv('ENCUESTAS_DB_PASSWORD') ?: '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
}
