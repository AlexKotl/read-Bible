import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    actions: {
        async fetchChapters({ commit, getters, dispatch, state }) {
            const res = await fetch('http://bible-api/?action=chapters&session_id=' + state.user.session_id);
            const chapters = await res.json();

            commit('updateChapters', chapters)
        }
    },
    mutations: {
        updateChapters(state, chapters) {
            state.chapters = chapters;
        },
        setUser(state, user) {
            state.user = user;
        },
        updateFontSize(state, font_size) {
            state.font_size = font_size;
        }
    },
    state: {
        chapters: [],
        user: false,
        font_size: 15,
    },
    getters: {
        getChapters(state) {
            return state.chapters;
        },
        getUser(state) {
            return state.user;
        },
        getFontSize(state) {
            return state.font_size;
        }
    }
})