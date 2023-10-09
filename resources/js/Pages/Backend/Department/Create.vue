<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New Department</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('department.index')" label="Departments" />
                        <q-breadcrumbs-el label="New Department" />
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
                <q-input v-model="form.description"
                         label="Description "
                         :error="!!form?.errors?.description"
                         :error-message="!!form?.errors?.description"

                />
                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('department.index'))" label="Cancel"  color="negative"/>
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
    description:'',
})

const submit=e=>{
    form.submit('post',route('department.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
