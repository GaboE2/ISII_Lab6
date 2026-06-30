<?php
declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/IUsuarioRepository.php';

class UsuarioService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registrar(
        string $tipoDocumento,
        string $numeroDocumento,
        string $fechaNacimiento,
        string $nombres,
        string $apellidos,
        string $telefono,
        string $passwordPlano,
        string $rol,
        ?string $especialidad = null
    ): bool {
        // Regla de aplicación: no permitir documentos duplicados
        $existente = $this->repository->buscarPorDocumento($numeroDocumento);
        if ($existente !== null) {
            throw new RuntimeException("Ya existe un usuario registrado con ese número de documento.");
        }

        // La Entidad valida sus propios invariantes en el constructor
        $usuario = new Usuario(
            $tipoDocumento,
            $numeroDocumento,
            $fechaNacimiento,
            $nombres,
            $apellidos,
            $telefono,
            $passwordPlano,
            $rol,
            $especialidad
        );

        return $this->repository->guardar($usuario);
    }
}
