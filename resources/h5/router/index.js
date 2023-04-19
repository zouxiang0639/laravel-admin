import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export const constantRoutes = [

  {
    path: '/login',
    component: () => import('@h5/views/login/index'),
  },
  {
    path: '/404',
    component: () => import('@/views/error-page/404'),
  },
  {
    path: '/401',
    component: () => import('@/views/error-page/401'),
  },
]

/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
export const asyncRoutes = [



  // 404 page must be placed at the end !!!
  { path: '*', redirect: '/404', hidden: true }
]

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
