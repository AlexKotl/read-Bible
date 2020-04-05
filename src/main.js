import Vue from 'vue'
import Router from 'vue-router'
import App from './App.vue'
import Chapters from './components/Chapters.vue'
import Chapter from './components/Chapter.vue'

Vue.use(Router)

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
    }]
})

new Vue({
    el: '#app',
    render: h => h(App),
    router
})
