<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Impl;

use Catch\TradeEngineering\Order\Exception\CartCannotCheckoutException;
use Catch\TradeEngineering\Order\Model\Cart;
use Catch\TradeEngineering\Order\Model\ConfirmedOrder;
use Catch\TradeEngineering\Order\Model\Payment;
use Catch\TradeEngineering\Order\OrderServiceInterface;
use Ramsey\Uuid\Uuid;
use RuntimeException;

final class OrderServiceImpl implements OrderServiceInterface
{

    /**
     * @throws CartCannotCheckoutException
     * @throws RuntimeException
     */
    public function checkout(Cart $cart): ConfirmedOrder
    {
        if (!$this->canCartCheckout($cart)) {
            throw new CartCannotCheckoutException($cart);
        }

        $payment = $this->collectPayment($cart);
        $order = new ConfirmedOrder();
        $order->setCustomer($cart->getCustomer())
            ->setItems($cart->getCartProducts())
            ->setPayment($payment);

        $this->applyBusinessRules($cart, $order);

        return $order;
    }

    private function collectPayment(Cart $cart): Payment
    {
        $baseAmount = $cart->calculateBaseTotal();
        $taxTotal = $cart->calculateTaxTotal();
        return new Payment(
            Uuid::uuid4()->toString(),
            Payment::PAYMENT_METHOD_CREDIT_CARD,
            Payment::PAYMENT_STATUS_CONFIRMED,
            (float) bcadd((string)$baseAmount, (string)$taxTotal, 2)
        );
    }

    private function canCartCheckout(Cart $cart): bool
    {
        return $cart->getCartProducts() !== [];
    }

    private function applyBusinessRules(Cart $cart, ConfirmedOrder $confirmedOrder): void
    {
        // Business rules go here
        throw new RuntimeException('Not implemented');
    }
}