import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../views/LoginPage.vue";
import AdminLayouts from "@/layouts/AdminLayouts.vue";
import DashboardView from "@/views/admin/DashboardView.vue";
import EmergencyBloodView from "@/views/admin/EmergencyBloodView.vue";
import DonorReportView from "@/views/admin/DonorReportView.vue";
import SubmissionReportView from "@/views/admin/SubmissionReportView.vue";
import FormView from "@/views/FormView.vue";
import UserLayouts from "@/layouts/UserLayouts.vue";
import HomePage from "../views/HomePage.vue";
import TentangPage from "@/views/TentangPage.vue";
import HistoryPage from "@/views/HistoryPage.vue";
import SubmissionView from "@/views/admin/SubmissionView.vue";
import DonorView from "@/views/admin/DonorView.vue";
import { store } from '@/stores/stores';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "user-layouts",
      component: UserLayouts,
      children: [
        {
          path: "",
          name: "home",
          component: HomePage,
        },
        {
          path: "tentang",
          name: "tentang",
          component: TentangPage,
        },
        {
          path: "permohonan",
          name: "permohonan",
          component: FormView,
        },
        {
          path: "history",
          name: "history",
          component: HistoryPage,
        },
      ],
    },
    {
      path: "/hubungi",
      name: "hubungi",
      component: () => import("../views/HubungiPage.vue"),
    },
    {
      path: "/masuk",
      name: "login",
      component: LoginPage,
    },
    {
      path: "/daftarakun",
      name: "daftarakun",
      component: () => import("../views/RegisterPage.vue"),
    },
    {
      path: "/admin",
      name: "admin",
      component: AdminLayouts,
      meta: { requiresAuth: true, requiresAdmin: true },
      children: [
        {
          path: "dashboard",
          name: "admin-dashboard",
          component: DashboardView,
        },
        {
          path: "darah-darurat",
          name: "darah-darurat",
          component: EmergencyBloodView,
        },
        {
          path: "permohonan-admin",
          name: "permohonan-admin",
          component: SubmissionView,
        },
        {
          path: "donor-admin",
          name: "donor-admin",
          component: DonorView,
        },
        {
          path: "laporan-donor",
          name: "laporan-donor",
          component: DonorReportView,
        },
        {
          path: "laporan-permohonan",
          name: "laporan-permohonan",
          component: SubmissionReportView,
        },
      ],
    },
  ],
});

router.beforeEach((to, from, next) => {

  // 🔐 Belum login
  if (to.meta.requiresAuth && !store.isLoggedIn) {
    return next('/masuk')
  }

  // 🔐 Bukan admin
  if (to.meta.requiresAdmin && store.user.role !== 'admin') {
    return next('/') // atau /403
  }

  next()
})


export default router;
