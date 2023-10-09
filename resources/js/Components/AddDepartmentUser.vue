<template>
        <q-card class="q-pa-md" flat style="width: 520px">
            <div class="flex justify-between items-center">
                <div class="text-md">Assign Department User</div>
                <q-btn class="q-pa-none" flat icon="close"/>
            </div>
            <q-separator class="full-width q-my-md"/>
            <q-form class="row q-col-gutter-sm" @submit="submit">
                <div class="col-xs-12 col-sm-6">
                    <p class="text-color">Department</p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <q-chip :label="department?.name" square/>
                </div>

                <div class="col-xs-12 col-sm-6">Select User</div>
                <div class="col-xs-12 col-sm-6">
                    <q-select v-model="form.user"
                              :options="options.users"
                              :error="!!form.errors?.user_id"
                              :error-message="!!form.errors?.user_id"
                              :rules="[
                                  val=>!!val || 'User is required'
                              ]"
                              dense
                              outlined
                    />
                </div>
                <div class="col-xs-12">
                    <div class="flex q-gutter-sm">
                        <q-btn color="primary" label="Confirm" type="submit"/>
                        <q-btn v-close-popup color="negative" label="Cancel" outline/>
                    </div>
                </div>


            </q-form>
        </q-card>
</template>
<script setup>

import {useForm} from "@inertiajs/vue3";
import {onMounted, reactive} from "vue";
import {useQuasar} from "quasar";

const props = defineProps(['department'])
const emit = defineEmits(['onSuccess'])
const form = useForm({
    user: null
})
const q = useQuasar();
const options = reactive({
    users: []
})
const submit = e => {
    console.log('test');
    form.transform(data => ({id: data.user.value, ...data}))
        .post(route('assignment.department', props.department.id), {
            preserveState: false,
            onStart: params => q.loading.show({message: 'Assigning...'}),
            onSuccess: params => emit('onSuccess'),
            onFinish: params => q.loading.hide()
        })
}

onMounted(() => {
    console.log('test')
    axios.get(route('option.users'))
        .then(res => {
            const {list} = res.data;
            options.users = list;
        })
        .catch(err => {
            q.notify({type: 'negative', message: err?.response?.data?.message})
        })
})

</script>
