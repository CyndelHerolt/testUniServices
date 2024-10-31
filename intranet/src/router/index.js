import { createRouter, createWebHistory } from 'vue-router'
import EdtView from '../views/EdtView.vue'
import EvalView from "@/views/EvalView.vue";
import HomeView from "@/views/HomeView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/eval',
      name: 'eval',
      component: EvalView
    },
    {
      path: '/edt',
      name: 'edt',
      component: EdtView
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
    return window.location.href = 'http://localhost:5173/login';
  }

  const tokenParts = token.split('.');
  const payload = JSON.parse(atob(tokenParts[1]));
  const exp = payload.exp * 1000; // Convert to milliseconds
  if (Date.now() >= exp) {
    localStorage.removeItem('token');
    // renvoyer vers localhost:5173/ et recharger la page
    return window.location.href = 'http://localhost:5173/portail';
  }

  next();
});

export default router
