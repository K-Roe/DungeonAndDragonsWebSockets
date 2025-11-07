import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPersistedstate from 'pinia-plugin-persistedstate';
import App from './App.vue';
import router from './router';
import axios from 'axios';
import { useAuthStore } from './stores/auth';
import '../css/app.css';
import './bootstrap';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = import.meta.env.VITE_APP_URL || '';

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);
pinia.use(piniaPersistedstate);

const init = async () => {
    const authStore = useAuthStore();
    await authStore.fetchUser();
    app.mount('#app');
};

init();
