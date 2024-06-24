<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;

final class Customer
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $address,
        private Membership      $membership
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getMembership(): Membership
    {
        return $this->membership;
    }

    public function setMembership(Membership $membership): Customer
    {
        $this->membership = $membership;
        return $this;
    }
}