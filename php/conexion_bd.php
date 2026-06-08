<?php

// Configuración mediante variables de entorno o valores por defecto
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: "";
$db   = getenv('DB_NAME') ?: "login_db";
$port = getenv('DB_PORT') ?: 3310;

$conexion = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conexion) {
    error_log("Fallo la conexión a la base de datos: " . mysqli_connect_error());
    die("Error de conexión interno.");
}
?>