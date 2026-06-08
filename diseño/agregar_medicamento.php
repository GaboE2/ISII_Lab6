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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['nombre'];
    $product_class = $_POST['product_class'];
    $exp_date = $_POST['exp_date'];
    $stock = $_POST['stock'];
    $price = $_POST['precio'];

    $sql = "INSERT INTO medicamento (Nombre_Medicamento, Clase_Medicamento, Fecha_vencimiento, Stock_medicamento, Precio_medicamento) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssid", $product_name, $product_class, $exp_date, $stock, $price);

    if ($stmt->execute()) {
        echo "Medicamento agregado correctamente";
    } else {
        echo "Error agregando el medicamento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
