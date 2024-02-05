<?php

namespace Modules\User\Queries\GetUserByEmail;

use App\CQRS\QueryInterface;
use Core\ValueObjects\Email;

class GetUserByEmailQuery implements QueryInterface
{
    public function __construct(
        public Email $email,
    )
    {
    }
}
