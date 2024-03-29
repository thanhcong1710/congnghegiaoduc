/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'
import auth from '@/auth/authService'
Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          redirect: '/admin/rooms'
        },
        {
          path: '/admin/dashboard',
          name: 'admin-dashboard',
          component: () => import('./views/DashboardAnalytics.vue'),
          meta: {
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/user/profile',
          name: 'user-profile',
          component: () => import('@/views/users/UserSettings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', active: true }
            ],
            pageTitle: 'Tài khoản',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/rooms',
          name: 'rooms',
          component: () => import('@/views/rooms/list.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Phòng họp', active: true }
            ],
            pageTitle: 'Phòng họp',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/rooms/:id',
          name: 'room-detail-view',
          component: () => import('@/views/rooms/detail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Phòng họp', url: '/' },
              { title: 'Chi tiết', active: true },
            ],
            pageTitle: 'Chi tiết phòng họp',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/records',
          name: 'records',
          component: () => import('@/views/records/list.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Lưu trữ', active: true }
            ],
            pageTitle: 'Lưu trữ',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/upgrade',
          name: 'upgrade',
          component: () => import('@/views/users/upgrade.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Nâng cấp dịch vụ', active: true }
            ],
            pageTitle: 'Nâng cấp dịch vụ',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/user/payments',
          name: 'payments',
          component: () => import('@/views/users/payments.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Lịch sử thanh toán', active: true }
            ],
            pageTitle: 'Lịch sử thanh toán',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/user/payment/:id',
          name: 'payment-detail',
          component: () => import('@/views/users/paymentDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Lịch sử thanh toán', url:'/admin/user/payments' },
              { title: 'Chi tiết thanh toán', active: true }
            ],
            pageTitle: 'Chi tiết thanh toán',
            rule: 'editor',
            authRequired: true
          }
        },

        {
          path: '/admin/grade/:id',
          name: 'grade',
          component: () => import('@/views/quizs/grade.vue'),
          meta: {
            rule: 'editor',
            authRequired: true
          }
        },

        {
          path: '/admin/subject/:id',
          name: 'subject',
          component: () => import('@/views/quizs/subject.vue'),
          meta: {
            rule: 'editor',
            authRequired: true
          }
        },

        {
          path: '/admin/chapter/:id',
          name: 'chapter',
          component: () => import('@/views/quizs/chapter.vue'),
          meta: {
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/topics',
          name: 'topics',
          component: () => import('@/views/quizs/topics.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Chuyên đề', active: true },
            ],
            pageTitle: 'Chuyên đề',
            rule: 'editor',
            authRequired: true
          }
        },
        {
          path: '/admin/tests',
          name: 'tests',
          component: () => import('@/views/tests/list.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Bài kiểm tra', active: true }
            ],
            pageTitle: 'Bài kiểm tra',
            rule: 'editor',
            authRequired: true
          }
        },

        {
          path: '/admin/tests/:id',
          name: 'test-detail-view',
          component: () => import('@/views/tests/detail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Bài kiểm tra', url: '/admin/tests' },
              { title: 'Chi tiết', active: true },
            ],
            pageTitle: 'Chi tiết bài kiểm tra',
            rule: 'editor',
            authRequired: true
          }
        },
        
        // =============================================================================
        // LAW MAIN PAGE LAYOUTS
        // =============================================================================
        
      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/tests/join/:code',
          name: 'test-join',
          component: () => import('@/views/guest/tests/join.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/tests/take/:code',
          name: 'test-take',
          component: () => import('@/views/guest/tests/take.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/rooms/:code',
          name: 'room-join',
          component: () => import('@/views/rooms/join.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/login',
          name: 'page-login',
          component: () => import('@/views/pages/login/Login.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/register',
          name: 'page-register',
          component: () => import('@/views/pages/register/Register.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/active-account',
          name: 'page-active-account',
          component: () => import('@/views/pages/ActiveAccount.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/forgot-password',
          name: 'page-forgot-password',
          component: () => import('@/views/pages/ForgotPassword.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/reset-password',
          name: 'page-reset-password',
          component: () => import('@/views/pages/ResetPassword.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/notify-active/:email',
          name: 'page-notify-active',
          component: () => import('@/views/pages/NotifyActive.vue'),
          meta: {
            rule: 'editor'
          }
        },

        {
          path: '/callback',
          name: 'auth-callback',
          component: () => import('@/views/Callback.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/lock-screen',
          name: 'page-lock-screen',
          component: () => import('@/views/pages/LockScreen.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/comingsoon',
          name: 'page-coming-soon',
          component: () => import('@/views/pages/ComingSoon.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-500',
          name: 'page-error-500',
          component: () => import('@/views/pages/Error500.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/not-authorized',
          name: 'page-not-authorized',
          component: () => import('@/views/pages/NotAuthorized.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/maintenance',
          name: 'page-maintenance',
          component: () => import('@/views/pages/Maintenance.vue'),
          meta: {
            rule: 'editor'
          }
        },
        // =============================================================================
        // LAW FULL PAGE LAYOUTS
        // =============================================================================
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    },
  ]
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

router.beforeEach((to, from, next) => {
  if (to.meta.authRequired) {
    if (!(auth.isAuthenticated())) {
      router.push({ path: '/pages/login', query: { to: to.path } })
    }
  }

  return next()
})

export default router
