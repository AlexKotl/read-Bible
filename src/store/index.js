import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    actions: {
        async fetchChapters({ commit, getters, dispatch }) {
            const res = await fetch('http://bible-api/?action=chapters');
            const chapters = await res.json();

            commit('updateChapters', chapters)
        }
    },
    mutations: {
        updateChapters(state, chapters) {
            state.chapters = chapters
        }
    },
    state: {
        chapters: []
    },
    getters: {
        getChapters(state) {
            return state.chapters;
        }
    }
})
