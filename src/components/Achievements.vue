<template>
    <div>
        <Achievement v-if="show_achievement" :title="current_title" :icon="current_icon" @click.native="show_achievement = false"></Achievement>
        <h2>{{ $t("Achievements") }}</h2>
        <h2 v-if="achievements.length > 0">{{ doneNumber }} / {{ totalNumber }}</h2>
        <h2 v-else>{{ $t('Loading') }}...</h2>

        <div class="achievements-list">
            <div v-for="achievement in achievements"
                :key="'id'+achievement.id"
                class="item"
                @click="achievement.is_done == 1 ? showAchievement(achievement.title, achievement.name) : ''">
                <img :src="achievement.image" alt="">
                <div class="title">
                    {{ achievement.title }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Achievement from './Achievement';
import { mapGetters } from 'vuex';

export default {
    components: { Achievement },
    computed: {
        ...mapGetters(["getUser"]),
        totalNumber: function() {
            return this.achievements.length;
        },
        doneNumber: function() {
            return this.achievements.filter(el => el.is_done == 1).length;
        },
    },
    data() {
        return {
            achievements: [],
            total_number: 0,
            done_number: 0,
            show_achievement: false,
            current_title: '',
            current_icon: '',
        }
    },
    methods: {
        showAchievement: function(title, name) {
            this.current_title = title;
            this.current_icon = name;
            this.show_achievement = true;
        }
    },
    async created() {
        const res = await fetch(process.env.API_URL + '/?action=get_achievements&lang=' + this.getLang + '&session_id=' + this.getUser.session_id);
        const data = await res.json();

        data.map((val) => {
            var img;
            console.log('done:',val.is_done);
            try {
                img = require('../assets/achievements/' + val.name + (val.is_done == 1 ? '_done' : '') + '.png');
            }
            catch (e) {
                img = require('../assets/achievements/default.png');
            }
            return val['image'] = img;
        });

        this.achievements = data;
    }
}
</script>

<style lang="scss" scoped>

.achievements-list {
    display: flex;
    flex-flow: wrap;
}

.item {
    width: 33%;
    text-align:center;
    padding: 20px 10px;
    box-sizing: border-box;

    img {
        width:100%;
    }

    .title {
        margin-top: 10px;
        border: 2px solid #787878;
        padding: 8px 10px;
        border-radius: 14px;
        color: #333;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;
    }
}
</style>
