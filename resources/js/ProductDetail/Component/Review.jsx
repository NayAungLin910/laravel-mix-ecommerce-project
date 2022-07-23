import axios from "axios";
import React, { useState, Fragment } from "react";
import StarRatings from "react-star-ratings";
import Spinner from "../../Component/Spinner";

export default function Review({ review }) {
    const [reviewList, setReviewList] = useState(review);
    const [comment, setComment] = useState("");
    const [rating, setRating] = useState(0);
    const [loader, setLoader] = useState(false);

    const disabledReview = rating && comment !== "" ? false : true;
    const makeReview = () => {
        const user_id = window.auth.id;
        const slug = window.product_slug;
        const data = { comment, user_id, slug, rating };
        setLoader(true);
        axios.post("/api/make-review/" + slug, data).then(({data}) => {
            if (data.message === false) {
                showToast("Product not found!");
                setLoader(false);
            } else {
                setReviewList([...reviewList, data.data]);
                setLoader(false);
                setComment("");
                setRating(0);
            }
        });
    };

    return (
        <div className="col-12" style={{ marginTop: 100 }}>
            {/* loop review */}
            {reviewList.map((r) => (
                <div className="review" key={r.id}>
                    <div className="card p-3">
                        <div className="row">
                            <div className="col-md-2">
                                <div className="d-flex justify-content-between">
                                    <img
                                        className="w-100 rounded-circle"
                                        src={r.user.image}
                                        alt=""
                                    />
                                </div>
                            </div>
                            <div className="col-md-10">
                                <div className="rating">
                                    <StarRatings
                                        rating={r.rating}
                                        starRatedColor="#FC764B"
                                        starDimension="20px"
                                        starSpacing="1px"
                                    />
                                </div>
                                <div className="name">
                                    <b>{r.user.name}</b>
                                </div>
                                <div className="mt-3">
                                    <small>{r.review}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ))}
            {window.auth && (
                <div className="add-review mt-5">
                    {loader && <Spinner />}
                    {!loader && (
                        <Fragment>
                            <h4>Make Review</h4>
                            {/* rating component */}
                            <StarRatings
                                rating={rating}
                                starHoverColor="#FC764B"
                                starRatedColor="#FC764B"
                                starDimension="35px"
                                changeRating={(rateCount) =>
                                    setRating(rateCount)
                                }
                                numberOfStars={5}
                            />
                            <div>
                                <textarea
                                    value={comment}
                                    className="form-control"
                                    rows={5}
                                    placeholder="enter review"
                                    onChange={(e) => setComment(e.target.value)}
                                />
                                <button
                                    className="btn btn-dark float-right mt-3"
                                    disabled={disabledReview}
                                    onClick={() => {
                                        makeReview();
                                    }}
                                >
                                    Review
                                </button>
                            </div>
                        </Fragment>
                    )}
                </div>
            )}
        </div>
    );
}
