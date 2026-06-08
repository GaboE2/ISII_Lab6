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
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];

    $sql = "UPDATE medicamento SET Precio_medicamento = ? WHERE ID_Medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_price, $product_id);

    if ($stmt->execute()) {
        echo "Precio actualizado correctamente";
    } else {
        echo "Error actualizando el precio: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
