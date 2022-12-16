import axiosClient from "../axios";
import { createToaster } from "@meforma/vue-toaster";
import jwt_decode from "jwt-decode";
import router from "../router";
import axios from "axios";
import { ref } from "vue";
export default function useAuth() {
    const toaster = createToaster({
        position: "top-right",
        duration: 3000,
    });
    const validkah = ref([]);
    const login = async (data) => {
        await axiosClient
            .post("/login", data)
            .then((response) => {
                if (!response.response) {
                    localStorage.setItem("token", response.data.token);
                    let token = jwt_decode(response.data.token);
                    let userRole = token.user.roles[0].name;
                    if (userRole === "user") {
                        router.push({
                            name: "User",
                        });
                    } else if (userRole === "admin") {
                        router.push({
                            name: "Admin",
                        });
                    }
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const logout = async () => {
        let coba = await axiosClient.post("/logout");
        localStorage.removeItem("token");
        router.push({
            name: "Login",
        });
    };
    const register = async (data) => {
        let response = await axiosClient
            .post("/register", data)
            .then((response) => {
                console.log(response);
                if (!response.response) {
                    login(data);
                }
            });
    };
    const sentToken = async (data) => {
        await axiosClient.post("/sentToken", data).then((response) => {
            console.log(response);
        });
    };
    const validateToken = async (data) => {
        await axiosClient.post("/validateToken", data).then((response) => {
            if (response.status === 202) {
                let cobastring =
                    "email+" + response.data.email + "+" + data.token;
                let decode64 = btoa(cobastring);
                let generateUrl = decode64 + "??new-password";
                router.push({
                    name: "NewPassword",
                    params: { id: generateUrl },
                });
            }
        });
    };
    const resetPassword = async (id) => {
        let response = await axiosClient.post(`/resetPassword/${id}`);
        console.log(response);
    };
    const newPassword = async (data, id) => {
        let response = await axiosClient.post(`/newPassword/${id}`, data);
        console.log(response);
    };
    return {
        login,
        logout,
        register,
        sentToken,
        validateToken,
        resetPassword,
        newPassword,
    };
}
