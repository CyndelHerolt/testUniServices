import { createRouter, createWebHistory } from 'vue-router'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import TestView from '../views/TestView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/test',
      name: 'test',
      component: TestView
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
