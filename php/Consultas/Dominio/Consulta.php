<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosRegistroConsulta.php';

class Consulta
{
    private ?int $id;
    private int $idCita;
    private int $idPaciente;
    private int $idDoctor;
    private string $fechaConsulta;
    private string $motivo;
    private string $diagnostico;

    public function __construct(DatosRegistroConsulta $datos)
    {
        if ($datos->idCita <= 0) {
            throw new InvalidArgumentException("La cita asociada es obligatoria.");
        }

        if (trim($datos->diagnostico) === '') {
            throw new InvalidArgumentException("El diagnóstico es obligatorio.");
        }

        $this->id = null;
        $this->idCita = $datos->idCita;
        $this->idPaciente = $datos->idPaciente;
        $this->idDoctor = $datos->idDoctor;
        $this->fechaConsulta = $datos->fechaConsulta;
        $this->motivo = $datos->motivo;
        $this->diagnostico = $datos->diagnostico;
    }

    public static function reconstruir(
        int $id,
        int $idCita,
        int $idPaciente,
        int $idDoctor,
        string $fechaConsulta,
        string $motivo,
        string $diagnostico
    ): self {
        $instancia = new self(new DatosRegistroConsulta(
            idCita: $idCita,
            idPaciente: $idPaciente,
            idDoctor: $idDoctor,
            fechaConsulta: $fechaConsulta,
            motivo: $motivo,
            diagnostico: $diagnostico
        ));

        $instancia->id = $id;

        return $instancia;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdCita(): int { return $this->idCita; }
    public function getIdPaciente(): int { return $this->idPaciente; }
    public function getIdDoctor(): int { return $this->idDoctor; }
    public function getFechaConsulta(): string { return $this->fechaConsulta; }
    public function getMotivo(): string { return $this->motivo; }
    public function getDiagnostico(): string { return $this->diagnostico; }

    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'id_cita'        => $this->idCita,
            'id_paciente'    => $this->idPaciente,
            'id_doctor'      => $this->idDoctor,
            'fecha_consulta' => $this->fechaConsulta,
            'motivo'         => $this->motivo,
            'diagnostico'    => $this->diagnostico,
        ];
    }
}
