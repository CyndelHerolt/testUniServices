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
  const loggedIn = localStorage.getItem('token');

  if (!loggedIn && !PUBLIC_PAGES.includes(to.name)) {
    return next('/login');
  }

  next();
});

export default router
