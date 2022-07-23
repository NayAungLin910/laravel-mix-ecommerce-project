import React from "react";

function SmallLoader() {
    return (
        <>
            <span
                className="spinner-grow spinner-grow-sm"
                role="status"
                aria-hidden="true"
            />
            <span className="sr-only">Loading...</span>
        </>
    );
}

export default SmallLoader;
