<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/IConsultaRepository.php';
require_once __DIR__ . '/../Dominio/Consulta.php';

final class ConsultaRepository implements IConsultaRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function buscarCitaDelDoctor(int $idCita, int $idDoctor): ?array
    {
        $sql = "SELECT fecha_cita, motivo FROM cita WHERE id = ? AND id_doctor = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idCita, $idDoctor);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {
            $stmt->close();
            return null;
        }

        $datos = $result->fetch_assoc();
        $stmt->close();
        return $datos;
    }

    public function guardar(Consulta $consulta): ?int
    {
        $sql = "INSERT INTO consulta (id_cita, id_paciente, id_doctor, fecha_consulta, motivo, diagnostico)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->conn->error);
            return null;
        }

        $idCita = $consulta->getIdCita();
        $idPaciente = $consulta->getIdPaciente();
        $idDoctor = $consulta->getIdDoctor();
        $fecha = $consulta->getFechaConsulta();
        $motivo = $consulta->getMotivo();
        $diagnostico = $consulta->getDiagnostico();

        $stmt->bind_param(
            "iiisss",
            $idCita,
            $idPaciente,
            $idDoctor,
            $fecha,
            $motivo,
            $diagnostico
        );

        if (!$stmt->execute()) {
            error_log("Error al insertar consulta: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $idGenerado = $stmt->insert_id;
        $stmt->close();
        return $idGenerado;
    }

    public function marcarCitaComoAtendida(int $idCita): bool
    {
        $sql = "UPDATE cita SET estado = 'atendida' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idCita);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function buscarPorPaciente(int $idPaciente): array
    {
        $sql = "SELECT c.fecha_consulta, c.motivo, c.diagnostico, u.nombres, u.apellidos, u.especialidad
                FROM consulta c
                INNER JOIN usuario u ON c.id_doctor = u.id
                WHERE c.id_paciente = ?
                ORDER BY c.fecha_consulta DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPaciente);
        $stmt->execute();
        $result = $stmt->get_result();

        $consultas = [];
        while ($row = $result->fetch_assoc()) {
            $consultas[] = $row;
        }

        $stmt->close();
        return $consultas;
    }
}

