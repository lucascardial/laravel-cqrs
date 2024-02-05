<?php

namespace Modules\User\Dtos;

class UserDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    )
    {
    }
}
