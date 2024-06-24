<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;

final class CartProduct
{

    public function __construct(private readonly Product $product, private int $quantity = 1)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function __toString(): string
    {
        return $this->product->getName() . ' x ' . $this->quantity;
    }

    public function incrementQuantity(): self
    {
        $this->quantity++;
        return $this;
    }

    public function decrementQuantity(): self
    {
        $this->quantity--;
        return $this;
    }
}