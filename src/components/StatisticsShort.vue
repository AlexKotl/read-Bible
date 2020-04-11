<template>
    <div>
        <div class="left">
            <PieChart :chart-data="datacollection"></PieChart>
        </div>
        <div class="right">
            Прочитано:
            <div class='number'>
                {{ this.totalPercents }}%
            </div>
            Прочитано глав:
            <div class='number'>
                {{ this.stats.read_chapters }}/{{ this.stats.total_chapters }}
            </div>
            Наши пользователи прочитали глав:
            <div class='number'>
                {{ this.stats.total_users_chapters }} ({{ this.stats.total_users }})
            </div>
        </div>
        <br style="clear:both">
    </div>
</template>

<script>
import PieChart from './charts/PieChart.vue';
import { mapGetters } from 'vuex';
export default {
    components: { PieChart },
    data () {
        return {
            datacollection: null,
            stats: {}
        }
    },
    computed: {
        ...mapGetters(["getUser"]),
        totalPercents: function() {
            return Math.round(this.stats.read_chars / (this.stats.total_chars) * 1000)/10;
        }
    },
    methods: {
        test() {
            console.log(this.getUser.session_id)
        }
    },
    async created() {
        console.log(this.getUser)
        if (this.getUser.session_id === undefined) {
            console.log('no user session')
            return;
        }

        const res = await fetch(process.env.API_URL + "/?action=statistics&session_id=" + this.getUser.session_id);
        this.stats = await res.json();

        this.datacollection = {
            labels: ['Прочитано', 'Не прочитано'],
            legend: { display: false },
            datasets: [{
                backgroundColor: ['#5da85d', '#ebe293'],
                data: [this.stats.read_chapters, this.stats.total_chapters]
            }]
        }
    }
}
</script>

<style lang="scss" scoped>
.left {
    float:left;
    width:40%
}
.right {
    float:right;
    width:60%;
    text-align: center;
    font-size:12px;

    .number {
        font-size: 26px;
        margin-bottom: 10px;
    }
}
</style>
