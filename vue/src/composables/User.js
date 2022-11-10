import axiosClient from "../axios";
import { createToaster } from "@meforma/vue-toaster";
import jwt_decode from "jwt-decode";
import router from "../router";
import axios from "axios";
import { ref } from "vue";
export default function useUser() {
    const toaster = createToaster({
        position: "top-right",
        duration: 3000,
    });
    const users = ref([]);
    const getUsers = async (url = null, data) => {
        url = url || "/admin/users";
        console.log(url);
        try {
            let response = await axiosClient.get(url);
            users.value = response.data;
            console.log(response);
        } catch (error) {
            console.log(error);
        }
    };
    return {
        users,
        getUsers,
    };
}
