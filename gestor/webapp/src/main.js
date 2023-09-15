import { createApp } from "vue";
import "./scss/app.scss";
import App from "./App.vue";
import router from "./router/router";

const app = createApp(App);
app.use(router);
app.mount("#app");
