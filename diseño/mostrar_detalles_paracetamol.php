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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $sql = "SELECT * FROM medicamento WHERE ID_Medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo "Detalles del Medicamento:<br>";
        echo "Nombre: " . $row["Nombre_Medicamento"] . "<br>";
        echo "Clase: " . $row["Clase_Medicamento"] . "<br>";
        echo "Fecha de Vencimiento: " . $row["Fecha_vencimiento"] . "<br>";
        echo "Stock: " . $row["Stock_medicamento"] . "<br>";
        echo "Precio: S/ " . $row["Precio_medicamento"];
    } else {
        echo "Error al mostrar los detalles";
    }

    $stmt->close();
}

$conn->close();
?>
