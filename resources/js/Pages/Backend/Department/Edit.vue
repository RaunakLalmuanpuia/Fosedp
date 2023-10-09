<template>
            <div class="flex justify-between items-center text-color">
                <div>
                   <p class="page-header">Edit Department</p>
                    <q-breadcrumbs>
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                        <q-breadcrumbs-el :href="route('department.index')" label="Departments" />
                        <q-breadcrumbs-el label="Edit Department" />
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

                <q-input v-model="form.description"
                         label="Description"
                         :error="!!form?.errors?.description"
                         :error-message="!!form?.errors?.description"
                />

                <div class="flex q-gutter-sm">
                    <q-btn class="sized-btn" type="submit" label="Update"  color="accent"/>
                    <q-btn class="sized-btn" @click="$inertia.replace(route('department.index'))" label="Cancel"  color="negative"/>
                </div>
                <br/>
                <q-separator class="q-my-sm full-width"/>
                <q-tabs v-model="state.tab"
                        class="bg-secondary text-grey-1"
                >
                    <q-tab name="trade"
                           label="Trades">

                    </q-tab>
                    <q-tab  name="user" label="Users"/>
                </q-tabs>

                    <q-tab-panels v-model="state.tab" animated>
                        <q-tab-panel name="trade">
                            <q-list separator>
                                <q-item v-for="(item,index) in data.trades" :key="index">
                                    <q-item-section avatar>
                                        <q-chip square :label="index+1"/>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>{{item?.name}}</q-item-label>
                                    </q-item-section>
                                    <q-item-section side>
                                        <q-btn size="sm" @click="handleDelete(item)" outline color="negative" icon="delete"/>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-tab-panel>
                        <q-tab-panel name="user">
                            <q-list separator>
                                <q-item v-for="(item,index) in data.users" :key="index">
                                    <q-item-section avatar>
                                        <q-chip square :label="index+1"/>
                                    </q-item-section>
                                    <q-item-section>
                                        <q-item-label>{{item?.name}}</q-item-label>
                                        <q-item-label caption>{{item?.name}}</q-item-label>
                                    </q-item-section>
                                    <q-item-section side>
                                        <q-btn size="sm" @click="handleRemove(item)" outline color="negative" icon="o_close"/>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-tab-panel>
                    </q-tab-panels>

            </q-form>
</template>
<script setup>

import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {reactive, ref} from "vue";
const props=defineProps(['data'])

const q = useQuasar();
const form=useForm({
    name:props.data.name,
    description:props.data.description,
})
const state=reactive({
    tab:'trade'
})
const trades = ref(props.data.trades);

const handleDelete=item=>{
    q.dialog({
        title:'Confirm Remove',
        message:'Do you want to remove',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.delete(route('trade.detach',item.id),{
                onStart:params => q.loading.show({message:'Detaching...'}),
                onFinish:params => q.loading.hide(),
                preserveState:false
            })
        })
}

const handleRemove=item=>{
    q.dialog({
        title:'Confirm Remove',
        message:'Do you want to remove',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.delete(route('assignment.department.detach-user',[props.data.id,item.id]),{
                onStart:params => q.loading.show({message:'Detaching...'}),
                onFinish:params => q.loading.hide(),
                preserveState:false
            })
        })
}
const submit=e=>{
    form.submit('put',route('department.update',props.data.id),{
        onStart:params => q.loading.show({message:'Updating...'}),
        onFinish: params => q.loading.hide()
    })
}
</script>
