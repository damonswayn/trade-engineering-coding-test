<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Tests\Unit\Order\Model;

use Catch\TradeEngineering\Order\Model\Cart;
use Catch\TradeEngineering\Tests\BaseTestCase;
use Catch\TradeEngineering\Tests\Util\TestDataFactory;

final class CartTest extends BaseTestCase
{
    public function testCartCanBeCreated(): void
    {
        $customer = TestDataFactory::createFakeCustomer();
        $cart = new Cart($customer);
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals($customer->getName(), $cart->getCustomer()->getName());
    }

    public function testSingleItemsCanBeAddedToCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $product = TestDataFactory::createFakeProduct();
        $cart->addProduct($product);
        $this->assertNumberOfProductsInCart(1, $cart);
    }

    public function testMultipleItemsCanBeAddedToCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $productA = TestDataFactory::createFakeProduct();
        $productB = TestDataFactory::createFakeProduct();
        $cart->addProduct($productA);
        $cart->addProduct($productB);
        $this->assertNumberOfProductsInCart(2, $cart);
    }

    public function testMultipleOfOneItemCanBeAddedToCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $productA = TestDataFactory::createFakeProduct();
        $productB = TestDataFactory::createFakeProduct();
        $cart->addProduct($productA)
            ->addProduct($productA)
            ->addProduct($productB);
        $this->assertNumberOfProductsInCart(2, $cart);
        $this->assertQuantityOfProductInCart($productA, 2, $cart);
    }

    public function testDecrementingQuantityOfProductInCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $product = TestDataFactory::createFakeProduct();
        $cart->addProduct($product)
            ->addProduct($product)
            ->removeProduct($product);
        $this->assertNumberOfProductsInCart(1, $cart);
        $this->assertQuantityOfProductInCart($product, 1, $cart);
    }

    public function testRemovingProductFromCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $product = TestDataFactory::createFakeProduct();
        $cart->addProduct($product)
            ->removeProduct($product);
        $this->assertNumberOfProductsInCart(0, $cart);
        $this->assertProductNotInCart($product, $cart);
    }

    public function testRemovingNonExistentProductFromCart(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $product = TestDataFactory::createFakeProduct();
        $cart->removeProduct($product);
        $this->assertNumberOfProductsInCart(0, $cart);
        $this->assertProductNotInCart($product, $cart);
    }

    public function testCartBaseTotalPrice(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $productA = TestDataFactory::createSpecificFakeProductWithRandomCategory(1, 'Product A', 10.00);
        $productB = TestDataFactory::createSpecificFakeProductWithRandomCategory(2, 'Product B', 20.00);
        $cart->addProduct($productA)
            ->addProduct($productB);
        $this->assertCartBaseTotalPrice(30.00, $cart);
    }

    public function testCartTaxTotalPrice(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $productA = TestDataFactory::createSpecificFakeProductWithRandomCategory(1, 'Product A', 10.00, 10.0);
        $productB = TestDataFactory::createSpecificFakeProductWithRandomCategory(2, 'Product B', 20.00, 20.0);
        $cart->addProduct($productA)
            ->addProduct($productB);
        $this->assertCartTaxTotalPrice(5.00, $cart);
    }

    public function testCartTotalPrice(): void
    {
        $cart = new Cart(TestDataFactory::createFakeCustomer());
        $productA = TestDataFactory::createSpecificFakeProductWithRandomCategory(1, 'Product A', 10.00, 10.0);
        $productB = TestDataFactory::createSpecificFakeProductWithRandomCategory(2, 'Product B', 20.00, 20.0);
        $cart->addProduct($productA)
            ->addProduct($productB);
        $this->assertCartTotalPriceTotal(35.00, $cart);
    }
}
