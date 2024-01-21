import {createRouter, createWebHistory} from 'vue-router'
import Dictionary from './pages/Dictionary.vue'
import Login from './pages/Auth/Login.vue'
import Register from './pages/Auth/Register.vue'

const routes = [
    {
        path: '/',
        name: 'Dictionary',
        component: Dictionary,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;
