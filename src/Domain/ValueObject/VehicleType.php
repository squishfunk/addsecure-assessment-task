<?php

namespace Domain\ValueObject;

class VehicleType
{
    public const TYPES = ['passenger', 'bus', 'truck'];

    private string $value;

    public function __construct(string $value)
    {
        $value = strtolower(trim($value));
        if (!in_array($value, self::TYPES)) {
            throw new \InvalidArgumentException("Invalid vehicle type: $value");
        }

        $this->value = $value;
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