<?php
declare(strict_types=1);

require_once __DIR__ . '/DatosEnvioPedido.php';
require_once __DIR__ . '/DetallePedido.php';

class Pedido
{
    private const ESTADOS_VALIDOS = ['pendiente', 'completado', 'cancelado'];

    private ?int $id;
    private int $idUsuario;
    private string $nombreEnvio;
    private string $direccion;
    private string $ciudad;
    private string $telefono;
    private float $total;
    private string $estado;
    /** @var DetallePedido[] */
    private array $detalles;

    /**
     * @param DetallePedido[] $detalles
     */
    public function __construct(DatosEnvioPedido $datosEnvio, array $detalles)
    {
        if (trim($datosEnvio->nombreEnvio) === '') {
            throw new InvalidArgumentException("El nombre de envío es obligatorio.");
        }

        if (trim($datosEnvio->direccion) === '') {
            throw new InvalidArgumentException("La dirección es obligatoria.");
        }

        if (trim($datosEnvio->ciudad) === '') {
            throw new InvalidArgumentException("La ciudad es obligatoria.");
        }

        if (trim($datosEnvio->telefono) === '') {
            throw new InvalidArgumentException("El teléfono es obligatorio.");
        }

        if (count($detalles) === 0) {
            throw new InvalidArgumentException("El carrito está vacío.");
        }

        foreach ($detalles as $detalle) {
            if (!($detalle instanceof DetallePedido)) {
                throw new InvalidArgumentException("Detalle de pedido inválido.");
            }
        }

        $this->id = null;
        $this->idUsuario = $datosEnvio->idUsuario;
        $this->nombreEnvio = $datosEnvio->nombreEnvio;
        $this->direccion = $datosEnvio->direccion;
        $this->ciudad = $datosEnvio->ciudad;
        $this->telefono = $datosEnvio->telefono;
        $this->detalles = $detalles;
        $this->estado = 'completado';

        $total = 0.0;
        foreach ($detalles as $detalle) {
            $total += $detalle->getSubtotal();
        }
        $this->total = round($total, 2);

        if ($this->total <= 0) {
            throw new InvalidArgumentException("El total del pedido debe ser mayor a 0.");
        }
    }

    public function getId(): ?int { return $this->id; }
    public function getIdUsuario(): int { return $this->idUsuario; }
    public function getNombreEnvio(): string { return $this->nombreEnvio; }
    public function getDireccion(): string { return $this->direccion; }
    public function getCiudad(): string { return $this->ciudad; }
    public function getTelefono(): string { return $this->telefono; }
    public function getTotal(): float { return $this->total; }
    public function getEstado(): string { return $this->estado; }

    /** @return DetallePedido[] */
    public function getDetalles(): array { return $this->detalles; }

    public function asignarId(int $id): void
    {
        $this->id = $id;
    }
}

