import Vue from 'vue';
import store from './store';
import Router from 'vue-router';
import i18n from './i18n';
import App from './App.vue';
import Chapters from './components/Chapters.vue';
import Chapter from './components/Chapter.vue';
import LoginForm from './components/LoginForm.vue';
import RegistrationForm from './components/RegistrationForm.vue';
import Achievements from './components/Achievements.vue';

Vue.use(Router);

const router = new Router({
    routes: [{
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
    }]
})

new Vue({
    store,
    i18n,
    el: '#app',
    render: h => h(App),
    router
});
