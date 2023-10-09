<template>
    <q-card>
        <div class="flex justify-between items-center">
            <p class="text-lg q-ma-none">Permissions</p>
            <q-btn  flat icon="close" v-close-popup class="q-pa-xs"/>
        </div>
        <q-separator/>
        <q-form @submit="submit">
            <div class="col-4">
                <label class="text-color">Current </label>
            </div>
            <div class="col-6">

            </div>
            <div class="flex q-gutter-sm">
                <q-btn type="submit" color="accent"/>
                <q-btn color="negative" outline v-close-popup/>
            </div>
        </q-form>

    </q-card>
</template>
<script setup>
import {onMounted, reactive} from "vue";
import {useQuasar} from "quasar";

const props=defineProps(['user'])
const q = useQuasar();
const state=reactive({
    currentPermissions:[],
    optionPermissions: []
})

onMounted(()=>{

    q.loading.show();
    axios.get(route('json.user.perms',props.user?.id))
    .then(res=>{
        const {list} = res.data;
        state.currentPermissions = list;
    })
    .catch(err=>{
        state.currentPermissions = [];
        q.loading.show({type:'negative',message:err?.response?.data?.message || err.toString()})
    })
    .finally(()=>q.loading.hide())
})
</script>
