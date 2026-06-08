<?php

declare(strict_types=1);

session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Auth\LoginController;
use App\Auth\LoginService;
use Farmacia\Infrastructure\Database\Connection;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../diseño/login.html');
    exit;
}

try {
    $connection = Connection::getInstance(
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'farmacia',
        port: 3310
    );
} catch (Throwable $exception) {
    http_response_code(500);
    echo '<h1>Error de conexión</h1>';
    echo '<p>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p><a href="../diseño/login.html">Volver al login</a></p>';
    exit;
}

$loginController = new LoginController(new LoginService($connection));
$response = $loginController->handle($_POST, $_SERVER, $_SESSION);
header('Location: ' . $response['redirect']);
exit;
