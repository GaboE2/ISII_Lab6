<?php

declare(strict_types=1);

namespace Farmacia\Tests\Sistema;

use Farmacia\Domain\ValueObjects\PersonalId;
use PHPUnit\Framework\TestCase;

class IdentificadorPersonalObjetoValorTest extends TestCase
{
    private PersonalId $personalId;

    protected function setUp(): void
    {
        $this->personalId = new PersonalId('12345678');
    }

    protected function tearDown(): void
    {
        unset($this->personalId);
    }

    // ===== CASO PI1: Crear PersonalId válido =====
    // Especificación: Crear PersonalId con valor válido
    // Valores de Prueba: "12345678"
    // Resultado Esperado: PersonalId creado correctamente
    public function test_crea_identificador_personal(): void
    {
        // ARRANGE (Inicializar)
        $personalIdValue = '12345678';

        // ACT (Ejecutar)
        $personalId = $this->personalId;

        // ASSERT (Verificar)
        $this->assertEquals($personalIdValue, $personalId->getValue());
        $this->assertInstanceOf(PersonalId::class, $personalId);
    }

    // ===== CASO PI2: PersonalId vacío lanza excepción =====
    // Especificación: Intentar crear PersonalId con cadena vacía
    // Valores de Prueba: ""
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_identificador_vacio(): void
    {
        // ARRANGE (Indicar que esperamos excepción)
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("ID personal no puede estar vacío");

        // ACT (Ejecutar - debe lanzar excepción)
        new PersonalId('');
    }

    // ===== CASO PI2B: PersonalId muy corto lanza excepción (EXTRA) =====
    // Especificación: Intentar crear PersonalId con menos de 6 caracteres
    // Valores de Prueba: "123"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_identificador_muy_corto(): void
    {
        // ARRANGE (Indicar que esperamos excepción)
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("ID personal debe tener al menos 6 caracteres");

        // ACT (Ejecutar - debe lanzar excepción)
        new PersonalId('123');
    }

    // ===== CASO PI3: Obtener valor del PersonalId =====
    // Especificación: Obtener el valor string del PersonalId
    // Valores de Prueba: PersonalId("87654321")
    // Resultado Esperado: Retorna "87654321"
    public function test_obtiene_valor_del_identificador_personal(): void
    {
        // ARRANGE (Inicializar)
        $expectedValue = '87654321';
        $personalId = new PersonalId($expectedValue);

        // ACT (Ejecutar)
        $actualValue = $personalId->getValue();

        // ASSERT (Verificar)
        $this->assertEquals($expectedValue, $actualValue);
        $this->assertIsString($actualValue);
    }

    // ===== CASO PI4: Comparar PersonalIds iguales =====
    // Especificación: Verificar que dos PersonalIds con mismo valor son iguales
    // Valores de Prueba: ID1("12345678"), ID2("12345678")
    // Resultado Esperado: equals() retorna true
    public function test_compara_identificadores_iguales(): void
    {
        // ARRANGE (Inicializar)
        $value = '12345678';
        $personalId1 = new PersonalId($value);
        $personalId2 = new PersonalId($value);

        // ACT (Ejecutar)
        $isEqual = $personalId1->equals($personalId2);

        // ASSERT (Verificar)
        $this->assertTrue($isEqual);
        $this->assertEquals($personalId1->getValue(), $personalId2->getValue());
    }

    // ===== CASO PI5: Comparar PersonalIds diferentes =====
    // Especificación: Verificar que dos PersonalIds con distinto valor no son iguales
    // Valores de Prueba: ID1("12345678"), ID2("87654321")
    // Resultado Esperado: equals() retorna false
    public function test_compara_identificadores_diferentes(): void
    {
        // ARRANGE (Inicializar)
        $personalId1 = new PersonalId('12345678');
        $personalId2 = new PersonalId('87654321');

        // ACT (Ejecutar)
        $isEqual = $personalId1->equals($personalId2);

        // ASSERT (Verificar)
        $this->assertFalse($isEqual);
        $this->assertNotEquals($personalId1->getValue(), $personalId2->getValue());
    }

    // ===== CASO PI6: Convertir PersonalId a string =====
    // Especificación: Usar __toString() para convertir PersonalId a string
    // Valores de Prueba: PersonalId("55443322")
    // Resultado Esperado: Retorna "55443322"
    public function test_convierte_identificador_a_cadena(): void
    {
        // ARRANGE (Inicializar)
        $expectedValue = '55443322';
        $personalId = new PersonalId($expectedValue);

        // ACT (Ejecutar)
        $stringRepresentation = (string)$personalId;

        // ASSERT (Verificar)
        $this->assertEquals($expectedValue, $stringRepresentation);
        $this->assertIsString($stringRepresentation);
    }
}

