<?php

declare(strict_types=1);

namespace Catch\TradeEngineering\Tests\Util;

use Catch\TradeEngineering\Order\Model\Category;
use Catch\TradeEngineering\Order\Model\Customer;
use Catch\TradeEngineering\Order\Model\Membership;
use Catch\TradeEngineering\Order\Model\Product;
use Faker\Factory;
use Faker\Generator;

class TestDataFactory
{
    private static function getFakerFactory(): Generator
    {
        return Factory::create();
    }

    public static function createFakeCustomer(): Customer
    {
        $membership = new Membership(self::getFakerFactory()->randomElement([
            Membership::MEMBERSHIP_TYPE_BASIC,
            Membership::MEMBERSHIP_TYPE_ONEPASS,
            Membership::MEMBERSHIP_TYPE_ONEPASS_PREMIUM
        ]));

        return new Customer(
            self::getFakerFactory()->name,
            self::getFakerFactory()->email,
            self::getFakerFactory()->address,
            $membership
        );
    }

    public static function createFakeProduct(): Product
    {
        $category = new Category(
            self::getFakerFactory()->word(),
            self::getFakerFactory()->randomElement([
                Category::CATEGORY_TYPE_DIGITAL,
                Category::CATEGORY_TYPE_PHYSICAL
            ])
        );

        return new Product(
            self::getFakerFactory()->randomNumber(),
            self::getFakerFactory()->word(),
            $category,
            self::getFakerFactory()->randomFloat(2, 0, 1000)
        );
    }

    public static function createSpecificFakeProduct(int $id, string $name, Category $category, float $price, float $taxRate = 10.0): Product
    {
        return new Product($id, $name, $category, $price, $taxRate);
    }

    public static function createSpecificFakeProductWithRandomCategory(int $id, string $name, float $price, float $taxRate = 10.0): Product
    {
        $category = new Category(
            self::getFakerFactory()->word(),
            self::getFakerFactory()->randomElement([
                Category::CATEGORY_TYPE_DIGITAL,
                Category::CATEGORY_TYPE_PHYSICAL
            ])
        );

        return self::createSpecificFakeProduct($id, $name, $category, $price, $taxRate);
    }
}