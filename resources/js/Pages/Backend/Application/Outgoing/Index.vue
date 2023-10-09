<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">Outbox</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el class="text-color" label="Outbox"/>
            </q-breadcrumbs>
        </div>
        <div>
            <q-btn @click="revert" :disable="selected.length<=0" color="accent" label="Revert" no-caps/>
            <q-btn-dropdown class="q-pa-xs" dropdown-icon="more_vert" flat>
                <q-list>
                    <q-item>
                        <q-item-section>Visible Column</q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section>
                            <q-checkbox v-for="col in visibleColumns" v-model="col.selected" :label="col.name" val=""/>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-btn-dropdown>
        </div>
    </div>
    <br/>
    <div class="flex justify-between items-center">
        <div>
            <q-input v-model="search"
                     autofocus
                     @update:model-value="handleSearch"
                     :debounce="800"
                     dense outlined
                     placeholder="Type here..."/>
        </div>

    </div>

    <br/>
    <q-table
        v-model:pagination="pagination"
        v-model:selected="selected"
        :columns="columns"
        :filter="filter"
        :loading="loading"
        :rows="rows"
        :rows-per-page-options="[7,15,30,50,100,200]"
        :visible-columns="visible"
        binary-state-sort
        flat
        row-key="id"
        selection="multiple"
        table-class="text-color"
        table-header-class="table-header"
        @request="onRequest"
        @row-click="onRowClick">


        <template #body-cell-action="props">
            <td align="right">
                <div class="flex q-gutter-sm justify-end">
                    <q-btn icon="undo" outline size="sm" @click.stop="handleUndo(props.row)"/>
                </div>
            </td>
        </template>
    </q-table>
</template>
<script setup>
import {computed, onMounted, reactive, ref} from 'vue'
import {router} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props = defineProps(['search','list', 'departments', 'districts','filter']);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'head_of_family', align: 'left', label: 'Head of Family', field: 'head_of_family',},
    {name: 'mobile', align: 'left', label: 'Mobile', field: 'mobile',},
    {name: 'epic_no', align: 'left', label: 'Epic no', field: 'epic_no',},
    {name: 'district', align: 'left', label: 'District', field: 'district', format: val => val?.name},
    {name: 'constituency', align: 'left', label: 'Constituency', field: 'constituency', format: val => val?.name},
    {name: 'department', align: 'left', label: 'Department', field: 'department', format: val => val?.name},
    {name: 'trade', align: 'left', label: 'Trade', field: 'trade', format: val => val?.name},
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
const selected = ref([]);
const search = ref(props.search);
const visibleColumns = ref([
    {name: 'head_of_family', selected: true},
    {name: 'mobile', selected: true},
    {name: 'district', selected: true},
    {name: 'constituency', selected: true},
    {name: 'department', selected: true},
    {name: 'trade', selected: true},
    {name: 'action', selected: true},
]);


const options = reactive({
    trades: [],
    constituencies: [],
})
const filterData = reactive({
    district: props.filter?.district || null,
    constituency: props.filter?.constituency || null,
    department: props.filter?.department || null,
    trade: props.filter?.trade || null
})

const visible = computed(args => visibleColumns.value.filter(item => item.selected).map(item => item.name))



const handleSearch=val=>{
    onRequest({pagination: pagination});
}
const handleUndo = item => {
    q.dialog({
        title: 'Confirmation',
        message: 'Do you want to undo',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
            router.delete(route('application.revert', item.id), {
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}
const revert=e=>{
    q.dialog({
        title: 'Confirmation',
        message: 'Do you want to revert',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
            router.put(route('application.bulk-revert'), {
                'ids':selected.value.map(item=>item.id)
            },{
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}

const onRowClick = (event, row, index) => router.get(route('application.show', row.id))


function onRequest(props) {
    const {page, rowsPerPage, sortBy, descending} = props.pagination
    router.get(route('application.outgoing'), {
        per_page: rowsPerPage,
        page: page,
        filter_district_id:filterData?.district?.value,
        filter_constituency_id:filterData?.constituency?.value,
        filter_trade_id:filterData?.trade?.value,
        filter_department_id:filterData?.department?.value,
        search:search.value
    }, {
        preserveState: false,
        onStart: params => loading.value = true,
        onFinish: params => loading.value = false,
    })
}


</script>
