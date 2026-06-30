<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosRegistroUsuario.php';

class Usuario
{
    private const ROLES_VALIDOS = ['paciente', 'doctor', 'administrador'];

    private string $tipoDocumento;
    private string $numeroDocumento;
    private string $fechaNacimiento;
    private string $nombres;
    private string $apellidos;
    private string $telefono;
    private string $passwordHash;
    private string $rol;
    private ?string $especialidad;

    public function __construct(DatosRegistroUsuario $datos)
    {
        if (!in_array($datos->rol, self::ROLES_VALIDOS, true)) {
            throw new InvalidArgumentException("Tipo de cuenta inválido: {$datos->rol}");
        }

        if (trim($datos->passwordPlano) === '') {
            throw new InvalidArgumentException("La contraseña es obligatoria.");
        }

        if ($datos->rol === 'doctor' && (empty($datos->especialidad) || trim($datos->especialidad) === '')) {
            throw new InvalidArgumentException("La especialidad es obligatoria para doctores.");
        }

        $this->tipoDocumento = $datos->tipoDocumento;
        $this->numeroDocumento = $datos->numeroDocumento;
        $this->fechaNacimiento = $datos->fechaNacimiento;
        $this->nombres = $datos->nombres;
        $this->apellidos = $datos->apellidos;
        $this->telefono = $datos->telefono;
        $this->passwordHash = password_hash($datos->passwordPlano, PASSWORD_DEFAULT);
        $this->rol = $datos->rol;
        $this->especialidad = ($datos->rol === 'doctor') ? $datos->especialidad : null;
    }

    public function getTipoDocumento(): string { return $this->tipoDocumento; }
    public function getNumeroDocumento(): string { return $this->numeroDocumento; }
    public function getFechaNacimiento(): string { return $this->fechaNacimiento; }
    public function getNombres(): string { return $this->nombres; }
    public function getApellidos(): string { return $this->apellidos; }
    public function getTelefono(): string { return $this->telefono; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function getRol(): string { return $this->rol; }
    public function getEspecialidad(): ?string { return $this->especialidad; }

    public function esDoctor(): bool
    {
        return $this->rol === 'doctor';
    }

    public function toArray(): array
    {
        return [
            'tipo_documento'   => $this->tipoDocumento,
            'numero_documento' => $this->numeroDocumento,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'nombres'          => $this->nombres,
            'apellidos'        => $this->apellidos,
            'telefono'         => $this->telefono,
            'password'         => $this->passwordHash,
            'rol'              => $this->rol,
            'especialidad'     => $this->especialidad,
        ];
    }
}
