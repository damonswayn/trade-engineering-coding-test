import {Cart, ConfirmedOrder, PAYMENT_STATUS_CONFIRMED, Product} from "../src/Order/Model/OrderModels";
import {
    assertCartBaseTotalPrice, assertCartTotalPrice,
    assertNumberOfProductsInCart,
    assertQuantityOfProductInCart,
    createFakeCustomer,
    createFakeProduct, createSpecificFakeProductWithRandomCategory
} from "./test_utils";

describe('Cart model tests', () => {
    test('cart can be created', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        expect(cart).toBeDefined();
        expect(cart).toBeInstanceOf(Cart);
        expect(cart.customer.name).toEqual(customer.name);
    });

    test('test single item can be added to cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product = createFakeProduct();
        cart.addProduct(product);
        assertNumberOfProductsInCart(1, cart);
    });

    test('test multiple items can be added to cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product1 = createFakeProduct();
        const product2 = createFakeProduct();
        cart.addProduct(product1);
        cart.addProduct(product2);
        assertNumberOfProductsInCart(2, cart);
    });

    test('test multiple of one item can be added to cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product = createFakeProduct();
        cart.addProduct(product)
            .addProduct(product);
        assertNumberOfProductsInCart(1, cart);
        assertQuantityOfProductInCart(product, 2, cart);
    });

    test('test decrementing quantity of product in cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product = createFakeProduct();
        cart.addProduct(product)
            .addProduct(product)
            .removeProduct(product);
        assertQuantityOfProductInCart(product, 1, cart);
    });

    test('test removing product from cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product = createFakeProduct();
        cart.addProduct(product)
            .removeProduct(product);
        assertNumberOfProductsInCart(0, cart);
    });

    test('test removing non-existent product from cart', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product = createFakeProduct();
        cart.addProduct(product)
            .removeProduct(createFakeProduct());
        assertNumberOfProductsInCart(1, cart);
    });

    test('test cart base total price calculation', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product1 = createSpecificFakeProductWithRandomCategory('1', 'product1', 10.0);
        const product2 = createSpecificFakeProductWithRandomCategory('2', 'product2', 20.0);
        cart.addProduct(product1)
            .addProduct(product2);
        assertCartBaseTotalPrice(30.0, cart);
    });

    test('test cart tax total price calculation', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product1 = createSpecificFakeProductWithRandomCategory('1', 'product1', 10.0, 10.0);
        const product2 = createSpecificFakeProductWithRandomCategory('2', 'product2', 20.0, 20.0);
        cart.addProduct(product1)
            .addProduct(product2);
        expect(cart.calculateTaxTotal()).toBe(5.0);
    });

    test('test cart total price', () => {
        const customer = createFakeCustomer();
        const cart = new Cart(customer);
        const product1 = createSpecificFakeProductWithRandomCategory('1', 'product1', 10.0, 10.0);
        const product2 = createSpecificFakeProductWithRandomCategory('2', 'product2', 20.0, 20.0);
        cart.addProduct(product1)
            .addProduct(product2);
        assertCartTotalPrice(35.0, cart);
    });
});