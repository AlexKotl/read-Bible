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
import { mapGetters, mapMutations, mapActions } from 'vuex';
export default {
    props: ['id'],
    data() {
        return {
            verses: [],
            is_read: false
        }
    },
    methods: {
        ...mapGetters(["getUser"]),
        ...mapMutations(["updateChapters"]),
        ...mapActions(["fetchChapters"]),
        async markRead() {
            // redirect unlogged users
            if (this.getUser().session_id === undefined) {
                this.$router.push({ name: 'login'});
            }

            const res = await fetch("http://bible-api/?action=mark_read&" + new URLSearchParams({
                session_id: this.getUser().session_id,
                chapter_id: this.id,
                is_read: 1
            }).toString());

            this.fetchChapters();
        }
    },
    async created() {
        const res = await fetch('http://bible-api/?action=chapter&id=' + this.id);
        this.verses = await res.json();
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