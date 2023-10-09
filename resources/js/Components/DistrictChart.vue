<template>
    <q-card flat>
        <div class="text-lg text-weight-medium">Chart of Trade</div>
        <DoughnutChart ref="doughnutRef" :chartData="testData" :options="options" />
        <button @click="shuffleData">Shuffle</button>
    </q-card>
</template>

<script>
import { computed, defineComponent, ref } from 'vue';
import { DoughnutChart } from 'vue-chart-3';

export default defineComponent({
    name: 'DistrictChart',
    components: { DoughnutChart },
    setup() {
        const data = ref([30, 40, 60, 70, 5]);
        const doughnutRef = ref();

        const options = ref({
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Doughnut Chart',
                },
            },
        });

        const testData = computed(() => ({
            labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
            datasets: [
                {
                    data: data.value,
                    backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
                },
            ],
        }));

        function shuffleData() {
        }

        return { testData, shuffleData, doughnutRef, options };
    },
});
</script>
