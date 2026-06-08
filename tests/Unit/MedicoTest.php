<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Domain\Entity\Medico;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MedicoTest extends TestCase {
    public function test_crea_medico_exitoso(): void {
        $medico = new Medico('CMP123', 'Carlos Ruiz', 'Pediatría');
        self::assertSame('Pediatría', $medico->toArray()['especialidad']);
        self::assertSame('CMP123', $medico->toArray()['cmp']);
        self::assertSame('Carlos Ruiz', $medico->toArray()['nombre']);
    }

    public function test_falla_si_cmp_esta_vacio(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El CMP no puede estar vacío.');
        new Medico('   ', 'Carlos Ruiz', 'Pediatría');
    }

    public function test_falla_si_nombre_esta_vacio(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre no puede estar vacío.');
        new Medico('CMP123', '', 'Pediatría');
    }

    public function test_falla_si_especialidad_esta_vacia(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('La especialidad no puede estar vacía.');
        new Medico('CMP123', 'Carlos Ruiz', '  ');
    }
}