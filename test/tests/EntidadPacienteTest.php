<?php

use Farmacia\Domain\Entities\Patient;
use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;
use PHPUnit\Framework\TestCase;

class EntidadPacienteTest extends TestCase
{
    private Patient $patient;

    protected function setUp(): void
    {
        $this->patient = new Patient(
            id: 1,
            fullName: 'Juan Pérez',
            birthDate: new \DateTime('1990-05-15'),
            gender: 'M',
            phoneNumber: new PhoneNumber('1234567890'),
            email: new Email('juan@example.com')
        );
    }

    // ===== CASO P1: Crear paciente válido =====
    // Especificación: Crear paciente con todos los datos correctos
    // Valores de Prueba: id=1, fullName="Juan Pérez", birthDate="1990-05-15", gender="M"
    // Resultado Esperado: Patient creado correctamente con todos los atributos
    public function test_crea_paciente(): void
    {
        // Arrange
        $id = 1;
        $fullName = 'Juan Pérez';
        $birthDate = new \DateTime('1990-05-15');
        $gender = 'M';

        // Act
        // El patient ya fue creado en setUp()

        // Assert
        $this->assertEquals($id, $this->patient->getId());
        $this->assertEquals($fullName, $this->patient->getFullName());
        $this->assertEquals($gender, $this->patient->getGender());
        $this->assertInstanceOf(\DateTime::class, $this->patient->getBirthDate());
    }

    // ===== CASO P3: Obtener nombre completo =====
    // Especificación: Obtener el nombre completo del paciente
    // Valores de Prueba: Patient con fullName="Maria García"
    // Resultado Esperado: Retorna "Maria García"
    public function test_obtiene_nombre_completo_del_paciente(): void
    {
        // Arrange
        $expectedName = 'Maria García';
        $patient = new Patient(
            id: 2,
            fullName: $expectedName,
            birthDate: new \DateTime('1985-03-20'),
            gender: 'F',
            phoneNumber: new PhoneNumber('9876543210'),
            email: new Email('maria@example.com')
        );

        // Act
        $actualName = $patient->getFullName();

        // Assert
        $this->assertEquals($expectedName, $actualName);
    }

    // ===== CASO P4: Obtener email =====
    // Especificación: Obtener el email del paciente como objeto Email
    // Valores de Prueba: Patient con email="maria@example.com"
    // Resultado Esperado: Retorna Email ValueObject válido
    public function test_obtiene_email_del_paciente(): void
    {
        // Arrange
        $expectedEmail = 'maria@example.com';
        $patient = new Patient(
            id: 3,
            fullName: 'Maria García',
            birthDate: new \DateTime('1985-03-20'),
            gender: 'F',
            phoneNumber: new PhoneNumber('9876543210'),
            email: new Email($expectedEmail)
        );

        // Act
        $emailObject = $patient->getEmail();

        // Assert
        $this->assertInstanceOf(Email::class, $emailObject);
        $this->assertEquals($expectedEmail, $emailObject->getValue());
    }

    // ===== CASO P5: Actualizar teléfono válido =====
    // Especificación: Actualizar el teléfono a un valor válido
    // Valores de Prueba: newPhone="9876543210"
    // Resultado Esperado: phoneNumber se actualiza correctamente
    public function test_actualiza_telefono_del_paciente(): void
    {
        // Arrange
        $newPhoneValue = '9876543210';
        $newPhone = new PhoneNumber($newPhoneValue);

        // Act
        $this->patient->updatePhoneNumber($newPhone);

        // Assert
        $this->assertEquals($newPhoneValue, $this->patient->getPhoneNumber()->getValue());
    }

    // ===== CASO P6: Actualizar teléfono inválido =====
    // Especificación: Intentar actualizar a teléfono inválido lanza excepción
    // Valores de Prueba: newPhone="123" (muy corto)
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_al_actualizar_telefono_invalido(): void
    {
        // Arrange
        $invalidPhone = '123'; // Teléfono muy corto

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new PhoneNumber($invalidPhone);
    }

    // ===== CASO P7: Actualizar email válido =====
    // Especificación: Actualizar email a un valor válido
    // Valores de Prueba: newEmail="newemail@example.com"
    // Resultado Esperado: email se actualiza correctamente
    public function test_actualiza_email_del_paciente(): void
    {
        // Arrange
        $newEmailValue = 'newemail@example.com';
        $newEmail = new Email($newEmailValue);

        // Act
        $this->patient->updateEmail($newEmail);

        // Assert
        $this->assertEquals($newEmailValue, $this->patient->getEmail()->getValue());
    }

    // ===== CASO P8: Actualizar email inválido =====
    // Especificación: Intentar actualizar a email inválido lanza excepción
    // Valores de Prueba: newEmail="invalid-email" (sin @)
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_al_actualizar_email_invalido(): void
    {
        // Arrange
        $invalidEmail = 'invalid-email'; // Email sin @

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);

        // Act
        new Email($invalidEmail);
    }

    // ===== CASO P9: Obtener fecha de creación =====
    // Especificación: Obtener fecha de creación del paciente
    // Valores de Prueba: Patient recién creado
    // Resultado Esperado: Retorna DateTime con fecha actual
    public function test_fecha_creacion_del_paciente_es_actual(): void
    {
        // Arrange
        $beforeCreation = new \DateTime();

        // Act
        $patient = new Patient(
            id: 4,
            fullName: 'Carlos López',
            birthDate: new \DateTime('1992-07-10'),
            gender: 'M',
            phoneNumber: new PhoneNumber('1111111111'),
            email: new Email('carlos@example.com')
        );

        $afterCreation = new \DateTime();

        // Assert
        $createdAt = $patient->getCreatedAt();
        $this->assertInstanceOf(\DateTime::class, $createdAt);
        $this->assertGreaterThanOrEqual($beforeCreation, $createdAt);
        $this->assertLessThanOrEqual($afterCreation, $createdAt);
    }

    // ===== CASO P10: Obtener fecha de nacimiento =====
    // Especificación: Obtener la fecha de nacimiento del paciente
    // Valores de Prueba: Patient con birthDate="1990-05-15"
    // Resultado Esperado: Retorna DateTime correcto
    public function test_obtiene_fecha_nacimiento_del_paciente(): void
    {
        // Arrange
        $expectedBirthDate = new \DateTime('1990-05-15');
        $patient = new Patient(
            id: 5,
            fullName: 'Ana Martínez',
            birthDate: $expectedBirthDate,
            gender: 'F',
            phoneNumber: new PhoneNumber('5555555555'),
            email: new Email('ana@example.com')
        );

        // Act
        $actualBirthDate = $patient->getBirthDate();

        // Assert
        $this->assertEquals($expectedBirthDate->format('Y-m-d'), $actualBirthDate->format('Y-m-d'));
    }
}

