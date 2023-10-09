<template>
    <q-card flat>
        <div class="text-lg text-weight-medium">Trade selected district wise</div>
        <LineChart ref="chartRef" :chartData="testData" :options="options" />
    </q-card>
</template>

<script setup>
import {computed, defineComponent, onMounted, reactive, ref} from 'vue';
import {LineChart } from 'vue-chart-3';
import {useQuasar} from "quasar";
import useUtils from "@/Compositions/useUtils";

const {randomizeColor} = useUtils();
const q = useQuasar();
const chartRef = ref();
const state=reactive({
    loading:false
})
const data = ref([]);
const labels = ref(['one','two','three']);

const datasets = ref( [
    {
        label: 'Dataset 1',
        data: [10,27,43],
        borderColor:'blue',
        backgroundColor: 'yellow',
        yAxisID: 'y',
    },
    {
        label: 'Dataset 2',
        data: [40,5,6],
        borderColor: 'red',
        backgroundColor: 'blue',
        yAxisID: 'y',
    }
]);

const options = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'right',
        },
        title: {
            display: true,
            text: 'Trade Selected based on District',
        },
    },
});

const testData = computed(() => ({
    labels: labels.value,
    datasets:datasets.value
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
    state.loading=true
    axios.get(route('statistic.trade-district'))
    .then(res=>{
        const {districts} = res.data;
        const {trades} = res.data;
        labels.value = districts.map(item => item?.name);
        datasets.value=trades.map(item=>{
            return( {
                label:item?.name,
                data: getData(districts,item),
                backgroundColor: randomBg(),
                yAxisID: 'y',
            })
        })
    })
    .catch(err=>q.notify({type:'negative',message:err?.response?.data?.message}))
    .finally(()=>state.loading=false)
})

const getData=(districts,trade)=>{
    let data = [];
    for (let i = 0; i < districts.length; i++) {
        const district = districts[i];
        const appData=trade.app_data.find(item => item.district_id === district['id']);
        data.push(appData['application_count']);
    }

    return data;
}

</script>
