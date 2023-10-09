<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New Trade</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('trade.index')" label="Trades" />
                        <q-breadcrumbs-el label="New Trade" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">

                <q-input v-model="form.name"
                         label="Name *"
                         :error="!!form?.errors?.name"
                         :error-message="!!form?.errors?.name"
                         :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                />
                <q-select v-model="form.department"
                         label="Department *"
                         :options="departments"
                          :error="!!form?.errors?.department_id"
                         :error-message="!!form?.errors?.department_id"
                         :rules="[
                             val=>!!val || 'Department is required'
                         ]"
                />
                <q-input v-model="form.description"
                         label="Description"
                         :error="!!form?.errors?.description"
                         :error-message="!!form?.errors?.description"/>


                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('trade.index'))" label="Cancel"  color="negative"/>
                </div>
            </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
const props=defineProps(['departments'])

const q = useQuasar();
const form=useForm({
    name:'',
    department:null,
    description:'',
})

const submit=e=>{
    form.transform(data => ({...data,department_id:data.department.value})).submit('post',route('trade.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
