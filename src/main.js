import Vue from 'vue';
import store from './store';
import Router from 'vue-router';
import i18n from './i18n';
import GAuth from 'vue-google-oauth2';
import VueAnalytics from 'vue-analytics';
import App from './App.vue';
import Chapters from './components/Chapters.vue';
import Chapter from './components/Chapter.vue';
import LoginForm from './components/LoginForm.vue';
import RegistrationForm from './components/RegistrationForm.vue';
import Achievements from './components/Achievements.vue';
import Users from './components/Users.vue';
import About from './components/About.vue';

Vue.use(Router);
Vue.use(GAuth, {
    clientId: '728597747623-97ccjeq1dkh69ntpe8fi43hjto5274d7.apps.googleusercontent.com',
});

const router = new Router({
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    },
    routes: [
        {
            path: '/',
            name: 'chapters',
            component: Chapters,
        },
        {
            path: '/chapters/:id',
            name: 'chapter',
            component: Chapter,
            props: true,
        },
        {
            path: '/login',
            name: 'login',
            component: LoginForm,
        },
        {
            path: '/registration',
            name: 'registration',
            component: RegistrationForm,
        },
        {
            path: '/achievements',
            name: 'achievements',
            component: Achievements,
        },
        {
            path: '/users',
            name: 'users',
            component: Users,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        }
    ]
});

Vue.use(VueAnalytics, {
    id: "UA-9891041-15",
    router
});

new Vue({
    store,
    i18n,
    el: '#app',
    render: h => h(App),
    router
});
