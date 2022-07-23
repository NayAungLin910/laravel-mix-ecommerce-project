import React, { useState } from "react";
import SmallLoader from "../Component/SmallLoader";
import axios from "axios";

const ChangePassword = () => {
    const [password, setPassword] = useState("");
    const [newPassword, setNewPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [loader, setLoader] = useState(false);

    const changePassword = () => {
        setLoader(true);
        if (newPassword !== confirmPassword) {
            showToast(
                "New password and confirm password does not match!",
                "error"
            );
            setLoader(false);
        } else {
            axios
                .post("/api/change-password?user_id=" + window.auth.id, {
                    password,
                    newPassword,
                })
                .then((d) => {
                    const { data } = d;
                    if (data.message === false) {
                        showToast(data.data, "error");
                    } else {
                      showToast("Password has been changed!", "success");
                    }
                    setLoader(false);
                });
        }
    };

    return (
        <div className="container">
            <div className="card p-5 mt-3">
                <div className="form-group">
                    <label htmlFor="">Enter Current Passwrod</label>
                    <input
                        type="password"
                        onChange={(e) => {
                            setPassword(e.target.value);
                        }}
                        className="form-control"
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="">Enter New Passwrod</label>
                    <input
                        type="password"
                        name="newPassword"
                        className="form-control"
                        onChange={(e) => {
                            setNewPassword(e.target.value);
                        }}
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="">Confirm New Passwrod</label>
                    <input
                        type="password"
                        name="confirmPassword"
                        className="form-control"
                        onChange={(e) => {
                            setConfirmPassword(e.target.value);
                        }}
                    />
                </div>
                <div>
                    <button
                        className="btn btn-dark"
                        disabled={loader}
                        onClick={() => changePassword()}
                    >
                        {loader && (
                            <>
                                <span className="mr-2">
                                    <SmallLoader />
                                </span>
                            </>
                        )}
                        Change
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ChangePassword;
