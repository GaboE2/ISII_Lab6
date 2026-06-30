<?php
declare(strict_types=1);
session_start();
ob_start();

require_once __DIR__ . '/conexion_bd.php';
require_once __DIR__ . '/Citas/Aplicacion/CitaService.php';
require_once __DIR__ . '/Citas/Infraestructura/CitaRepository.php';
require_once __DIR__ . '/Citas/Dominio/DatosRegistroCita.php';

$conn = $conexion;

// Solo un paciente logueado puede reservar cita.
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['rol'] !== 'paciente') {
    header("Location: /farmacia/diseno/pages/login.html?error=" . urlencode("Debes iniciar sesión como paciente."));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idPaciente = (int) $_SESSION['id_usuario'];
    $idDoctor   = (int) trim(htmlspecialchars($_POST['id_doctor'] ?? ''));
    $fechaCita  = trim(htmlspecialchars($_POST['fecha_cita'] ?? ''));
    $horaCita   = trim(htmlspecialchars($_POST['hora_cita'] ?? ''));
    $motivo     = trim(htmlspecialchars($_POST['motivo_cita'] ?? ''));

    $repository = new CitaRepository($conn);
    $service = new CitaService($repository);

    try {
        $datos = new DatosRegistroCita(
            idPaciente: $idPaciente,
            idDoctor: $idDoctor,
            fechaCita: $fechaCita,
            horaCita: $horaCita,
            motivo: $motivo
        );

        $exito = $service->reservar($datos);

        $conn->close();

        if ($exito) {
            header("Location: /farmacia/diseno/pages/citapaciente.php?exito=1");
        } else {
            header("Location: /farmacia/diseno/pages/citapaciente.php?error=" . urlencode("No se pudo guardar la cita."));
        }
        exit();

    } catch (InvalidArgumentException $e) {
        $conn->close();
        header("Location: /farmacia/diseno/pages/citapaciente.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

ob_end_flush();
?>

