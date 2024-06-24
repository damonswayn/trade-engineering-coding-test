<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;
final class ConfirmedOrder
{
    private Customer $customer;

    private Payment $payment;

    /** @var CartProduct[] */
    private array $items;

    private float $total;

    private float $taxTotal;

    private float $discounts;

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): ConfirmedOrder
    {
        $this->customer = $customer;
        return $this;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): ConfirmedOrder
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * @return CartProduct[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CartProduct[] $items
     * @return $this
     */
    public function setItems(array $items): ConfirmedOrder
    {
        $this->items = $items;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): ConfirmedOrder
    {
        $this->total = $total;
        return $this;
    }

    public function getTaxTotal(): float
    {
        return $this->taxTotal;
    }

    public function setTaxTotal(float $taxTotal): ConfirmedOrder
    {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    public function getDiscounts(): float
    {
        return $this->discounts;
    }

    public function setDiscounts(float $discounts): ConfirmedOrder
    {
        $this->discounts = $discounts;
        return $this;
    }
}