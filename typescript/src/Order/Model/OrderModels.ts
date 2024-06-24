export class Cart {
    private readonly _customer: Customer;

    private _cartProducts: Record<string, CartProduct> = {};

    constructor(customer: Customer) {
        this._customer = customer;
    }

    get customer(): Customer {
        return this._customer;
    }

    get cartProducts(): Record<string, CartProduct> {
        return this._cartProducts;
    }

    public addProduct(product: Product): this {
        this.incrementCartProductQuantity(product);
        return this;
    }

    public removeProduct(product: Product): this {
        this.decrementCartProductQuantity(product);
        return this;
    }

    public incrementCartProductQuantity(product: Product, quantity: number = 1): this {
        if (this._cartProducts[product.id]) {
            this._cartProducts[product.id].incrementQuantity();
        } else {
            this._cartProducts[product.id] = new CartProduct(product, quantity);
        }

        return this;
    }

    public decrementCartProductQuantity(product: Product, quantity: number = 1): this {
        if (this._cartProducts[product.id]) {
            this._cartProducts[product.id].decrementQuantity();

            if (this._cartProducts[product.id].quantity <= 0) {
                delete this._cartProducts[product.id];
            }
        }

        return this;
    }

    public calculateBaseTotal(): number {
        return Object.values(this._cartProducts).reduce<number>((total, cartProduct: CartProduct) => {
            return total + cartProduct.product.price;
        }, 0);
    }

    public calculateTaxTotal(): number {
        return Object.values(this._cartProducts).reduce<number>((total, cartProduct: CartProduct) => {
            const taxMultiplier = cartProduct.product.taxRate / 100;
            return total + (cartProduct.product.price * taxMultiplier);
        }, 0);
    }
}

export class CartProduct {
    private readonly _product: Product;
    private _quantity: number;

    constructor(product: Product, quantity: number) {
        this._product = product;
        this._quantity = quantity;
    }

    get product(): Product {
        return this._product;
    }

    get quantity(): number {
        return this._quantity;
    }

    set quantity(value: number) {
        this._quantity = value;
    }

    public incrementQuantity(): void {
        this._quantity++;
    }

    public decrementQuantity(): void {
        this._quantity--;
    }
}

export const CATEGORY_TYPE_DIGITAL: string = 'digital';
export const CATEGORY_TYPE_PHYSICAL: string = 'physical';

export class Category {
    private readonly _name: string;

    private readonly _type: string;

    constructor(name: string, type: string) {
        this._name = name;
        this._type = type;
    }

    get name(): string {
        return this._name;
    }

    get type(): string {
        return this._type;
    }
}

export class ConfirmedOrder {
    private _customer: Customer|null = null;

    private _payment: Payment|null = null;

    private _items: CartProduct[] = [];

    private _total: number = 0.0;

    private _taxTotal: number = 0.0;

    private _discounts: number = 0.0;

    get customer(): Customer|null {
        return this._customer;
    }

    set customer(value: Customer) {
        this._customer = value;
    }

    get payment(): Payment|null {
        return this._payment;
    }

    set payment(value: Payment) {
        this._payment = value;
    }

    get items(): CartProduct[] {
        return this._items;
    }

    set items(value: CartProduct[]) {
        this._items = value;
    }

    get total(): number {
        return this._total;
    }

    set total(value: number) {
        this._total = value;
    }

    get taxTotal(): number {
        return this._taxTotal;
    }

    set taxTotal(value: number) {
        this._taxTotal = value;
    }

    get discounts(): number {
        return this._discounts;
    }

    set discounts(value: number) {
        this._discounts = value;
    }
}

export class Customer {
    private readonly _name: string;
    private readonly _email: string;
    private readonly _address: string;
    private _membership: Membership;

    constructor(name: string, email: string, address: string, membership: Membership) {
        this._name = name;
        this._email = email;
        this._address = address;
        this._membership = membership;
    }

    get name(): string {
        return this._name;
    }

    get email(): string {
        return this._email;
    }

    get address(): string {
        return this._address;
    }

    get membership(): Membership {
        return this._membership;
    }

    set membership(value: Membership) {
        this._membership = value;
    }
}

export const MEMBERSHIP_TYPE_BASIC = 'free';
export const MEMBERSHIP_TYPE_ONEPASS = 'onepass';
export const MEMBERSHIP_TYPE_ONEPASS_PREMIUM = 'onepass_premium';
export class Membership {
    private readonly _type: string;

    constructor(type: string) {
        this._type = type;
    }

    get type(): string {
        return this._type;
    }
}

export const PAYMENT_STATUS_CONFIRMED = 'confirmed';
export const PAYMENT_STATUS_PENDING = 'pending';
export const PAYMENT_STATUS_FAILED = 'failed';
export const PAYMENT_METHOD_CREDIT_CARD = 'credit_card';

export class Payment {
    private readonly _transactionId: string;
    private readonly _paymentMethod: string;
    private readonly _paymentStatus: string;
    private readonly _amount: number;

    constructor(transactionId: string, paymentMethod: string, paymentStatus: string, amount: number) {
        this._transactionId = transactionId;
        this._paymentMethod = paymentMethod;
        this._paymentStatus = paymentStatus;
        this._amount = amount;
    }

    get transactionId(): string {
        return this._transactionId;
    }

    get paymentMethod(): string {
        return this._paymentMethod;
    }

    get paymentStatus(): string {
        return this._paymentStatus;
    }

    get amount(): number {
        return this._amount;
    }
}

export class Product {
    private readonly _id: string;

    private readonly _name: string;

    private readonly _category: Category;

    private readonly _price: number;

    private readonly _taxRate: number;

    constructor(id: string, name: string, category: Category, price: number, taxRate: number) {
        this._id = id;
        this._name = name;
        this._category = category;
        this._price = price;
        this._taxRate = taxRate;
    }

    get id(): string {
        return this._id;
    }

    get name(): string {
        return this._name;
    }

    get category(): Category {
        return this._category;
    }

    get price(): number {
        return this._price;
    }

    get taxRate(): number {
        return this._taxRate;
    }
}