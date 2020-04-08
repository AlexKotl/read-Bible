<template>
    <div>
        <PieChart :chart-data="datacollection"></PieChart>
    </div>
</template>

<script>
import PieChart from './charts/PieChart.vue';
export default {
    components: { PieChart },
    data () {
        return {
            datacollection: null
        }
    },
    mounted() {
        this.datacollection = {
            labels: ['Прочитано', 'Не прочитано'],
            datasets: [{
                backgroundColor: ['#5da85d', '#ebe293'],
                data: [3, 5]
            }]
        }
    }
}
</script>

<style lang="css" scoped>
</style>
