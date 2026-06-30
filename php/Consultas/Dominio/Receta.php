<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosRegistroReceta.php';

class Receta
{
    private ?int $id;
    private int $idConsulta;
    private int $idMedicamento;
    private string $dosis;
    private string $instrucciones;

    public function __construct(DatosRegistroReceta $datos)
    {
        if ($datos->idMedicamento <= 0) {
            throw new InvalidArgumentException("El medicamento es obligatorio.");
        }

        if (trim($datos->dosis) === '') {
            throw new InvalidArgumentException("La dosis es obligatoria.");
        }

        $this->id = null;
        $this->idConsulta = $datos->idConsulta;
        $this->idMedicamento = $datos->idMedicamento;
        $this->dosis = $datos->dosis;
        $this->instrucciones = $datos->instrucciones;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdConsulta(): int { return $this->idConsulta; }
    public function getIdMedicamento(): int { return $this->idMedicamento; }
    public function getDosis(): string { return $this->dosis; }
    public function getInstrucciones(): string { return $this->instrucciones; }

    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'id_consulta'    => $this->idConsulta,
            'id_medicamento' => $this->idMedicamento,
            'dosis'          => $this->dosis,
            'instrucciones'  => $this->instrucciones,
        ];
    }
}

