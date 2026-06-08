<?php

namespace Farmacia\Application\DTOs;

class CreatePatientRequestDTO
{
    public string $fullName;
    public string $birthDate;
    public string $gender;
    public string $phoneNumber;
    public string $email;

    public function __construct(
        string $fullName,
        string $birthDate,
        string $gender,
        string $phoneNumber,
        string $email
    ) {
        $this->fullName = $fullName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }
}
