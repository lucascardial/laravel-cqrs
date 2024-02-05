<?php

namespace App\CQRS;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
