<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">New Notification</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('notice.index')" label="Notices" />
                        <q-breadcrumbs-el label="New Notification" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">
                <q-input v-model="form.title"
                         label="Title *"
                         outlined
                         :error="!!form?.errors?.title"
                         :error-message="!!form?.errors?.title"
                         :rules="[
                             val=>!!val || 'title is required'
                         ]"
                />
                <q-editor v-model="form.body" min-height="5rem"
                          :toolbar="[
                              [{
                                label: $q.lang.editor.align,
                                icon: $q.iconSet.editor.align,
                                fixedLabel: true,
                                list: 'only-icons',
                                options: ['left', 'center', 'right', 'justify']
                              }],
                               ['bold', 'italic', 'strike', 'underline', 'subscript', 'superscript'],
                              ['quote', 'unordered', 'ordered'],
                              ['undo', 'redo'],
                              ['viewsource']
                          ]"
                />
<!--                <q-input v-model="form.body"-->
<!--                         type="textarea"-->
<!--                         label="Content "-->
<!--                         outlined-->
<!--                         :error="!!form?.errors?.body"-->
<!--                         :error-message="!!form?.errors?.body"-->
<!--                         :rules="[-->
<!--                             val=>!!val || 'body is required'-->
<!--                         ]"-->
<!--                />-->
                <q-toggle v-model="form.published"
                          label="Published"
                          left-label
                />

                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Save"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('notice.index'))" label="Cancel"  color="negative"/>
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
    title:'',
    body:'',
    published:false
})

const submit=e=>{
    form.submit('post',route('notice.store'),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
