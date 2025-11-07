export default [
    {
        path: '/login',
        name: 'login',
        component: () => import('../../pages/auth/Login.vue'),
        meta: { guest: true }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../../pages/auth/Register.vue'),
        meta: { guest: true }
    },
    {
        path: '/verify-email',
        name: 'verifyEmail',
        component: () => import('../../pages/auth/VerifyEmail.vue'),
        meta: { guest: true }
    },
    {
        path: '/verify-email-success',
        name: 'VerifyEmailSuccess',
        component: () => import('../../pages/auth/EmailVerified.vue')
    },
    {
        path: '/email-verification-failed',
        name: 'EmailVerificationFailed',
        component: () => import('../../pages/auth/EmailVerificationFailed.vue')
    }
];
