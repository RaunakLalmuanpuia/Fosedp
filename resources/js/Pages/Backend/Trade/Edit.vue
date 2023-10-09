<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">Edit Trade</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('trade.index')" label="Trade" />
                        <q-breadcrumbs-el label="Edit Trade" />
                    </q-breadcrumbs>
                </div>
            </div>
            <br/>
            <br/>
            <q-form @submit="submit">

                <q-input v-model="form.name"
                         label="Name *"
                         :error="!!form?.errors?.name"
                         :error-message="!!form?.errors?.name"
                         :rules="[
                             val=>!!val || 'Name is required'
                         ]"
                />

                <q-select v-model="form.department"
                         label="Department *"
                          :options="departments"
                         :error="!!form?.errors?.department_id"
                         :error-message="!!form?.errors?.department_id"
                         :rules="[
                             val=>!!val || 'Department is required'
                         ]"
                />

                <q-input v-model="form.description"
                         label="Description"
                         :error="!!form?.errors?.description"
                         :error-message="!!form?.errors?.description"
                />

                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Update"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('trade.index'))" label="Cancel"  color="negative"/>
                </div>
                <br/>
                <q-item>
                    <q-item-section>
                        <q-item-label class="text-md text-color">SubTrades</q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <q-btn size="md" outline no-caps @click="openCreate=true" label="New Subtrade"/>
                    </q-item-section>
                </q-item>
                <q-list separator v-if="data.sub_trades.length>0">

                    <q-item v-for="(item,index) in data.sub_trades" :key="index">
                        <q-item-section avatar>
                            <q-chip square :label="index+1"/>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>{{item?.name}}</q-item-label>
                        </q-item-section>
                        <q-item-section side>
                            <div class="flex q-gutter-sm">
                                <q-btn size="sm" outline @click="edit(item)" icon="edit"/>
                                <q-btn size="sm" outline @click="handleDelete(item)" icon="delete"/>
                            </div>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-form>

    <q-dialog v-model="openCreate">
        <q-card style="width: 480px" class="q-pa-md">
            <div class="flex justify-between items-center">
                <p class="q-ma-none text-md text-weight-medium text-color">New Subtrade</p>
                <q-icon size="18px" class="cursor-pointer" name="close" v-close-popup/>
            </div>
            <q-form class="column q-gutter-sm" @submit="createSubtrade">
                <q-input v-model="subtradeForm.name"
                         autofocus
                         label="Name *"
                         :rules="[
                             val=>!!val || 'Name is required'
                         ]"/>
                <div class="flex q-gutter-sm">
                    <q-btn type="submit" color="accent" label="Save"/>
                    <q-btn color="negative" label="Cancel" v-close-popup/>
                </div>

            </q-form>
        </q-card>
    </q-dialog>

</template>
<script setup>

import {router, useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {ref} from "vue";
const props=defineProps(['data','departments'])

const q = useQuasar();
const openCreate = ref(false);
const form=useForm({
    name:props.data.name,
    department:!!props.data.department ?({value:props.data.department.id,label:props.data.department.name}):null,
    description:props.data.description,
})

const subtradeForm=useForm({
    name: ''
})

const createSubtrade=e=>{
    subtradeForm.submit('post',route('trade.subtrade.store',props.data.id),{
        onStart:params => q.loading.show({message:'Saving...'}),
        onSuccess: params => {
            subtradeForm.name = '';
            openCreate.value = false;
        },
        onFinish: params => q.loading.hide()
    })
}
const handleDelete = item => {
    q.dialog({
        title:'Confirm Detach',
        message:'Do you want to Detach Subtrade',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.delete(route('trade.subtrade.detach',item.id),{
                onStart:params => q.loading.show({message:'Removing...'}),
                onFinish:params => q.loading.hide(),
                preserveState:false
            })
        })
}
const submit=e=>{
    console.log(form.data());
    form.transform(data => ({department_id:data.department.value,...data}))
        .submit('put',route('trade.update',props.data.id),{
        onStart:params => q.loading.show({message:'Updating...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
