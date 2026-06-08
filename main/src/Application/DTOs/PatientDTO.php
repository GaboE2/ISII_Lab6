<?php

namespace Farmacia\Application\DTOs;

class PatientDTO
{
    public int $id;
    public string $fullName;
    public string $birthDate;
    public string $gender;
    public string $phoneNumber;
    public string $email;

    public function __construct(
        int $id,
        string $fullName,
        string $birthDate,
        string $gender,
        string $phoneNumber,
        string $email
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'birthDate' => $this->birthDate,
            'gender' => $this->gender,
            'phoneNumber' => $this->phoneNumber,
            'email' => $this->email,
        ];
    }
}
