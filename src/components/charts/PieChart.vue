<script>
import { Pie, mixins } from 'vue-chartjs';

export default {
    extends: Pie,
    mixins: [mixins.reactiveProp],
    props: ['options'],
    mounted () {
        this.renderChart(this.chartdata, this.options);
    }
}
</script>
