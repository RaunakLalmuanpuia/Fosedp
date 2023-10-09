<template>
    <div class="container bg-white q-pa-md">
        <div class="flex justify-between items-center">
            <div>
                <p class="page-header">List of Department</p>
                <q-breadcrumbs >
                    <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard"/>
                    <q-breadcrumbs-el label="Departments"/>
                </q-breadcrumbs>
            </div>
            <q-btn color="accent" label="New Department"  @click="$inertia.get(route('department.create'))"/>
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
            :rows-per-page-options="[2,5,7,15,30,50]">

            <template #body-cell-sn="props">
                <td>{{props.rowIndex+1}}</td>
            </template>
            <template #body-cell-action="props">
                <td align="right">
                    <div class="flex q-gutter-sm justify-end">
                        <q-btn @click="$inertia.get(route('department.edit',props.row.id))" size="sm" icon="edit" outline/>
                        <q-btn @click="handleDelete(props.row)" size="sm" icon="delete" outline/>
                        <q-btn-dropdown flat class="q-pa-xs" dropdown-icon="more_vert">
                            <q-list>
                                <q-item v-close-popup clickable @click="addUser(props.row)">
                                    <q-item-section><q-item-label>Add User</q-item-label></q-item-section>
                                </q-item>
                            </q-list>
                        </q-btn-dropdown>
                    </div>
                </td>
            </template>
        </q-table>

        <q-dialog v-model="state.openUser">
            <AddDepartmentUser :open="state.openUser"
                               :department="state.department"
                               @onSuccess="state.openUser=false"/>
        </q-dialog>

        />

    </div>


</template>
<script setup>
import {onMounted, reactive, ref} from 'vue'
import {router} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import AddDepartmentUser from "@/Components/AddDepartmentUser.vue";

const props = defineProps(['list']);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'name', align: 'left', label: 'Name', field: 'name',},
    {name: 'action', label: 'Action', field: 'id', },
]

const q = useQuasar();
const state=reactive({
    openUser:false,
    department:null
})
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
        router.delete(route('department.destroy',item.id),{
            onStart:params => q.loading.show({message:'Deleting...'}),
            onFinish:params => q.loading.hide(),
            preserveState:false
        })
    })
}

const addUser=item=>{
    state.department = item;
    state.openUser = true;
}
function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination

    router.get(route('user.index'),{
        per_page:rowsPerPage,
        page:page
    },{
        onStart:params => loading.value=true,
        onFinish: params => loading.value = false
    })
}




</script>
