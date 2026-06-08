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
    $delete_medicine = $_POST['delete_medicine'];

    $sql = "DELETE FROM medicamento WHERE Nombre_Medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $delete_medicine);

    if ($stmt->execute()) {
        echo "Medicamento eliminado correctamente";
    } else {
        echo "Error eliminando el medicamento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
