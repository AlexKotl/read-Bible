<template>
    <div>
        <h2>{{ $t("Achievements") }}</h2>
        <div v-for="achievement in achievements" :key="'id'+achievement.id" class="achievement" :class="{disabled: achievement.is_done == 0}">
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
            achievements: []
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
.achievement {
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
