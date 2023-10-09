<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Edit District</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('district.index')" icon="people_outline" label="District"/>
                <q-breadcrumbs-el label="Edit District"/>
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form @submit="submit">
        <q-input v-model="form.code"
                 :error="!!form?.errors?.code"
                 :error-message="!!form?.errors?.code"
                 :rules="[
                             val=>!!val || 'Code is required'
                         ]"
                 label="Code *"
        />

        <q-input v-model="form.name"
                 :error="!!form?.errors?.name"
                 :error-message="!!form?.errors?.name"
                 :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                 label="Name *"
        />


        <div class="flex q-gutter-sm">
            <q-btn class="sized-btn" color="accent" label="Update" type="submit"/>
            <q-btn class="sized-btn" color="negative" label="Cancel"
                   @click="$inertia.replace(route('district.index'))"/>
        </div>
    </q-form>
    <br/>
    <q-list separator title="Constituency">
        <q-item>
            <q-item-section class="text-lg text-color">Constituencies</q-item-section>
        </q-item>
        <q-item v-for="(item,index) in constituencies" :key="index">
            <q-item-section avatar>
                <q-chip :label="index+1" square/>
            </q-item-section>
            <q-item-section>
                <q-item-label class="text-color">{{ item?.name }}</q-item-label>
            </q-item-section>
            <q-item-section side>
                <q-btn color="negative" icon="delete" outline size="sm" @click="handleDelete(item)"/>
            </q-item-section>
        </q-item>
    </q-list>
</template>
<script setup>

import {router, useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {ref} from "vue";

const props = defineProps(['data'])

const q = useQuasar();
const form = useForm({
    code: props.data.code,
    name: props.data.name,
})
const constituencies = ref(props.data.constituencies);

const handleDelete = item => {
    q.dialog({
        title: 'Confirm Remove',
        message: 'Do you want to remove',
        ok: 'Yes',
        cancel: 'No'
    })
        .onOk(() => {
            router.delete(route('constituency.detach', item.id), {
                onStart: params => q.loading.show({message: 'Removing...'}),
                onSuccess: params => {
                    console.log(item);
                    constituencies.value = constituencies.value.filter(value => value.id !== item.id)
                },
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}
const submit = e => {
    form.submit('put', route('district.update', props.data.id), {
        onStart: params => q.loading.show({message: 'Updating...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
