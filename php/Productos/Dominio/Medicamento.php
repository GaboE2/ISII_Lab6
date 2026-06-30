<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosRegistroProducto.php';

class Medicamento
{
    private const TIPOS_VALIDOS = ['medicamento', 'suplemento'];

    private ?int $id;
    private string $tipo;
    private string $nombre;
    private string $clase;
    private int $stock;
    private float $precio;
    private string $imagen;

    public function __construct(DatosRegistroProducto $datos)
    {
        if (!in_array($datos->tipo, self::TIPOS_VALIDOS, true)) {
            throw new InvalidArgumentException("Tipo de producto inválido: {$datos->tipo}");
        }

        if (trim($datos->nombre) === '') {
            throw new InvalidArgumentException("El nombre del producto es obligatorio.");
        }

        if (trim($datos->clase) === '') {
            throw new InvalidArgumentException("La clase del producto es obligatoria.");
        }

        if ($datos->stock < 0) {
            throw new InvalidArgumentException("El stock no puede ser negativo.");
        }

        if ($datos->precio <= 0) {
            throw new InvalidArgumentException("El precio debe ser mayor a 0.");
        }

        if (trim($datos->imagen) === '') {
            throw new InvalidArgumentException("La imagen del producto es obligatoria.");
        }

        $this->id = null;
        $this->tipo = $datos->tipo;
        $this->nombre = $datos->nombre;
        $this->clase = $datos->clase;
        $this->stock = $datos->stock;
        $this->precio = $datos->precio;
        $this->imagen = $datos->imagen;
    }

    public function esMedicamento(): bool { return $this->tipo === 'medicamento'; }
    public function esSuplemento(): bool { return $this->tipo === 'suplemento'; }
    public function tieneStockDisponible(): bool { return $this->stock > 0; }

    public function getId(): ?int { return $this->id; }
    public function getTipo(): string { return $this->tipo; }
    public function getNombre(): string { return $this->nombre; }
    public function getClase(): string { return $this->clase; }
    public function getStock(): int { return $this->stock; }
    public function getPrecio(): float { return $this->precio; }
    public function getImagen(): string { return $this->imagen; }

    public function asignarId(int $id): void
    {
        $this->id = $id;
    }
}

