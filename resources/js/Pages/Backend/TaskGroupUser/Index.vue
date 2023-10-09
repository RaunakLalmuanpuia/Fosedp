<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">List of your Task Group User</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="o_dashboard" label="Dashboard" @click="$inertia.get(route('dashboard'))"/>
                <q-breadcrumbs-el class="text-color" label="Task group users"/>
            </q-breadcrumbs>
        </div>

    </div>
    <br/>
    <div class="flex justify-between items-center">
        <q-input v-model="search"
                 :debounce="800"
                 dense
                 outlined
                 placeholder="Type here"
                 @update:model-value="handleSearch"
        />
        <q-btn color="accent" label="New Task Group User"
               @click="$inertia.get(route('task-group-user.create'),{},{
                    preserveState:false
                })"/>
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
        <template #body-cell-roles="props">
            <td align="left">
                <q-chip v-for="role in props.row.roles"
                        :label="role?.name" square/>
            </td>
        </template>

        <template #body-cell-action="props">
            <td align="right">
                <div class="flex q-gutter-sm justify-end">
                    <q-btn icon="edit" outline size="sm" @click="$inertia.get(route('task-group-user.edit',props.row.id))"/>
                    <q-btn icon="delete" outline size="sm" @click="handleDelete(props.row)"/>

                </div>
            </td>
        </template>
    </q-table>
</template>
<script setup>
import {onMounted, ref} from 'vue'
import ApplicationLayout from "@/Layouts/ApplicationLayout.vue";
import {router} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props = defineProps(['list', 'search']);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'name', align: 'left', label: 'Name', field: 'user',format:val=>val.name},
    {name: 'email', align: 'left', label: 'Email', field: 'user',format:val=>val.email},
    {name: 'mobile', align: 'left', label: 'Mobile', field: 'user',format:val=>val.mobile},
    {name: 'district', align: 'left', label: 'District', field: 'district',format:val=>val.name},
    {name: 'action', label: 'Action', field: 'id',},
]

const q = useQuasar();
const rows = ref(props.list.data || [])
const loading = ref(false)
const search = ref(props.search);
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
    }).onOk(() => {
            router.delete(route('task-group-user.destroy', item.id), {
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
    })
}

const handleSearch = val => {
    onRequest({pagination: pagination.value});
}


function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination

    router.get(route('user.index'), {
        per_page: rowsPerPage,
        page: page,
        search: search.value
    }, {
        preserveState: false,
        onStart: params => loading.value = true,
        onFinish: params => loading.value = false
    })
}


</script>
