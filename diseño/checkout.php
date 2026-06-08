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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart'])) {
    $cart = json_decode($_POST['cart'], true);
    $user_id = 1; // Puedes reemplazar esto con el ID de usuario real si tienes un sistema de autenticación

    echo "<pre>";
    print_r($cart); // Esto imprimirá el contenido del carrito para que puedas ver lo que se está recibiendo
    echo "</pre>";

    $conn->begin_transaction();

    try {
        foreach ($cart as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];

            // Reducir el stock del medicamento
            $sql = "UPDATE medicamento SET Stock_medicamento = Stock_medicamento - ? WHERE ID_Medicamento = ? AND Stock_medicamento >= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $id, $quantity);

            if (!$stmt->execute()) {
                throw new Exception("Error actualizando el stock: " . $stmt->error);
            }

            if ($stmt->affected_rows === 0) {
                throw new Exception("Stock insuficiente para el medicamento ID: " . $id);
            }

            // Registrar el pedido en la tabla pedido_usuario
            $sql = "INSERT INTO pedido_usuario (user_id, medicamento_id, cantidad, fecha_pedido) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $user_id, $id, $quantity);

            if (!$stmt->execute()) {
                throw new Exception("Error registrando el pedido: " . $stmt->error);
            }
        }

        $conn->commit();
        echo "Sepudo";
    } catch (Exception $e) {
        $conn->rollback();
        echo "No se pudo realizar el pedido: " . $e->getMessage();
    }
} else {
    echo "Carrito vacío";
}

$conn->close();
?>
