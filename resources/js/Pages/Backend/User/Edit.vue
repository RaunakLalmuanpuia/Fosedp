<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Edit User</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('user.index')" icon="people_outline" label="Users"/>
                <q-breadcrumbs-el label="Edit User"/>
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form @submit="submit">
        <q-input v-model="form.name"
                 :error="!!form?.errors?.name"
                 :error-message="!!form?.errors?.name"
                 :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                 label="Name *"
        />

        <q-input v-model="form.mobile"
                 :error="!!form?.errors?.mobile"
                 :error-message="!!form?.errors?.mobile"
                 :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                 label="Mobile *"
        />

        <q-input v-model="form.email"
                 :error="!!form?.errors?.email"
                 :error-message="!!form?.errors?.email"
                 :rules="[
                             val=>!!val || 'Email is required'
                         ]"
                 label="Email *"
        />
        <q-select v-model="form.roles"
                  :error="!!form?.errors?.role_ids"
                  :error-message="!!form?.errors?.role_ids"
                  :options="roles"
                  :rules="[
                             val=>!!val || 'Role is required'
                         ]"
                  label="Role *"
                  multiple
                  use-chips
        />

        <q-select v-model="form.districts"
                  :error="!!form?.errors?.districts"
                  :error-message="!!form?.errors?.districts"
                  :options="districts"
                  label="Appointed District"
                  multiple
                  use-chips
        />

        <q-input v-model="form.password"
                 :error="!!form?.errors?.password"
                 :error-message="!!form?.errors?.password"
                 hint="Leave blank to use current password"
                 label="Password *"
                 type="password"
        />
        <q-input v-model="form.password_confirmation"
                 :error="!!form?.errors?.password_confirmation"
                 :error-message="!!form?.errors?.password_confirmation"
                 :rules="[
                             val=>val===form.password || 'Confirm Password does not match password'
                         ]"
                 label="Confirm Password *"
                 type="password"
        />
        <div class="flex q-gutter-sm">
            <q-btn class="sized-btn" color="accent" label="Update" rounded type="submit"/>
            <q-btn class="sized-btn" color="negative" label="Cancel" rounded
                   @click="$inertia.replace(route('user.index'))"/>
        </div>
    </q-form>
</template>
<script setup>

import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props = defineProps(['districts', 'roles', 'data'])

const q = useQuasar();
const form = useForm({
    name: props.data.name,
    mobile: props.data.mobile,
    email: props.data.email,
    roles: props.data?.roles.map(item => ({value: item.id, label: item.name})),
    districts: props.data.districts.map(item => ({value: item.id, label: item.name})),
    password: '',
    password_confirmation: ''
})

const submit = e => {
    form.transform(data => ({
            role_ids: data?.roles?.map(item => item.value),
            ids: data.districts.map(item => item.value), ...data
        }
    ))
        .submit('put', route('user.update', props.data.id), {
            onStart: params => q.loading.show({message: 'Updating...'}),
            onFinish: params => q.loading.hide()
        })
}
</script>
