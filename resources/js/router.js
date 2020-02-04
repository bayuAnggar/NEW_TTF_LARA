import VueRouter from 'vue-router'

// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'

// USER PAGE
import Dashboard from './pages/user/Dashboard'
import InputTTF from './pages/user/InputTTF'

// ADMIN PAGE
import AdminDashboard from './pages/admin/Dashboard'


// Routes
const routes = [
  {
    path: '/',
    name: 'home',
    component: Login,
    meta: {
      auth: undefined
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  // USER ROUTES
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true,
      title: 'Inquiry TTF'
    }
  },
  {
    path: '/inputTTF',
    name: 'User.InputTTF',
    component: InputTTF,
    meta: {
      auth: true,
      title: 'Input TTF'
    }
  },
  // ADMIN ROUTES
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: AdminDashboard,
    meta: {
      auth: {roles: 1, redirect: {name: 'login'}, forbiddenRedirect: '/403'},
      title: 'Admin Board'
    }
  },
]

const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let auth = $auth.check()
        if (!auth) {
            next({ name: 'login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
