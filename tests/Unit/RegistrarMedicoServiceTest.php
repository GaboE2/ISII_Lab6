<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Application\RegistrarMedicoService;
use App\Domain\Repository\MedicoRepositoryInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class RegistrarMedicoServiceTest extends TestCase {
    public function test_ejecuta_y_guarda_medico_exitosamente(): void {
        $repo = $this->createMock(MedicoRepositoryInterface::class);
        $repo->expects(self::once())->method('save')->willReturn(true);

        $service = new RegistrarMedicoService($repo);
        $result = $service->ejecutar([
            'cmp' => 'CMP123',
            'nombre' => 'Carlos Ruiz',
            'especialidad' => 'Pediatría'
        ]);
        
        self::assertTrue($result);
    }

    public function test_falla_si_faltan_datos(): void {
        $repo = $this->createMock(MedicoRepositoryInterface::class);
        $service = new RegistrarMedicoService($repo);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Faltan datos para registrar el médico.');
        
        $service->ejecutar([
            'nombre' => 'Carlos Ruiz'
        ]);
    }
}
