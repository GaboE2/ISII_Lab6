<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmacia";
$puerto=3310;

$conn = new mysqli($servername, $username, $password, $dbname,3310);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_name = "Paracetamol";
$product_class = "Analgesico";
$exp_date = "2025-12-31";
$stock = 100;
$price = 10.00;

$sql = "INSERT INTO medicamento (Nombre_Medicamento, Clase_Medicamento, Fecha_vencimiento, Stock_medicamento, Precio_medicamento) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdi", $product_name, $product_class, $exp_date, $stock, $price);

if ($stmt->execute()) {
    echo "Paracetamol agregado correctamente";
} else {
    echo "Error agregando Paracetamol: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
