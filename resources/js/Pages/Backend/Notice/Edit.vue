<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Edit Notice</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('notice.index')"  label="Notice"/>
                <q-breadcrumbs-el label="Edit Notification"/>
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form @submit="submit">
        <q-input v-model="form.title"
                 :error="!!form?.errors?.title"
                 :error-message="!!form?.errors?.title"
                 :rules="[
                             val=>!!val || 'Title is required'
                         ]"
                 label="Title *"
        />

        <q-input v-model="form.body"
                 type="textarea"
                 :error="!!form?.errors?.body"
                 :error-message="!!form?.errors?.body"
                 :rules="[
                             val=>!!val || 'body is required'
                         ]"
                 label="Body *"
        />

        <q-toggle v-model="form.published"
                  label="Published"
                  left-label
        />

        <div class="flex q-gutter-sm">
            <q-btn class="sized-btn" color="accent" label="Update" type="submit"/>
            <q-btn class="sized-btn" color="negative" label="Cancel"
                   @click="$inertia.replace(route('notice.index'))"/>
        </div>
    </q-form>
    <br/>

</template>
<script setup>

import {router, useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {ref} from "vue";

const props = defineProps(['data'])

const q = useQuasar();
const form = useForm({
    title: props.data.title,
    body: props.data.body,
    published:!!props.data.published
})

const handleDelete = item => {
    q.dialog({
        title: 'Confirmation',
        message: 'Do you want to delete',
        ok: 'Yes',
        cancel: 'No'
    })
        .onOk(() => {
            router.delete(route('notice.destroy', item.id), {
                onStart: params => q.loading.show({message: 'Removing...'}),
                onSuccess: params => {
                    console.log(item);
                },
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}
const submit = e => {
    form.submit('put', route('notice.update', props.data.id), {
        onStart: params => q.loading.show({message: 'Updating...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
