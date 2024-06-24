<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;

final readonly class Payment
{
    public const PAYMENT_STATUS_CONFIRMED = 'confirmed';

    public const PAYMENT_STATUS_PENDING = 'pending';

    public const PAYMENT_STATUS_FAILED = 'failed';

    public const PAYMENT_METHOD_CREDIT_CARD = 'credit_card';

    public function __construct(
        private string $transactionId,
        private string $paymentMethod,
        private string $paymentStatus,
        private float  $amount
    ) {}

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getPaymentStatus(): string
    {
        return $this->paymentStatus;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}