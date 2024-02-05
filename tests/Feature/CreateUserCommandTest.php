<?php

namespace Tests\Feature;

use Core\ValueObjects\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Commands\CreateUserCommand;
use Modules\User\Commands\CreateUserCommandHandler;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_expect_user_created()
    {
        $command = new CreateUserCommand(
            name: fake()->name,
            email: Email::from(fake()->email),
            password: fake()->password
        );

        $handler = new CreateUserCommandHandler();

        $handler->handle($command);

        $this->assertDatabaseHas('users', [
            'name' => $command->name,
            'email' => $command->email,
        ]);
    }
}
