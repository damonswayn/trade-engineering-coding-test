import OrderServiceImpl from "../src/Order/Impl/OrderServiceImpl";
import {TestCartBuilder} from "./test_utils";

describe('Order Service', () => {
    test('order service can be created', () => {
        const orderService = new OrderServiceImpl();
        expect(orderService).toBeInstanceOf(OrderServiceImpl);
    });

    test('test order can checkout with cart', () => {
        const orderService = new OrderServiceImpl();
        const cart = TestCartBuilder.begin()
            .withArbitraryCustomer()
            .withArbitraryProduct()
            .build();

        const confirmedOrder = orderService.checkout(cart);
        expect(confirmedOrder).toBeDefined();
    });
});