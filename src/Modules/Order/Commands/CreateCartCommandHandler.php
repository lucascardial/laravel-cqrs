<?php

namespace Modules\Order\Commands;

use App\CQRS\CommandHandlerInterface;
use App\CQRS\CommandInterface;
use App\Models\Cart;

class CreateCartCommandHandler implements CommandHandlerInterface
{

    /**
     * @param CreateCartCommand $command
     * @return void
     */
    public function handle(CommandInterface $command): void
    {
        /** @var Cart  $cart */
        $cart = Cart::query()->create([
            'user_id' => $command->userId,
            'shipping_address' => $command->shippingAddress,
        ]);

        $cart->items()->createMany($command->products);
    }
}
