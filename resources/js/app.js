import {createPinia} from 'pinia'
import { createApp } from 'vue';
import { createI18n } from 'vue-i18n'
import setHeaderAuth from "./utilits/setHeaderAuth.js";
import axios from 'axios';
import router from './router.js'
import App from "./App.vue";
import vClickOutside from "click-outside-vue3"
import messages from '@intlify/vite-plugin-vue-i18n/messages'

//Localisation
const availableLocales = ['ru', 'en'];

let authUser = JSON.parse(localStorage.getItem('authUser'))

let userLocale = authUser && authUser.locale !== '' ? authUser.locale : null;
let storageLocale = localStorage.getItem('locale') !== '' ? localStorage.getItem('locale') : null;
let browserLocale = availableLocales.includes(navigator.language) ? navigator.language : null;

const i18n = createI18n({
    locale: userLocale ?? storageLocale ?? browserLocale ?? 'ru',
    messages: messages
})

//Axios settings
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

//Set auth token
if (localStorage.getItem('token')) {
    setHeaderAuth(localStorage.getItem('token'))
} else {
    setHeaderAuth(false);
}

//Create application
createApp(App)
    .use(createPinia())
    .use(router)
    .use(vClickOutside)
    .use(i18n)
    .mount("#app");
