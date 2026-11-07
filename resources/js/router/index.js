import { createRouter, createWebHistory } from 'vue-router';
import PortfolioView from '../views/PortfolioView.vue';
import LoginView from '../views/admin/LoginView.vue';
import AdminDashboardView from '../views/admin/AdminDashboardView.vue';

const routes = [
  {
    path: '/',
    name: 'portfolio',
    component: PortfolioView,
  },
  {
    path: '/admin/login',
    name: 'admin-login',
    component: LoginView,
  },
  {
    path: '/admin',
    redirect: '/admin/dashboard',
  },
  {
    path: '/admin/:tab?',
    name: 'admin-dashboard',
    component: AdminDashboardView,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 };
  },
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('admin_token');

  if (to.meta.requiresAuth && !token) {
    next({ name: 'admin-login' });
  } else if (to.name === 'admin-login' && token) {
    next({ path: '/admin/dashboard' });
  } else {
    next();
  }
});

export default router;
