import {ref} from 'vue';
import {defineStore} from 'pinia'
import axios from "axios";
import router from '../router.js'
import setHeaderAuth from "../utilits/setHeaderAuth.js";

export const useAuthStore = defineStore("authStore", () => {
    const authUser = ref(JSON.parse(localStorage.getItem('authUser')));
    const error = ref(null);
    const credentials = ref(null);

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

                router.push({name: 'Dictionary'})
            }
        }).catch((e) => {
            error.value = e.response.data.error.message
        });
    };

    const register = async (name, credentials, password, passwordConfirm) => {
        error.value = null;

        await axios.post('/api/register', {
            name: name,
            credentials: credentials,
            password: password,
            password_confirm: passwordConfirm
        }).then((r) => {
            let response = r.data;

            if (response.success) {
                authUser.value = response.data.user;

                setHeaderAuth(response.data.token)

                localStorage.setItem('authUser', JSON.stringify(response.data.user));
                localStorage.setItem('token', response.data.token);

                router.push({name: 'Dictionary'})
            }
        }).catch((e) => {
            error.value = e.response.data.error.message
        });
    };

    const logout = () => {
        authUser.value = null;

        localStorage.removeItem('authUser');
        localStorage.removeItem('token');

        router.push({name: 'Login'}).then();
    }

    const recovery = async (credentials) => {
        error.value = null;

        await axios.post('/api/reset-password', {
            credentials: credentials,
        }).catch((e) => {
            error.value = e.response.data.error.message
        });
    }

    const changePassword = async (credentials, password, passwordConfirm) => {
        error.value = null;

        await axios.post('/api/set-new-password', {
            credentials: credentials,
            password: password,
            password_confirm: passwordConfirm,
        }).catch((e) => {
            error.value = e.response.data.error.message
        });
    }

    const verifyToken = async (token) => {
        error.value = null;

        await axios.post('/api/reset-password/' + token).then((r) => {
            let response = r.data;

            if (response.success) {
               credentials.value = response.data.email
            }
        }).catch((e) => {
            error.value = e.response.data.error.message
        });
    }

    const clearAuthUser = () => {
        authUser.value = null;

        localStorage.removeItem('authUser');
        localStorage.removeItem('token');
    }

    return {
        authUser,
        error,
        credentials,
        login,
        register,
        logout,
        recovery,
        changePassword,
        verifyToken,
        getProfile,
        clearAuthUser
    }
})
