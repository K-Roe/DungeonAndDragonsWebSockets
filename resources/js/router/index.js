import { createRouter, createWebHashHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routeModules = import.meta.glob('./routes/*.js', { eager: true });

const routes = Object.values(routeModules).reduce((acc, module) => {
    return [...acc, ...module.default];
}, []);

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    if (authStore.loading) {
        await new Promise(resolve => {
            const unwatch = authStore.$subscribe(() => {
                if (!authStore.loading) {
                    unwatch();
                    resolve();
                }
            });
        });
    }

    if (to.meta.requiresAuth && !authStore.authenticated) {
        next('/login');
    } else if (to.meta.guest && authStore.authenticated) {
        next('/dashboard');
    } else {
        next();
    }
});

export default router;
