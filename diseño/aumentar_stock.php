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
    $new_stock = $_POST['new_stock'];

    $sql = "UPDATE medicamento SET Stock_medicamento = Stock_medicamento + ? WHERE ID_Medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_stock, $product_id);

    if ($stmt->execute()) {
        echo "Stock actualizado correctamente";
    } else {
        echo "Error actualizando el stock: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
