<?php
declare(strict_types=1);

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

    public function __construct(
        string $tipoDocumento,
        string $numeroDocumento,
        string $fechaNacimiento,
        string $nombres,
        string $apellidos,
        string $telefono,
        string $passwordPlano,
        string $rol,
        ?string $especialidad = null
    ) {
        if (!in_array($rol, self::ROLES_VALIDOS, true)) {
            throw new InvalidArgumentException("Tipo de cuenta inválido: {$rol}");
        }

        if (trim($passwordPlano) === '') {
            throw new InvalidArgumentException("La contraseña es obligatoria.");
        }

        if ($rol === 'doctor' && (empty($especialidad) || trim($especialidad) === '')) {
            throw new InvalidArgumentException("La especialidad es obligatoria para doctores.");
        }

        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);
        $this->rol = $rol;
        $this->especialidad = ($rol === 'doctor') ? $especialidad : null;
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

    /** Convierte la entidad al array que espera la capa de persistencia */
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