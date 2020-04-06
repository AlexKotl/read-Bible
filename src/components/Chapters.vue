<template>
    <div>
        <h2>Оглавление</h2>
        <div v-for="(chapters, book) in getChapters" :key="book">
            {{ book }}
            <div>
                <router-link
                    v-for="chapter in chapters"
                    :key="chapter.id"
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
import { mapGetters, mapActions } from "vuex";
import axios from 'axios';

export default {
    data() {
        return {
            message: ""
        }
    },

    computed: mapGetters(["getChapters"]),
    methods: mapActions(["fetchChapters"]),

    async mounted() {
        if (this.getChapters.length == 0) {
            this.fetchChapters();
        }
    }
}
</script>

<style lang="scss">

</style>