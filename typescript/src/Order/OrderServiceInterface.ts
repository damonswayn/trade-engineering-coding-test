import {Cart, ConfirmedOrder} from "./Model/OrderModels";

export default interface OrderServiceInterface {
    checkout(cart: Cart): ConfirmedOrder;
}