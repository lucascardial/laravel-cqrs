<?php

namespace App\CQRS\CommandBus;

use App\CQRS\CommandInterface;

final class MiddlewarePipelineFactory
{
    public static function create(CommandMiddlewareInterface ...$commandMiddlewares): callable
    {
        $nextMiddleware = function (CommandInterface $command) {};

        foreach (array_reverse($commandMiddlewares) as $commandMiddleware) {
            $nextMiddleware = function (CommandInterface $command) use ($commandMiddleware, $nextMiddleware) {
                $commandMiddleware($command, $nextMiddleware);
            };
        }

        return $nextMiddleware;
    }
}
