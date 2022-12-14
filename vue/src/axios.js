import axios from "axios";
import { createToaster } from "@meforma/vue-toaster";
import router from "./router";
const axiosClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Content-type": "application/json",
    },
});
const toaster = createToaster({
    position: "top-right",
    duration: 3000,
});
axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
axiosClient.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        const err_status = error.response.status;
        const err_message = error.response.data.message;
        const e_code = error.response.data.e_code;
        if (err_status === 401) {
            toaster.error(err_status + ", " + err_message);
            localStorage.removeItem("token");
            router.push({ name: "Login" });
        }
        if (err_status === 404) {
            if (e_code === "11") {
                toaster.error("Error Status: " + e_code + ", " + err_message);
                router.push({ name: "ResetPassword" });
            }
        }
        return error;
    }
);

export default axiosClient;
