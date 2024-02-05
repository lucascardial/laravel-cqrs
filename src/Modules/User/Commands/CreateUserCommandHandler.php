<?php

namespace Modules\User\Commands;

use App\CQRS\CommandHandlerInterface;
use App\CQRS\CommandInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserCommandHandler implements CommandHandlerInterface
{

    /**
     * @param CreateUserCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        User::query()->create([
            'name' => $command->name,
            'email' => $command->email,
            'password' => Hash::make($command->password),
        ]);
    }
}
