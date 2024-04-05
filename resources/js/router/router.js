import {createWebHistory,createRouter} from 'vue-router'

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import ForgetPassword from '../components/auth/ForgetPassword.vue';
import ResetPassword from '../components/auth/ResetPassword.vue';
import Dashboard from '../components/views/Dashboard.vue';
import Activation from '../components/auth/Activation.vue';
import Plans from '../components/views/Plans.vue';
import NotFound from '../components/views/NotFound.vue'; // Import your custom 404 component
import TeamMember from '../components/views/TeamMember.vue';
import AllUsers from '../components/views/AllUsers.vue';
import Features from '../components/views/Features.vue';
import Plan_Features from '../components/views/Plan_Features.vue';
import Features_Access from '../components/views/FeatureAccess.vue';
import Transactions from '../components/views/TransactionRecords.vue';
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
        path:'/',
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
        path:'/reset-password/:token',
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
    // AUTH ROUTES END
    {
        path:'/dashboard',
        component:Dashboard,
        meta: {
            title: 'Dashboard',
            requiresAuth: true, // Add this to require authentication for this route
        },
    },
    {
        path:'/team-members',
        component:TeamMember,
        meta: {
            title: 'Team Members',
            requiresAuth: true, // Add this to require authentication for this route
        },
    },

    {
        path:'/plans',
        component:Plans,
        meta: {
            title: 'Plans',
            //requiresAuth: true, // Add this to require authentication for this route
        },
    },
    {
        path:'/all-users',
        component:AllUsers,
    },
    {
        path:'/features',
        component:Features,
    },
    {
        path:'/plan-features',
        component:Plan_Features,
    },
    {
        path:'/features-access',
        component:Features_Access,
    },
    {
        path:'/transaction-records',
        component:Transactions,
    },
     // Wildcard route for undefined routes
    {
        path: '/:catchAll(.*)',
        component: NotFound,
        meta: {
        title: 'Not Found',
        },
    },

]

const router   = createRouter({
    history:createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
  document.title = to.meta.title || 'Subscription Management';

  // Check if the route requires authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Check if the user is authenticated (replace this with your authentication logic)
    const isAuthenticated = localStorage.getItem('token');

    if (!isAuthenticated) {
      // If not authenticated, redirect to the login page
      next('/login');
    } else {
      // If authenticated, proceed to check the subscription status
      try {
        // Make an API call to check subscription status
        const response = await axios.get('/api/check-subcription', {
          headers: {
            Authorization: `Bearer ${isAuthenticated}`,
          },
        });

        if (response.data.has_subscription) {
          // If the user has an active subscription, proceed to the requested route
          next();
        } else {
          // If the user does not have an active subscription, redirect to the plans page or another route
          next('/plans');
        }
      } catch (error) {
        // Handle API call error
        console.error(error);
        // Redirect to an error page or another route as needed
        next('/error');
      }
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

