<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;
class Category
{
    public const CATEGORY_TYPE_DIGITAL = 'digital';

    public const CATEGORY_TYPE_PHYSICAL = 'physical';

    public function __construct(private string $name, private string $type)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }
}