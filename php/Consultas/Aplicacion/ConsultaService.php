<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dominio/Consulta.php';
require_once __DIR__ . '/../Dominio/DatosRegistroConsulta.php';
require_once __DIR__ . '/../Dominio/Receta.php';
require_once __DIR__ . '/../Dominio/DatosRegistroReceta.php';
require_once __DIR__ . '/../Dominio/IConsultaRepository.php';
require_once __DIR__ . '/../Dominio/IRecetaRepository.php';

class ConsultaService
{
    private IConsultaRepository $consultaRepository;
    private IRecetaRepository $recetaRepository;

    public function __construct(
        IConsultaRepository $consultaRepository,
        IRecetaRepository $recetaRepository
    ) {
        $this->consultaRepository = $consultaRepository;
        $this->recetaRepository = $recetaRepository;
    }

    /**
     * Registra una consulta médica a partir de una cita existente del doctor.
     * Si se incluyen idMedicamento y dosis, registra también la receta.
     * Al finalizar, marca la cita original como atendida.
     *
     * @throws InvalidArgumentException si la cita no existe o no pertenece al doctor.
     */
    public function registrar(
        int $idCita,
        int $idPaciente,
        int $idDoctor,
        string $diagnostico,
        int $idMedicamento = 0,
        string $dosis = '',
        string $instrucciones = ''
    ): bool {
        $datosCita = $this->consultaRepository->buscarCitaDelDoctor($idCita, $idDoctor);

        if ($datosCita === null) {
            throw new InvalidArgumentException("La cita no existe o no pertenece a este doctor.");
        }

        $consulta = new Consulta(new DatosRegistroConsulta(
            idCita: $idCita,
            idPaciente: $idPaciente,
            idDoctor: $idDoctor,
            fechaConsulta: $datosCita['fecha_cita'],
            motivo: $datosCita['motivo'],
            diagnostico: $diagnostico
        ));

        $idConsultaGenerada = $this->consultaRepository->guardar($consulta);

        if ($idConsultaGenerada === null) {
            return false;
        }

        if ($idMedicamento > 0 && trim($dosis) !== '') {
            $receta = new Receta(new DatosRegistroReceta(
                idConsulta: $idConsultaGenerada,
                idMedicamento: $idMedicamento,
                dosis: $dosis,
                instrucciones: $instrucciones
            ));

            $this->recetaRepository->guardar($receta);
        }

        $this->consultaRepository->marcarCitaComoAtendida($idCita);

        return true;
    }

    public function obtenerConsultasDePaciente(int $idPaciente): array
    {
        return $this->consultaRepository->buscarPorPaciente($idPaciente);
    }

    public function obtenerRecetasDePaciente(int $idPaciente): array
    {
        return $this->recetaRepository->buscarPorPaciente($idPaciente);
    }
}

