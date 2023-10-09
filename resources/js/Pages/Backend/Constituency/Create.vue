<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New Constituency</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('constituency.index')" label="Districts" icon="people_outline" />
                        <q-breadcrumbs-el label="New Constituency" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">
                <q-input v-model="form.name"
                         label="Code *"
                         :error="!!form?.errors?.code"
                         :error-message="!!form?.errors?.code"
                         :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                />
                <q-select v-model="form.district"
                          label="District *"
                          :options="districts"
                          :error="!!form?.errors?.district"
                          :error-message="!!form?.errors?.district"
                          :rules="[
                             val=>!!val || 'District is required'
                         ]"
                />
                <q-input v-model="form.description"
                         label="Description"
                         type="textarea"
                         :error="!!form?.errors?.description"
                         :error-message="!!form?.errors?.description"
                         :rules="[
                             val=>!!val || 'Description is required'
                         ]"
                />




                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('constituency.index'))" label="Cancel"  color="negative"/>
                </div>
            </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
const props=defineProps(['districts'])

const q = useQuasar();
const form=useForm({
    name:'',
    district:null,
    description:null
})

const submit=e=>{
    form.transform(data=>({...data,district_id:data?.district.value}))
        .submit('post',route('constituency.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
