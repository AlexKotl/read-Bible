<template>
    <div>

        <div class="left">
            <PieChart :chart-data="pieChartData"></PieChart>
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
        <div>
            <BarChart :chart-data="monthChartData" :options="monthChartOptions" :styles="{height: '160px'}"></BarChart>
        </div>
    </div>
</template>

<script>
import PieChart from './charts/PieChart.vue';
import BarChart from './charts/BarChart.vue';
import { mapGetters } from 'vuex';
export default {
    components: { PieChart, BarChart },
    data () {
        return {
            pieChartData: null,
            monthChartData: null,
            stats: {},
            monthChartTooltip: {},
            monthChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes:[{
                        display: false,
                        ticks: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            display: false,
                            beginAtZero: true
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: (t, d) => {
                            const chapters = this.monthChartTooltip[t.label];
                            return 'Глав прочитано: ' + chapters;
                        }
                    }
                }
            }
        }
    },
    computed: {
        ...mapGetters(["getUser"]),
        totalPercents: function() {
            return Math.round(this.stats.read_chars / (this.stats.total_chars) * 1000)/10;
        }
    },
    methods: {

    },
    async created() {
        console.log(this.getUser)
        if (this.getUser.session_id === undefined) {
            console.log('no user session')
            return;
        }

        const res = await fetch(process.env.API_URL + "/?action=statistics&session_id=" + this.getUser.session_id);
        this.stats = await res.json();

        this.pieChartData = {
            labels: ['Прочитано', 'Не прочитано'],
            datasets: [{
                backgroundColor: ['#5da85d', '#ebe293'],
                data: [this.stats.read_chapters, this.stats.total_chapters]
            }]
        }

        // format month chart
        let monthData = [];
        let labels = [];
        for (let i=30; i>=0; i--) {
            const date = new Date(new Date() - 60*60*24*1000 * i).toISOString().substr(0, 10);
            const dayData = this.stats.by_month[date] !== undefined ? this.stats.by_month[date].chars : 0;
            monthData.push(dayData);
            labels.push(date);
            this.monthChartTooltip[date] = this.stats.by_month[date] !== undefined ? this.stats.by_month[date].chapters : 0;
        }
        console.log(this.monthChartTooltip);
        this.monthChartData = {
            labels: labels,
            datasets: [{
                label: 'Дневной прогресс чтения',
                backgroundColor: '#5ba1c3',
                data: monthData
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
