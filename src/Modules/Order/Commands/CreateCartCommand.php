<?php

namespace Modules\Order\Commands;

use App\CQRS\CommandInterface;

class CreateCartCommand implements CommandInterface
{
    public function __construct(
        public int $userId,
        public string $shippingAddress,
        public array $products
    )
    {
    }
}
