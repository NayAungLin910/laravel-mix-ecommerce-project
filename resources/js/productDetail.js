import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import ProductDetail from "./ProductDetail/ProductDetail";


const MainRouter = () => {
    return (
        <HashRouter>
            <Routes>
                <Route path="/" element={<ProductDetail />} />
            </Routes>
        </HashRouter>
    )
}

createRoot(document.getElementById("root")).render(<MainRouter />);