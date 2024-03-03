import './bootstrap';

import { createApp } from 'vue';

import router from './router/router'

import App from './App.vue'


createApp(App).use(router).mount("#app")

// const app = createApp({});
// app.component('app',App);

// app.mount("#app");
