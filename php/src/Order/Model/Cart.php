<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;

final class Cart
{
    /**
     * @var array<int, CartProduct>
     */
    private array $cartProducts = [];

    public function __construct(private readonly Customer $customer)
    {
    }

    public function addProduct(Product $product): self
    {
        if (array_key_exists($product->getId(), $this->cartProducts)) {
            $this->incrementCartProductQuantity($product);
        } else {
            $this->addNewItemToCart($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if (array_key_exists($product->getId(), $this->cartProducts)) {
            $this->decrementCartProductQuantity($product);
        }

        return $this;
    }

    /**
     * @return CartProduct[]
     */
    public function getCartProducts(): array
    {
        return $this->cartProducts;
    }

    public function incrementCartProductQuantity(Product $product): self
    {
        $existingCartProduct = $this->cartProducts[$product->getId()];
        $existingCartProduct->incrementQuantity();
        return $this;
    }

    public function decrementCartProductQuantity(Product $product): self
    {
        $existingCartProduct = $this->cartProducts[$product->getId()];
        $existingCartProduct->decrementQuantity();

        if ($existingCartProduct->getQuantity() === 0) {
            unset($this->cartProducts[$product->getId()]);
        }

        return $this;
    }

    private function addNewItemToCart(Product $product): void
    {
        $this->cartProducts[$product->getId()] = new CartProduct($product);
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function calculateBaseTotal(): float
    {
        return array_reduce(
            $this->cartProducts,
            static fn(float $carry, CartProduct $cartProduct) =>
                (float) bcadd((string)$carry, (string)$cartProduct->getProduct()->getPrice()),
            0.0
        );
    }

    public function calculateTaxTotal(): float
    {
        return array_reduce(
            $this->cartProducts,
            static fn(float $carry, CartProduct $cartProduct) =>
                (float) bcadd(
                    (string)$carry,
                    (string) bcmul(
                        (string)$cartProduct->getProduct()->getPrice(),
                        (string) bcdiv((string)$cartProduct->getProduct()->getTaxRate(), '100', 2),
                        2
                    ),
                    2
                ),
            0.0
        );
    }
}