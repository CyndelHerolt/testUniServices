import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
  ]
})

router.beforeEach((to, from, next) => {
  const PUBLIC_PAGES = ['login', 'register'];
  if (PUBLIC_PAGES.includes(to.name)) {
    return next();
  }

  const token = localStorage.getItem('token');
  if (!token) {
    return next('/login');
  }

  const tokenParts = token.split('.');
  const payload = JSON.parse(atob(tokenParts[1]));
  const exp = payload.exp * 1000; // Convert to milliseconds
  if (Date.now() >= exp) {
    localStorage.removeItem('token');
    return next('/login');
  }

  next();
});

export default router
