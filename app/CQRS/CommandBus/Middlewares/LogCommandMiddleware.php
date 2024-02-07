<?php

namespace App\CQRS\CommandBus\Middlewares;

use App\CQRS\CommandBus\CommandMiddlewareInterface;
use App\CQRS\CommandInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function Ramsey\Uuid\v4;

class LogCommandMiddleware implements CommandMiddlewareInterface
{
    public function __construct(
        private readonly ContainerInterface $container,
    )
    {
    }

    public function __invoke(CommandInterface $command, callable $next): void
    {
        $log = [
            'id' => v4(),
            'user_id' => auth()->id(),
            'command' => get_class($command),
            'data' => $command
        ];

        /** @var LoggerInterface $logger */
        $logger = $this->container->get(LoggerInterface::class);

        $logger->info('Command received', $log);

        $next($command);
    }
}
