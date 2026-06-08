<?php

use Farmacia\Domain\Entities\Appointment;
use PHPUnit\Framework\TestCase;

class EntidadCitaTest extends TestCase
{
    private Appointment $appointment;
    private \DateTime $futureDate;

    protected function setUp(): void
    {
        $this->futureDate = new \DateTime('2030-05-20 14:30');
        $this->appointment = new Appointment(
            id: 1,
            patientId: 1,
            doctorId: 1,
            appointmentDate: $this->futureDate,
            reason: 'Chequeo general',
            durationMinutes: 30,
            status: 'pending'
        );
    }

    // ===== CASO A1: Crear cita válida futura =====
    // Especificación: Crear cita con todos los datos válidos
    // Valores de Prueba: id=1, patientId=1, doctorId=1, appointmentDate="2030-05-20 14:30", reason="Chequeo", duration=30
    // Resultado Esperado: Appointment creado correctamente
    public function test_crea_cita(): void
    {
        // Arrange - Se crea en setUp()

        // Act
        $date = $this->futureDate;

        // Assert
        $this->assertEquals(1, $this->appointment->getId());
        $this->assertEquals(1, $this->appointment->getPatientId());
        $this->assertEquals(1, $this->appointment->getDoctorId());
        $this->assertEquals('Chequeo general', $this->appointment->getReason());
        $this->assertEquals('pending', $this->appointment->getStatus());
        $this->assertEquals(30, $this->appointment->getDurationMinutes());
    }

    // ===== CASO A2: Crear cita con fecha pasada =====
    // Especificación: Intentar crear cita con fecha pasada
    // Valores de Prueba: appointmentDate="2020-05-15 14:30"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_fecha_pasada(): void
    {
        // Arrange
        $pastDate = new \DateTime('2020-05-15 14:30');

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("La fecha de la cita no puede ser en el pasado");

        // Act
        new Appointment(
            id: 2,
            patientId: 1,
            doctorId: 1,
            appointmentDate: $pastDate,
            reason: 'Chequeo general',
            durationMinutes: 30
        );
    }

    // ===== CASO A3: Crear cita con duración negativa =====
    // Especificación: Intentar crear cita con duración negativa
    // Valores de Prueba: durationMinutes=-30
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_duracion_invalida(): void
    {
        // Arrange
        $negativeDuration = -30;

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Duración de la cita debe ser mayor a 0");

        // Act
        new Appointment(
            id: 3,
            patientId: 1,
            doctorId: 1,
            appointmentDate: $this->futureDate,
            reason: 'Chequeo general',
            durationMinutes: $negativeDuration
        );
    }

    // ===== CASO A4: Crear cita con duración cero =====
    // Especificación: Intentar crear cita con duración cero
    // Valores de Prueba: durationMinutes=0
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_con_duracion_cero(): void
    {
        // Arrange
        $zeroDuration = 0;

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Duración de la cita debe ser mayor a 0");

        // Act
        new Appointment(
            id: 4,
            patientId: 1,
            doctorId: 1,
            appointmentDate: $this->futureDate,
            reason: 'Chequeo general',
            durationMinutes: $zeroDuration
        );
    }

    // ===== CASO A5: Estado inicial de cita =====
    // Especificación: Verificar que una cita recién creada tiene status "pending"
    // Valores de Prueba: Appointment recién creada
    // Resultado Esperado: Status es "pending"
    public function test_estado_inicial_es_pendiente(): void
    {
        // Arrange - Se crea en setUp()

        // Act
        $status = $this->appointment->getStatus();

        // Assert
        $this->assertEquals('pending', $status);
    }

    // ===== CASO A6: Cancelar cita válida =====
    // Especificación: Cancelar una cita con status "pending"
    // Valores de Prueba: Appointment con status="pending"
    // Resultado Esperado: Status cambia a "cancelled"
    public function test_cita_puede_cancelarse(): void
    {
        // Arrange - Se crea en setUp() con status pending

        // Act
        $this->appointment->cancel();

        // Assert
        $this->assertEquals('cancelled', $this->appointment->getStatus());
    }

    // ===== CASO A7: Cancelar cita completada =====
    // Especificación: Intentar cancelar una cita que ya está completada
    // Valores de Prueba: Appointment con status="completed"
    // Resultado Esperado: Se lanza InvalidArgumentException
    public function test_falla_al_cancelar_cita_completada(): void
    {
        // Arrange
        $this->appointment->complete();
        $this->assertEquals('completed', $this->appointment->getStatus());

        // Assert - Esperamos excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No se puede cancelar una cita completada");

        // Act
        $this->appointment->cancel();
    }

    // ===== CASO A8: Completar cita =====
    // Especificación: Cambiar status de cita a "completed"
    // Valores de Prueba: Appointment con status="pending"
    // Resultado Esperado: Status cambia a "completed"
    public function test_cita_puede_completarse(): void
    {
        // Arrange - Se crea en setUp() con status pending

        // Act
        $this->appointment->complete();

        // Assert
        $this->assertEquals('completed', $this->appointment->getStatus());
    }

    // ===== CASO A9: Obtener fecha de cita =====
    // Especificación: Obtener la fecha de la cita
    // Valores de Prueba: Appointment con appointmentDate="2030-05-20 14:30"
    // Resultado Esperado: Retorna DateTime correcto
    public function test_obtiene_fecha_de_cita(): void
    {
        // Arrange
        $expectedDate = new \DateTime('2030-05-20 14:30');

        // Act
        $actualDate = $this->appointment->getAppointmentDate();

        // Assert
        $this->assertEquals($expectedDate->format('Y-m-d H:i'), $actualDate->format('Y-m-d H:i'));
    }

    // ===== CASO A10: Obtener motivo de cita =====
    // Especificación: Obtener el motivo de la cita
    // Valores de Prueba: Appointment con reason="Chequeo general"
    // Resultado Esperado: Retorna "Chequeo general"
    public function test_obtiene_motivo(): void
    {
        // Arrange
        $expectedReason = 'Chequeo general';

        // Act
        $actualReason = $this->appointment->getReason();

        // Assert
        $this->assertEquals($expectedReason, $actualReason);
    }

    // ===== CASO A11: Obtener duración =====
    // Especificación: Obtener la duración de la cita en minutos
    // Valores de Prueba: Appointment con duration=45
    // Resultado Esperado: Retorna 45
    public function test_obtiene_duracion_en_minutos(): void
    {
        // Arrange
        $futureDate = new \DateTime('2026-06-15 10:00');
        $appointment = new Appointment(
            id: 5,
            patientId: 2,
            doctorId: 2,
            appointmentDate: $futureDate,
            reason: 'Consulta especializada',
            durationMinutes: 45
        );

        // Act
        $duration = $appointment->getDurationMinutes();

        // Assert
        $this->assertEquals(45, $duration);
    }
}

