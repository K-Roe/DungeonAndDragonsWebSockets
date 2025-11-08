export default [
    {
        path: '/host-adventure',
        name: 'hostAdventure',
        component: () => import('../../pages/game/HostAdventure.vue'),
        meta: { requiresAuth: true }
    },

]
