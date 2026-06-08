<?php

namespace Farmacia\Domain\Entities;

use Farmacia\Domain\ValueObjects\Email;
use Farmacia\Domain\ValueObjects\PhoneNumber;

class Patient
{
    private int $id;
    private string $fullName;
    private \DateTime $birthDate;
    private string $gender;
    private PhoneNumber $phoneNumber;
    private Email $email;
    private \DateTime $createdAt;

    public function __construct(
        int $id,
        string $fullName,
        \DateTime $birthDate,
        string $gender,
        PhoneNumber $phoneNumber,
        Email $email
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatePhoneNumber(PhoneNumber $newPhoneNumber): void
    {
        $this->phoneNumber = $newPhoneNumber;
    }

    public function updateEmail(Email $newEmail): void
    {
        $this->email = $newEmail;
    }
}
