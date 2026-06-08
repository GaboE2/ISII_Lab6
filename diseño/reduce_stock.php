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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = 1; // La cantidad a reducir, puedes ajustar esto según sea necesario

    // Reducir el stock del medicamento
    $sql = "UPDATE medicamento SET Stock_medicamento = Stock_medicamento - ? WHERE ID_Medicamento = ? AND Stock_medicamento >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $product_id, $quantity);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Stock reducido exitosamente";
    } else {
        echo "Error al reducir el stock o stock insuficiente";
    }

    $stmt->close();
} else {
    echo "Datos inválidos";
}

$conn->close();
?>
