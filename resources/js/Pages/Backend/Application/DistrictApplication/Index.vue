<template>
    <div class="flex justify-between items-center">
        <div>
            <p class="page-header">List of Application</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el class="text-color" label="Inbox"/>
            </q-breadcrumbs>
        </div>
        <div>

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
<!--            <a @click="exportExcel" class="q-btn q-btn-item non-selectable no-outline q-btn&#45;&#45;outline q-btn&#45;&#45;rectangle  q-btn&#45;&#45;actionable q-focusable q-hoverable ">Export To Excel</a>-->
            <q-btn v-if="canExport" color="accent" @click="exportExcel" label="Export EXCEL"/>
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
        :rows="listData.data"
        :rows-per-page-options="[7,15,30,50,100,200]"
        :visible-columns="visible"
        flat
        row-key="id"
        selection="multiple"
        table-class="text-color"
        table-header-class="table-header"
        @request="onRequest"
        @row-click="onRowClick">

    </q-table>




</template>
<script setup>
import {computed, onMounted, reactive, ref} from 'vue'
import {router, usePage} from "@inertiajs/vue3";
import {useQuasar} from "quasar";

const props = defineProps([
    'departments', 'districts','constituencies','district'
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
    {name: 'first_movement', align: 'center', label: 'Entry', field: 'first_movement',format:val => val?.recipient?.name},
    {name: 'last_movement', align: 'center', label: 'Current Location', field: 'last_movement',format:val => val?.recipient?.name},
]

const q = useQuasar();
const loading = ref(false)

const pagination = ref({
    page: 1,
    rowsPerPage: 15,
    rowsNumber: 0
})
const listData = reactive({
    per_page: 3,
    data: [],
    current_page: 1,
    total: 1
});
const selected = ref([]);
const search = ref(props.search);

const visibleColumns = ref([
    {name: 'head_of_family', selected: true},
    {name: 'mobile', selected: true},
    {name: 'district', selected: true},
    {name: 'constituency', selected: true},
    {name: 'department', selected: true},
    {name: 'trade', selected: true},
    {name: 'first_movement', selected: true},
    {name: 'last_movement', selected: true},
    {name: 'action', selected: true},
]);

const pageCount= computed(() => Math.ceil(listData.total / listData.per_page));
const canExport=computed(()=>{
    const roles=usePage().props.roles;
    if (roles) {
        const role = roles[0];
        return role === 'planning' || role === 'admin' || role==='governing' || role==='dc-approval' || role==='dc-verifier';
    }
    return false;
})

const filterData = reactive({
    district:props?.district || null,
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

onMounted(()=>{
    filterData.district = props.districts[0] || null;
    onDistrictSelect(filterData.district);
    onRequest({pagination:pagination.value})
})


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


const handleSearch=val=>onRequest({pagination:pagination.value});

const onRowClick = (event, row, index) => router.get(route('application.show', row.id))

const doFilter = e => onRequest({pagination:pagination.value})

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

const exportExcel=(e)=>{
    router.get(route('export.district-application',{
        district_id: filterData.district?.value || null,
        constituency_id: filterData.constituency?.value || null,
        trade_id: filterData.trade?.value || null,
        department_id: filterData.department?.value || null,
    }), {},{
        onStart:params => q.loading.show({message:'Generating...'}),
        onFinish:params => q.loading.hide(),
        preserveState:false
    })
}
const onRequest = prop => {
    const {page, rowsPerPage, sortBy, descending} = prop.pagination
    q.loading.show()
    axios.get(route('application.district.all'), {
        params: {
            page, rowsPerPage, sortBy, descending, search: search.value,
            district_id: filterData.district?.value || null,
            constituency_id: filterData.constituency?.value || null,
            trade_id: filterData.trade?.value || null,
            department_id: filterData.department?.value || null,
        }
    }).then(res => updateTableData(res.data.list))
        .catch(err => q.notify({type: 'negative', message: err.response?.data?.message || err.toString()}))
        .finally(() =>q.loading.hide() )
}


const updateTableData = list => {
    const {current_page, per_page, data, to, total} = list
    listData.data = data;
    pagination.value.rowsNumber = total;
    pagination.value.page = current_page;
    pagination.value.rowsPerPage = per_page;
}


</script>
