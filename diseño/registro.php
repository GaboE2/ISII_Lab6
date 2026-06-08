<?php
$servername = "localhost"; // Cambia esto si tu servidor no es local
$username = "tu_usuario"; // Reemplaza con tu nombre de usuario de MySQL
$password = "tu_contraseña"; // Reemplaza con tu contraseña de MySQL
$dbname = "farmacia"; // Nombre de tu base de datos
$puerto=3310;

$conn = new mysqli($servername, $username, $password, $dbname,3310);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $correo = $_POST['Correo'];
    $contraseña = $_POST['Contraseña'];
    $rol = 4; // Asigna el rol por defecto como Cliente (asegúrate de que el ID_Rol correspondiente en la tabla `rol` sea 4)

    // Hash de la contraseña para mayor seguridad
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar y enlazar la declaración SQL
    $stmt = $conn->prepare("INSERT INTO usuario (Nombre_usuario, Apellido_usuario, Correo_usuario, Contraseña_usuario, ID_Rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $hashed_password, $rol);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
