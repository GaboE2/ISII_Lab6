<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../php/Productos/Dominio/Medicamento.php';
require_once __DIR__ . '/../../php/Productos/Dominio/DatosRegistroProducto.php';

class MedicamentoTest extends TestCase
{
    public function test_crea_medicamento_valido_correctamente()
    {
        $med = new Medicamento(new DatosRegistroProducto(
            tipo: 'medicamento',
            nombre: 'Paracetamol',
            clase: 'Analgésico',
            stock: 100,
            precio: 10.5,
            imagen: 'img_123.jpg'
        ));

        $this->assertTrue($med->esMedicamento());
        $this->assertFalse($med->esSuplemento());
        $this->assertTrue($med->tieneStockDisponible());
    }

    public function test_tipo_invalido_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de producto inválido');

        new Medicamento(new DatosRegistroProducto(
            tipo: 'vitamina',
            nombre: 'Vitamina C',
            clase: 'Suplemento',
            stock: 50,
            precio: 35.9,
            imagen: 'img_456.jpg'
        ));
    }

    public function test_nombre_vacio_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('nombre del producto es obligatorio');

        new Medicamento(new DatosRegistroProducto(
            tipo: 'medicamento',
            nombre: '',
            clase: 'Analgésico',
            stock: 10,
            precio: 5.0,
            imagen: 'img.jpg'
        ));
    }

    public function test_stock_negativo_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('stock no puede ser negativo');

        new Medicamento(new DatosRegistroProducto(
            tipo: 'medicamento',
            nombre: 'Ibuprofeno',
            clase: 'Analgésico',
            stock: -5,
            precio: 8.0,
            imagen: 'img.jpg'
        ));
    }

    public function test_precio_cero_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('precio debe ser mayor a 0');

        new Medicamento(new DatosRegistroProducto(
            tipo: 'suplemento',
            nombre: 'Vitamina D',
            clase: 'Suplemento',
            stock: 20,
            precio: 0,
            imagen: 'img.jpg'
        ));
    }

    public function test_imagen_vacia_lanza_excepcion()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('imagen del producto es obligatoria');

        new Medicamento(new DatosRegistroProducto(
            tipo: 'medicamento',
            nombre: 'Amoxicilina',
            clase: 'Antibiótico',
            stock: 30,
            precio: 15.0,
            imagen: ''
        ));
    }

    public function test_tiene_stock_disponible_es_falso_si_stock_es_cero()
    {
        $med = new Medicamento(new DatosRegistroProducto(
            tipo: 'medicamento',
            nombre: 'Aspirina',
            clase: 'Analgésico',
            stock: 0,
            precio: 5.0,
            imagen: 'img.jpg'
        ));

        $this->assertFalse($med->tieneStockDisponible());
    }
}

