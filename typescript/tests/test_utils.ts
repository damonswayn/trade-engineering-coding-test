import {
    Cart, Category, CATEGORY_TYPE_DIGITAL, CATEGORY_TYPE_PHYSICAL,
    ConfirmedOrder,
    Customer,
    Membership, MEMBERSHIP_TYPE_BASIC, MEMBERSHIP_TYPE_ONEPASS, MEMBERSHIP_TYPE_ONEPASS_PREMIUM,
    PAYMENT_STATUS_CONFIRMED,
    Product
} from "../src/Order/Model/OrderModels";
import {faker} from "@faker-js/faker";

export function assertNumberOfProductsInCart(expected: number, cart: Cart) {
    expect(Object.keys(cart.cartProducts).length).toBe(expected);
}

export function assertProductInCart(product: Product, cart: Cart) {
    expect(cart.cartProducts[product.id]).toBeDefined();
}

export function assertProductNotInCart(product: Product, cart: Cart) {
    expect(cart.cartProducts[product.id]).toBeUndefined();
}

export function assertQuantityOfProductInCart(product: Product, quantity: number, cart: Cart) {
    expect(cart.cartProducts[product.id].quantity).toBe(quantity);
}

export function assertCartBaseTotalPrice(expectedTotal: number, cart: Cart) {
    expect(cart.calculateBaseTotal()).toBe(expectedTotal);
}

export function assertCartTaxTotalPrice(expectedTotal: number, cart: Cart) {
    expect(cart.calculateTaxTotal()).toBe(expectedTotal);
}

export function assertCartTotalPrice(expectedTotal: number, cart: Cart) {
    expect(cart.calculateBaseTotal() + cart.calculateTaxTotal()).toBe(expectedTotal);
}

export function assertSuccessfulCheckout(confirmedOrder: ConfirmedOrder) {
    expect(confirmedOrder.payment?.paymentStatus).toBe(PAYMENT_STATUS_CONFIRMED);
}

export function createFakeCustomer(): Customer {
    return new Customer(
        faker.person.fullName(),
        faker.internet.email(),
        faker.location.streetAddress(),
        new Membership(faker.helpers.arrayElement([
            MEMBERSHIP_TYPE_BASIC,
            MEMBERSHIP_TYPE_ONEPASS,
            MEMBERSHIP_TYPE_ONEPASS_PREMIUM
        ]))
    );
}

export function createFakeProduct(): Product {
    const category = new Category(faker.commerce.department(), faker.helpers.arrayElement([
        CATEGORY_TYPE_DIGITAL,
        CATEGORY_TYPE_PHYSICAL,
    ]));

    return new Product(
        faker.string.uuid(),
        faker.commerce.productName(),
        category,
        faker.number.float({ min: 2, max: 1000, fractionDigits: 2 }),
        10.0
    );
}

export function createSpecificFakeProduct(id: string, name: string, category: Category, price: number): Product {
    return new Product(id, name, category, price, 10.0);
}

export function createSpecificFakeProductWithRandomCategory(id: string, name: string, price: number, taxRate: number = 10.0): Product {
    return new Product(id, name, new Category(faker.commerce.department(), faker.helpers.arrayElement([
        CATEGORY_TYPE_DIGITAL,
        CATEGORY_TYPE_PHYSICAL,
    ])), price, taxRate);
}

export class TestCartBuilder {
    private cart: Cart|null = null;

    public static begin(): TestCartBuilder {
        return new TestCartBuilder();
    }

    public withCustomer(customer: Customer): TestCartBuilder {
        this.cart = new Cart(customer);
        return this;
    }

    public withArbitraryCustomer(): TestCartBuilder {
        return this.withCustomer(createFakeCustomer());
    }

    public withProduct(product: Product, quantity: number = 1): TestCartBuilder {
        this.cart?.incrementCartProductQuantity(product, quantity);
        return this;
    }

    public withArbitraryProduct(quantity: number = 1): TestCartBuilder {
        return this.withProduct(createFakeProduct(), quantity);
    }

    public build(): Cart {
        if (this.cart === null) {
            throw new Error("Cart is not initialized");
        }

        return this.cart;
    }
}