<?php

namespace Farmacia\Tests\Sistema\Dominio\ObjetosValor;

use Farmacia\Domain\ValueObjects\PhoneNumber;
use PHPUnit\Framework\TestCase;

class TelefonoObjetoValorUnitariaTest extends TestCase
{
    private PhoneNumber $phoneNumber;
    private string $validPhone = '1234567890';

    protected function setUp(): void
    {
        // Inicializar PhoneNumber válido para usarlo en múltiples tests
        $this->phoneNumber = new PhoneNumber($this->validPhone);
    }

    protected function tearDown(): void
    {
        // Liberar el objeto después de cada prueba
        unset($this->phoneNumber);
    }

    // ===== CASO PN1: Crear PhoneNumber válido (10 dígitos) =====
    // Especificación: Crear PhoneNumber con valor válido de 10 dígitos
    // Valores de Prueba: "1234567890"
    // Resultado Esperado: PhoneNumber creado correctamente
    public function test_crea_telefono_valido_de_diez_digitos(): void
    {
        $this->assertInstanceOf(PhoneNumber::class, $this->phoneNumber);
        $this->assertEquals($this->validPhone, $this->phoneNumber->getValue());
    }

    // ===== CASO PN2: Crear PhoneNumber con 7 dígitos =====
    // Especificación: Crear PhoneNumber con cantidad mínima de dígitos
    // Valores de Prueba: "1234567"
    // Resultado Esperado: PhoneNumber creado correctamente (7 es mínimo)
    public function test_crea_telefono_con_minimo_de_digitos(): void
    {
        $phoneNumber = new PhoneNumber('1234567');
        $this->assertInstanceOf(PhoneNumber::class, $phoneNumber);
        $this->assertEquals('1234567', $phoneNumber->getValue());
    }

    // ===== CASO PN3: Crear PhoneNumber con 15 dígitos =====
    // Especificación: Crear PhoneNumber con cantidad máxima de dígitos
    // Valores de Prueba: "123456789012345"
    // Resultado Esperado: PhoneNumber creado correctamente (15 es máximo)
    public function test_crea_telefono_con_maximo_de_digitos(): void
    {
        $phoneNumber = new PhoneNumber('123456789012345');
        $this->assertInstanceOf(PhoneNumber::class, $phoneNumber);
        $this->assertEquals('123456789012345', $phoneNumber->getValue());
    }

    // ===== CASO PN4: Crear PhoneNumber con prefijo internacional =====
    // Especificación: Crear PhoneNumber con prefijo +
    // Valores de Prueba: "+1234567890"
    // Resultado Esperado: PhoneNumber creado correctamente con +
    public function test_crea_telefono_con_prefijo_internacional(): void
    {
        $phoneNumber = new PhoneNumber('+1234567890');
        $this->assertInstanceOf(PhoneNumber::class, $phoneNumber);
        $this->assertEquals('+1234567890', $phoneNumber->getValue());
    }

    // ===== CASO PN5: Crear PhoneNumber con menos de 7 dígitos =====
    // Especificación: Intentar crear PhoneNumber con menos de 7 dígitos
    // Valores de Prueba: "123456" (solo 6 dígitos)
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_menos_del_minimo_de_digitos(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('123456');
    }

    // ===== CASO PN6: Crear PhoneNumber con más de 15 dígitos =====
    // Especificación: Intentar crear PhoneNumber con más de 15 dígitos
    // Valores de Prueba: "1234567890123456" (16 dígitos)
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_mas_del_maximo_de_digitos(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('1234567890123456');
    }

    // ===== CASO PN7: Crear PhoneNumber con caracteres alfabéticos =====
    // Especificación: Intentar crear PhoneNumber con letras
    // Valores de Prueba: "123456abc"
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_caracteres_alfabeticos(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('123456abc');
    }

    // ===== CASO PN8: Crear PhoneNumber con caracteres especiales =====
    // Especificación: Intentar crear PhoneNumber con caracteres especiales
    // Valores de Prueba: "123-456-7890"
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_caracteres_especiales(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('123-456-7890');
    }

    // ===== CASO PN9: Crear PhoneNumber vacío =====
    // Especificación: Intentar crear PhoneNumber con cadena vacía
    // Valores de Prueba: ""
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_telefono_vacio(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('');
    }

    // ===== CASO PN10: Obtener valor del PhoneNumber =====
    // Especificación: Obtener el valor string del PhoneNumber
    // Valores de Prueba: PhoneNumber("9876543210")
    // Resultado Esperado: Retorna "9876543210"
    public function test_obtiene_valor_del_telefono(): void
    {
        $expectedValue = '9876543210';
        $phoneNumber = new PhoneNumber($expectedValue);
        
        $this->assertEquals($expectedValue, $phoneNumber->getValue());
        $this->assertIsString($phoneNumber->getValue());
    }

    // ===== CASO PN11: Comparar PhoneNumbers iguales =====
    // Especificación: Verificar que dos PhoneNumbers con mismo valor son iguales
    // Valores de Prueba: PN1("1234567890"), PN2("1234567890")
    // Resultado Esperado: equals() retorna true
    public function test_compara_telefonos_iguales(): void
    {
        $value = '1234567890';
        $phoneNumber1 = new PhoneNumber($value);
        $phoneNumber2 = new PhoneNumber($value);
        
        $this->assertTrue($phoneNumber1->equals($phoneNumber2));
        $this->assertEquals($phoneNumber1->getValue(), $phoneNumber2->getValue());
    }

    // ===== CASO PN12: Comparar PhoneNumbers diferentes =====
    // Especificación: Verificar que dos PhoneNumbers con distinto valor no son iguales
    // Valores de Prueba: PN1("1234567890"), PN2("9876543210")
    // Resultado Esperado: equals() retorna false
    public function test_compara_telefonos_diferentes(): void
    {
        $phoneNumber1 = new PhoneNumber('1234567890');
        $phoneNumber2 = new PhoneNumber('9876543210');
        
        $this->assertFalse($phoneNumber1->equals($phoneNumber2));
        $this->assertNotEquals($phoneNumber1->getValue(), $phoneNumber2->getValue());
    }

    // ===== CASO PN13: Convertir PhoneNumber a string =====
    // Especificación: Usar __toString() para convertir PhoneNumber a string
    // Valores de Prueba: PhoneNumber("5556667777")
    // Resultado Esperado: Retorna "5556667777"
    public function test_convierte_telefono_a_cadena(): void
    {
        $expectedValue = '5556667777';
        $phoneNumber = new PhoneNumber($expectedValue);
        
        $stringRepresentation = (string)$phoneNumber;
        
        $this->assertEquals($expectedValue, $stringRepresentation);
        $this->assertIsString($stringRepresentation);
    }

    // ===== CASO PN14: PhoneNumber con espacios en blanco =====
    // Especificación: Intentar crear PhoneNumber con espacios
    // Valores de Prueba: "123 456 7890"
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_con_espacios_en_blanco(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        new PhoneNumber('123 456 7890');
    }

    // ===== CASO PN15: PhoneNumber con prefijo internacional largo =====
    // Especificación: Crear PhoneNumber con prefijo + y máximo de dígitos
    // Valores de Prueba: "+123456789012345" (con +, suma 16 caracteres)
    // Resultado Esperado: Lanza InvalidArgumentException (más de 15 dígitos)
    public function test_falla_con_prefijo_internacional_largo(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de teléfono inválido');
        
        // +12345678901234 = 14 dígitos + 1 signo = válido
        $validOne = new PhoneNumber('+12345678901234');
        $this->assertEquals('+12345678901234', $validOne->getValue());
        
        // +123456789012345 = 15 dígitos + 1 signo = inválido (16 caracteres totales pero regex verifica solo dígitos)
        // El regex es: /^\+?[0-9]{7,15}$/ - entonces esto debería fallar si tienen más de 15 dígitos
        // Probamos con 16 dígitos después del +
        new PhoneNumber('+1234567890123456');
    }

    // ===== CASO PN16: Reflexión del estado después de setUp y tearDown =====
    // Especificación: Verificar que después de setUp, el objeto está en estado correcto
    // Valores de Prueba: PhoneNumber del setUp
    // Resultado Esperado: El phoneNumber tiene el valor validPhone
    public function test_estado_despues_de_preparacion(): void
    {
        // El setUp ya crea $this->phoneNumber con $this->validPhone
        $this->assertEquals($this->validPhone, $this->phoneNumber->getValue());
        $this->assertInstanceOf(PhoneNumber::class, $this->phoneNumber);
    }

    // ===== CASO PN17: Múltiples instancias son independientes =====
    // Especificación: Crear múltiples PhoneNumbers y verificar que son independientes
    // Valores de Prueba: PN1("1111111111"), PN2("2222222222"), PN3("3333333333")
    // Resultado Esperado: Cada instancia mantiene su valor
    public function test_multiples_instancias_de_telefono_son_independientes(): void
    {
        $phone1 = new PhoneNumber('1111111111');
        $phone2 = new PhoneNumber('2222222222');
        $phone3 = new PhoneNumber('3333333333');
        
        $this->assertEquals('1111111111', $phone1->getValue());
        $this->assertEquals('2222222222', $phone2->getValue());
        $this->assertEquals('3333333333', $phone3->getValue());
        
        $this->assertFalse($phone1->equals($phone2));
        $this->assertFalse($phone2->equals($phone3));
        $this->assertFalse($phone1->equals($phone3));
    }

    // ===== CASO PN18: Validación con número de país México =====
    // Especificación: Crear PhoneNumber con formato México (10 dígitos)
    // Valores de Prueba: "5551234567"
    // Resultado Esperado: PhoneNumber creado correctamente
    public function test_valida_formato_mexico(): void
    {
        $phoneNumber = new PhoneNumber('5551234567');
        $this->assertEquals('5551234567', $phoneNumber->getValue());
    }

    // ===== CASO PN19: Validación con formato internacional Colombia =====
    // Especificación: Crear PhoneNumber con código internacional de Colombia
    // Valores de Prueba: "+573001234567"
    // Resultado Esperado: PhoneNumber creado correctamente
    public function test_valida_formato_internacional_colombia(): void
    {
        $phoneNumber = new PhoneNumber('+573001234567');
        $this->assertEquals('+573001234567', $phoneNumber->getValue());
    }

    // ===== CASO PN20: Validación con solo 7 dígitos y prefijo =====
    // Especificación: Crear PhoneNumber con prefijo + pero solo 7 dígitos
    // Valores de Prueba: "+1234567"
    // Resultado Esperado: PhoneNumber creado correctamente (cumple mínimo)
    public function test_valida_prefijo_internacional_con_minimo_de_digitos(): void
    {
        $phoneNumber = new PhoneNumber('+1234567');
        $this->assertEquals('+1234567', $phoneNumber->getValue());
    }
}

