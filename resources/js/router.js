import { createRouter, createWebHistory } from 'vue-router';

import store from './vuex-store';

import Error404 from './pages/Error404.vue';
import Index from './pages/Index.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import User from './pages/User.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: Index,
        },
        {
            path: '/login',
            component: Login,
            meta: { unauthorized: true },
        },
        {
            path: '/register',
            component: Register,
            meta: { unauthorized: true },
        },
        {
            path: '/@:user',
            component: User,
        },
        // This route must be last:
        {
            path: '/:pathMatch(.*)*',
            name: '404',
            component: Error404,
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { left: 0, top: 0 };
        }
    },
});

// Before entering routes, check authentication requirements
router.beforeEach((to, from) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.user) {
            return {
                path: '/login',
                query: { redirect: to.fullPath },
            };
        }
    } else if (to.matched.some(record => record.meta.unauthorized)) {
        if (store.state.user) {
            return {
                path: '/',
            };
        }
    }
});

export default router;
