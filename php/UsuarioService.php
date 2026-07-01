<?php
declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/IUsuarioRepository.php';
require_once __DIR__ . '/DatosRegistroUsuario.php';
require_once __DIR__ . '/DocumentoYaRegistradoException.php';

class UsuarioService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registrar(DatosRegistroUsuario $datos): bool
    {
        $existente = $this->repository->buscarPorDocumento($datos->numeroDocumento);
        if ($existente !== null) {
            throw new DocumentoYaRegistradoException($datos->numeroDocumento);
        }

        $usuario = new Usuario($datos);

        return $this->repository->guardar($usuario);
    }
}

