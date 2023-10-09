<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">List of Constituency</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el label="Constituencies"/>
            </q-breadcrumbs>
        </div>
        <q-btn color="accent" label="New Constituency" @click="$inertia.get(route('constituency.create'))"/>
    </div>
    <br/>
    <q-table
        v-model:pagination="pagination"
        :columns="columns"
        :filter="filter"
        :loading="loading"
        :rows="rows"
        :rows-per-page-options="[2,5,7,15,30,50]"
        binary-state-sort
        flat
        row-key="id"
        table-class="text-color"
        table-header-class="table-header"
        @request="onRequest">

        <template #body-cell-sn="props">
            <td>{{ props.rowIndex + 1 }}</td>
        </template>

        <template #body-cell-action="props">
            <td align="right">
                <div class="flex q-gutter-sm justify-end">
                    <q-btn icon="edit" outline size="sm"
                           @click="$inertia.get(route('constituency.edit',props.row.id))"/>
                    <q-btn icon="delete" outline size="sm" @click="handleDelete(props.row)"/>
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
    {name: 'district', align: 'center', label: 'District', field: 'district', format: val => val?.name || ''},
    {name: 'action', label: 'Action', field: 'id',},
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
        title: 'Confirm Delete',
        message: 'Do you want to delete',
        ok: 'Yes',
        cancel: 'No'
    })
        .onOk(() => {
            router.delete(route('constituency.destroy', item.id), {
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}


function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination
    router.get(route('constituency.index'), {
        per_page: rowsPerPage,
        page: page
    }, {
        onStart: params => loading.value = true,
        onFinish: params => loading.value = false
    })
}


</script>
