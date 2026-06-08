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

    // Recibir el ID_paciente (DNI) del paciente desde la solicitud
    $idPaciente = $_GET['idp'];

    // Preparar la consulta SQL utilizando ID_paciente como criterio de búsqueda
    $stmt = $conn->prepare("SELECT Nombre_paciente AS nombre, Primer_apellido_paciente AS apellido1, Segundo_apellido_paciente AS apellido2 FROM paciente WHERE ID_Paciente = :idPaciente");
    $stmt->bindParam(':idPaciente', $idPaciente, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se encontró el paciente
    if ($stmt->rowCount() > 0) {
        // Obtener los datos del paciente
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
        // Devolver los datos en formato JSON
        echo json_encode($paciente);
    } else {
        // Devolver un mensaje de error o un objeto vacío
        echo json_encode(['error' => 'Paciente no encontrado']);
    }
} catch (PDOException $e) {
    // Manejar el error de conexión
    echo "Error de conexión: " . $e->getMessage();
}
?>
