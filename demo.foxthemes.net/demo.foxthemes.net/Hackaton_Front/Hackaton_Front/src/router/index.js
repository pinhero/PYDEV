import { createRouter, createWebHistory } from 'vue-router'
// import HomeView from '../views/HomeView.vue'
import login1View from '../views/login1View.vue'
import register from '../views/register.vue'
import forgot_password from '../views/forgot_password.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // {
    //   path: '/',
    //   name: 'home',
    //   component: HomeView
    // },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue')
    // },
    {
      path: '/register',
      name: 'register',
      component: () =>
        import('../views/register.vue')
    },
        {
      path: '/login',
      name: 'login',
      component: () =>
        import('../views/login1View.vue')
    },
        {
      path: '/forgot_password',
      name: 'forgot_password',
      component: () =>
        import('../views/forgot_password.vue')
    },
    {
      path: '/',
      name: 'login',
      component: () =>
        import('../views/LoginView.vue')
    },
  ]
})

export default router
