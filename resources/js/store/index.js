import { createStore } from "vuex";
import createPersistedstate from "vuex-persistedstate";
import user from "./modules/user";
import checkin from "./modules/checkin";
import upload from "./modules/upload";
import report from "./modules/report";
import edit from "./modules/edit";
import add from "./modules/add";
import timer from "./modules/timer";

const store = createStore({
    plugins: [
        createPersistedstate()
    ],
    modules: {
        user,
        checkin,
        upload,
        report,
        edit,
        add,
        timer,
    },
});

export default store;
