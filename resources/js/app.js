import axios from 'axios';
import { createApp } from 'vue';
import router from './router';
import store from './vuex-store';

// Make basic libraries accessible globally
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set user in store
const el = document.querySelector('#userData');
if (el) {
    const user = JSON.parse(el.innerHTML);
    store.commit('setUser', user);
}

// Initialize app
const app = createApp();
app.use(router);
app.use(store);
app.mount('#app');
