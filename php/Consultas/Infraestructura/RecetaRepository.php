<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/IRecetaRepository.php';
require_once __DIR__ . '/../Dominio/Receta.php';

final class RecetaRepository implements IRecetaRepository
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function guardar(Receta $receta): bool
    {
        $sql = "INSERT INTO receta (id_consulta, id_medicamento, dosis, instrucciones)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la receta: " . $this->conn->error);
            return false;
        }

        $idConsulta = $receta->getIdConsulta();
        $idMedicamento = $receta->getIdMedicamento();
        $dosis = $receta->getDosis();
        $instrucciones = $receta->getInstrucciones();

        $stmt->bind_param(
            "iiss",
            $idConsulta,
            $idMedicamento,
            $dosis,
            $instrucciones
        );

        $ok = $stmt->execute();
        if (!$ok) {
            error_log("Error al insertar receta: " . $stmt->error);
        }

        $stmt->close();
        return $ok;
    }

    public function buscarPorPaciente(int $idPaciente): array
    {
        $sql = "SELECT r.dosis, r.instrucciones, c.fecha_consulta, m.nombre AS nombre_medicamento, u.nombres, u.apellidos
                FROM receta r
                INNER JOIN consulta c ON r.id_consulta = c.id
                INNER JOIN medicamento m ON r.id_medicamento = m.id
                INNER JOIN usuario u ON c.id_doctor = u.id
                WHERE c.id_paciente = ?
                ORDER BY c.fecha_consulta DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPaciente);
        $stmt->execute();
        $result = $stmt->get_result();

        $recetas = [];
        while ($row = $result->fetch_assoc()) {
            $recetas[] = $row;
        }

        $stmt->close();
        return $recetas;
    }
}
