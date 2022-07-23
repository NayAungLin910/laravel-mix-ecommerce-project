import React from "react";

export default function Spinner() {
    return (
        <div className="row">
            <div className="col-4"></div>
            <div className="col-4" align="center">
                <div
                    className="spinner-grow "
                    style={{ width: "3rem", height: "3rem" }}
                    role="status"
                >
                    <span className="sr-only">Loading...</span>
                </div>
            </div>
            <div className="col-4"></div>
        </div>
    );
}
