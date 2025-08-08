<?php

namespace Domain\ValueObject;

class RegistrationNumber
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = strtoupper($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
