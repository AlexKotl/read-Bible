<template>
    <div id="app">
        <div class="menu-actions">

            <div v-if="getUser.session_id">
                Привет {{ getUser.user_name }},
                <a @click="logout" href="#">Выйти</a>
            </div>
            <div v-else>
                <router-link :to="{ name: 'login' }">Вход</router-link>
                <router-link :to="{ name: 'registration' }">Регистрация</router-link>
            </div>
        </div>

        <router-link :to="{ name: 'chapters' }">
            <h1>Библия</h1>
        </router-link>

        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    name: 'app',
    computed: mapGetters(["getUser"]),
    data() {
        return {
            msg: 'Библия',
        }
    },
    methods: {
        ...mapMutations(['setUser']),
        ...mapActions(["fetchChapters"]),
        logout() {
            delete localStorage.session_id;
            delete localStorage.user_name;
            delete localStorage.user_email;
            this.setUser({});
            this.fetchChapters();
        }
    },
    mounted() {
        if (localStorage.session_id !== undefined) {
            this.setUser({
                session_id: localStorage.session_id,
                user_name: localStorage.user_name,
                user_email: localStorage.user_email
            });
        }

        // load chapters to store
        this.fetchChapters();
    }
}
</script>

<style lang="scss">
#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    margin: 60px auto;
    padding: 0 8px;
    max-width: 500px;
    font-size: 18px;
}

h1, h2 {
    text-align: center;
    color: #2c3e50;
    text-decoration: none;
}

.button {
    background-color: #ebebeb;
    box-shadow: 0px 3px 0 #c2c2c2;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    margin: 4px 3px;
    padding: 4px 7px;
    font-weight: bold;
    font-size: 16px;
    min-width: 20px;
    text-align: center;
    display: inline-block;

    &:hover {
        background-color: #f2f1f1;
    }

    &.green {
        background-color: #58a700;
        box-shadow: 0px 3px 0 #78c800;
        color: white;

        &:hover {
            background-color: #66ba07;
        }
    }

    &.disabled {
        color: #b6b6b6;
    }

}

a {
    color: #42b983;
    cursor: pointer;
}

div {
    box-sizing: border-box;
}

form {
    input[type=text], input[type=password], input[type=email] {
        width: 100%;
        font-size: 1em;
        line-height: 2em;
        margin-bottom: 7px;
        border-radius: 3px;
        border: 1px solid #c7c7c7;
    }
    .button {
        padding: 10px 20px;
    }
}
</style>
