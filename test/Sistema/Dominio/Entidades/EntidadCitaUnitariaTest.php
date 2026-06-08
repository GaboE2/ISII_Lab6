<?php

namespace Farmacia\Tests\Sistema\Dominio\Entidades;

use Farmacia\Domain\Entities\Appointment;
use PHPUnit\Framework\TestCase;

class EntidadCitaUnitariaTest extends TestCase
{
    private Appointment $appointment;
    private int $validId = 1;
    private int $validPatientId = 10;
    private int $validDoctorId = 20;
    private \DateTime $validFutureDate;
    private string $validReason = 'Consulta general';
    private int $validDuration = 30;

    protected function setUp(): void
    {
        // Inicializar una fecha futura válida (mañana a las 10:00)
        $this->validFutureDate = new \DateTime('tomorrow 10:00:00');
        
        // Crear una cita válida para ser usada en los tests
        $this->appointment = new Appointment(
            id: $this->validId,
            patientId: $this->validPatientId,
            doctorId: $this->validDoctorId,
            appointmentDate: $this->validFutureDate,
            reason: $this->validReason,
            durationMinutes: $this->validDuration,
            status: 'pending'
        );
    }

    protected function tearDown(): void
    {
        // Liberar objetos después de cada prueba
        unset($this->appointment, $this->validFutureDate);
    }

    // ===== CASO AP1: Crear cita válida =====
    // Especificación: Crear una cita con todos los datos correctos
    // Valores de Prueba: id=1, patientId=10, doctorId=20, appointmentDate=mañana 10:00, reason='Consulta general', durationMinutes=30, status='pending'
    // Resultado Esperado: Appointment creada correctamente con todos los atributos
    public function test_crea_cita_con_datos_validos(): void
    {
        $this->assertInstanceOf(Appointment::class, $this->appointment);
        $this->assertEquals($this->validId, $this->appointment->getId());
        $this->assertEquals($this->validPatientId, $this->appointment->getPatientId());
        $this->assertEquals($this->validDoctorId, $this->appointment->getDoctorId());
        $this->assertEquals($this->validReason, $this->appointment->getReason());
        $this->assertEquals($this->validDuration, $this->appointment->getDurationMinutes());
        $this->assertEquals('pending', $this->appointment->getStatus());
    }

    // ===== CASO AP2: Crear cita con fecha en el pasado =====
    // Especificación: Intentar crear una cita con fecha anterior a hoy
    // Valores de Prueba: appointmentDate='2020-01-01'
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_al_crear_cita_con_fecha_pasada(): void
    {
        $pastDate = new \DateTime('yesterday 10:00:00');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La fecha de la cita no puede ser en el pasado');
        
        new Appointment(
            id: 2,
            patientId: 11,
            doctorId: 21,
            appointmentDate: $pastDate,
            reason: 'Consulta',
            durationMinutes: 30
        );
    }

    // ===== CASO AP3: Crear cita con duración inválida (0 o menor) =====
    // Especificación: Intentar crear una cita con duración <= 0
    // Valores de Prueba: durationMinutes=0
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_al_crear_cita_con_duracion_cero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Duración de la cita debe ser mayor a 0');
        
        new Appointment(
            id: 3,
            patientId: 12,
            doctorId: 22,
            appointmentDate: $this->validFutureDate,
            reason: 'Consulta',
            durationMinutes: 0
        );
    }

    // ===== CASO AP4: Crear cita con duración negativa =====
    // Especificación: Intentar crear una cita con duración negativa
    // Valores de Prueba: durationMinutes=-15
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_al_crear_cita_con_duracion_negativa(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Duración de la cita debe ser mayor a 0');
        
        new Appointment(
            id: 4,
            patientId: 13,
            doctorId: 23,
            appointmentDate: $this->validFutureDate,
            reason: 'Consulta',
            durationMinutes: -15
        );
    }

    // ===== CASO AP5: Cancelar una cita en estado pending =====
    // Especificación: Cambiar estado de cita pending a cancelled
    // Valores de Prueba: cita con status='pending'
    // Resultado Esperado: El estado cambia a 'cancelled'
    public function test_cancela_cita_en_estado_pendiente(): void
    {
        $this->assertEquals('pending', $this->appointment->getStatus());
        
        $this->appointment->cancel();
        
        $this->assertEquals('cancelled', $this->appointment->getStatus());
    }

    // ===== CASO AP6: Intentar cancelar una cita completada =====
    // Especificación: Intentar cancelar una cita ya completada
    // Valores de Prueba: cita con status='completed'
    // Resultado Esperado: Lanza InvalidArgumentException
    public function test_falla_al_cancelar_cita_completada(): void
    {
        $this->appointment->complete();
        $this->assertEquals('completed', $this->appointment->getStatus());
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No se puede cancelar una cita completada');
        
        $this->appointment->cancel();
    }

    // ===== CASO AP7: Completar una cita =====
    // Especificación: Cambiar estado de cita a completed
    // Valores de Prueba: cita con status='pending'
    // Resultado Esperado: El estado cambia a 'completed'
    public function test_completa_cita(): void
    {
        $this->assertEquals('pending', $this->appointment->getStatus());
        
        $this->appointment->complete();
        
        $this->assertEquals('completed', $this->appointment->getStatus());
    }

    // ===== CASO AP8: Obtener información de la cita =====
    // Especificación: Verificar que todos los getters devuelven valores correctos
    // Valores de Prueba: Appointment con datos completos
    // Resultado Esperado: Todos los getters retornan los valores asignados
    public function test_obtiene_datos_de_la_cita(): void
    {
        $this->assertEquals($this->validId, $this->appointment->getId());
        $this->assertEquals($this->validPatientId, $this->appointment->getPatientId());
        $this->assertEquals($this->validDoctorId, $this->appointment->getDoctorId());
        $this->assertEquals($this->validReason, $this->appointment->getReason());
        $this->assertEquals($this->validDuration, $this->appointment->getDurationMinutes());
        $this->assertInstanceOf(\DateTime::class, $this->appointment->getAppointmentDate());
        $this->assertInstanceOf(\DateTime::class, $this->appointment->getCreatedAt());
    }

    // ===== CASO AP9: Verificar que createdAt es la fecha actual =====
    // Especificación: Verificar que la fecha de creación es aproximadamente ahora
    // Valores de Prueba: Appointment recién creada
    // Resultado Esperado: createdAt está entre antes y después de la creación
    public function test_fecha_de_creacion_es_actual(): void
    {
        $beforeCreation = new \DateTime();
        
        $futureDate = new \DateTime('+2 days 14:00:00');
        $newAppointment = new Appointment(
            id: 5,
            patientId: 14,
            doctorId: 24,
            appointmentDate: $futureDate,
            reason: 'Revisión',
            durationMinutes: 45
        );
        
        $afterCreation = new \DateTime();
        $createdAt = $newAppointment->getCreatedAt();
        
        $this->assertGreaterThanOrEqual($beforeCreation, $createdAt);
        $this->assertLessThanOrEqual($afterCreation, $createdAt);
    }

    // ===== CASO AP10: Transiciones de estado válidas =====
    // Especificación: Verificar que pending -> cancelled y pending -> completed son válidas
    // Valores de Prueba: Appointment en estado pending
    // Resultado Esperado: Ambas transiciones funcionan desde pending
    public function test_transiciones_validas_desde_pendiente(): void
    {
        $futureDate = new \DateTime('+3 days 11:30:00');
        $apt1 = new Appointment(
            id: 6,
            patientId: 15,
            doctorId: 25,
            appointmentDate: $futureDate,
            reason: 'Chequeo',
            durationMinutes: 20
        );
        $apt2 = new Appointment(
            id: 7,
            patientId: 16,
            doctorId: 26,
            appointmentDate: $futureDate,
            reason: 'Chequeo',
            durationMinutes: 20
        );
        
        // Primera cita: pending -> cancelled
        $this->assertEquals('pending', $apt1->getStatus());
        $apt1->cancel();
        $this->assertEquals('cancelled', $apt1->getStatus());
        
        // Segunda cita: pending -> completed
        $this->assertEquals('pending', $apt2->getStatus());
        $apt2->complete();
        $this->assertEquals('completed', $apt2->getStatus());
    }
}

