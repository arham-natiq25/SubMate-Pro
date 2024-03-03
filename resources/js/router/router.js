import {createWebHistory,createRouter} from 'vue-router'

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import ForgetPassword from '../components/auth/ForgetPassword.vue';
import ResetPassword from '../components/auth/ResetPassword.vue';

const routes = [

    // AUTH ROUTES
    {
        path:'/login',
        component:Login,
        meta: {
            title: 'Login',
        },
    },
    {
        path:'/register',
        component:Register,
        meta: {
            title: 'Register',
        },
    },
    {
        path:'/forget-password',
        component:ForgetPassword,
        meta: {
            title: 'Forget Password',
        },
    },
    {
        path:'/reset-password/token',
        component:ResetPassword,
        meta: {
            title: 'Reset Password',
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
    next();
  });



export default router;

