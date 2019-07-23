import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Registration from './views/Registration.vue'
import Dashboard from './views/Dashboard.vue'
import MainLayout from './views/MainLayout.vue'
import Profile from './views/Profile.vue'
import Files from './views/Files.vue'
import ResetPasswordForm from './views/ResetPasswordForm.vue'

Vue.use(Router)

let dashboardMenu = {
  path: '/dashboard',
      name: 'dashboard',
      component: MainLayout,
      redirect: '/dashboard/main',
      children: [
        {
          path: 'main',
          name: 'Main',
          component: Dashboard
        },
        {
          path: 'files',
          name: 'Files',
          component: Files
        },
        {
          path: 'profile',
          name: 'Profile',
          component: Profile
        },
        {
          path: 'logout',
          name: 'Logout',
          component: Profile
        }
      ]  
}


export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/registration',
      name: 'registration',
      component: Registration
    },
    { 
      path: '/reset-password/:token', 
      name: 'reset-password-form', 
      component: ResetPasswordForm,
      props: true 
    },
    dashboardMenu,   

    {
      path: '*', 
      redirect: '/dashboard/main'
    }
  ]
})
