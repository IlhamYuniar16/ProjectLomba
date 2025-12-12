import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '../views/LoginPage.vue'
import AdminLayouts from '@/layouts/AdminLayouts.vue'
import DashboardView from '@/views/admin/DashboardView.vue'
import EmergencyBloodView from '@/views/admin/EmergencyBloodView.vue'
import DonorReportView from '@/views/admin/DonorReportView.vue'
import SubmissionReportView from '@/views/admin/SubmissionReportView.vue'
import FormView from '@/views/FormView.vue'
import UserLayouts from '@/layouts/UserLayouts.vue'
import HomePage from '../views/HomePage.vue'
import TentangPage from '@/views/TentangPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'user-layouts',
      component: UserLayouts,
      children: [
        {
          path: '',
          name: 'home',
          component: HomePage
        },
        {
          path: 'tentang',
          name: 'tentang',
          component: TentangPage
        },
        {
          path: 'permohonan',
          name: 'permohonan',
          component: FormView
        },
      ]
    },
    {
      path: '/',
      name: 'about',
      component: () => import('../views/AboutView.vue'),
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
    {
      path: '/admin',
      name: 'admin',
      component: AdminLayouts,
      children: [
        {
          path: 'dashboard',
          name: 'admin-dashboard',
          component: DashboardView
        },
        {
          path: 'darah-darurat',
          name: 'darah-darurat',
          component: EmergencyBloodView
        },
        {
          path: 'laporan-donor',
          name: 'laporan-donor',
          component: DonorReportView
        },
        {
          path: 'laporan-pengajuan',
          name: 'laporan-pengajuan',
          component: SubmissionReportView
        },
      ]
    }
  ],
})

export default router
