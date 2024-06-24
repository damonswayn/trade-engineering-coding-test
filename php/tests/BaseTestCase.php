<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Tests;

use Catch\TradeEngineering\Order\Model\Cart;
use Catch\TradeEngineering\Order\Model\ConfirmedOrder;
use Catch\TradeEngineering\Order\Model\Payment;
use Catch\TradeEngineering\Order\Model\Product;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    public function assertNumberOfProductsInCart(int $expected, Cart $cart): void
    {
        $this->assertCount($expected, $cart->getCartProducts());
    }

    public function assertProductInCart(Product $product, Cart $cart): void
    {
        $cartProducts = $cart->getCartProducts();
        $this->assertArrayHasKey($product->getId(), $cartProducts);
    }

    public function assertProductNotInCart(Product $product, Cart $cart): void
    {
        $cartProducts = $cart->getCartProducts();
        $this->assertArrayNotHasKey($product->getId(), $cartProducts);
    }

    public function assertQuantityOfProductInCart(Product $product, int $expectedQty, Cart $cart): void
    {
        $cartProduct = $cart->getCartProducts()[$product->getId()];
        $this->assertEquals($expectedQty, $cartProduct->getQuantity());
    }

    public function assertCartTotalPriceTotal(float $expectedTotal, Cart $cart): void
    {
        $combinedTotal = (float) bcadd((string)$cart->calculateBaseTotal(), (string)$cart->calculateTaxTotal(), 2);
        $this->assertEquals($expectedTotal, $combinedTotal);
    }

    public function assertCartBaseTotalPrice(float $expectedTotal, Cart $cart): void
    {
        $this->assertEquals($expectedTotal, $cart->calculateBaseTotal());
    }

    public function assertCartTaxTotalPrice(float $expectedTotal, Cart $cart): void
    {
        $this->assertEquals($expectedTotal, $cart->calculateTaxTotal());
    }

    protected function assertSuccessfulCheckout(ConfirmedOrder $order): void
    {
        $this->assertEquals(
            Payment::PAYMENT_STATUS_CONFIRMED,
            $order->getPayment()->getPaymentStatus()
        );
    }
}