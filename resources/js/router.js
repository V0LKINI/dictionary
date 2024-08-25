import {createRouter, createWebHistory} from 'vue-router'
import {useAuthStore} from "./stores/AuthStore.js";
import Dictionary from './pages/Dictionary.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Recovery from './pages/Recovery.vue'
import RecoverySent from './pages/RecoverySent.vue'

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
    {
        path: '/recovery',
        name: 'Recovery',
        component: Recovery,
    },
    {
        path: '/recovery',
        name: 'RecoverySent',
        component: RecoverySent,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    const publicPages = ['Login', 'Register', 'Recovery', 'RecoverySent'];
    const authRequired = !publicPages.includes(to.name);

    if (authRequired && !authStore.authUser) {
        next({name: 'Login'})
    }  else if (!authRequired && authStore.authUser) {
        next({name: 'Dictionary'})
    } else {
        next()
    }
})

export default router;
