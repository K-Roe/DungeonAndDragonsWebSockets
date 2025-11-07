export default [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('../../pages/dashboard/Dashboard.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/profile',
        name: 'profile',
        component: () => import('../../pages/dashboard/Profile.vue'),
        meta: { requiresAuth: true }
    },
];
