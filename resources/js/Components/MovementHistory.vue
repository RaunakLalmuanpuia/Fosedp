<template>
    <div class="column q-gutter-sm q-pl-sm">
        <q-timeline>
            <q-timeline-entry
                v-for="(item,index) in movements"
                :key="index"
                :subtitle="formatDateTime(item.sent_at)"
                side="left"
                :icon="!!item.received_at ? 'done_all':''"
            >
                <div class="zcard q-pa-md">
                    <div class="flex items-center justify-between">
                        <p class="q-ma-none text-color">Sender</p>
                        <p class="q-ma-none text-color text-weight-medium">{{item?.sender?.name}}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="q-ma-none text-color">Receiver</p>
                        <p class="q-ma-none text-color text-weight-medium">{{item?.recipient?.name}}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="q-ma-none text-color">Received at</p>
                        <p class="q-ma-none text-color text-weight-medium">{{formatDateTime(item?.received_at)}}</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="q-ma-none text-color">Remark</p>
                        <p class="q-ma-none text-color text-weight-medium">{{item?.remark}}</p>
                    </div>
                </div>



            </q-timeline-entry>
        </q-timeline>
    </div>

</template>
<script setup>
import {onMounted, ref} from "vue";
import {useQuasar} from "quasar";
import useUtils from "@/Compositions/useUtils";

const props=defineProps({
    file:Object
})
const {formatDateTime} = useUtils();
const q = useQuasar();
const movements=ref([])
const fetchHistory=()=>{
    q.loading.show();
    axios.get(route('json.movement.history',props.file.id))
    .then(res=>{
        const {list} = res.data;
        movements.value = list;
    })
    .catch(err=>{
        q.notify({type:'negative',message:err?.response?.data?.message || err.toString()})
    })
    .finally(()=>q.loading.hide())
}

onMounted(()=>{
    fetchHistory();
})
</script>
