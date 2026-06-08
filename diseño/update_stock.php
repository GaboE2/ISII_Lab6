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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);

    // Actualizar el stock del medicamento
    $sql = "UPDATE medicamento SET Stock_medicamento = Stock_medicamento - ? WHERE ID_Medicamento = ? AND Stock_medicamento >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $id, $quantity);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Stock actualizado correctamente";
    } else {
        echo "Error actualizando el stock o stock insuficiente";
    }

    $stmt->close();
} else {
    echo "Datos inválidos";
}

$conn->close();
?>
