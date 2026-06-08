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

// Obtener los medicamentos
$sql = "SELECT * FROM medicamento";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="product" data-name="p-' . $row["ID_Medicamento"] . '" data-id="' . $row["ID_Medicamento"] . '">';
        echo '<img src="img/im' . $row["ID_Medicamento"] . '.png" alt="' . $row["Nombre_Medicamento"] . '">';
        echo '<h3>' . $row["Nombre_Medicamento"] . '</h3>';
        echo '<h3>ID: ' . str_pad($row["ID_Medicamento"], 3, '0', STR_PAD_LEFT) . '</h3>';
        echo '<div class="price">S/ ' . $row["Precio_medicamento"] . '</div>';
        echo '</div>';
    }
} else {
    echo "No hay productos disponibles.";
}

$conn->close();
?>
