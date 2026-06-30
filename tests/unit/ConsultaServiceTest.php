<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Consultas/Aplicacion/ConsultaService.php';
require_once __DIR__ . '/../../php/Consultas/Dominio/IConsultaRepository.php';
require_once __DIR__ . '/../../php/Consultas/Dominio/IRecetaRepository.php';

class ConsultaServiceTest extends TestCase
{
    public function test_registra_consulta_sin_receta_correctamente()
    {
        $consultaRepo = $this->createMock(IConsultaRepository::class);
        $recetaRepo = $this->createMock(IRecetaRepository::class);

        $consultaRepo->expects($this->once())
                      ->method('buscarCitaDelDoctor')
                      ->with(5, 3)
                      ->willReturn(['fecha_cita' => '2026-07-10', 'motivo' => 'Control']);

        $consultaRepo->expects($this->once())
                      ->method('guardar')
                      ->willReturn(20);

        $recetaRepo->expects($this->never())->method('guardar');

        $consultaRepo->expects($this->once())
                      ->method('marcarCitaComoAtendida')
                      ->with(5)
                      ->willReturn(true);

        $service = new ConsultaService($consultaRepo, $recetaRepo);

        $resultado = $service->registrar(
            idCita: 5,
            idPaciente: 1,
            idDoctor: 3,
            diagnostico: 'Paciente estable'
        );

        $this->assertTrue($resultado);
    }

    public function test_registra_consulta_con_receta_correctamente()
    {
        $consultaRepo = $this->createMock(IConsultaRepository::class);
        $recetaRepo = $this->createMock(IRecetaRepository::class);

        $consultaRepo->method('buscarCitaDelDoctor')
                      ->willReturn(['fecha_cita' => '2026-07-10', 'motivo' => 'Control']);
        $consultaRepo->method('guardar')->willReturn(20);
        $consultaRepo->method('marcarCitaComoAtendida')->willReturn(true);

        $recetaRepo->expects($this->once())->method('guardar')->willReturn(true);

        $service = new ConsultaService($consultaRepo, $recetaRepo);

        $resultado = $service->registrar(
            idCita: 5,
            idPaciente: 1,
            idDoctor: 3,
            diagnostico: 'Paciente estable',
            idMedicamento: 2,
            dosis: '500mg cada 8h'
        );

        $this->assertTrue($resultado);
    }

    public function test_lanza_excepcion_si_cita_no_pertenece_al_doctor()
    {
        $consultaRepo = $this->createMock(IConsultaRepository::class);
        $recetaRepo = $this->createMock(IRecetaRepository::class);

        $consultaRepo->method('buscarCitaDelDoctor')->willReturn(null);
        $consultaRepo->expects($this->never())->method('guardar');

        $service = new ConsultaService($consultaRepo, $recetaRepo);

        $this->expectException(InvalidArgumentException::class);

        $service->registrar(
            idCita: 99,
            idPaciente: 1,
            idDoctor: 3,
            diagnostico: 'Diagnóstico'
        );
    }
}

