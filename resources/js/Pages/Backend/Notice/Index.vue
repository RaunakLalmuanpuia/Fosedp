<template>
            <div class="flex justify-between items-center">
                <div>
                    <p class="page-header">List of Notice</p>
                    <q-breadcrumbs class="text-accent" >
                        <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard"/>
                        <q-breadcrumbs-el label="Notices"/>
                    </q-breadcrumbs>
                </div>
                <q-btn color="accent" label="New Notification"  @click="$inertia.get(route('notice.create'))"/>
            </div>
            <br/>
                <q-table
                    table-class="text-color"
                    flat
                    table-header-class="table-header"
                    v-model:pagination="pagination"
                    :columns="columns"
                    :filter="filter"
                    :loading="loading"
                    :rows="rows"
                    binary-state-sort
                    row-key="id"
                    @request="onRequest"
                    :rows-per-page-options="[7,15,30,50]">

                    <template #body-cell-sn="props">
                        <td width="40px">{{props.rowIndex+1}}</td>
                    </template>
                    <template #body-cell-published="props">
                        <td width="40">{{props.row.published ? 'Yes':'No'}}</td>
                    </template>
                    <template #body-cell-action="props">
                        <td width="150" align="right">
                            <div class="flex q-gutter-sm justify-end">
                                <q-btn @click="$inertia.get(route('notice.edit',props.row.id))" size="sm" icon="edit" outline/>
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
    {name: 'title', align: 'left', label: 'title', field: 'title',},
    {name: 'published', align: 'left', label: 'Published', field: 'published',},
    {name: 'action', label: 'Action', field: 'id', },
]

const q = useQuasar();
const rows = ref(props.list.data || [])
const loading = ref(false)
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
    })
    .onOk(()=>{
        router.delete(route('notice.destroy',item.id),{
            onStart:params => q.loading.show({message:'Deleting...'}),
            onFinish:params => q.loading.hide(),
            preserveState:false
        })
    })
}



function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination
    router.get(route('district.index'),{
        per_page:rowsPerPage,
        page:page
    },{
        onStart:params => loading.value=true,
        onFinish: params => loading.value = false
    })
}




</script>
