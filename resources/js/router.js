import {createRouter, createWebHistory} from 'vue-router'
import {useAuthStore} from "./stores/AuthStore.js";
import Dictionary from './pages/Dictionary.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Recovery from './pages/Recovery.vue'
import RecoveryConfirm from './pages/RecoveryConfirm.vue'
import FindTranslation from './pages/Exercises/FindTranslation.vue'

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
        path: '/recovery-confirm',
        name: 'RecoveryConfirm',
        component: RecoveryConfirm,
    },
    {
        path: '/exercises/findTranslation',
        name: 'FindTranslation',
        component: FindTranslation,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    const publicPages = ['Login', 'Register', 'Recovery', 'RecoveryConfirm'];
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
