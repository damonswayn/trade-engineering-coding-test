<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Tests\Util;
use Catch\TradeEngineering\Order\Model\Cart;
use Catch\TradeEngineering\Order\Model\Customer;
use Catch\TradeEngineering\Order\Model\Product;

final class TestCartBuilder
{
    private Cart $cart;

    public static function begin(): self
    {
        return new self();
    }

    public function forCustomer(Customer $customer): self
    {
        $this->cart = new Cart($customer);
        return $this;
    }

    public function withRandomCustomer(): self
    {
        return $this->forCustomer(TestDataFactory::createFakeCustomer());
    }

    public function addProduct(Product $product): self
    {
        $this->cart->addProduct($product);
        return $this;
    }

    public function addRandomProduct(): self
    {
        $this->cart->addProduct(TestDataFactory::createFakeProduct());
        return $this;
    }

    public function build(): Cart
    {
        return $this->cart;
    }
}