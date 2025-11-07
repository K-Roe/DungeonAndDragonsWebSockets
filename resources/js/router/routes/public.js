export default [
    {
        path: '/',
        name: 'home',
        component: () => import('../../pages/Home.vue'),
        meta: { guest: true }
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('../../pages/About.vue')
    },
];
