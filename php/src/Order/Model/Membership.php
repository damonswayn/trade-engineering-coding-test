<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;
class Membership
{
    public const MEMBERSHIP_TYPE_BASIC = 'free';

    public const MEMBERSHIP_TYPE_ONEPASS = 'onepass';

    public const MEMBERSHIP_TYPE_ONEPASS_PREMIUM = 'onepass_premium';

    public function __construct(private string $type)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }
}