import axios from "axios";
import React, { Fragment, useEffect, useState } from "react";
import Spinner from "../Component/Spinner";

export default function Home() {
    const [category, setCategory] = useState([]);
    const [productByCategory, setProductByCategory] = useState([]);
    const [loader, setLoader] = useState(true);
    const [featureProduct, setFeatureProduct] = useState([]);

    const fetchProduct = () => {
        axios.get("/api/home").then((d) => {
            const { category, featureProduct, productByCategory } = d.data.data;
            setCategory(category);
            setFeatureProduct(featureProduct);
            setProductByCategory(productByCategory);
            setLoader(false);
        });
    };

    const checkChangeColor = (index) => {
        if (index % 2 !== 0) {
            return false;
        } else {
            return true;
        }
    };

    useEffect(() => {
        fetchProduct();
    }, []);

    return (
        <Fragment>
            {loader && <Spinner />}
            {!loader && (
                <Fragment>
                    <div className="w-80 mt-5">
                        <div className="row mt-2">
                            {/* loop category */}
                            {category.map((c) => {
                                return (
                                    <div
                                        className="col-12 col-sm-12 col-md-3 col-lg-3 border"
                                        key={c.slug}
                                    >
                                        <a
                                            href={`/product?category=${c.slug}`}
                                            className="text-dark"
                                        >
                                            <div className="d-flex justify-content-around align-items-center p-3">
                                                <img
                                                    src={c.image}
                                                    width={100}
                                                    alt=""
                                                />
                                                <div className="text-center">
                                                    <p className="fs-2">
                                                        {window.locale === "mm"
                                                            ? c.mm_name
                                                            : c.name}
                                                    </p>
                                                    <small>
                                                        {c.product_count} items
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                    <div className="w-80 mt-5">
                        <div className="row">
                            <div className="col-12 col-sm-12 col-md-3 col-lg-3 ">
                                {featureProduct.map((p, index) => (
                                    <a href={`/product/${p.slug}`} key={p.id}>
                                        <div
                                            className={`border ${
                                                checkChangeColor(index)
                                                    ? "bg-primary"
                                                    : "bg-warning"
                                            } p-5 text-center rounded`}
                                        >
                                            <img
                                                src={p.image}
                                                className="w-80 margin-auto  rounded"
                                                alt=""
                                            />
                                            <div className="mt-5">
                                                <h4 className="text-center mt-4 text-white">
                                                    {p.name}
                                                </h4>
                                                <span className="text badge badge-white">
                                                    {p.sale_price}
                                                </span>
                                                <span className="text badge badge-danger">
                                                    <strike>
                                                        {p.discount_price}
                                                    </strike>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                ))}
                            </div>
                            <div className="col-12 col-sm-12 col-md-9 col-lg-9">
                                <div className="row">
                                    {/* products */}
                                    {productByCategory.map((c) => (
                                        <div
                                            className="col-12 col-sm-12 col-md-12 col-lg-12 mt-3 product"
                                            key={c.id}
                                        >
                                            <div className="row">
                                                <div className="col-12">
                                                    <div className="d-flex justify-content-between align-items-center">
                                                        <b className="fs-1">
                                                            {c.name}
                                                        </b>
                                                        <a
                                                            href={`/product?category=${c.slug}`}
                                                            className="btn btn-warning"
                                                        >
                                                            View All
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="row">
                                                {/* loop product */}
                                                {c.product.map((p) => (
                                                    <div
                                                        className="col-12 col-md-4 text-center mt-2"
                                                        key={p.slug}
                                                    >
                                                        <a
                                                            href={`/product/${p.slug}`}
                                                        >
                                                            <div className="card p-2">
                                                                <img
                                                                    src={
                                                                        p.image
                                                                    }
                                                                    alt=""
                                                                    className="w-100"
                                                                />
                                                                <b>{p.name}</b>
                                                                <div>
                                                                    <small className=" badge badge-danger">
                                                                        <strike>
                                                                            {
                                                                                p.discount_price
                                                                            }{" "}
                                                                            ks
                                                                        </strike>
                                                                    </small>
                                                                    <small className="badge bg-primary">
                                                                        {
                                                                            p.sale_price
                                                                        }{" "}
                                                                        ks
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </Fragment>
            )}
        </Fragment>
    );
}
