<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New Trade</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('associated-user.index')" label="Associated Users" />
                        <q-breadcrumbs-el label="Assign User" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">
                <q-select v-model="form.parent"
                          outlined
                          label="Parent User *"
                          :options="users"
                          :error="!!form?.errors?.parent_id"
                          :error-message="!!form?.errors?.parent_id"
                          :rules="[
                             val=>!!val || 'Please select parent user'
                         ]"
                />

                <q-select v-model="form.user"
                          outlined
                         label="Child User *"
                         :options="users"
                          :error="!!form?.errors?.user_id"
                         :error-message="!!form?.errors?.user_id"
                         :rules="[
                             val=>!!val || 'Please select user'
                         ]"
                />
                <q-select v-model="form.district"
                          outlined
                         label="District *"
                         :options="districts"
                          :error="!!form?.errors?.district_id"
                         :error-message="!!form?.errors?.district_id"
                         :rules="[
                             val=>!!val || 'Please select district'
                         ]"
                />



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
const props=defineProps(['users','districts'])

const q = useQuasar();
const form=useForm({
    parent: null,
    user: null,
    district:null,
})

const submit=e=>{
    form.transform(data => ({
        ...data,
        parent_id:data?.parent?.value,
        district_id:data?.district?.value,
        user_id:data.user.value}))
        .submit('post',route('associated-user.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
