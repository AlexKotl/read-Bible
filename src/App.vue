<template>
    <div id="app">
        <div class="menu-actions">

            <div v-if="getUser.session_id">
                Привет {{ getUser.user_name }},
                <a @click="logout" href="#">Выйти</a>
            </div>
            <div v-else>
                <router-link :to="{ name: 'login' }">Вход</router-link>
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
import { mapGetters, mapMutations } from "vuex";

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
        logout() {
            delete localStorage.session_id;
            delete localStorage.user_name;
            delete localStorage.user_email;
            this.setUser({});
        }
    },
    mounted() {
        console.log('user', this.getUser);

        if (localStorage.session_id !== undefined) {
            console.log('saving user to store', localStorage.session_id);
            this.setUser({
                session: localStorage.session_id,
                name: localStorage.user_name,
                email: localStorage.user_email
            });
        }
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
    max-width: 500px;
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
    margin: 3px 2px;
    padding: 3px 5px;
    font-weight: bold;
    font-size: 14px;
    min-width: 20px;
    text-align: center;
    display: inline-block;

    &.green {
        background-color: #58a700;
        box-shadow: 0px 3px 0 #78c800;
        color: white;
    }
}

a {
    color: #42b983;
    cursor: pointer;
}
</style>
