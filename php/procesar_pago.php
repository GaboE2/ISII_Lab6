<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/conexion_bd.php';
require_once __DIR__ . '/Pedidos/Aplicacion/PedidoService.php';
require_once __DIR__ . '/Pedidos/Infraestructura/PedidoRepository.php';
require_once __DIR__ . '/Pedidos/Dominio/DatosEnvioPedido.php';

$conn = $conexion;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido.']);
    exit();
}

if (empty($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    echo json_encode(['success' => false, 'mensaje' => 'Debes iniciar sesión para realizar un pedido.']);
    exit();
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos) {
    echo json_encode(['success' => false, 'mensaje' => 'Datos inválidos.']);
    exit();
}

$idUsuario = (int) $_SESSION['id_usuario'];
$carrito   = $datos['carrito'] ?? [];

$repository = new PedidoRepository($conn);
$service = new PedidoService($repository);

try {
    $datosEnvio = new DatosEnvioPedido(
        idUsuario: $idUsuario,
        nombreEnvio: trim($datos['nombre_envio'] ?? ''),
        direccion: trim($datos['direccion'] ?? ''),
        ciudad: trim($datos['ciudad'] ?? ''),
        telefono: trim($datos['telefono'] ?? '')
    );

    $idPedido = $service->realizarPedido($datosEnvio, $carrito);

    $conn->close();

    if ($idPedido === null) {
        echo json_encode(['success' => false, 'mensaje' => 'Error al registrar el pedido.']);
        exit();
    }

    echo json_encode([
        'success'   => true,
        'mensaje'   => 'Pedido registrado correctamente.',
        'id_pedido' => $idPedido
    ]);
    exit();

} catch (InvalidArgumentException $e) {
    $conn->close();
    echo json_encode(['success' => false, 'mensaje' => $e->getMessage()]);
    exit();
}
?>

