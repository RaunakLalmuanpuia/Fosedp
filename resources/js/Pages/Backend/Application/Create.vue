<template>
    <div class="bg-white">
        <div class="flex justify-between items-center text-color">
            <div class="full-width">
                <div class="text-center full-width">
                    <p class="page-header">FORM-4</p>
                    <p class="page-description">(Family Oriented SEDP hnuaia thlan tur chhungkua Village?local Level SEDP Committee ten District Level Committee hnenah rawtna an thlenna)</p>
                </div>
                <q-breadcrumbs>
                    <q-breadcrumbs-el :href="route('dashboard')" label="Dashboard" icon="o_dashboard" />
                    <q-breadcrumbs-el label="New Application" />
                </q-breadcrumbs>
                <q-separator class="full-width q-my-sm"/>

            </div>
        </div>
        <br/>
        <q-form @submit="submit" class="row q-col-gutter-sm">
            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.head_of_family"
                         no-error-icon
                         placeholder="Chhungkaw hotu hming"
                         outlined
                         :error="!!form?.errors?.head_of_family"
                         :error-message="form?.errors?.head_of_family"
                         :rules="[
                                 val=>!!val || 'Head of family is required'
                             ]"
                         label="Head of Family *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.mobile"
                         mask="##########"
                         no-error-icon
                         outlined
                         :error="!!form?.errors?.mobile"
                         :error-message="form?.errors?.mobile"
                         :rules="[
                                 val=>!!val || 'Mobile is required'
                             ]"
                         label="Mobile No *"/>
            </div>


            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.epic_no"
                         no-error-icon
                         outlined
                         :error="!!form?.errors?.epic_no"
                         :error-message="form?.errors?.epic_no"
                         :rules="[
                                 val=>!!val || 'Epic No is required'
                             ]"
                         label="Voter Epic No *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.address"
                         type="textarea"
                         placeholder="House No,Veng,Khua,District"
                         no-error-icon
                         outlined
                         :error="form?.errors?.address"
                         :error-message="form?.errors?.address"
                         :rules="[
                                 val=>!!val || 'Address is required'
                             ]"
                         label="Address *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-select v-model="form.district"
                          :options="districts"
                          no-error-icon
                          outlined
                          @update:model-value="onDistrictSelect"
                         :error="!!form?.errors?.district"
                         :error-message="form?.errors?.district"
                         :rules="[
                                 val=>!!val || 'District is required'
                             ]"
                         label="District *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-select v-model="form.constituency"
                          :options="options.constituencies"
                          no-error-icon
                          outlined
                          :error="!!form?.errors?.constituency_id"
                          :error-message="form?.errors?.constituency_id"
                          :rules="[
                                 val=>!!val || 'Constituency is required'
                             ]"
                          label="Constituency *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-select v-model="form.department"
                          :options="departments"
                          outlined
                          no-error-icon
                          @update:model-value="onDepartmentSelect"
                          :error="!!form?.errors?.department_id"
                          :error-message="form?.errors?.department_id"
                          :rules="[
                                 val=>!!val || 'Department is required'
                             ]"
                          label="Department *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-select v-model="form.trade"
                          :input-debounce="800"
                          :options="options.trades"
                          no-error-icon
                          outlined
                          @update:model-value="onTradeSelect"
                          :error="!!form?.errors?.trade_id"
                          :error-message="form?.errors?.trade_id"
                          :rules="[
                                 val=>!!val || 'Trade is required'
                             ]"
                          label="Trade *"/>
            </div>

            <div class="col-xs-12 col-sm-6">
                <q-select v-model="form.subTrade"
                          v-if="options.subTrades.length>0"
                          outlined
                          :options="options.subTrades"
                          label="Sub Trade"/>
            </div>
            <div class="col-xs-12">
                <p class="q-mt-md text-lg text-color">Bank Account</p>
            </div>

            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.ac_no"
                         :error="!!form?.errors?.ac_no"
                         :error-message="form?.errors?.ac_no"
                         no-error-icon
                         outlined
                         :rules="[
                                 val=>!!val || 'Account No is required'
                             ]"
                         label="Account No *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.bank_name"
                         :error="!!form?.errors?.bank_name"
                         :error-message="form?.errors?.bank_name"
                         no-error-icon
                         outlined
                         :rules="[
                                 val=>!!val || 'Bank name is required'
                             ]"
                         label="Bank Name *"/>
            </div>
            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.branch_name"
                         :error="!!form?.errors?.branch_name"
                         :error-message="form?.errors?.branch_name"
                         no-error-icon
                         outlined
                         :rules="[
                                 val=>!!val || 'Branch name is required'
                             ]"
                         label="Branch Name *"/>
            </div>

            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.ac_holder"
                         :error="!!form?.errors?.ac_holder"
                         :error-message="form?.errors?.ac_holder"
                         no-error-icon
                         outlined
                         :rules="[
                                 val=>!!val || 'Account holder is required'
                             ]"
                         label="Account Holder *"/>
            </div>

            <div class="col-xs-12 col-sm-6">
                <q-input v-model="form.ifsc"
                         :error="!!form?.errors?.ifsc"
                         :error-message="form?.errors?.ifsc"
                         no-error-icon
                         outlined
                         :rules="[
                                 val=>!!val || 'IFSC is required',
                                 val => val?.length===11 || 'IFSC Code must be 11 character'
                             ]"
                         label="IFSC *"/>
            </div>



            <div class="col-xs-12">
                <div class="flex q-gutter-sm">
                    <q-btn type="submit" color="accent" label="Submit"/>
                    <q-btn @click="$inertia.get(route('application.received'))" color="negative" label="Cancel"/>
                </div>
            </div>

        </q-form>
    </div>

</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import {onMounted, reactive} from "vue";
import {useQuasar} from "quasar";

const q = useQuasar();
const props = defineProps([ 'districts','departments'])
const form = useForm({
    head_of_family: '',
    mobile: '',
    epic_no: '',
    address: '',
    district: null,
    constituency: null,
    department: null,
    trade: null,
    subTrade: null,

    bank_name: '',
    branch_name: '',
    ac_holder: '',
    ac_no: '',
    ifsc: ''
})
const member = reactive({
    name:'',
    relation:''
});
const options=reactive({
    constituencies:[],
    trades:[],
    subTrades:[]
})

const addMember=e=>{

}
const submit=e=>{
    form.transform(data => ({
        ...data,
        district_id:data.district?.value,
        constituency_id:data.constituency?.value,
        department_id:data.department?.value,
        trade_id:data.trade.value,
        subtrade_id:data?.subTrade?.value || null
    })).post(route('application.store'),{
        onStart:params => q.loading.show({message:'Submitting ...'}),
        onError: params => console.log(params),
        onFinish:params => q.loading.hide()
    })
}

const onDistrictSelect=val=>{
    if (val) {
        form.constituency = null;
        q.loading.show()
        axios.get(route('option.district.constituencies',val.value))
        .then(res=>{
            const {list} = res.data;
            options.constituencies = list;
        })
        .catch(err=>{
            q.notify({
                type:'negative',
                message:err?.response?.data?.message || err.toString()
            })
        })
        .finally(()=>q.loading.hide())
    }
}
const onDepartmentSelect=val=>{
    if (val) {
        form.trade = null;
        form.subTrade = null;
        q.loading.show()
        axios.get(route('option.department.trades',val.value))
            .then(res=>{
                const {list} = res.data;
                options.trades = list;
            })
            .catch(err=>{
                q.notify({
                    type:'negative',
                    message:err?.response?.data?.message || err.toString()
                })
            })
            .finally(()=>q.loading.hide())
    }
}
async function filterTrade(val, update, abort) {
    try {
        const result = await axios.get(route('option.trades'), {
            params: {
                search: val
            }
        });
        update(() => {
            const {list} = result.data;
            options.trades = list;
        })
    } catch (e) {
        abort()
    }
}

onMounted(()=>{
    // q.loading.show()
    //     axios.get(route('option.trades'))
    //         .then(res=>{
    //             const {list} = res.data;
    //             options.trades = list;
    //         })
    //         .catch(err=>{
    //             q.notify({
    //                 type:'negative',
    //                 message:err?.response?.data?.message || err.toString()
    //             })
    //         })
    //         .finally(()=>q.loading.hide())
})
const onTradeSelect=val=>{
    if (val) {
        form.subTrade = null;
        q.loading.show()
        axios.get(route('option.trade.subtrades',val.value))
            .then(res=>{
                const {list} = res.data;
                options.subTrades = list;
            })
            .catch(err=>
                q.notify({
                    type:'negative',
                    message:err?.response?.data?.message || err.toString()
                })
            )
            .finally(()=>q.loading.hide())
    }
}


</script>
