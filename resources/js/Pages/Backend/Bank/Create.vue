<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">Generate Bank Verification</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')"
                                  icon="o_dashboard"
                                  label="Dashboard"/>
                <q-breadcrumbs-el :href="route('bank.index')" icon="o_list" label="Bank Wise Files"/>
                <q-breadcrumbs-el label="Generate Bank Wise File"/>
            </q-breadcrumbs>
        </div>
    </div>
    <br/>
    <br/>
    <q-form style="width: 450px" class="column q-gutter-sm" @submit="submit">
        <br/>
        <q-input type="number" v-model="form.from" outlined label="FROM"/>
        <q-input type="number" v-model="form.to" outlined label="TO"/>
        <q-btn type="submit" color="primary" label="Generate"/>

    </q-form>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const q = useQuasar();
const form=useForm({
    from:0,
    to:10
})

const submit=e=>{
    form.post(route('bank.verify'),{
        onStart:params =>q.loading.show({message:'Submitting...'}),
        onFinish:params => q.loading.hide()
    })
}
</script>
