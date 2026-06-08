<?php

namespace Farmacia\Tests\Aplicacion;

use Farmacia\Application\DTOs\CreatePatientRequestDTO;
use Farmacia\Application\UseCases\CreatePatientUseCase;
use Farmacia\Application\DTOs\PatientDTO;
use Farmacia\Domain\Entities\Patient;
use Farmacia\Domain\Repositories\PatientRepositoryInterface;
use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;
use PHPUnit\Framework\TestCase;

class CrearPacienteCasoUsoTest extends TestCase
{
    private CreatePatientRequestDTO $validRequest;

    protected function setUp(): void
    {
        $this->validRequest = new CreatePatientRequestDTO(
            'Ana García',
            '1990-05-15',
            'F',
            '9876543210',
            'ana@example.com'
        );
    }

    protected function tearDown(): void
    {
        unset($this->validRequest);
    }

    // Clase/Método: CreatePatientUseCase::execute
    // Caso Prueba: Crear paciente válido y guardar en repositorio
    // Valores de Prueba: fullName='Ana García', birthDate='1990-05-15', gender='F', phoneNumber='9876543210', email='ana@example.com'
    // Resultado Esperado: Retorna PatientDTO con los datos, y save() se invoca una vez
    public function test_ejecuta_crea_paciente_y_lo_guarda(): void
    {
        $request = $this->validRequest;
        $patientRepositoryMock = $this->createMock(PatientRepositoryInterface::class);

        $patientRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(fn (Patient $patient): bool =>
                $patient->getFullName() === $request->fullName
                && $patient->getBirthDate()->format('Y-m-d') === $request->birthDate
                && $patient->getGender() === $request->gender
                && $patient->getPhoneNumber()->getValue() === $request->phoneNumber
                && $patient->getEmail()->getValue() === $request->email
            ));

        $createPatientUseCase = new CreatePatientUseCase($patientRepositoryMock);
        $patientDto = $createPatientUseCase->execute($request);

        $this->assertInstanceOf(PatientDTO::class, $patientDto);
        $this->assertEquals($request->fullName, $patientDto->fullName);
        $this->assertEquals($request->birthDate, $patientDto->birthDate);
        $this->assertEquals($request->gender, $patientDto->gender);
        $this->assertEquals($request->phoneNumber, $patientDto->phoneNumber);
        $this->assertEquals($request->email, $patientDto->email);
        $this->assertIsInt($patientDto->id);
    }

    // Clase/Método: CreatePatientUseCase::execute
    // Caso Prueba: Fecha de nacimiento inválida
    // Valores de Prueba: birthDate='15-05-1990' (formato inválido)
    // Resultado Esperado: Lanza InvalidArgumentException y no guarda en repositorio
    public function test_falla_si_fecha_nacimiento_es_invalida(): void
    {
        $request = new CreatePatientRequestDTO(
            'Ana García',
            '15-05-1990',
            'F',
            '9876543210',
            'ana@example.com'
        );

        $patientRepositoryMock = $this->createMock(PatientRepositoryInterface::class);
        $patientRepositoryMock
            ->expects($this->never())
            ->method('save');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fecha de nacimiento inválida');

        $createPatientUseCase = new CreatePatientUseCase($patientRepositoryMock);
        $createPatientUseCase->execute($request);
    }

    // Clase/Método: CreatePatientUseCase::execute (Integración con repositorio)
    // Caso Prueba: Guardar paciente usando un repositorio en memoria
    // Valores de Prueba: fullName='Carlos Pérez', birthDate='1988-02-25', gender='M', phoneNumber='3216549870', email='carlos@example.com'
    // Resultado Esperado: El paciente se guarda en el repositorio de prueba y se puede recuperar
    public function test_integracion_guarda_paciente_en_repositorio_memoria(): void
    {
        $inMemoryRepository = new class implements PatientRepositoryInterface {
            private array $storage = [];

            public function save(Patient $patient): void
            {
                $this->storage[$patient->getId()] = $patient;
            }

            public function findById(int $id): ?Patient
            {
                return $this->storage[$id] ?? null;
            }

            public function findAll(): array
            {
                return array_values($this->storage);
            }

            public function delete(int $id): void
            {
                unset($this->storage[$id]);
            }

            public function getSavedPatientIds(): array
            {
                return array_keys($this->storage);
            }
        };

        $useCase = new CreatePatientUseCase($inMemoryRepository);

        $request = new CreatePatientRequestDTO(
            'Carlos Pérez',
            '1988-02-25',
            'M',
            '3216549870',
            'carlos@example.com'
        );

        $patientDto = $useCase->execute($request);

        $this->assertInstanceOf(PatientDTO::class, $patientDto);
        $this->assertNotEmpty($patientDto->id);
        $this->assertSame($request->fullName, $patientDto->fullName);

        $savedPatient = $inMemoryRepository->findById($patientDto->id);
        $this->assertInstanceOf(Patient::class, $savedPatient);
        $this->assertEquals($patientDto->fullName, $savedPatient->getFullName());
        $this->assertEquals($patientDto->birthDate, $savedPatient->getBirthDate()->format('Y-m-d'));
        $this->assertEquals($patientDto->email, $savedPatient->getEmail()->getValue());
        $this->assertEquals($patientDto->phoneNumber, $savedPatient->getPhoneNumber()->getValue());
    }
}

