<?php
declare(strict_types=1);
session_start();
ob_start();

require_once __DIR__ . '/conexion_bd.php';
require_once __DIR__ . '/Consultas/Aplicacion/ConsultaService.php';
require_once __DIR__ . '/Consultas/Infraestructura/ConsultaRepository.php';
require_once __DIR__ . '/Consultas/Infraestructura/RecetaRepository.php';

$conn = $conexion;

// Solo un doctor logueado puede registrar consultas.
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['rol'] !== 'doctor') {
    header("Location: /farmacia/diseno/pages/login.php?error=" . urlencode("Debes iniciar sesión como doctor."));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idDoctor      = (int) $_SESSION['id_usuario'];
    $idCita        = (int) trim(htmlspecialchars($_POST['id_cita'] ?? ''));
    $idPaciente    = (int) trim(htmlspecialchars($_POST['id_paciente'] ?? ''));
    $diagnostico   = trim(htmlspecialchars($_POST['diagnostico'] ?? ''));
    $idMedicamento = (int) trim(htmlspecialchars($_POST['id_medicamento'] ?? ''));
    $dosis         = trim(htmlspecialchars($_POST['dosis'] ?? ''));
    $instrucciones = trim(htmlspecialchars($_POST['instrucciones'] ?? ''));

    if ($idCita === 0 || $idPaciente === 0 || $diagnostico === '') {
        header("Location: /farmacia/diseno/pages/citas_doctor.php?error=" . urlencode("Completa el diagnóstico antes de guardar."));
        exit();
    }

    $consultaRepository = new ConsultaRepository($conn);
    $recetaRepository = new RecetaRepository($conn);
    $service = new ConsultaService($consultaRepository, $recetaRepository);

    try {
        $exito = $service->registrar(
            idCita: $idCita,
            idPaciente: $idPaciente,
            idDoctor: $idDoctor,
            diagnostico: $diagnostico,
            idMedicamento: $idMedicamento,
            dosis: $dosis,
            instrucciones: $instrucciones
        );

        $conn->close();

        if ($exito) {
            header("Location: /farmacia/diseno/pages/citas_doctor.php?exito=1");
        } else {
            header("Location: /farmacia/diseno/pages/citas_doctor.php?error=" . urlencode("No se pudo guardar la consulta."));
        }
        exit();

    } catch (InvalidArgumentException $e) {
        $conn->close();
        header("Location: /farmacia/diseno/pages/citas_doctor.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

ob_end_flush();
?>

