import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '../views/LoginPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/HomePage.vue'),
    },
    {
      path: '/masuk',
      name: 'login',
      component: LoginPage,
    },
    {
      path: '/daftarakun',
      name: 'daftarakun',
      component: () => import('../views/RegisterPage.vue'),
    },
  ],
})

export default router
