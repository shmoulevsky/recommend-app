import { createApp } from 'vue';
import router from "./router.js";
import App from './components/App.vue';

createApp(App)
    .use(router)
    .mount('#app')
