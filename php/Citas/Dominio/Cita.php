<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosRegistroCita.php';

class Cita
{
    private const ESTADOS_VALIDOS = ['pendiente', 'atendida', 'cancelada'];

    private ?int $id;
    private int $idPaciente;
    private int $idDoctor;
    private string $fechaCita;
    private string $horaCita;
    private string $motivo;
    private string $estado;
    private ?string $creadoEn;

    public function __construct(DatosRegistroCita $datos)
    {
        if (trim($datos->fechaCita) === '') {
            throw new InvalidArgumentException("La fecha de la cita es obligatoria.");
        }

        if (trim($datos->horaCita) === '') {
            throw new InvalidArgumentException("La hora de la cita es obligatoria.");
        }

        if ($datos->idPaciente === $datos->idDoctor) {
            throw new InvalidArgumentException("El paciente y el doctor no pueden ser la misma persona.");
        }

        $this->id = null;
        $this->idPaciente = $datos->idPaciente;
        $this->idDoctor = $datos->idDoctor;
        $this->fechaCita = $datos->fechaCita;
        $this->horaCita = $datos->horaCita;
        $this->motivo = $datos->motivo;
        $this->estado = 'pendiente';
        $this->creadoEn = null;
    }

    /**
     * Reconstruye una Cita ya existente (por ejemplo, desde la base de datos),
     * sin pasar por las validaciones de creación nueva.
     */
    public static function reconstruir(
        int $id,
        int $idPaciente,
        int $idDoctor,
        string $fechaCita,
        string $horaCita,
        string $motivo,
        string $estado,
        ?string $creadoEn
    ): self {
        if (!in_array($estado, self::ESTADOS_VALIDOS, true)) {
            throw new InvalidArgumentException("Estado de cita inválido: {$estado}");
        }

        $instancia = new self(new DatosRegistroCita(
            idPaciente: $idPaciente,
            idDoctor: $idDoctor,
            fechaCita: $fechaCita,
            horaCita: $horaCita,
            motivo: $motivo
        ));

        $instancia->id = $id;
        $instancia->estado = $estado;
        $instancia->creadoEn = $creadoEn;

        return $instancia;
    }

    public function cancelar(): void
    {
        $this->estado = 'cancelada';
    }

    public function marcarComoAtendida(): void
    {
        $this->estado = 'atendida';
    }

    public function getId(): ?int { return $this->id; }
    public function getIdPaciente(): int { return $this->idPaciente; }
    public function getIdDoctor(): int { return $this->idDoctor; }
    public function getFechaCita(): string { return $this->fechaCita; }
    public function getHoraCita(): string { return $this->horaCita; }
    public function getMotivo(): string { return $this->motivo; }
    public function getEstado(): string { return $this->estado; }
    public function getCreadoEn(): ?string { return $this->creadoEn; }

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'id_paciente'  => $this->idPaciente,
            'id_doctor'    => $this->idDoctor,
            'fecha_cita'   => $this->fechaCita,
            'hora_cita'    => $this->horaCita,
            'motivo'       => $this->motivo,
            'estado'       => $this->estado,
            'creado_en'    => $this->creadoEn,
        ];
    }
}
