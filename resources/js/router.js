import {createRouter, createWebHistory} from 'vue-router'
import Dictionary from './components/Dictionary.vue'
import Login from './components/Login.vue'

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
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;