<?php
// Importar conexión centralizada
require_once __DIR__ . '/../php/conexion_bd.php';
$conn = $conexion;

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['id'];

// Verificar y actualizar el stock
$sql = "SELECT Stock_medicamento FROM medicamento WHERE ID_Medicamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['Stock_medicamento'] > 0) {
        $newStock = $row['Stock_medicamento'] - 1;
        $updateSql = "UPDATE medicamento SET Stock_medicamento = ? WHERE ID_Medicamento = ?";
        $updStmt = $conn->prepare($updateSql);
        $updStmt->bind_param("ii", $newStock, $productId);
        if ($updStmt->execute() === TRUE) {
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
