import { createRouter, createWebHistory } from "vue-router";
import LoginForm from "./pages/auth/LoginForm.vue";
import Dashboard from "./pages/Dashboard.vue";
import SiteSetting from "./pages/settings/SettingSite.vue";
import HrSystemSetup from "./pages/settings/HrSystemSetup.vue";
import store from './store/index.js';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/login",
            name: "login",
            component: LoginForm,
        },
        {
            path: "/",
            name: "dashboard",
            redirect: {name: 'home'},
            children: [
                {
                    path: "/home",
                    name: "home",
                    component: Dashboard,
                },
                {
                    path: "/report",
                    name: "report",
                    component: Dashboard,
                },
            ],
        },
        {
            path: "/employee",
            name: "employee",
            component: Dashboard,
        },
        {
            path: "/site-setting",
            name: "site-setting",
            component: SiteSetting,
        },
        {
            path: "/hr-system-setup",
            name: "hr-system-setup",
            component: HrSystemSetup,
        },
    ],
    linkActiveClass: "active",
});

router.beforeEach(async function (to, from) {
    await store.dispatch('getUser');
    const isAuth = store.getters.isAuthenticated;
    if(to.name != 'login' && !isAuth){
        return { name: 'login' };
    }else if(to.name == 'login' && isAuth){
        return { name: '' };
    }
});

export default router;
