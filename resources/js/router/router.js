import {createWebHistory,createRouter} from 'vue-router'

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import ForgetPassword from '../components/auth/ForgetPassword.vue';
import ResetPassword from '../components/auth/ResetPassword.vue';
import Dashboard from '../components/views/Dashboard.vue';
import Activation from '../components/auth/Activation.vue';

const routes = [

    // AUTH ROUTES
    {
        path:'/login',
        component:Login,
        meta: {
            title: 'Login',
            guest: true,
        },
    },
    {
        path:'/register',
        component:Register,
        meta: {
            title: 'Register',
            guest: true,
        },
    },
    {
        path:'/forget-password',
        component:ForgetPassword,
        meta: {
            title: 'Forget Password',
            guest: true,
        },
    },
    {
        path:'/reset-password/token',
        component:ResetPassword,
        meta: {
            title: 'Reset Password',
            guest: true,
        },
    },
    {
        path:'/activation/:token',
        component:Activation,
        meta: {
            title: 'Activation',
            guest: true,
        },
    },
    {
        path:'/dashboard',
        component:Dashboard,
        meta: {
            title: 'Dashboard',
            requiresAuth: true, // Add this to require authentication for this route
        },
    },

    // AUTH ROUTES END
]

const router   = createRouter({
    history:createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title || 'Subscription Management';

    // Check if the route requires authentication
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // Check if the user is authenticated (replace this with your authentication logic)
      const isAuthenticated = localStorage.getItem('token');

      if (!isAuthenticated) {
        // If not authenticated, redirect to the login page
        next('/login');
      } else {
        // If authenticated, proceed to the requested route
        next();
      }
    } else if (to.matched.some(record => record.meta.guest)) {
      // Check if the route is meant for guests (unauthenticated users)
      const isAuthenticated = localStorage.getItem('token');

      if (isAuthenticated) {
        // If authenticated, redirect to the dashboard
        next('/dashboard');
      } else {
        // If not authenticated, proceed to the requested route
        next();
      }
    } else {
      // If the route does not require authentication or is for guests, proceed
      next();
    }
  });


export default router;

