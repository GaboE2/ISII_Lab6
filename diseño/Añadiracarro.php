<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmacia";
$puerto=3310;

$conn = new mysqli($servername, $username, $password, $dbname,3310);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['id'];

// Verificar y actualizar el stock
$sql = "SELECT Stock_medicamento FROM medicamento WHERE ID_Medicamento = $productId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['Stock_medicamento'] > 0) {
        $newStock = $row['Stock_medicamento'] - 1;
        $updateSql = "UPDATE medicamento SET Stock_medicamento = $newStock WHERE ID_Medicamento = $productId";
        if ($conn->query($updateSql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el stock']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Sin stock']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
}

$conn->close();
?>
