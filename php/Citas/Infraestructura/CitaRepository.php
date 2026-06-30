<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/ICitaRepository.php';
require_once __DIR__ . '/../Dominio/Cita.php';

final class CitaRepository implements ICitaRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function guardar(Cita $cita): bool
    {
        $sql = "INSERT INTO cita (id_paciente, id_doctor, fecha_cita, hora_cita, motivo, estado)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la consulta de cita: " . $this->conn->error);
            return false;
        }

        $idPaciente = $cita->getIdPaciente();
        $idDoctor = $cita->getIdDoctor();
        $fecha = $cita->getFechaCita();
        $hora = $cita->getHoraCita();
        $motivo = $cita->getMotivo();
        $estado = $cita->getEstado();

        $stmt->bind_param(
            "iissss",
            $idPaciente,
            $idDoctor,
            $fecha,
            $hora,
            $motivo,
            $estado
        );

        $ok = $stmt->execute();
        if (!$ok) {
            error_log("Error al insertar cita: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }

    public function buscarPendientesPorPaciente(int $idPaciente): array
    {
        $sql = "SELECT c.fecha_cita, c.hora_cita, u.nombres, u.apellidos, u.especialidad
                FROM cita c
                INNER JOIN usuario u ON c.id_doctor = u.id
                WHERE c.id_paciente = ? AND c.estado = 'pendiente'
                ORDER BY c.fecha_cita ASC, c.hora_cita ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPaciente);
        $stmt->execute();
        $result = $stmt->get_result();

        $citas = [];
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }

        $stmt->close();
        return $citas;
    }

    public function listarDoctores(): array
    {
        $sql = "SELECT id, nombres, apellidos, especialidad FROM usuario WHERE rol = 'doctor' ORDER BY nombres ASC";
        $result = $this->conn->query($sql);

        $doctores = [];
        while ($row = $result->fetch_assoc()) {
            $doctores[] = $row;
        }

        return $doctores;
    }
}
