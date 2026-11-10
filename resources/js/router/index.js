import { createRouter, createWebHistory } from 'vue-router';
import PortfolioView from '../views/PortfolioView.vue';

const routes = [
  {
    path: '/',
    name: 'portfolio',
    component: PortfolioView,
  },
  {
    path: '/admin/:pathMatch(.*)*',
    beforeEnter(to) {
      window.location.href = to.fullPath;
    },
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 };
  },
});

export default router;
