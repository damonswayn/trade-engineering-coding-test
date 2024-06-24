import OrderServiceInterface from "../OrderServiceInterface";
import {
    Cart,
    ConfirmedOrder,
    Payment,
    PAYMENT_METHOD_CREDIT_CARD,
    PAYMENT_STATUS_CONFIRMED
} from "../Model/OrderModels";
import * as crypto from "node:crypto";

export default class OrderServiceImpl implements OrderServiceInterface {
    checkout(cart: Cart): ConfirmedOrder {
        if (!this.canCartCheckout(cart)) {
            throw new Error("Cart is not eligible for checkout");
        }

        const payment = this.collectPayment(cart);
        const confirmedOrder = new ConfirmedOrder();
        confirmedOrder.customer = cart.customer;
        confirmedOrder.items = Object.values(cart.cartProducts);
        confirmedOrder.payment = payment;

        this.applyBusinessRules(cart, confirmedOrder);

        return confirmedOrder;
    }

    private canCartCheckout(cart: Cart): boolean {
        return Object.values(cart.cartProducts).length > 0;
    }

    private collectPayment(cart: Cart): Payment {
        const baseAmount = cart.calculateBaseTotal();
        const taxTotal = cart.calculateTaxTotal();
        return new Payment(
            crypto.randomUUID(),
            PAYMENT_METHOD_CREDIT_CARD,
            PAYMENT_STATUS_CONFIRMED,
            baseAmount + taxTotal
        );
    }

    private applyBusinessRules(cart: Cart, confirmedOrder: ConfirmedOrder) {
        throw new Error("Not implemented");
    }
}