<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Citas/Aplicacion/CitaService.php';
require_once __DIR__ . '/../../php/Citas/Dominio/ICitaRepository.php';
require_once __DIR__ . '/../../php/Citas/Dominio/DatosRegistroCita.php';

class CitaServiceTest extends TestCase
{
    public function test_reserva_cita_correctamente()
    {
        $repoMock = $this->createMock(ICitaRepository::class);

        $repoMock->expects($this->once())
                 ->method('guardar')
                 ->willReturn(true);

        $service = new CitaService($repoMock);

        $resultado = $service->reservar(new DatosRegistroCita(
            idPaciente: 1,
            idDoctor: 3,
            fechaCita: '2026-07-20',
            horaCita: '09:00',
            motivo: 'Control'
        ));

        $this->assertTrue($resultado);
    }

    public function test_no_guarda_si_paciente_es_igual_a_doctor()
    {
        $repoMock = $this->createMock(ICitaRepository::class);
        $repoMock->expects($this->never())->method('guardar');

        $service = new CitaService($repoMock);

        $this->expectException(InvalidArgumentException::class);

        $service->reservar(new DatosRegistroCita(
            idPaciente: 7,
            idDoctor: 7,
            fechaCita: '2026-07-20',
            horaCita: '09:00',
            motivo: ''
        ));
    }

    public function test_obtiene_proximas_citas_de_paciente()
    {
        $repoMock = $this->createMock(ICitaRepository::class);
        $repoMock->expects($this->once())
                 ->method('buscarPendientesPorPaciente')
                 ->with(1)
                 ->willReturn([['fecha_cita' => '2026-07-20']]);

        $service = new CitaService($repoMock);
        $citas = $service->obtenerProximasCitasDePaciente(1);

        $this->assertCount(1, $citas);
    }
}

