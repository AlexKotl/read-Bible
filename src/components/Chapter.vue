<template>
    <div>
        <h2>Глава</h2>
        <router-link :to="{ name: 'chapters' }">К оглавлению</router-link>

        <p v-for="verse in verses" :key="'num' + verse.number" class="verse">
            <sup>{{ verse.number }}</sup>
            <span v-html="verse.text"></span>
        </p>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: ['id'],
    data() {
        return {
            verses: []
        }
    },
    created() {
        axios('http://bible-api/?action=chapter&id=' + this.id).then(response => {
            this.verses = response.data;
        })
        .catch( error => {
            console.error(error);
        })
    },
    // watch: {
    //     '$route'() {
    //         this.getPost(this.id); // update content ...
    //     }
    // }
}
</script>

<style lang="scss">
.verse {
    text-align: justify;

    sup {
        color: #bbb;
        font-size: 9px;
    }
}
</style>