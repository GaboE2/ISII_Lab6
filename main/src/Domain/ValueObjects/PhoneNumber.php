<?php

namespace Farmacia\Domain\ValueObjects;

class PhoneNumber
{
    private string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^\+?[0-9]{7,15}$/', $value)) {
            throw new \InvalidArgumentException("Número de teléfono inválido: {$value}");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(PhoneNumber $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
