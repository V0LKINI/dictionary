import {ref} from 'vue';
import {defineStore} from 'pinia'
import axios from "axios";
import router from '../router.js'
import setHeaderAuth from "../utilits/setHeaderAuth.js";

export const useAuthStore = defineStore("authStore", () => {
    const authUser = ref(JSON.parse(localStorage.getItem('authUser')));
    const error = ref(null);

    const getProfile = async () => {
        return await axios.get('/user/profile');
    };

    const login = async (credentials, password) => {
        error.value = null;

        await axios.post('/api/login', {
            credentials: credentials,
            password: password
        }).then((r) => {
            let response = r.data;

            if (response.success) {
                authUser.value = response.data.user;

                setHeaderAuth(response.data.token)

                localStorage.setItem('authUser', JSON.stringify(response.data.user));
                localStorage.setItem('token', response.data.token);

                router.push({name: 'Dashboard'})
            } else {
                error.value = response.error.message
            }
        }).catch((e) => {
            console.log(e);
        });
    };

    const logout = () => {
        authUser.value = null;

        localStorage.removeItem('authUser');
        localStorage.removeItem('token');

        router.push({name: 'Login'}).then();
    }

    const clearAuthUser = () => {
        authUser.value = null;

        localStorage.removeItem('authUser');
        localStorage.removeItem('token');
    }

    return {
        authUser,
        error,
        login,
        logout,
        getProfile,
        clearAuthUser
    }
})