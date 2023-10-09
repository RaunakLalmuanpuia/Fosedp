<template>
    <div>
        <slot name="trigger">
            <q-btn class="q-mr-sm" @click="open=true" label="Update Status" color="accent" no-caps/>
        </slot>

        <q-dialog v-model="open">
            <q-card style="width: 540px" flat class="">
                <div class="flex justify-between items-center q-pl-md">
                    <p class="text-lg q-ma-none q-my-sm">Update Status</p>
                    <q-btn round v-close-popup icon="close" flat class="q-pa-xs"/>
                </div>
                <q-separator class="full-width" />
                <div class="q-pl-md">
                    <p class="text-color text-sm">{{'No of Application to be update : '+files?.length || 0}}</p>
                    <p v-if="!!form?.errors?.ids" class="text-negative">{{form?.errors?.ids}}</p>
                </div>

                <q-form class="q-pa-md" @submit="submit">
                    <q-select v-model="form.status"
                              outlined
                              :options="statuses"
                              :error="!!form?.errors?.user_id"
                              :error-message="form?.errors?.user_id"
                              :rules="[
                                     val=>!!val || 'Please select status'
                              ]"
                              label="Select Status"/>
                    <div class="flex q-gutter-sm q-mt-md">
                        <q-btn v-close-popup type="submit" color="primary" label="Update"/>
                        <q-btn outline v-close-popup color="negative" label="Cancel"/>
                    </div>
                </q-form>
            </q-card>
        </q-dialog>
    </div>

</template>
<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {computed, onMounted, ref} from "vue";
import useUtils from "@/Compositions/useUtils";

const props=defineProps(['files','default'])
const emit=defineEmits(['onSuccess'])
const q = useQuasar();
const {formatDateTime,APPLICATION_STATUSES}=useUtils()
const users = ref([]);
const open = ref(false);
const form=useForm({
    status:props.default,
})

const statuses=computed(()=>{
    const roles = usePage().props?.roles || [];
    let temp = [];
    if (roles.find(item => item === 'dc-verifier')) {
        temp.push('verified')
    }
    if (roles.find(item => item === 'dc-approval')) {
        temp.push('approved');
    }
    return temp;
})
const submit=e=>{
    const ids = props.files.map(item => item.id) || [];
    if (ids.length === 1) {
        form.transform(data => ({ids,...data}))
            .put(route('application.update-status',[ids[0]]),{
                onStart:params => q.loading.show({message:'Submitting...'}),
                onSuccess: params => emit('onSuccess'),
                onFinish:params => q.loading.hide()
            });
    }

}
</script>
