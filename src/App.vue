<template>
    <div id="app">
        <h1>{{ msg }}</h1>

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
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}

a {
  color: #42b983;
}
</style>
