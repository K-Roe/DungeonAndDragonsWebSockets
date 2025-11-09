import axios from 'axios'
window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

import {configureEcho, echo} from '@laravel/echo-vue'

configureEcho({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? '127.0.0.1',
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: `${window.location.origin}/broadcasting/auth`,
    withCredentials: true,
    namespace: false

})
window.Echo = echo()
console.log('🔌 Echo configured')
