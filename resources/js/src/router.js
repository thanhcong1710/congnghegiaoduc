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
          redirect: '/dashboard/analytics'
        },
        {
          path: '/law/list',
          name: 'law-list',
          component: () => import('./views/law/list.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Danh sách luật sư', active: true }
            ],
            pageTitle: 'Danh sách luật sư',
            rule: 'editor'
          }
        },
        {
          path: '/law/item/:item_id',
          name: 'law-item-detail-view',
          component: () => import('./views/law/ItemDetailView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Danh sách luật sư', url: {name: 'law-list'} },
              { title: 'Thông tin chi tiết', active: true }
            ],
            parent: 'law-item-detail-view',
            pageTitle: 'Thông tin chiết',
            rule: 'editor'
          }
        },
        {
          path: '/law/checkout',
          name: 'law-checkout',
          component: () => import('./views/law/Checkout.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Danh sách luật sư', url: {name: 'law-list'} },
              { title: 'Giỏ hàng', active: true }
            ],
            pageTitle: 'Giỏ hàng',
            rule: 'editor'
          }
        },
        {
          path: '/user/wish-list',
          name: 'user-wish-list',
          component: () => import('./views/users/WishList.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', url:'/user/profile'},
              { title: 'Ưa thích', active: true }
            ],
            pageTitle: 'Ưa thích',
            rule: 'editor'
          }
        },
        {
          path: '/user/profile',
          name: 'user-profile',
          component: () => import('@/views/users/UserSettings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', active: true }
            ],
            pageTitle: 'Tài khoản',
            rule: 'editor'
          }
        },

        {
          path: '/user/payments',
          name: 'user-payments',
          component: () => import('@/views/users/PaymentListView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', url:'/user/profile'},
              { title: 'Thanh toán', active: true }
            ],
            pageTitle: 'Thanh toán',
            rule: 'editor'
          }
        },

        {
          path: '/user/products',
          name: 'user-products',
          component: () => import('@/views/users/ProductList.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', url:'/user/profile'},
              { title: 'Sản phẩm', active: true }
            ],
            pageTitle: 'Sản phẩm',
            rule: 'editor'
          }
        },

        {
          path: '/user/calendar',
          name: 'user-calendar',
          component: () => import('@/views/users/Calendar.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tài khoản', url:'/user/profile'},
              { title: 'Đặt lịch', active: true }
            ],
            pageTitle: 'Đặt lịch',
            rule: 'editor'
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
    if (!(auth.isAuthenticated() || firebaseCurrentUser)) {
      router.push({ path: '/pages/login', query: { to: to.path } })
    }
  }

  return next()
})

export default router
