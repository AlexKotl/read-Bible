<template>
    <div>
        <h2>Оглавление</h2>
        <div v-for="(chapters, book) in getChapters" :key="book">
            {{ book }}
            <div>
                <router-link
                    v-for="chapter in chapters"
                    :key="chapter.id"
                    :class="{'green': chapter.is_read, 'button': true}"
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

export default {
    computed: mapGetters(["getChapters"]),
    methods: mapActions(["fetchChapters"]),
}
</script>

<style lang="scss">

</style>