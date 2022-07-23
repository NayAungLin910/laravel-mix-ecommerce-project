import React, { Fragment, useState, useEffect } from "react";
import axios from "axios";
import Spinner from "../Component/Spinner";

const Order = () => {
    const [loader, setLoader] = useState(true);
    const [order, setOrder] = useState({});
    const [page, setPage] = useState(1);

    const fetchOrderData = () => {
        const user_id = window.auth.id;
        axios
            .get(`/api/order?page=${page}&user_id=${user_id}`)
            .then(({ data }) => {
                setOrder(data.data);
                setLoader(false);
            });
    };

    useEffect(() => {
        fetchOrderData();
    }, [page]);
    return (
        <Fragment>
            {loader && <Spinner />}
            {!loader && (
                <>
                    <table className="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {order.data.map((o) => (
                                <tr key={o.id}>
                                    <td>
                                        <img
                                            src={o.product.image}
                                            style={{ width: 70 }}
                                            alt={o.product.name}
                                        />
                                    </td>
                                    <td>{o.product.name}</td>
                                    <td>{o.total_quantity}</td>
                                    <td>{o.product.sale_price}</td>
                                    <td>
                                        {
                                            // bruhh next time try to be more precise
                                            o.status === "cancel" && (
                                                <span className="badge badge-danger">
                                                    Reject
                                                </span>
                                            )
                                        }
                                        {
                                            // bruhh next time try to be more precise
                                            o.status === "success" && (
                                                <span className="badge badge-success">
                                                    Success
                                                </span>
                                            )
                                        }
                                        {
                                            // bruhh next time try to be more precise
                                            o.status === "pending" && (
                                                <span className="badge badge-warning">
                                                    Pending
                                                </span>
                                            )
                                        }
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <div className="p-3 text-center">
                        <button
                            className="btn btn-dark"
                            disabled={
                                order.prev_page_url === null ? true : false
                            }
                            onClick={() => setPage(page - 1)}
                        >
                            <i className="fa-solid fa-angle-left"></i>
                        </button>
                        <button
                            className="btn btn-dark"
                            disabled={
                                order.next_page_url === null ? true : false
                            }
                            onClick={() => setPage(page + 1)}
                        >
                            <i className="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                </>
            )}
        </Fragment>
    );
};

export default Order;
