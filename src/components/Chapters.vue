<template>
    <div>
        <StatisticsShort  :disabled="!getUser.session_id"></StatisticsShort>

        <h2>{{ $t("Index") }}</h2>
        <div v-for="(chapters, book) in getChapters" :key="book">
            <b>{{ book }}</b>
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
import StatisticsShort from './StatisticsShort.vue';

export default {
    computed: mapGetters(["getChapters", "getUser"]),
    methods: mapActions(["fetchChapters"]),
    components: { StatisticsShort },
}
</script>

<style lang="scss" scoped>
#app.dark .greetings-window {
    color: black;
}
</style>