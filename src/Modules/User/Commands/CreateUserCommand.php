<?php

namespace Modules\User\Commands;

use App\CQRS\CommandInterface;
use Core\ValueObjects\Email;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public Email $email,
        public string $password,
    )
    {
    }
}
