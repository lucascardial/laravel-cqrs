<?php

namespace App\CQRS\CommandBus\Middlewares;

use App\CQRS\CommandBus\CommandMiddlewareInterface;
use App\CQRS\CommandHandlerInterface;
use App\CQRS\CommandInterface;
use Psr\Container\ContainerInterface;

class ExecutorCommandMiddleware implements CommandMiddlewareInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    )
    {
    }

    public function __invoke(CommandInterface $command, callable $next): void
    {
        /** @var CommandHandlerInterface $handler */
        $handler = $this->container->get(get_class($command) . 'Handler');

        $handler->handle($command);
    }
}
