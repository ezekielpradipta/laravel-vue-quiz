import { createApp } from "vue";
import App from "./App.vue";
//CSS
import "./index.css";
import "./assets/scss/global.scss";
import "flowbite";
//
import store from "./store";
import router from "./router";
// COMPONENTS
import BaseCard from "./views/components/Base/BaseCard.vue";
import BaseBtn from "./views/components/Base/BaseBtn.vue";
import BreadCrumb from "./views/components/BreadCrumb.vue";
import PerfectScrollbar from "vue3-perfect-scrollbar";
createApp(App)
    .component("BaseCard", BaseCard)
    .component("BaseBtn", BaseBtn)
    .component("BreadCrumb", BreadCrumb)
    .use(router)
    .use(store)
    .use(PerfectScrollbar)
    .mount("#app");
