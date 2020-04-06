<template>
    <div>
        <h2>Оглавление</h2>
        <div v-for="(chapters, book) in books" :key="book">
            {{ book }}
            <div>
                <router-link
                    v-for="chapter in chapters"
                    :key="chapter.id"
                    active-class="is-active"
                    class="button"
                    :to="{ name: 'chapter', params: { id: chapter.id } }">
                    {{ chapter.number }}
                </router-link>
            </div>
            <br/>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: []
        }
    },

    created() {
        axios('http://bible-api/?action=chapters').then(response => {
            this.books = response.data;
        })
        .catch( error => {
            console.error(error);
        })

    }
}
</script>

<style lang="scss">

</style>