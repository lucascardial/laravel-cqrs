<?php

namespace Modules\User\Queries\GetUserByEmail;

use App\CQRS\QueryResultInterface;
use Modules\User\Dtos\UserDto;

class GetUserByEmailQueryResult implements QueryResultInterface
{
    public function __construct(
        private readonly ?UserDto $user
    )
    {
    }

    public function getResult(): UserDto | null
    {
        return $this->user;
    }
}
