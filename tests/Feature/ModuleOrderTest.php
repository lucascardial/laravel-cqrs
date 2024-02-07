<?php

namespace Tests\Feature;

use App\CQRS\CommandBus\CommandBusInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Order\Commands\CreateCartCommand;
use Tests\TestCase;

class ModuleOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_by_command_bus_expect_order_created()
    {
        $loggerStub = $this->createStub(\Psr\Log\LoggerInterface::class);

        // Garante que o método info será chamado uma vez
        $loggerStub->expects($this->once())
            ->method('info')
            ->with('Command received');

        // Troca a instância do logger padrão pela instância do stub
        $this->app->instance(\Psr\Log\LoggerInterface::class, $loggerStub);

        $items = [
            [
                'product_name' => 'Product 1',
                'quantity' => 1,
                'price' => 100
            ],
            [
                'product_name' => 'Product 2',
                'quantity' => 1,
                'price' => 50
            ]
        ];

        $command = new CreateCartCommand(
            userId: 1,
            shippingAddress: 'Address 1',
            products: $items
        );

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->app->make(CommandBusInterface::class);

        $commandBus->execute($command);

        $this->assertDatabaseHas('carts', [
            'user_id' => $command->userId,
            'shipping_address' => $command->shippingAddress,
        ]);

        $this->assertDatabaseCount('cart_items', 2);
    }

    public function test_create_order_by_command_bus_expect_rollback()
    {
        $items = [
            [
                'product_name' => 'Product 1',
                'quantity' => null,
                'price' => 100
            ],
            [
                'product_name' => 'Product 2',
                'quantity' => 1,
                'price' => 50
            ]
        ];

        $command = new CreateCartCommand(
            userId: 1,
            shippingAddress: 'Address 1',
            products: $items
        );

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->app->make(CommandBusInterface::class);

        try {
            $commandBus->execute($command);
        } catch (\Exception $e) {
            $this->assertDatabaseCount('carts', 0);
            $this->assertDatabaseCount('cart_items', 0);
        }
    }
}
