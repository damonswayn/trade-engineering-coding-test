<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Exception;
use Catch\TradeEngineering\Order\Model\Cart;
use Exception;
use Throwable;

final class CartCannotCheckoutException extends Exception
{
    public function __construct(private readonly Cart $cart, ?Throwable $previous = null)
    {
        parent::__construct('Cart is not in a valid state for checkout', 0, $previous);
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}