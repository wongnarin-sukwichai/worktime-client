import { createRouter, createWebHistory } from "vue-router";

import Welcome from "../components/Welcome.vue";
import Checkout from "../components/Checkout.vue";
import Otin from "../components/Otin.vue";
import Otout from "../components/Otout.vue";

import store from "../store";

const routes = [
    {
        path: "/",
        name: "welcome",
        component: Welcome,
    },
    {
        path: "/checkout",
        name: "checkout",
        component: Checkout,
    },
    {
        path: "/otin",
        name: "otin",
        component: Otin,
    },
    {
        path: "/otout",
        name: "otout",
        component: Otout,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (store.getters.user) {
        if (to.matched.some((route) => route.meta.guard === "guest"))
            next({ name: "home" });
        else next();
    } else {
        if (to.matched.some((route) => route.meta.guard === "auth"))
            next({ name: "login" });
        else next();
    }
});

export default router;
