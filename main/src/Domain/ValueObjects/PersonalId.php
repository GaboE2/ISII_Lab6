<?php

namespace Farmacia\Domain\ValueObjects;

class PersonalId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validatePersonalId($value);
        $this->value = $value;
    }

    private function validatePersonalId(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("ID personal no puede estar vacío");
        }
        if (strlen($value) < 6) {
            throw new \InvalidArgumentException("ID personal debe tener al menos 6 caracteres");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(PersonalId $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
