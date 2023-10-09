<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">List of Office</p>
            <q-breadcrumbs >
                <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard"/>
                <q-breadcrumbs-el label="Offices"/>
            </q-breadcrumbs>
        </div>
        <q-btn color="accent" label="New Office"  @click="$inertia.get(route('office.create'))"/>
    </div>
    <br/>
    <div class="flex justify-between items-center">
        <q-input v-model="search"
                 :debounce="700"
                 @update:model-value="handleSearch"
                 outlined
                 dense
                 placeholder="Type here..."
        />
    </div>
    <q-table
        table-class="text-color"
        flat
        table-header-class="table-header"
        v-model:pagination="pagination"
        :columns="columns"
        :loading="loading"
        :rows="rows"
        binary-state-sort
        row-key="id"
        @request="onRequest"
        :rows-per-page-options="[2,5,7,15,30,50]">

        <template #body-cell-sn="props">
            <td>{{props.rowIndex+1}}</td>
        </template>
        <template #body-cell-action="props">
            <td align="right">
                <div class="flex q-gutter-sm justify-end">
                    <q-btn @click="$inertia.get(route('office.edit',props.row.id))" size="sm" icon="edit" outline/>
                    <q-btn @click="handleDelete(props.row)" size="sm" icon="delete" outline/>
                </div>
            </td>
        </template>
    </q-table>
</template>
<script setup>
import {onMounted, ref} from 'vue'
import {router} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props = defineProps(['list']);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'name', align: 'left', label: 'Name', field: 'name',},
    {name: 'district', align: 'left', label: 'District', field: 'district',format:val=>val?.name},
    {name: 'department', align: 'left', label: 'Department', field: 'department',format:val=>val?.name},
    {name: 'action', label: 'Action', field: 'id', },
]

const q = useQuasar();
const rows = ref(props.list.data || [])
const loading = ref(false)
const search = ref();
const pagination = ref({
    page: props.list.current_page,
    rowsPerPage: props.list.per_page,
    rowsNumber: props.list.total
})

const handleDelete = item => {
    q.dialog({
        title:'Confirm Delete',
        message:'Do you want to delete',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            router.delete(route('office.destroy',item.id),{
                onStart:params => q.loading.show({message:'Deleting...'}),
                onFinish:params => q.loading.hide(),
                preserveState:false
            })
        })
}

const handleSearch=val=>{
    onRequest({pagination})
}

function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination
    router.get(route('office.index'),{
        per_page:rowsPerPage,
        search:search.value,
        page:page
    },{
        onStart:params => loading.value=true,
        onFinish: params => loading.value = false
    })
}




</script>
