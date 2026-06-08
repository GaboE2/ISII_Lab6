<?php
// Parámetros de conexión a la base de datos
$host = "localhost";
$puerto = "3310";
$usuario = "root";
$contrasena = "";
$nombreBaseDeDatos = "farmacia";

try {
    // Crear conexión PDO con el puerto especificado
    $conn = new PDO("mysql:host=$host;port=$puerto;dbname=$nombreBaseDeDatos", $usuario, $contrasena);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener la especialidad seleccionada desde la solicitud GET
    $especialidad = $_GET['especialidad'];

    // Preparar la consulta SQL para seleccionar los doctores de la especialidad especificada
    $stmt = $conn->prepare("SELECT Nombre_doctor AS Nombre, Primer_apellido_doctor AS Apellido1, Segundo_apellido_doctor AS Apellido2 FROM doctor WHERE Especialidad = :especialidad");
    $stmt->bindParam(':especialidad', $especialidad, PDO::PARAM_STR);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se encontraron resultados
    if ($stmt->rowCount() > 0) {
        // Obtener todos los resultados como un array asociativo
        $doctores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Devolver los datos en formato JSON
        echo json_encode($doctores);
    } else {
        // Devolver un mensaje de error o un objeto vacío
        echo json_encode(['error' => 'No hay doctores disponibles en esta especialidad']);
    }
} catch (PDOException $e) {
    // Manejar el error de conexión
    echo "Error de conexión: " . $e->getMessage();
}
?>
