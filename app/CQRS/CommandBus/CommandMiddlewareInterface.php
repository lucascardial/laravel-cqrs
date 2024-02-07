<?php

namespace App\CQRS\CommandBus;

use App\CQRS\CommandInterface;

interface CommandMiddlewareInterface
{
    public function __invoke(CommandInterface $command, callable $next): void;
}
