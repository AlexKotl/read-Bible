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
            <div v-if="!getUser.session_id">
                <router-link :to="{ name: 'login' }" class="button disabled">Отметить главу прочитанной {{getUser.session_id}}</router-link>
                <br/><small>Необходимо <router-link :to="{ name: 'login' }">авторизироваться</router-link>, чтоб отметить главу как прочитанную</small>
            </div>
            <div v-else-if="isRead">
                <button class="button green" @click="markRead">
                    Глава уже прочитана
                </button>
                <br/><small>Нажмите еще раз чтобы отметить главу как не прочитанную</small>
            </div>
            <div v-else>
                <button class="button green" @click="markRead">
                    Отметить главу прочитанной
                </button>
                <br/><small>После прочтения главы не забудьте нажать эту кнопку</small>
            </div>

        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
export default {
    props: ['id'],
    data() {
        return {
            verses: []
        }
    },
    computed: {
        ...mapGetters(["getUser", "getChapters", "getReadStatus"]),
        isRead() {
            let is_read = false;
            Object.values(this.getChapters).forEach((book) => {
                let found = book.find( (chapter) => chapter.id == this.id && chapter.is_read == "1" );
                if (found !== undefined) {
                    is_read = true;
                }
            });
            return is_read;
        }
    },
    methods: {
        ...mapActions(["fetchChapters"]),
        async markRead() {
            // redirect unlogged users
            if (this.getUser.session_id === undefined) {
                this.$router.push({ name: 'login'});
            }

            const res = await fetch("http://bible-api/?action=mark_read&" + new URLSearchParams({
                session_id: this.getUser.session_id,
                chapter_id: this.id,
                is_read: 1
            }).toString());

            this.fetchChapters();
        }
    },
    async created() {
        const res = await fetch('http://bible-api/?action=chapter&id=' + this.id);
        this.verses = await res.json();

        let is_read = false;
        Object.values(this.getChapters).forEach((book) => {
            let found = book.find( (chapter) => chapter.id == this.id && chapter.is_read == "1" );
            if (found !== undefined) {
                is_read = true;
            }
        });
    }
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