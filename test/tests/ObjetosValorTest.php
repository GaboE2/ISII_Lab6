<?php

use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;
use Farmacia\Domain\ValueObjects\PersonalId;
use PHPUnit\Framework\TestCase;

class ObjetosValorTest extends TestCase
{
    // ============ PRUEBAS EMAIL VALUE OBJECT ============

    // ===== CASO E1: Crear email válido =====
    // Especificación: Crear Email con dirección válida
    // Valores de Prueba: "user@example.com"
    // Resultado Esperado: Email creado correctamente
    public function test_valida_email(): void
    {
        // Arrange
        $emailAddress = 'user@example.com';

        // Act
        $email = new Email($emailAddress);

        // Assert
        $this->assertEquals($emailAddress, $email->getValue());
    }

    // ===== CASO E2: Email inválido - sin @ =====
    // Especificación: Crear Email sin símbolo @
    // Valores de Prueba: "userexample.com"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_email_invalido(): void
    {
        // Arrange
        $invalidEmail = 'invalid-email';

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido');

        // Act
        new Email($invalidEmail);
    }

    // ===== CASO E3: Email vacío =====
    // Especificación: Crear Email con cadena vacía
    // Valores de Prueba: ""
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_email_vacio(): void
    {
        // Arrange
        $emptyEmail = '';

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new Email($emptyEmail);
    }

    // ===== CASO E4: Obtener valor de email =====
    // Especificación: Obtener el valor string del Email
    // Valores de Prueba: Email("test@example.com")
    // Resultado Esperado: Retorna "test@example.com"
    public function test_obtiene_valor_del_email(): void
    {
        // Arrange
        $emailAddress = 'test@example.com';
        $email = new Email($emailAddress);

        // Act
        $value = $email->getValue();

        // Assert
        $this->assertEquals($emailAddress, $value);
    }

    // ===== CASO E5: Comparar emails iguales =====
    // Especificación: Verificar que dos emails iguales son equivalentes
    // Valores de Prueba: Email1("test@example.com"), Email2("test@example.com")
    // Resultado Esperado: Retorna true
    public function test_compara_emails_iguales(): void
    {
        // Arrange
        $emailAddress = 'test@example.com';
        $email1 = new Email($emailAddress);
        $email2 = new Email($emailAddress);

        // Act
        $isEqual = $email1->equals($email2);

        // Assert
        $this->assertTrue($isEqual);
    }

    // ===== CASO E6: Comparar emails diferentes =====
    // Especificación: Verificar que dos emails diferentes no son equivalentes
    // Valores de Prueba: Email1("test1@example.com"), Email2("test2@example.com")
    // Resultado Esperado: Retorna false
    public function test_compara_emails_diferentes(): void
    {
        // Arrange
        $email1 = new Email('test1@example.com');
        $email2 = new Email('test2@example.com');

        // Act
        $isEqual = $email1->equals($email2);

        // Assert
        $this->assertFalse($isEqual);
    }

    // ===== CASO EXTRA E7: Email toString =====
    // Especificación: Convertir Email a string
    // Valores de Prueba: Email("admin@farmacia.com")
    // Resultado Esperado: Retorna "admin@farmacia.com"
    public function test_convierte_email_a_cadena(): void
    {
        // Arrange
        $emailAddress = 'admin@farmacia.com';
        $email = new Email($emailAddress);

        // Act
        $stringRepresentation = (string)$email;

        // Assert
        $this->assertEquals($emailAddress, $stringRepresentation);
    }

    // ============ PRUEBAS PHONE NUMBER VALUE OBJECT ============

    // ===== CASO PH1: Crear teléfono válido =====
    // Especificación: Crear PhoneNumber con número válido
    // Valores de Prueba: "1234567890"
    // Resultado Esperado: PhoneNumber creado correctamente
    public function test_valida_telefono(): void
    {
        // Arrange
        $phoneNumber = '1234567890';

        // Act
        $phone = new PhoneNumber($phoneNumber);

        // Assert
        $this->assertEquals($phoneNumber, $phone->getValue());
    }

    // ===== CASO PH2: Teléfono muy corto =====
    // Especificación: Crear PhoneNumber con menos de 10 dígitos
    // Valores de Prueba: "123"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_telefono_invalido(): void
    {
        // Arrange
        $shortPhone = '123';

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new PhoneNumber($shortPhone);
    }

    // ===== CASO PH3: Teléfono con caracteres inválidos =====
    // Especificación: Crear PhoneNumber con caracteres no numéricos
    // Valores de Prueba: "12345abc90"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_telefono_no_numerico(): void
    {
        // Arrange
        $invalidPhone = '12345abc90';

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new PhoneNumber($invalidPhone);
    }

    // ===== CASO PH4: Obtener valor de teléfono =====
    // Especificación: Obtener el valor string del PhoneNumber
    // Valores de Prueba: PhoneNumber("9876543210")
    // Resultado Esperado: Retorna "9876543210"
    public function test_obtiene_valor_del_telefono(): void
    {
        // Arrange
        $phoneNumber = '9876543210';
        $phone = new PhoneNumber($phoneNumber);

        // Act
        $value = $phone->getValue();

        // Assert
        $this->assertEquals($phoneNumber, $value);
    }

    // ===== CASO PH5: Comparar teléfonos iguales =====
    // Especificación: Verificar que dos teléfonos iguales son equivalentes
    // Valores de Prueba: PH1("1234567890"), PH2("1234567890")
    // Resultado Esperado: Retorna true
    public function test_compara_telefonos_iguales(): void
    {
        // Arrange
        $phoneNumber = '1234567890';
        $phone1 = new PhoneNumber($phoneNumber);
        $phone2 = new PhoneNumber($phoneNumber);

        // Act
        $isEqual = $phone1->equals($phone2);

        // Assert
        $this->assertTrue($isEqual);
    }

    // ===== CASO EXTRA PH6: Comparar teléfonos diferentes =====
    // Especificación: Verificar que dos teléfonos diferentes no son equivalentes
    // Valores de Prueba: PH1("1234567890"), PH2("9876543210")
    // Resultado Esperado: Retorna false
    public function test_compara_telefonos_diferentes(): void
    {
        // Arrange
        $phone1 = new PhoneNumber('1234567890');
        $phone2 = new PhoneNumber('9876543210');

        // Act
        $isEqual = $phone1->equals($phone2);

        // Assert
        $this->assertFalse($isEqual);
    }

    // ===== CASO EXTRA PH7: Teléfono vacío =====
    // Especificación: Crear PhoneNumber con cadena vacía
    // Valores de Prueba: ""
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_telefono_vacio(): void
    {
        // Arrange
        $emptyPhone = '';

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new PhoneNumber($emptyPhone);
    }
}

