<?php

namespace Farmacia\Infrastructure\Persistence;

use Farmacia\Domain\Entities\Patient;
use Farmacia\Domain\Repositories\PatientRepositoryInterface;
use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;
use Farmacia\Infrastructure\Database\Connection;

class PatientRepository implements PatientRepositoryInterface
{
    private \mysqli $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    public function save(Patient $patient): void
    {
        $id = $patient->getId();
        $fullName = $patient->getFullName();
        $birthDate = $patient->getBirthDate()->format('Y-m-d');
        $gender = $patient->getGender();
        $phoneNumber = $patient->getPhoneNumber()->getValue();
        $email = $patient->getEmail()->getValue();

        $stmt = $this->connection->prepare(
            "INSERT INTO pacientes (id, nombre_completo, fecha_nacimiento, sexo, telefono, email) 
             VALUES (?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE nombre_completo=?, fecha_nacimiento=?, sexo=?, telefono=?, email=?"
        );

        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param(
            "isssssssss",
            $id,
            $fullName,
            $birthDate,
            $gender,
            $phoneNumber,
            $email,
            $fullName,
            $birthDate,
            $gender,
            $phoneNumber,
            $email
        );

        if (!$stmt->execute()) {
            throw new \Exception("Error al guardar paciente: " . $stmt->error);
        }

        $stmt->close();
    }

    public function findById(int $id): ?Patient
    {
        $stmt = $this->connection->prepare("SELECT * FROM pacientes WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return null;
        }

        $row = $result->fetch_assoc();
        $stmt->close();

        return new Patient(
            id: (int)$row['id'],
            fullName: $row['nombre_completo'],
            birthDate: new \DateTime($row['fecha_nacimiento']),
            gender: $row['sexo'],
            phoneNumber: new PhoneNumber($row['telefono']),
            email: new Email($row['email'])
        );
    }

    public function findAll(): array
    {
        $result = $this->connection->query("SELECT * FROM pacientes");
        if (!$result) {
            throw new \Exception("Error en query: " . $this->connection->error);
        }

        $patients = [];
        while ($row = $result->fetch_assoc()) {
            $patients[] = new Patient(
                id: (int)$row['id'],
                fullName: $row['nombre_completo'],
                birthDate: new \DateTime($row['fecha_nacimiento']),
                gender: $row['sexo'],
                phoneNumber: new PhoneNumber($row['telefono']),
                email: new Email($row['email'])
            );
        }

        return $patients;
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM pacientes WHERE id = ?");
        if (!$stmt) {
            throw new \Exception("Error en preparación: " . $this->connection->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new \Exception("Error al eliminar: " . $stmt->error);
        }

        $stmt->close();
    }
}
