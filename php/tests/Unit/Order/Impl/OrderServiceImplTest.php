<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Tests\Unit\Order\Impl;

use Catch\TradeEngineering\Order\Impl\OrderServiceImpl;
use Catch\TradeEngineering\Order\OrderServiceInterface;
use Catch\TradeEngineering\Tests\BaseTestCase;
use Catch\TradeEngineering\Tests\Util\TestCartBuilder;

final class OrderServiceImplTest extends BaseTestCase
{
    private OrderServiceInterface $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = new OrderServiceImpl();
    }

    public function testOrderServiceCanBeCreated(): void
    {
        $this->assertInstanceOf(OrderServiceImpl::class, $this->orderService);
    }

    public function testOrderCanCheckoutWithCart(): void
    {
        $testCart = TestCartBuilder::begin()
            ->withRandomCustomer()
            ->addRandomProduct()
            ->addRandomProduct()
            ->build();

        $order = $this->orderService->checkout($testCart);
        $this->assertSuccessfulCheckout($order);
    }
}
