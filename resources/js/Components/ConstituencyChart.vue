<template>
    <q-card flat>
        <div class="flex justify-between items-center">
            <div class="text-lg text-weight-medium">No of applications</div>
            <q-option-group
                inline
                v-model="toggle"
                :options="toggleOptions"
                @update:model-value="changeToggle"
                color="primary"
            />
        </div>
        <BarChart ref="doughnutRef" :chartData="testData" :options="options" />
    </q-card>
</template>

<script setup>
import {computed, defineComponent, onMounted, ref} from 'vue';
import {BarChart } from 'vue-chart-3';
import useUtils from "@/Compositions/useUtils";
import {useQuasar} from "quasar";

const {randomizeColor} = useUtils();

const q = useQuasar();
const data = ref([30, 40, 60, 70, 5]);
const label = ref([]);
const doughnutRef = ref();
const loading = ref(false);
const toggle=ref('district')
const toggleOptions=[
    {
        label: 'District Wise',
        value: 'district'
    },
    {
        label: 'Constituency Wise',
        value: 'constituency'
    },
]
const options = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'right',
        },
        title: {
            display: true,
            text: 'Constituencies Wise Applications',
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

const changeToggle=()=>{
    fetchData();
}
const fetchData=()=>{
    axios.get(route('statistic.application.constituency'),{
        params:{
            toggle:toggle.value
        }
    }).then(res=>{
            const {list} = res.data;
            data.value = list.map(item => item.applications_count);
            label.value = list.map(d => d.name);
        })
        .catch(err=>{
            q.notify({type:'negative',message:err?.response?.data?.message || err.toString()})
        })
}
onMounted(()=>fetchData())

</script>
