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
    const user = ref([]);
    const getUsers = async (page, data) => {
        let uri_get = "/admin/users?page=" + page;
        let uri_post = "/admin/users/search?page=" + page;
        console.log(uri_post);
        console.log(data);
        try {
            if (data) {
                let response = await axiosClient.post(uri_post, data);
                users.value = response.data;
            } else {
                let response = await axiosClient.get(uri_get);
                users.value = response.data;
            }
        } catch (error) {
            console.log(error);
        }
    };
    const getUser = async (id) => {
        let response = await axiosClient.post(`/admin/users/edit/${id}`);
        console.log(response);
        user.value = response.data;
    };
    const cekEmail = async (data) => {
        try {
            let response = await axiosClient.post("/cek/email", data);
            return response;
        } catch (error) {}
    };
    const createUser = async (data) => {
        try {
            await axiosClient
                .post("/admin/users/save", data)
                .then((response) => {
                    console.log(response);
                    if (response.response) {
                        if (response.response.status === 400) {
                            for (const [key, value] of Object.entries(
                                response.response.data
                            )) {
                                toaster.error(`${value}`);
                            }
                        }
                    } else {
                        toaster.success("Pengguna Berhasil Ditambahkan");
                        router.push({
                            name: "ListUsers",
                        });
                    }
                });
        } catch (error) {}
    };
    const deleteData = async (id) => {
        await axiosClient.post(`/admin/users/delete/${id}`);
    };
    return {
        users,
        getUsers,
        cekEmail,
        createUser,
        user,
        getUser,
        deleteData,
    };
}
