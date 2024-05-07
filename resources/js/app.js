import "./bootstrap";

import { createApp } from "vue";
import App from './components/App.vue';

import router from "./router/index"; //ใช้ Vue-route
import store from "./store/index"; //ใช้ Vuex

const app = createApp(App)

app.use(router)
app.use(store)
app.mount('#app')