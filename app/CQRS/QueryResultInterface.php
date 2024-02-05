<?php

namespace App\CQRS;

interface QueryResultInterface
{
    public function getResult(): mixed;
}
