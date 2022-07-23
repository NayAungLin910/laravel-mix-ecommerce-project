import React from "react";
import { Link, useLocation } from "react-router-dom";

const Nav = () => {
    const { pathname } = useLocation();
    console.log(pathname);

    return (
        <div className="container-fluid mt-3">
            <div className="card p-3 bg-dark">
                <div>
                    <Link
                        to={"/"}
                        className={`btn btn${
                            pathname === "/" ? "" : "-outline"
                        }-warning`}
                    >
                        Cart List
                    </Link>
                    <Link to={"/order"}  className={`btn btn${
                            pathname === "/order" ? "" : "-outline"
                        }-warning`}>
                        Order List
                    </Link>
                    <Link to={"/profile"}  className={`btn btn${
                            pathname === "/profile" ? "" : "-outline"
                        }-primary`}>
                        Profile
                    </Link>
                    <Link to={"/password"}  className={`btn btn${
                            pathname === "/password" ? "" : "-outline"
                        }-primary`}>
                        Change Password
                    </Link>
                </div>
            </div>
        </div>
    );
};

export default Nav;
