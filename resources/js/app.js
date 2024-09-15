import setHeaderAuth from "./utilits/setHeaderAuth.js";
import {createPinia} from 'pinia'
import axios from 'axios';
import { createApp } from 'vue';
import router from './router.js'
import App from "./App.vue";
import vClickOutside from "click-outside-vue3"

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_BASE_URL_API;

axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response.status === 401) {
            localStorage.removeItem('authUser');
            localStorage.removeItem('token');
        }

        return Promise.reject(error);
    }
);

if (localStorage.getItem('token')) {
    setHeaderAuth(localStorage.getItem('token'))
} else {
    setHeaderAuth(false);
}

createApp(App)
    .use(createPinia())
    .use(router)
    .use(vClickOutside)
    .mount("#app");
