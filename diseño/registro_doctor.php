<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Parámetros de conexión a la base de datos
$host = 'localhost';
$puerto = 3310; // Especifica el puerto aquí
$usuario = 'root';
$contrasena = '';
$nombreBaseDeDatos = 'farmacia';

// Crear conexión MySQLi con el puerto especificado
$conn = new mysqli($host, $usuario, $contrasena, $nombreBaseDeDatos, $puerto);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Recibir los datos del formulario
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$primerApellido = $_POST['primer_apellido'];
$segundoApellido = $_POST['segundo_apellido'];
$especialidad = $_POST['especialidad'];
$edad = $_POST['edad'];
$fechaNacimiento = $_POST['fecha'];
$id_departamento = $_POST['id_departamento'];

// Preparar la sentencia SQL para insertar los datos
$sql = "INSERT INTO doctor (ID_Doctor, Nombre_doctor, Primer_apellido_doctor, Segundo_apellido_doctor, Especialidad, Edad_Doctor, Fecha_nacimiento_doctor, ID_Departamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
// Asegúrate de que el tipo de datos (i para int, s para string, etc.) coincida con tus datos.
$stmt->bind_param("sssssisi", $codigo, $nombre, $primerApellido, $segundoApellido, $especialidad, $edad, $fechaNacimiento, $id_departamento);

// Ejecutar la sentencia
if ($stmt->execute()) {
    echo "Doctor registrado correctamente.";
    echo '<br><a href="index.html"><button>Regresar</button></a>';
} else {
    echo "Error al registrar el doctor: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
