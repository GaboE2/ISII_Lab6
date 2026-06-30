<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Usuario.php';
require_once __DIR__ . '/../../php/IUsuarioRepository.php';
require_once __DIR__ . '/../../php/UsuarioService.php';

class UsuarioServiceTest extends TestCase
{
    public function test_registra_usuario_nuevo_correctamente()
    {
        $repoMock = $this->createMock(IUsuarioRepository::class);

        $repoMock->expects($this->once())
                 ->method('buscarPorDocumento')
                 ->with('99999999')
                 ->willReturn(null); // no existe aún

        $repoMock->expects($this->once())
                 ->method('guardar')
                 ->willReturn(true);

        $service = new UsuarioService($repoMock);

        $resultado = $service->registrar(
            'DNI', '99999999', '2000-01-01',
            'Test', 'Paciente', '999000000',
            '123456', 'paciente'
        );

        $this->assertTrue($resultado);
    }

    public function test_lanza_excepcion_si_documento_ya_existe()
    {
        $repoMock = $this->createMock(IUsuarioRepository::class);

        $repoMock->expects($this->once())
                 ->method('buscarPorDocumento')
                 ->willReturn(['id' => 1, 'numero_documento' => '99999999']);

        // guardar() NUNCA debe llamarse si el documento ya existe
        $repoMock->expects($this->never())
                 ->method('guardar');

        $service = new UsuarioService($repoMock);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Ya existe un usuario');

        $service->registrar(
            'DNI', '99999999', '2000-01-01',
            'Test', 'Paciente', '999000000',
            '123456', 'paciente'
        );
    }

    public function test_no_guarda_si_rol_es_invalido()
    {
        $repoMock = $this->createMock(IUsuarioRepository::class);

        $repoMock->method('buscarPorDocumento')->willReturn(null);
        $repoMock->expects($this->never())->method('guardar');

        $service = new UsuarioService($repoMock);

        $this->expectException(InvalidArgumentException::class);

        $service->registrar(
            'DNI', '88888888', '2000-01-01',
            'Test', 'Invalido', '999000000',
            '123456', 'rol_que_no_existe'
        );
    }
}

