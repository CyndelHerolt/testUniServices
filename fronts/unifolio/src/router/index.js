import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TracesView from '../views/TracesView.vue'
import PortfoliosView from '../views/PortfoliosView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },{
      path: '/traces',
      name: 'traces',
      component: TracesView
    },{
      path: '/portfolios',
      name: 'portfolios',
      component: PortfoliosView
    },
  ]
})

export default router
