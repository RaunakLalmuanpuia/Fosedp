<template>
        <q-card style="width: 540px" flat class="">
            <div class="flex justify-between items-center q-pl-md">
                <p class="text-lg q-ma-none q-my-sm">FORWARD TO {{formattedRecipient}}</p>
                <q-btn round v-close-popup icon="close" flat class="q-pa-xs"/>
            </div>
            <q-separator class="full-width" />
            <div class="q-pl-md">
                <p class="text-color text-weight-medium q-ma-none">{{'No of Application to be Sent : '+files?.length || 0}}</p>
                <p v-if="!!form?.errors?.ids" class="text-negative q-ma-none">{{form?.errors?.ids}}</p>
            </div>

            <div class="q-mx-md q-my-sm text-weight-medium text-color">Select your recipient</div>

            <div class="q-gutter-sm">
                <q-option-group
                    v-model="recipient"
                    @update:model-value="fetchingUsers"
                    :options="[
                        {value:'dc',label:'DC'},
                        {value:'planning',label:'Planning'},
                        {value:'executive',label:'Executive Board'},
                        {value:'department',label:'Directorate'},
                        {value:'office',label:'District Office'},
                    ]"
                    color="primary"
                    inline
                />

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
import {computed, onMounted, ref} from "vue";
import useUtils from "@/Compositions/useUtils";

const props=defineProps(['files'])
const emit=defineEmits(['onSuccess'])
const q = useQuasar();
const {formatDateTime}=useUtils()
const users = ref([]);
const open = ref(false);
const recipient = ref(null);
const form=useForm({
    user:null,
    remark: ''
})
const formattedRecipient = computed(() => recipient.value?.toUpperCase());

const fetchingUsers=val=>{
    let path = null;
    switch (val.toLowerCase()) {
        case 'dc':
            path = route('option.dc-users');
            break;
        case 'planning':
        case 'admin':
            path = route('option.planning-users');
            break;
        case 'department':
            path = route('option.department-users');
            break;
        case 'executive':
            path = route('option.executive-users');
            break;
        case 'office':
            path = route('option.associated-users');
            break;

        default:
    }
    form.user = null;
    q.loading.show({message:'Fetching Users'});
    axios.get(path)
        .then(res=>{
            const {message,list} = res.data;
            users.value = list;
        })
        .catch(err=>{
            q.notify({type:'negative',message:err.response?.data?.message ||  err.toString()})
        })
        .finally(()=>q.loading.hide())
}

const submit=e=>{
    const ids = props.files.map(item => item.id) || [];
    form.transform(data => ({ids,user_id:data.user.value}))
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
