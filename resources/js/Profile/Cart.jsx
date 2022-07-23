import React, { useState, useEffect, Fragment } from "react";
import axios from "axios";
import Spinner from "../Component/Spinner";
import SmallLoader from "../ProductDetail/Component/SmallLoader";

const Cart = () => {
    const [loader, setLoader] = useState(true);
    const [cart, setCart] = useState([]);
    const [qtyLoader, setQtyLoader] = useState(false);

    const user_id = window.auth.id;

    const updateCart = (id, type) => {
        const updatedCart = cart.map((c) => {
            if (id === c.id) {
                switch (type) {
                    case "add":
                        c.total_quantity += 1;
                        break;
                    default:
                        if (c.total_quantity !== 1) {
                            c.total_quantity -= 1;
                        }
                        break;
                }
            }
            return c;
        });

        setCart(updatedCart);
    };

    const getCart = () => {
        axios.post("/api/get-cart", { user_id }).then((d) => {
            const { data } = d;
            setCart(data.data);
            setLoader(false);
        });
    };

    const updateQty = (id, total_quantity) => {
        setQtyLoader(id);
        axios
            .post("/api/update-cart-qty", { cart_id: id, total_quantity })
            .then((d) => {
                if (d.data.message == true) {
                    showToast("Cart quantity updated!");
                    setQtyLoader(false);
                }
            });
    };

    const removeCart = (id) => {
        axios.post("/api/remove-cart", { cart_id: id }).then((d) => {
            if (d.data.message == true) {
                setCart((preCart) => preCart.filter((c) => c.id !== id));
                showToast("Product removed from cart!");
            }
        });
    };

    const TotalPrice = () => {
        var total_price = 0;
        cart.map((c) => {
            total_price += c.product.sale_price * c.total_quantity;
        });
        return (
            <>
                <span>{total_price} Ks</span>
            </>
        );
    };

    const checkout = () => {
        const user_id = window.auth.id;

        axios.post("/api/checkout", { user_id }).then((d) => {
            setCart([]);
            window.updateCart(0);
            if(d.data.message === true){
                showToast('Checkout Success. Please wait for confirmation!');
            } 
        });
    };

    useEffect(() => {
        getCart();
    }, []);

    return (
        <div className="container-fluid mt-3">
            <div className="card p-3">
                <div>
                    <h4>Cart</h4>
                </div>
                {loader && <Spinner />}
                {!loader && (
                    <>
                        <table className="table table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Sale Price</th>
                                    <th>Add or Remove</th>
                                    <th>Total Price</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                {cart.map((c) => (
                                    <tr key={c.id}>
                                        <td>
                                            <img
                                                style={{ width: 80 }}
                                                src={c.product.image}
                                                alt={c.product.name}
                                            />
                                        </td>
                                        <td>{c.product.name}</td>
                                        <td>{c.total_quantity}</td>
                                        <td>{c.product.sale_price}</td>
                                        <td>
                                            <button
                                                type="button"
                                                className="btn btn-sm btn-dark"
                                                onClick={() =>
                                                    updateCart(c.id, "reduce")
                                                }
                                            >
                                                -
                                            </button>
                                            <input
                                                type="text"
                                                className="btn border-warning"
                                                value={c.total_quantity}
                                                disabled={true}
                                            />
                                            <button
                                                type="button"
                                                className="btn btn-sm btn-dark"
                                                onClick={() =>
                                                    updateCart(c.id, "add")
                                                }
                                            >
                                                +
                                            </button>
                                            <button
                                                disabled={qtyLoader == c.id}
                                                className="btn btn-sm btn-primary"
                                                onClick={() =>
                                                    updateQty(
                                                        c.id,
                                                        c.total_quantity
                                                    )
                                                }
                                            >
                                                {qtyLoader === c.id && (
                                                    <SmallLoader />
                                                )}
                                                Save
                                            </button>
                                        </td>
                                        <td>
                                            {c.product.sale_price *
                                                c.total_quantity}{" "}
                                            Ks
                                        </td>
                                        <td>
                                            <button
                                                className="btn btn-sm btn-danger"
                                                onClick={() => removeCart(c.id)}
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                <tr>
                                    <td colSpan={6}>
                                        <span className="float-right">
                                            Total:{" "}
                                        </span>
                                    </td>
                                    <td>
                                        <TotalPrice />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div className="text-center">
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={() => checkout()}
                            >
                                Checkout
                            </button>
                        </div>
                    </>
                )}
            </div>
        </div>
    );
};

export default Cart;
