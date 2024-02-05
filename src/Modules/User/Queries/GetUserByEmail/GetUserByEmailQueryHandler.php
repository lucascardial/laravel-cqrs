<?php

namespace Modules\User\Queries\GetUserByEmail;

use App\CQRS\QueryHandlerInterface;
use App\CQRS\QueryInterface;
use App\CQRS\QueryResultInterface;
use App\Models\User;
use Modules\User\Dtos\UserDto;

class GetUserByEmailQueryHandler implements QueryHandlerInterface
{

    public function handle(QueryInterface $query): QueryResultInterface | null
    {
        $user = User::query()->where('email', $query->email)->first();

        if (!$user) {
            return null;
        }

        $userDto = new UserDto(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );

        return new GetUserByEmailQueryResult($userDto);
    }
}
