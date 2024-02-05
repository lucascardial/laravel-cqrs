<?php

namespace Core\ValueObjects;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string | null $uuid = null
    )
    {
        if ($uuid === null) {
            $this->uuid = RamseyUuid::uuid4()->toString();
        }

        if (!RamseyUuid::isValid($this->uuid)) {
            throw new \InvalidArgumentException('Invalid UUID');
        }
    }

    public static function from(string $uuid): Uuid
    {
        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
