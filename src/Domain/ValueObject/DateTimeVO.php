<?php

namespace Domain\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

class DateTimeVO
{
    private DateTimeImmutable $dateTime;

    public function __construct(string|int|DateTimeImmutable $input)
    {
        if ($input instanceof DateTimeImmutable) {
            $this->dateTime = $input;
        } elseif (is_numeric($input)) {
            $this->dateTime = (new DateTimeImmutable())->setTimestamp((int)$input);
        } elseif (is_string($input)) {
            $timestamp = strtotime($input);
            $dt = (new DateTimeImmutable())->setTimestamp((int)$timestamp);

            if (!$dt) {
                throw new InvalidArgumentException("Invalid date string: $input");
            }

            $this->dateTime = $dt;
        } else {
            throw new InvalidArgumentException("Unsupported datetime input type");
        }
    }

    public function toTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function format(string $format = 'Y-m-d H:i'): string
    {
        return $this->dateTime->format($format);
    }

    public function __toString(): string
    {
        return $this->format(); // domyślny format
    }
}
