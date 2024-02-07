<?php

namespace App\CQRS\CommandBus\Middlewares;

use App\CQRS\CommandBus\CommandMiddlewareInterface;
use App\CQRS\CommandInterface;
use Illuminate\Database\ConnectionInterface;
use Psr\Container\ContainerInterface;

class TransactionalCommandMiddleware implements CommandMiddlewareInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    )
    {
    }

    public function __invoke(CommandInterface $command, callable $next): void
    {
        /** @var ConnectionInterface $connection */
        $connection = $this->container->get(ConnectionInterface::class);
        try {
            $connection->beginTransaction();
            $next($command);
            $connection->commit();
        } catch (\Throwable $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
