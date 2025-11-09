export default [
    {
        path: '/create-character',
        name: 'createCharacter',
        component: () => import('../../pages/Character/CreateCharacter.vue'),
        meta: {requiresAuth: true}
    }
]
