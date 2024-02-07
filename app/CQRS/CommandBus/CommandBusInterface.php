<?php

namespace App\CQRS\CommandBus;

use App\CQRS\CommandInterface;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): void;
}
