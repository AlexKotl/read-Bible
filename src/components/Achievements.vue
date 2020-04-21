<template>
    <div>
        <Achievement v-if="show_achievement" :title="current_title" :icon="current_icon" @click.native="show_achievement = false"></Achievement>
        <h2>{{ $t("Achievements") }}</h2>
        <h2>{{ done_number }} / {{ total_number }}</h2>


        <div v-for="achievement in achievements" :key="'id'+achievement.id" class="item" :class="{disabled: achievement.is_done == 0}" @click="showAchievement(achievement.title)">
            <img :src="achievement.image" alt="">
            <div class="title">
                {{ achievement.title }}
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
        showAchievement: function(title) {
            this.current_title = title;
            this.show_achievement = true;
        }
    },
    async created() {
        const res = await fetch(process.env.API_URL + '/?action=get_achievements&lang=' + this.getLang + '&session_id=' + this.getUser.session_id);
        const data = await res.json();

        data.map((val) => {
            var img;
            try {
                img = require('../assets/' + val.name + '.png')
            }
            catch (e) {
                img = require('../assets/achievements/default.png')
            }
            return val['image'] = img;
        });

        this.achievements = data;
    }
}
</script>

<style lang="scss" scoped>
.item {
    width: 33%;
    float:left;
    text-align:center;
    padding: 20px 10px;
    box-sizing: border-box;

    img {
        width:70%;
    }

    .title {
        margin-top: 10px;
        background-color: #525252;
        padding: 5px 10px;
        border-radius: 14px;
        color: white;
        font-weight: bold;
    }

    &.disabled {
        img {
            filter: grayscale(1);
        }
    }
}
</style>
