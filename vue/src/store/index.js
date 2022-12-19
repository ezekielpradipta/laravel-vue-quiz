import { createStore } from "vuex";

import largeSidebar from "./modules/largeSidebar";
import darkMode from "./modules/darkMode";
const store = createStore({
    state: {},
    getters: {},
    actions: {},
    mutations: {},
    modules: { largeSidebar, darkMode },
});
export default store;
