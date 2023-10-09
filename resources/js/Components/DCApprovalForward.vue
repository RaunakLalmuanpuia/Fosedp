<template>

        <q-card style="width: 540px" flat class="">
            <div class="flex justify-between items-center q-pl-md">
                <p class="text-lg q-ma-none q-my-sm">FORWARD TO APPROVAL</p>
                <q-btn round v-close-popup icon="close" flat class="q-pa-xs"/>
            </div>
            <q-separator class="full-width" />
            <div class="q-pl-md">
                <p class="text-color text-sm q-ma-none">{{'No of Application to be Sent : '+files?.length || 0}}</p>
                <p v-if="!!form?.errors?.ids" class="text-negative q-ma-none">{{form?.errors?.ids}}</p>
            </div>

            <q-form class="q-pa-md" @submit="submit">
                <q-select v-model="form.user"
                          outlined
                          :options="users"
                          :error="!!form?.errors?.user_id"
                          :error-message="form?.errors?.user_id"
                          :rules="[
                          val=>!!val || 'Please select recipient'
                      ]"
                          label="Select Recipient user"/>
                <q-input v-model="form.remark"
                         type="textarea"
                         outlined
                         label="Remark"
                />
                <div class="flex q-gutter-sm q-mt-md">
                    <q-btn v-close-popup type="submit" color="primary" label="Confirm"/>
                    <q-btn outline v-close-popup color="negative" label="Cancel"/>
                </div>
            </q-form>
        </q-card>
</template>
<script setup>

import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {onMounted, ref} from "vue";
import useUtils from "@/Compositions/useUtils";

const props=defineProps(['files'])
const emit=defineEmits(['onSuccess'])
const q = useQuasar();
const {formatDateTime}=useUtils()
const users = ref([]);
const open = ref(false);
const form=useForm({
    user:null,
    remark: ''
})

const fetchPlanningUsers=e=>{
    q.loading.show({message:'Fetching Users'})
    axios.get(route('option.dc-approvals'))
    .then(res=>{
        const {message,list} = res.data;
        users.value = list;
    })
    .catch(err=>{
        q.notify({type:'negative',message:err.response?.data?.message ||  err.toString()})
    })
    .finally(()=>q.loading.hide())
}
onMounted(()=>{
    fetchPlanningUsers();
})
const submit=e=>{
    const ids = props.files.map(item => item.id) || [];
    form.transform(data => ({ids,user_id:data.user.value,...data}))
        .post(route('application.forward'),{
            onStart:params => q.loading.show({message:'Forwarding...'}),
            onSuccess: params => {
                emit('onSuccess')
                open.value=false
            },
        onFinish:params => q.loading.hide()
    })
}
</script>
