<template>
    <div>
        <Achievement v-if="showAchievement" @click.native="hideAchievement" :title="achievement.title" :icon="achievement.name"></Achievement>

        <h2>{{ chapter.book_name }}</h2>

        <Skeleton v-if="verses.length == 0"/>
        <h3 v-else>
            {{ $t('Chapter') }} {{ chapter.number }}
        </h3>

        <div style="float:right">
            <a @click="zoomOut" class="button">	&#8722;</a>
            <a @click="zoomIn" class="button">+</a>
        </div>
        <router-link :to="{ name: 'chapters' }">{{ $t('ToIndex') }}</router-link>

        <div v-if="verses.length == 0">
            <Skeleton v-for="i in new Array(5)"
                :count="Math.random() * (4 - 1) + 1"
                :key="'skeleton'+i"
                style="margin-top: 10px; display: block;"/>
        </div>

        <div :style="{ 'font-size': getFontSize + 'px' }">
            <p v-for="verse in verses" :key="'num' + verse.number" class="verse">
                <sup>{{ verse.number }}</sup>
                <span v-html="verse.text"></span>
            </p>
        </div>

        <br/>
        <div class="chapter-footer">
            <div v-if="!getUser.session_id">
                <router-link :to="{ name: 'login' }" class="button disabled">{{ $t('MarkChapterAsRead') }} {{getUser.session_id}}</router-link>
                <br/><small>{{ $t('YouNeed') }} <router-link :to="{ name: 'login' }">{{ $t('authorize') }}</router-link>, {{ $t('toMarkChapterAsRead') }}</small>
            </div>
            <div v-else-if="isRead">
                <button class="button green" @click="markRead">
                    &#10004; &nbsp; {{ $t('ChapterAlreadyRead') }}
                </button>
                <br/><small>{{ $t('PressAgainToMarkAsRead') }}</small>
            </div>
            <div v-else>
                <button class="button green" @click="markRead">
                    {{ $t('MarkAsRead') }}
                </button>
                <br/><small>{{ $t('AfterReadPressButton') }}</small>
            </div>

            <br/><br/>
            <router-link :to="{ name: 'chapter', params: { id: chapter.prev_id } }" v-if="chapter.prev_id">
                &laquo; {{ $t('Previous') }}
            </router-link>
            <router-link :to="{ name: 'chapters' }" style="font-size: 30px; margin: 0 20px; text-decoration:none">
                &#8962;
            </router-link>
            <router-link :to="{ name: 'chapter', params: { id: chapter.next_id } }" v-if="chapter.next_id">
                {{ $t('Next') }} &raquo;
            </router-link>

        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex';
import Achievement from './Achievement';
import { Skeleton } from 'vue-loading-skeleton';

export default {
    props: ['id'],
    components: { Achievement, Skeleton },
    data() {
        return {
            verses: [],
            chapter: {},
            currentLang: this.getLang,
            showAchievement: false,
            achievement: {}
        }
    },
    computed: {
        ...mapGetters(["getUser", "getChapters", "getReadStatus", "getFontSize", "getLang"]),
        isRead() {
            let is_read = false;
            Object.values(this.getChapters).forEach((book) => {
                let found = book.find( (chapter) => chapter.id == this.id && chapter.is_read == 1 );
                if (found !== undefined) {
                    is_read = true;
                }
            });
            return is_read;
        }
    },
    methods: {
        ...mapActions(["fetchChapters"]),
        ...mapMutations(["updateFontSize"]),
        async getChapter(id) {
            const res = await fetch(process.env.API_URL + '/?action=chapter&id=' + this.id + '&lang=' + this.getLang);
            const data = await res.json();
            this.verses = data.verses;
            this.chapter = data.chapter;

            let is_read = false;
            Object.values(this.getChapters).forEach((book) => {
                let found = book.find( (chapter) => chapter.id == this.id && chapter.is_read == "1" );
                if (found !== undefined) {
                    is_read = true;
                }
            });
        },
        async markRead() {
            // redirect unlogged users
            if (this.getUser.session_id === undefined) {
                this.$router.push({ name: 'login'});
            }

            const res = await fetch(process.env.API_URL + "/?action=mark_read&" + new URLSearchParams({
                session_id: this.getUser.session_id,
                chapter_id: this.id,
                is_read: this.isRead ? 0 : 1
            }).toString());
            const data = await res.json();

            if (data.achievements) {
                this.achievement = data.achievements[0];
                this.showAchievement = true;
            }


            this.fetchChapters();
        },
        zoomOut() {
            return this.updateFontSize(this.getFontSize - 1);
        },
        zoomIn() {
            return this.updateFontSize(this.getFontSize + 1);
        },
        hideAchievement() {
            this.showAchievement = false;
        }
    },
    created() {

        this.getChapter(this.id);

        // watch for lang change to update chapter
        this.$store.watch(
            (state, getters) => this.$store.state.lang,
            (newValue, oldValue) => {
                this.getChapter(this.id);
            },
        );
    },
    watch: {
        '$route'() {
            this.verses = [];
            this.getChapter(this.id);
        }
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