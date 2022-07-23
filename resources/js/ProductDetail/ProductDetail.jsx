import React, { Fragment, useEffect, useState } from "react";
import Review from "./Component/Review";
import axios from "axios";
import Spinner from "../Component/Spinner";
import SmallLoader from "./Component/SmallLoader";

export default function ProductDetail() {
    const [product, setProduct] = useState({});
    const [loader, setLoader] = useState(true);
    const product_slug = window.product_slug;
    const [cartLoader, setCartLoader] = useState(false);
    const getProduct = () => {
        axios.get("/api/product/" + product_slug).then(({ data }) => {
            setProduct(data.data);
            setLoader(false);
        });
    };

    // ## Add to cart
    const addToCart = () => {
        setCartLoader(true);
        const user_id = window.auth.id;
        axios
            .post("/api/add-to-cart/" + product_slug, { user_id })
            .then((d) => {
                const { data } = d;
                if (data.fasle) {
                    setCartLoader(false);
                    showToast("Product not found!");
                } else {
                    setCartLoader(false);
                    window.updateCart(data.data);
                    showToast("Prodcut Added to cart");
                }
            });
    };

    useEffect(() => {
        getProduct();
    }, []);
    return (
        <Fragment>
            {loader && <Spinner />}
            {!loader && (
                <div className="card p-4">
                    <div className="row">
                        <div className="col-12 mb-3">
                            <h3>{product.name}</h3>
                            <div>
                                <small className="text-muted">Brand:</small>
                                <small>{product.brand.name}</small>|
                                <small className="text-muted">Category:</small>
                                <small className="badge badge-dark">
                                    {product.category.name}
                                </small>
                            </div>
                        </div>
                        <div className="col-12 col-sm-12 col-md-4 col-lg-4">
                            <img className="w-100" src={product.image} alt="" />
                        </div>
                        <div className="col-12 col-sm-12 col-md-8 col-lg-8">
                            <div className="mt-5">
                                <p>
                                    <small className="text-muted">
                                        <strike>
                                            {product.discount_price} ks
                                        </strike>
                                    </small>
                                    <span className="text-danger fs-1 d-inline">
                                        {product.sale_price} ks
                                    </span>
                                    <br />
                                    <span className="btn btn-sm btn-outline-success text-success mt-3">
                                        InStock :{product.total_quantity}
                                    </span>
                                    <button
                                        className="btn btn-sm btn-danger mt-3"
                                        onClick={() => addToCart()}
                                        disabled={cartLoader}
                                    >
                                        {cartLoader && (
                                            <>
                                                <SmallLoader />
                                            </>
                                        )}
                                        <i className="fas fa-shopping-cart" />
                                        Add To Cart
                                    </button>
                                </p>
                                <p
                                    className="mt-5"
                                    dangerouslySetInnerHTML={{
                                        __html: product.description,
                                    }}
                                ></p>
                                <small className="text-muted">
                                    Available Color:
                                </small>
                                {product.color.map((c) => (
                                    <span
                                        className="badge badge-danger"
                                        key={c.id}
                                    >
                                        {c.name}
                                    </span>
                                ))}
                            </div>
                        </div>
                        <hr />
                        <Review review={product.review} />
                    </div>
                </div>
            )}
        </Fragment>
    );
}
