<template>
    <div>
        <h2>Глава</h2>
        <router-link :to="{ name: 'chapters' }">К оглавлению</router-link>

        <p>{{ content }}</p>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: ['id'],
    data() {
        return {
            content: "SUPER!"
        }
    },
    watch: {
        '$route'() {
            // this.getPost(this.id); // update content ...
        }
    }
}
</script>

<style lang="scss">

</style>