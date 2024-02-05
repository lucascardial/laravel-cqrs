<?php

namespace Tests\Feature;

use Core\ValueObjects\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Commands\CreateUserCommand;
use Modules\User\Commands\CreateUserCommandHandler;
use Modules\User\Queries\GetUserByEmail\GetUserByEmailQuery;
use Modules\User\Queries\GetUserByEmail\GetUserByEmailQueryHandler;
use Tests\TestCase;

class ModuleUserTest extends TestCase
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

    public function test_get_user_by_email_expect_user_returned()
    {
        $email = Email::from(fake()->email);
        $name = fake()->name;
        $password = fake()->password;

        $command = new CreateUserCommand(
            name: $name,
            email: $email,
            password: $password
        );

        $handler = new CreateUserCommandHandler();

        $handler->handle($command);

        $query = new GetUserByEmailQuery($email);
        $handler = new GetUserByEmailQueryHandler();

        $result = $handler->handle($query);

        $this->assertEquals($name, $result->getResult()->name);
        $this->assertEquals($email, $result->getResult()->email);
    }

    public function test_get_user_by_email_expect_null()
    {
        $email = Email::from(fake()->email);
        $query = new GetUserByEmailQuery($email);
        $handler = new GetUserByEmailQueryHandler();

        $result = $handler->handle($query);

        $this->assertNull($result);
    }
}
