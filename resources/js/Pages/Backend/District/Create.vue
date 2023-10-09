<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New District</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('district.index')" label="Districts" icon="people_outline" />
                        <q-breadcrumbs-el label="New District" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">
                <q-input v-model="form.code"
                         label="Code *"
                         :error="!!form?.errors?.code"
                         :error-message="!!form?.errors?.code"
                         :rules="[
                             val=>!!val || 'Code is required'
                         ]"
                />
                <q-input v-model="form.name"
                         label="Name *"
                         :error="!!form?.errors?.name"
                         :error-message="!!form?.errors?.name"
                         :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                />



                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('district.index'))" label="Cancel"  color="negative"/>
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
    z:'',
    name:'',
})

const submit=e=>{
    form.submit('post',route('district.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
