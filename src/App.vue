<template>
    <div id="app">
        <div class="login-action">
            <router-link :to="{ name: 'login' }">Вход</router-link>
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
import axios from 'axios'

export default {
    name: 'app',
    data() {
        return {
            msg: 'Библия',
        }
    },

    created() {

    },

    methods: {
        getAllPosts() {
            axios.get(this.endpoint).then(response => {
                this.posts = response.data;
            }).catch(error => {
                console.error(error);
            })
        }
    },
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
}
</style>
