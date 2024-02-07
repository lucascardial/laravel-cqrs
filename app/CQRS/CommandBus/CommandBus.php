<?php

namespace App\CQRS\CommandBus;

use App\CQRS\CommandBus\Middlewares\ExecutorCommandMiddleware;
use App\CQRS\CommandBus\Middlewares\LogCommandMiddleware;
use App\CQRS\CommandBus\Middlewares\TransactionalCommandMiddleware;
use App\CQRS\CommandInterface;
use Psr\Container\ContainerInterface;

class CommandBus implements CommandBusInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    )
    {
    }

    public function execute(CommandInterface $command): void
    {
        $pipeline = MiddlewarePipelineFactory::create(
            new LogCommandMiddleware($this->container),
            new TransactionalCommandMiddleware($this->container),
            new ExecutorCommandMiddleware($this->container)
        );

        $pipeline($command);
    }
}
