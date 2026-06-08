<?php
declare(strict_types=1);
namespace Tests\Unit;

use App\Domain\Entity\Paciente;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PacienteTest extends TestCase {
    public function test_crea_paciente_exitoso(): void {
        $paciente = new Paciente('Ana', 'Lopez', '12345678');
        self::assertSame('Ana', $paciente->toArray()['nombre']);
        self::assertSame('Lopez', $paciente->toArray()['apellido']);
        self::assertSame('12345678', $paciente->toArray()['dni']);
    }

    public function test_falla_si_nombre_esta_vacio(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre no puede estar vacío.');
        new Paciente('', 'Lopez', '12345678');
    }

    public function test_falla_si_apellido_esta_vacio(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El apellido no puede estar vacío.');
        new Paciente('Ana', ' ', '12345678');
    }

    public function test_falla_si_dni_no_tiene_8_digitos(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El DNI debe tener exactamente 8 dígitos.');
        new Paciente('Ana', 'Lopez', '1234567');
    }

    public function test_falla_si_dni_tiene_letras(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El DNI debe tener exactamente 8 dígitos.');
        new Paciente('Ana', 'Lopez', '1234567a');
    }
}
