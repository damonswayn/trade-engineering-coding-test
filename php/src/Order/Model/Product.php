<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Order\Model;

final class Product
{
    private int $id;

    private string $name;

    private Category $category;

    private float $price;

    private float $taxRate;

    public function __construct(int $id, string $name, Category $category, float $price, float $taxRate = 10.0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->taxRate = $taxRate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function __toString(): string
    {
        return $this->name . ' @ ' . $this->price . ' + ' . $this->taxRate . '% tax';
    }
}