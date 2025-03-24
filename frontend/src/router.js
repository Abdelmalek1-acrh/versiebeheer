import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/login.vue';
import Dashboard from './components/dashboard.vue';

const routes = [
  { path: '/', component: Login },
  { path: '/dashboard', component: Dashboard }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
