<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">Inbox</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el class="text-color" label="Inbox"/>
            </q-breadcrumbs>
        </div>
        <div>
            <q-btn-dropdown  color="accent" :disable="selected.length<=0" @click="bulkForward" split label="Forward" no-caps>
                <q-list>
                    <q-item clickable @click="sendBack">
                        <q-item-section><q-item-label>Send Back</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canVerify" clickable @click="verify">
                        <q-item-section><q-item-label>Verify</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canApprove" clickable @click="approve">
                        <q-item-section><q-item-label>Approve</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canPlanningVerify" clickable @click="verifyPlanning">
                        <q-item-section><q-item-label>Verify(Planning)</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canPlanningApprove" clickable @click="approvePlanning">
                        <q-item-section><q-item-label>Approve(Planning)</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canExecutiveApprove" clickable @click="approveExecutive">
                        <q-item-section><q-item-label>Approve(Executive)</q-item-label></q-item-section>
                    </q-item>
                    <q-item v-if="canBoardApprove" clickable @click="approveBoard">
                        <q-item-section><q-item-label>Approve(Governing Board)</q-item-label></q-item-section>
                    </q-item>
                </q-list>
            </q-btn-dropdown>
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
        <div class="flex q-gutter-sm">
            <a :href="route('export.received-application')"
               class="q-btn q-btn-item non-selectable no-outline q-btn--outline q-btn--rectangle  q-btn--actionable q-focusable q-hoverable ">Export To Excel</a>
            <q-btn-dropdown  dropdown-icon="sort"  flat>
                <q-list class="q-pa-md" style="min-width: 250px">
                    <p class="text-color text-lg q-my-sm">Filter</p>
                    <q-form @submit="doFilter">
                        <q-select v-model="filterData.district"
                                  :options="districts"
                                  label="District"
                                  @update:model-value="onDistrictSelect"
                        />
                        <q-select v-model="filterData.constituency"
                                  :options="options.constituencies"
                                  label="Constituency"
                        />
                        <q-select v-model="filterData.department"
                                  :options="departments"
                                  label="Department"
                                  @update:model-value="onDepartmentSelect"
                        />
                        <q-select v-model="filterData.trade"
                                  :options="options?.trades"
                                  label="Trade"
                        />
                        <div class="flex q-gutter-sm q-mt-md">
                            <q-btn type="submit" color="primary" label="Apply"/>
                            <q-btn v-close-popup color="negative" label="Clear" outline @click="clearFilter"/>
                        </div>
                    </q-form>
                </q-list>
            </q-btn-dropdown>
        </div>
    </div>
    <div v-if="filtered" class="flex items-baseline q-gutter-sm q-mt-md">
        <p class="text-bold text-primary">Filter :</p>
        <q-chip v-if="filterData.district!=null" :label="filterData.district?.label" removable
                @remove="removeFilter('district')"/>
        <q-chip v-if="filterData.constituency!=null" :label="filterData.constituency?.label" removable
                @remove="removeFilter('constituency')"/>
        <q-chip v-if="filterData.department!=null" :label="filterData.department?.label" removable
                @remove="removeFilter('department')"/>
        <q-chip v-if="filterData.trade!=null" :label="filterData.trade?.label" removable
                @remove="removeFilter('trade')"/>
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
        flat
        row-key="id"
        selection="multiple"
        table-class="text-color"
        table-header-class="table-header"
        @request="onRequest"
        @row-click="onRowClick">
        <template #body-cell-action="props">
            <td align="right">
                <div class="flex justify-end q-gutter-sm">
                    <q-btn @click.stop="$inertia.get(route('application.edit',props.row.id))" size="sm" icon="edit" outline/>
<!--                    <q-btn @click.stop="handleDelete(props.row)" size="sm" icon="delete" outline/>-->
                </div>
            </td>
        </template>
        <template #body-cell-current_status="props">
            <td align="right">
                <div class="flex justify-end q-gutter-sm">
                  <q-chip dark square
                          :label="props.row?.current_status?.name"/>
                </div>
            </td>
        </template>
    </q-table>

    <q-dialog v-model="modal.other">
        <BulkForward :files="selected"/>
    </q-dialog>

    <q-dialog v-model="modal.verifier">
        <DCVerifierForward :files="selected"/>
    </q-dialog>

    <q-dialog v-model="modal.approval">
        <DCApprovalForward :files="selected"/>
    </q-dialog>
    <q-dialog v-model="modal.planning">
        <PlanningForward :files="selected"/>
    </q-dialog>
    <q-dialog v-model="modal.office">
        <OfficeForward :files="selected"/>
    </q-dialog>


</template>
<script setup>
import {computed, onMounted, reactive, ref} from 'vue'
import {router, usePage} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import DcForward from "@/Components/DcForward.vue";
import PlanningForward from "@/Components/PlanningForward.vue";
import OfficeForward from "@/Components/OfficeForward.vue";
import BulkForward from "@/Components/BulkForward.vue";
import DCVerifierForward from "@/Components/DCVerifierForward.vue";
import DCApprovalForward from "@/Components/DCApprovalForward.vue";

const props = defineProps([
    'search','list', 'departments', 'districts','filter','canVerify',
    'canApprove','canPlanningVerify','canPlanningApprove','canExecutiveApprove','canBoardApprove'
]);
const columns = [
    {name: 'sn', align: 'left', label: 'SN', field: 'id'},
    {name: 'head_of_family', align: 'left', label: 'Head of Family', field: 'head_of_family',},
    {name: 'mobile', align: 'left', label: 'Mobile', field: 'mobile',},
    {name: 'epic_no', align: 'left', label: 'Epic no', field: 'epic_no',},
    {name: 'district', align: 'left', label: 'District', field: 'district', format: val => val?.name},
    {name: 'constituency', align: 'left', label: 'Constituency', field: 'constituency', format: val => val?.name},
    {name: 'department', align: 'left', label: 'Department', field: 'department', format: val => val?.name},
    {name: 'trade', align: 'left', label: 'Trade', field: 'trade', format: val => val?.name},
    {name: 'current_status', align: 'center', label: 'Status', field: 'current_status'},
    {name: 'action', label: 'Action', field: 'id',},
]

const q = useQuasar();
const rows = ref(props.list.data || [])
const loading = ref(false)
const openBulk = ref(false)
const pagination = ref({
    page: props.list.current_page,
    rowsPerPage: props.list.per_page,
    rowsNumber: props.list.total
})
const selected = ref([]);
const search = ref(props.search);
const modal=reactive({
    verifier:false,
    approval:false,
    planning:false,
    office:false,
    other:false,
})
const visibleColumns = ref([
    {name: 'head_of_family', selected: true},
    {name: 'mobile', selected: true},
    {name: 'district', selected: true},
    {name: 'constituency', selected: true},
    {name: 'department', selected: true},
    {name: 'trade', selected: true},
    {name: 'current_status', selected: true},
    {name: 'action', selected: true},
]);

const filterData = reactive({
    district: props.filter?.district || null,
    constituency: props.filter?.constituency || null,
    department: props.filter?.department || null,
    trade: props.filter?.trade || null
})
const options = reactive({
    trades: [],
    constituencies: [],
})

const visible = computed(args => visibleColumns.value.filter(item => item.selected).map(item => item.name))
const filtered = computed(() => !!filterData.department || !!filterData.constituency || !!filterData.trade || !!filterData.district)

const sendBack=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to send back',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-send-back'),{
                ids
            },{
                preserveState:false,
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}
const verify=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to verify',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        const ids = selected.value.map(item => item.id);
        router.post(route('application.bulk-verify'),{
            ids
        },{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide(),
        })
    })
}
const approve=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to Approve',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-approve'),{
                ids
            },{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}

const verifyPlanning=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to verify',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-planning-verify'),{
                ids
            },{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}
const approvePlanning=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to Approve',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-planning-approve'),{
                ids
            },{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}
const approveExecutive=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to Approve',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-executive-approve'),{
                ids
            },{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}
const approveBoard=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to Approve',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            const ids = selected.value.map(item => item.id);
            router.post(route('application.bulk-board-approve'),{
                ids
            },{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide(),
            })
        })
}

const removeFilter = param => {
    switch (param) {
        case 'district':
            filterData.district = null;
            break;
        case 'constituency':
            filterData.constituency = null;
            break;
        case 'department':
            filterData.department = null;
            break;
        case 'trade':
            filterData.trade = null;
            break;
    }
    onRequest({pagination: pagination});
}
const bulkForward=e=> {

    const roles = usePage().props?.roles;
    if (roles.find(item => item === 'dc')) {
        modal.verifier = true;
    }else if(roles.find(item => item === 'dc-verifier')){
        modal.approval = true;
    }
    else if(roles.find(item => item === 'dc-approval')){
        modal.planning = true;
    }
    else if(roles.find(item => item === 'department')){
        modal.office = true;
    }
    else if(roles.find(item => item === 'planning')){
        modal.other = true;
    }
    openBulk.value = true;
}
const exportExcel=e=>{
    router.get(route('export.received-application'))
}
const handleSearch=val=>{
    onRequest({pagination: pagination});
}
const handleDelete = item => {
    q.dialog({
        title: 'Confirm Delete',
        message: 'Do you want to delete',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
            router.delete(route('application.destroy', item.id), {
                onStart: params => q.loading.show({message: 'Deleting...'}),
                onFinish: params => q.loading.hide(),
                preserveState: false
            })
        })
}

const onRowClick = (event, row, index) => router.get(route('application.show', row.id))

const doFilter = e => {
    onRequest({pagination:pagination})
}
const clearFilter = e => {
    filterData.district = null;
    filterData.trade = null;
    filterData.constituency = null;
    filterData.department = null;
    onRequest({pagination:pagination})
}
const onDistrictSelect = val => {
    if (val) {
        filterData.constituency = null;
        q.loading.show()
        axios.get(route('option.district.constituencies', val.value))
            .then(res => {
                const {list} = res.data;
                options.constituencies = list;
            })
            .catch(err => {
                q.notify({
                    type: 'negative',
                    message: err?.response?.data?.message || err.toString()
                })
            })
            .finally(() => q.loading.hide())
    }
}
const onDepartmentSelect = val => {
    if (val) {
        filterData.trade = null;
        q.loading.show()
        axios.get(route('option.department.trades', val.value))
            .then(res => {
                const {list} = res.data;
                options.trades = list;
            })
            .catch(err => {
                q.notify({
                    type: 'negative',
                    message: err?.response?.data?.message || err.toString()
                })
            })
            .finally(() => q.loading.hide())
    }
}


function onRequest(props) {
    const {page, rowsPerPage} = props.pagination;
    router.get(route('application.received'), {
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
