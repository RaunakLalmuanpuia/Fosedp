<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Task Group User</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el class="cursor-pointer" @click="$inertia.get(route('dashboard'))" label="Dashboard" icon="o_dashboard" />
                <q-breadcrumbs-el class="cursor-pointer" @click="$inertia.get(route('task-group-user.index'))" label="Task Group Users"  />
                <q-breadcrumbs-el label="New User" />
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form @submit="submit">
        <q-input v-model="form.name"
                 label="Name *"
                 :error="!!form?.errors?.name"
                 :error-message="form?.errors?.name"
                 outlined
                 :rules="[
                             val=>!!val || 'Name is required'
                         ]"
        />

        <q-input v-model="form.mobile"
                 label="Mobile *"
                 :error="!!form?.errors?.mobile"
                 :error-message="form?.errors?.mobile"
                 mask="##########"
                 outlined
                 :rules="[
                             val=>!!val || 'Mobile is required'
                         ]"
        />

        <q-input v-model="form.email"
                 label="Email *"
                 :error="!!form?.errors?.email"
                 :error-message="form?.errors?.email"
                 :rules="[
                             val=>!!val || 'Email is required'
                         ]"
                 outlined
        />


        <q-select v-model="form.district"
                  :options="districts"
                  label="Appointed District"
                  outlined
                  :error="!!form?.errors?.district_id"
                  :error-message="form?.errors?.district_id"

        />

        <q-input v-model="form.password"
                 type="password"
                 label="Password *"
                 outlined
                 :error="!!form?.errors?.password"
                 :error-message="form?.errors?.password"
                 :rules="[
                             val=>!!val || 'Password is required'
                         ]"
        />
        <q-input v-model="form.password_confirmation"
                 type="password"
                 label="Confirm Password *"
                 outlined
                 :error="!!form?.errors?.password_confirmation"
                 :error-message="form?.errors?.password_confirmation"
                 :rules="[
                             val=>!!val || 'Confirm Password is required',
                             val=>val===form.password || 'Confirm Password does not match password'
                         ]"
        />
        <div class="flex q-gutter-sm">
            <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
            <q-btn class="sized-btn" @click="$inertia.replace(route('task-group-user.index'))" label="Cancel"  color="negative"/>
        </div>
    </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
const props=defineProps(['districts',])

const q = useQuasar();
const form=useForm({
    name:'',
    mobile:'',
    email:'',
    roles:[],
    district:null,
    password:'',
    password_confirmation:''
})

const submit=e=>{
    form.transform(data=>({district_id:data.district.value,...data}))
        .submit('post',route('task-group-user.store'),{
            onStart:params => q.loading.show({message:'Saving...'}),
            onFinish: params => q.loading.hide()
        })
}
</script>
