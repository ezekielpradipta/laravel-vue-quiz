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
import BaseButton from "./views/components/Base/BaseButton.vue";
import BaseLink from "./views/components/Base/BaseLink.vue";
import BaseInput from "./views/components/Base/BaseInput.vue";
import BaseLabel from "./views/components/Base/BaseLabel.vue";
import FormError from "./views/components/Base/FormError.vue";
import BaseCheckbox from "./views/components/Base/BaseCheckbox.vue";
import BreadCrumb from "./views/components/BreadCrumb.vue";
import PerfectScrollbar from "vue3-perfect-scrollbar";
import "vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import ParentTransition from "./views/layouts/Transitions/ParentTransition.vue";
import ChildTransition from "./views/layouts/Transitions/ChildTransition.vue";
import AuthHeader from "./views/layouts/Partials/AuthHeader.vue";
import VueCountdown from "@chenfengyuan/vue-countdown";
createApp(App)
    .component("BaseCard", BaseCard)
    .component("BaseBtn", BaseBtn)
    .component("BaseButton", BaseButton)
    .component("BaseLink", BaseLink)
    .component("BaseInput", BaseInput)
    .component("BaseLabel", BaseLabel)
    .component("FormError", FormError)
    .component("BaseCheckbox", BaseCheckbox)
    .component("BreadCrumb", BreadCrumb)
    .component("ParentTransition", ParentTransition)
    .component("ChildTransition", ChildTransition)
    .component("AuthHeader", AuthHeader)
    .component(VueCountdown.name, VueCountdown)
    .use(router)
    .use(store)
    .use(PerfectScrollbar)
    .use(VueSweetalert2)
    .mount("#app");
