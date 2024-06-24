<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order;

use Catch\TradeEngineering\Order\Model\Cart;
use Catch\TradeEngineering\Order\Model\ConfirmedOrder;

interface OrderServiceInterface
{
    public function checkout(Cart $cart): ConfirmedOrder;
}