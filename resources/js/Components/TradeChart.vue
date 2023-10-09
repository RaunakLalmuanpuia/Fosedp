<template>
    <q-card flat>
        <div class="text-lg text-weight-medium">Chart of Trade</div>
        <BarChart ref="doughnutRef" :chartData="testData" :options="options" />
    </q-card>
</template>

<script setup>
import {computed, defineComponent, onMounted, ref} from 'vue';
import {BarChart } from 'vue-chart-3';
import useUtils from "@/Compositions/useUtils";

const {randomizeColor} = useUtils();

const data = ref([30, 40, 60, 70, 5]);
const label = ref([]);
const doughnutRef = ref();
const loading = ref(false);

const options = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'right',
        },
        title: {
            display: true,
            text: 'Department Wise Trade Selected',
        },
    },
});

const testData = computed(() => ({
    labels: label.value,
    datasets: [
        {
            data: data.value,
            backgroundColor:label.value.map(item=>randomBg())
        },
    ],
}));
const randomBg=()=>{
    const backgroundColor= [
        'rgba(208,14,53)',
        'rgba(207,126,47)',
        'rgba(255, 205, 86)',
        'rgba(75, 192, 192)',
        'rgba(17,113,177)',
        'rgba(35,19,67)',
        'rgb(165,111,52)',
        'rgb(96,171,50)',
        'rgb(52,119,99)',
        'rgb(41,8,169)',
        'rgb(40,36,45)',
        'rgb(193,184,102)'
    ]
    const index = Math.floor(Math.random() * backgroundColor.length);

    return backgroundColor[index]
}

onMounted(()=>{
    loading.value=true
    axios.get(route('statistic.trade-department'))
    .then(res=>{
        const {list} = res.data;
        data.value = list.map(item => item.applications_count);
        label.value = list.map(d => d.name);
    })
    .catch(err=>{

    })
    .finally(()=>loading.value=false)
})

</script>
