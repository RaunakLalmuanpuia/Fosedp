<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">New Office</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('office.index')" label="Office"/>
                <q-breadcrumbs-el label="New Office"/>
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

        <q-select v-model="form.levelSelect"
                  :options="OFFICES_LEVELS"
                  :error="!!form?.errors?.level"
                  :error-message="!!form?.errors?.level"
                  :rules="[
                             val=>!!val || 'Level is required'
                         ]"
                  label="Level"
        />

        <q-select v-model="form.department"
                  :options="departments"
                  :error="!!form?.errors?.department_id"
                  :error-message="!!form?.errors?.department_id"
                  :rules="[
                             val=>!!val || 'Department is required'
                         ]"
                  label="Department *"
        />
        <q-select v-model="form.districtSelect"
                 :options="districts"
                 :error="!!form?.errors?.district_id"
                 :error-message="!!form?.errors?.district_id"
                 :rules="[
                             val=>!!val || 'District is required'
                         ]"
                 label="District *"
        />
        <q-select v-model="form.officeSelect"
                  clearable
                  :options="offices"
                  :error="!!form?.errors?.parentOffice"
                  :error-message="!!form?.errors?.parentOffice"
                  label="Parent office"
        />

        <q-input v-model="form.description"
                 :error="!!form?.errors?.description"
                 :error-message="!!form?.errors?.description"

                 label="Description"
        />


        <div class="flex q-gutter-sm">
            <q-btn class="sized-btn" color="accent" label="Save" type="submit"/>
            <q-btn class="sized-btn" color="negative" label="Cancel"
                   @click="$inertia.replace(route('office.index'))"/>
        </div>
    </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import useUtils from "@/Compositions/useUtils";

const props = defineProps(['districts','offices','departments'])

const {OFFICES_LEVELS} = useUtils();
const q = useQuasar();
const form = useForm({
    name: '',
    description: '',
    levelSelect: OFFICES_LEVELS[0],
    districtSelect:null,
    department: null,
    officeSelect:null
})

const submit = e => {
    form.transform(data => ({
        ...data,
        level:data?.levelSelect?.value,
        district_id:data.districtSelect?.value,
        department_id:data.department?.value,
        office:data.officeSelect?.value}))
        .submit('post', route('office.store'), {
        onStart: params => q.loading.show({message: 'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
