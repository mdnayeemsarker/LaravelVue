import { createWebHistory, createRouter } from "vue-router";
import { useStore } from 'vuex';
import home from './pages/home.vue'
import login from './pages/login.vue'
import register from './pages/register.vue'
import dashboard from './pages/dashboard.vue'
import quize from './pages/quize.vue'
import q_create from './pages/q-create.vue'
import store from "./store";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: home,
    },
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta:{ requiresAuth:false},
    },
    {
        path: '/register',
        name: 'Register',
        component: register,
        meta:{ requiresAuth:false},
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: dashboard,
        meta:{ requiresAuth:true},
    },
    {
        path: '/quize',
        name: 'Quize',
        component: quize,
        meta:{ requiresAuth:true},
    },
    {
        path: '/add-quize',
        name: 'Add-Quize',
        component: q_create,
        meta:{ requiresAuth:true},
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && store.getters.getToken == 0) {
        return {name: 'Login'}
    }
    if (to.meta.requiresAuth == false && store.getters.getToken != 0) {
        return {name: 'Dashboard'}
    }
})

export default router;