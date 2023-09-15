import { createRouter, createWebHashHistory } from "vue-router";
import Home from "../pages/Home.vue";
import List from "../pages/List.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/list/:id", component: List },
];

export const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
