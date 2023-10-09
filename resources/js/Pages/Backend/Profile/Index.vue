<template>
    <div class="bg-white">
        <div class="flex justify-between items-center text-color">
            <div>
                <p class="page-header">My Profile</p>
                <q-breadcrumbs>
                    <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                    <q-breadcrumbs-el label="Profile" />
                </q-breadcrumbs>
            </div>
        </div>
        <br/>

            <q-form @submit="submit" class="row q-col-gutter-md">
                <q-input class="full-width"
                         no-error-icon
                         v-model="form.name"
                         label="Name *"
                         :error="form.errors?.mobile"
                         :error-message="form.errors?.mobile"
                         :rules="[
                             val=>!!val || 'Value is required'
                         ]"
                />
                <q-input class="full-width"
                         no-error-icon
                         v-model="form.email"
                         label="Email *"
                         :error="form.errors?.mobile"
                         :error-message="form.errors?.mobile"
                         :rules="[
                             val=>!!val || 'Email is required'
                         ]"
                />
                <q-input class="full-width"
                         label="Mobile *"
                         no-error-icon
                         v-model="form.mobile"
                         :error="form.errors?.mobile"
                         :error-message="form.errors?.mobile"
                         :rules="[
                             val=>!!val || 'Mobile is required'
                         ]"
                />

                <q-input v-model="form.password"
                         type="password"
                         class="full-width"
                         no-error-icon
                         label="Password *"
                         :error="!!form?.errors?.password"
                         :error-message="!!form?.errors?.password"
                         hint="Leave blank to use current password"
                />
                <q-input v-model="form.password_confirmation"
                         class="full-width"
                         no-error-icon
                         type="password"
                         label="Confirm Password *"
                         :error="!!form?.errors?.password_confirmation"
                         :error-message="!!form?.errors?.password_confirmation"
                         :rules="[
                             val=>val===form.password || 'Confirm Password does not match password'
                         ]"
                />
                <div class="full-width flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Update" rounded color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('profile.index'))" label="Cancel" rounded color="negative"/>
                </div>

            </q-form>

    </div>
</template>
<script setup>

import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props=defineProps(['data']);
const q = useQuasar();

const form=useForm({
    name:props.data?.name,
    mobile:props.data?.mobile,
    email:props.data?.email,
    password:'',
    password_confirmation:''
})

const submit=e=>{

    form.submit('put',route('profile.update'),{
        onStart:params =>  q.loading.show({message:'Submitting...'}),
        onFinish:params => q.loading.hide()
    })
}


</script>
