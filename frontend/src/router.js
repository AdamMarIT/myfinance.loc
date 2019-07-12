import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Registration from './views/Registration.vue'
import Dashboard from './views/Dashboard.vue'
import MainLayout from './views/MainLayout.vue'
import Profile from './views/Profile.vue'
import Report from './views/Report.vue'

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

let reportMenu = {
  path: '/report',
      name: 'report',
      component: MainLayout,
      redirect: '/report/month',
      children: [
        {
          path: 'month',
          name: 'reportMain',
          component: Report
        },

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
    dashboardMenu,   
    reportMenu,
    {
      path: '*', 
      redirect: '/dashboard/main'
    }
  ]
})
