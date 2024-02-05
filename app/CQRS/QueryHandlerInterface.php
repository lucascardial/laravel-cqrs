<?php

namespace App\CQRS;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query): QueryResultInterface;
}
