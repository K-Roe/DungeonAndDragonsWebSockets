export default [
    {
        path: '/host-adventure',
        name: 'hostAdventure',
        component: () => import('../../pages/game/HostAdventure.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/game/:id',
        name: 'gameRoom',
        component: () => import('../../pages/game/GameRoom.vue'),
        meta: { requiresAuth: true }
    },
]
