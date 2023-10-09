<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">Edit User</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('constituency.index')" label="Constituencies" />
                        <q-breadcrumbs-el label="Edit Constituency" />
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

                />

                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Update"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('constituency.index'))" label="Cancel"  color="negative"/>
                </div>
            </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
const props=defineProps(['data','districts'])

const q = useQuasar();
const form=useForm({
    name:props.data.name,
    description:props.data.description || null,
    district:({value:props.data.id,label:props.data.name}),
})


const submit=e=>{
    form.transform(data => ({...data,district_id:data.district.value})).submit('put',route('constituency.update',props.data.id),{
        onStart:params => q.loading.show({message:'Updating...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
