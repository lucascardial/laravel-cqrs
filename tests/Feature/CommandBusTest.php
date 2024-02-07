<?php

namespace Tests\Feature;

use App\CQRS\CommandBus\CommandBusInterface;
use App\CQRS\CommandBus\CommandMiddlewareInterface;
use App\CQRS\CommandBus\MiddlewarePipelineFactory;
use App\CQRS\CommandInterface;
use Tests\TestCase;

class CommandBusTest extends TestCase
{
    public function test_pipeline_middlewares_expect_rigth_execution_order()
    {
        $command = $this->dummyCommand();

        $middleware_1 = $this->commandMiddleware();
        $middleware_2 = $this->commandMiddleware();
        $middleware_3 = $this->commandMiddleware();

        $commandBus = new class ($middleware_1, $middleware_2, $middleware_3) implements CommandBusInterface {
            public function __construct(
                private CommandMiddlewareInterface $middleware_1,
                private CommandMiddlewareInterface $middleware_2,
                private CommandMiddlewareInterface $middleware_3
            )
            {
            }

            public function execute(CommandInterface $command): void
            {
                $pipeline = MiddlewarePipelineFactory::create(
                    $this->middleware_1,
                    $this->middleware_2,
                    $this->middleware_3
                );
                $pipeline($command);
            }
        };

        $commandBus->execute($command);

        $this->assertGreaterThan($middleware_1->calledAt(), $middleware_2->calledAt() );
        $this->assertGreaterThan($middleware_2->calledAt(), $middleware_3->calledAt() );
    }
    private function dummyCommand(): CommandInterface
    {
        return new class implements CommandInterface {
            public string $name = "Dummy Command";
        };
    }

    private function commandMiddleware(): CommandMiddlewareInterface
    {
        return new class implements CommandMiddlewareInterface {
            private int $calledAt;
            public function __invoke(CommandInterface $command, callable $next): void
            {
                sleep(1);
                $command->name = "Modified Command";
                $this->calledAt = time();
                $next($command);
            }

            public function calledAt(): int
            {
                return $this->calledAt;
            }
        };
    }
}
