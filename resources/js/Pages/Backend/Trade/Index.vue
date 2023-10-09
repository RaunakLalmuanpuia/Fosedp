<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">List of Trades</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el label="Trades"/>
            </q-breadcrumbs>
        </div>
        <q-btn color="accent" label="New Trade" @click="$inertia.get(route('trade.create'))"/>
    </div>
    <br/>

    <div class="flex justify-between items-center">
        <q-input v-model="search"
                 :debounce="800"
                 dense
                 outlined
                 placeholder="Type here"
                 @update:model-value="doSearch"
        />
    </div>
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
                    <q-btn icon="edit" outline size="sm" @click="$inertia.get(route('trade.edit',props.row.id))"/>
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

const props = defineProps(['list','search']);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'name', align: 'left', label: 'Name', field: 'name',},
    {name: 'department', align: 'left', label: 'Department', field: 'department', format: val => val?.name || 'NA'},
    {name: 'action', label: 'Action', field: 'id',},
]

const q = useQuasar();
const search = ref(props.search);
const rows = ref(props.list.data || [])
const loading = ref(false)
const pagination = ref({
    page: props.list.current_page,
    rowsPerPage: props.list.per_page,
    rowsNumber: props.list.total
})

const doSearch = search => {
    router.get(route('trade.index'), {
        search
    }, {
        onStart: params => q.loading.show(),
        onFinish: params => q.loading.hide()
    })
}

const handleDelete = item => {
    q.dialog({
        title: 'Confirm Delete',
        message: 'Do you want to delete',
        ok: 'Yes',
        cancel: 'No'
    })
        .onOk(() => {
            router.delete(route('trade.destroy', item.id), {
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}


function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination
    console.log(props.pagination);
    router.get(route('trade.index'), {
        per_page: rowsPerPage,
        page: page
    }, {
        onStart: params => loading.value = true,
        onFinish: params => loading.value = false
    })
}


</script>
