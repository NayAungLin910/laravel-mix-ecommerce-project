import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route, Link } from "react-router-dom";
import Cart from "./Profile/Cart";
import ChangePassword from "./Profile/ChangePassword";
import Nav from "./Profile/Component/Nav";
import Order from "./Profile/Order";
import Profile from "./Profile/Profile";

const MainRouter = () => {
    return (
        <HashRouter>
            <Nav />
            <Routes>
                <Route path="/" element={<Cart />} />
                <Route path="/order" element={<Order />} />
                <Route path="/profile" element={<Profile />} />
                <Route path="/password" element={<ChangePassword />} />
            </Routes>
        </HashRouter>
    )
}

createRoot(document.getElementById("root")).render(<MainRouter />);