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
    }
}
