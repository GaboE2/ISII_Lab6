<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Usuario.php';
require_once __DIR__ . '/../../php/DatosRegistroUsuario.php';

class UsuarioTest extends TestCase
{
    public function test_crea_usuario_paciente_valido_correctamente()
    {
        $usuario = new Usuario(new DatosRegistroUsuario(
            'DNI', '12345678', '1990-01-01',
            'Juan', 'Perez', '987654321',
            'claveSegura123', 'paciente'
        ));

        $this->assertSame('paciente', $usuario->getRol());
        $this->assertNull($usuario->getEspecialidad());
        $this->assertFalse($usuario->esDoctor());
    }

    public function test_crea_usuario_doctor_con_especialidad_correctamente()
    {
        $usuario = new Usuario(new DatosRegistroUsuario(
            'DNI', '87654321', '1985-05-10',
            'Maria', 'Lopez', '987111222',
            'claveSegura123', 'doctor', 'Cardiología'
        ));

        $this->assertTrue($usuario->esDoctor());
        $this->assertSame('Cardiología', $usuario->getEspecialidad());
    }

    public function test_rol_invalido_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de cuenta inválido');

        new Usuario(new DatosRegistroUsuario(
            'DNI', '11111111', '1990-01-01',
            'Carlos', 'Ramos', '987000000',
            'claveSegura123', 'superadmin'
        ));
    }

    public function test_password_vacia_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('contraseña es obligatoria');

        new Usuario(new DatosRegistroUsuario(
            'DNI', '22222222', '1990-01-01',
            'Ana', 'Torres', '987000001',
            '', 'paciente'
        ));
    }

    public function test_doctor_sin_especialidad_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('especialidad es obligatoria');

        new Usuario(new DatosRegistroUsuario(
            'DNI', '33333333', '1990-01-01',
            'Luis', 'Garcia', '987000002',
            'claveSegura123', 'doctor', null
        ));
    }
}


