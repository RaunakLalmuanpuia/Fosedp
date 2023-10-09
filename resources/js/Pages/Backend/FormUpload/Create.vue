<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Upload Form Eleven</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('form-eleven.index')"
                                  label="Form Eleven"/>
                <q-breadcrumbs-el label="Upload"/>
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form @submit="submit" class="column q-gutter-md" style="max-width: 480px">
        <q-file outlined
                bottom-slots
                v-model="form.attachment"
                label="Upload Form Eleven"
                counter
                :rules="[
                    val=>!!val || 'File is required'
                ]">
            <template v-slot:before>
                <q-icon name="folder_open" />
            </template>

            <template v-slot:hint>
                <p class="text-caption">Maximum size of file should be 10mb</p>
            </template>

            <template v-slot:append>
                <q-btn round dense flat icon="add" @click.stop.prevent />
            </template>
        </q-file>
        <q-select v-model="form.department"
                  :options="departments"
                  outlined
                  label="Department"
                  :rules="[
                      val=>!!val || 'Department is required'
                  ]"/>

        <q-input v-model="form.remark"
                 label="Remark"
                 outlined
                 type="textarea"
        />
        <q-btn class="q-mt-md" type="submit" label="Upload" color="primary"/>
    </q-form>
</template>
<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props=defineProps(['departments'])
const q = useQuasar();
const form=useForm({
    attachment:null,
    department:null,
    remark:''
});
const submit=e=>{
    form.transform(data=>({department_id:data.department.value,...data}))
        .post(route('form-eleven.store'),{
        onStart:params => q.loading.show(),
        onFinish:params => q.loading.hide()
    })
}
</script>
