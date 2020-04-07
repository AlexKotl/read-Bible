<template>
    <div>
        <h2>Глава</h2>
        <router-link :to="{ name: 'chapters' }">К оглавлению</router-link>

        <p v-for="verse in verses" :key="'num' + verse.number" class="verse">
            <sup>{{ verse.number }}</sup>
            <span v-html="verse.text"></span>
        </p>

        <br/>
        <div class="chapter-footer">
            <button class="button green" @click="markRead">
                Отменить главу прочитанной
            </button>
            <br/><small>После прочтения главы не забудьте нажать эту кнопку</small>
        </div>
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
    methods: {
        markRead() {
            console.log('read');
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
.chapter-footer {
    text-align: center;
    .button {
        line-height: 46px;
        padding: 0 20px;
    }
}

</style>