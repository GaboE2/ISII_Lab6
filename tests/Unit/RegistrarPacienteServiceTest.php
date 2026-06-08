<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Application\RegistrarPacienteService;
use App\Domain\Repository\PacienteRepositoryInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class RegistrarPacienteServiceTest extends TestCase {
    public function test_ejecuta_y_guarda_paciente_con_mock(): void {
        $repo = $this->createMock(PacienteRepositoryInterface::class);
        $repo->expects(self::once())->method('save')->willReturn(true);

        $service = new RegistrarPacienteService($repo);
        $result = $service->ejecutar([
            'nombre' => 'Ana', 
            'apellido' => 'Lopez', 
            'dni' => '76543210'
        ]);
        
        self::assertTrue($result);
    }

    public function test_falla_si_faltan_datos(): void {
        $repo = $this->createMock(PacienteRepositoryInterface::class);
        $service = new RegistrarPacienteService($repo);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Faltan datos para registrar el paciente.');
        
        $service->ejecutar([
            'nombre' => 'Ana'
        ]);
    }
}