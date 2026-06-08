<?php

namespace Farmacia\Application\UseCases;

use Farmacia\Application\DTOs\CreatePatientRequestDTO;
use Farmacia\Application\DTOs\PatientDTO;
use Farmacia\Domain\Entities\Patient;
use Farmacia\Domain\Repositories\PatientRepositoryInterface;
use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;

class CreatePatientUseCase
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * Ejecutar el caso de uso de crear un paciente
     */
    public function execute(CreatePatientRequestDTO $request): PatientDTO
    {
        $phoneNumber = new PhoneNumber($request->phoneNumber);
        $email = new Email($request->email);

        $birthDate = \DateTime::createFromFormat('Y-m-d', $request->birthDate);
        if (!$birthDate) {
            throw new \InvalidArgumentException("Fecha de nacimiento inválida");
        }

        $patient = new Patient(
            id: $this->generatePatientId(),
            fullName: $request->fullName,
            birthDate: $birthDate,
            gender: $request->gender,
            phoneNumber: $phoneNumber,
            email: $email
        );

        $this->patientRepository->save($patient);

        return new PatientDTO(
            id: $patient->getId(),
            fullName: $patient->getFullName(),
            birthDate: $patient->getBirthDate()->format('Y-m-d'),
            gender: $patient->getGender(),
            phoneNumber: $patient->getPhoneNumber()->getValue(),
            email: $patient->getEmail()->getValue()
        );
    }

    private function generatePatientId(): int
    {
        return (int)(microtime(true) * 10000);
    }
}
