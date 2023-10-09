<template>
    <div class="bg-white">
        <div class="flex justify-between items-center text-color print-hide">
            <div>
                <p class="page-header">Application</p>
                <q-breadcrumbs>
                    <q-breadcrumbs-el @click="$inertia.replace(route('dashboard'))" label="Dashboard" icon="o_dashboard" />
                    <q-breadcrumbs-el @click="$inertia.replace(route('application.received'))" label="Inbox" icon="o_list" />
                    <q-breadcrumbs-el :label="data?.head_of_family" />
                </q-breadcrumbs>
            </div>

            <div class="flex q-gutter-sm">
                <q-btn @click="handlePrint" color='positive' class="text-dark" icon="o_print"/>
                <UpdateStatus v-if="received" :files="[data]" @onSuccess="onStatusUpdated"/>
                <q-btn v-if="takeable" @click="take()" color="primary" label="Take" no-caps/>
                <q-btn v-if="pullable" @click="pullBack()" color="accent" label="Pull Back" no-caps/>

                <q-btn-dropdown flat class="q-pa-xs" dropdown-icon="more_vert">
                    <q-list>
                        <q-item v-if="canEdit" clickable @click="$inertia.get(route('application.edit',data.id))">
                            <q-item-section>Edit</q-item-section>
                        </q-item>
                        <q-item v-if="canDelete" clickable @click="handleDelete()">
                            <q-item-section>Delete</q-item-section>
                        </q-item>
                    </q-list>
                </q-btn-dropdown>
            </div>
        </div>
        <br/>
        <q-separator class="q-my-sm"/>
        <div class="row q-col-gutter-md print-hide">
            <div class="col-xs-12 col-sm-8">
                <div class="q-pa-md bg-white">
                    <table class="text-weight-medium full-width application">
                        <tr>
                            <td width="120px" class="text-dark">Head of Family</td>
                            <td class="text-dark text-bold">{{data?.head_of_family}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Mobile</td>
                            <td class="text-dark text-bold">{{data?.mobile}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Epic No</td>
                            <td class="text-dark text-bold">{{data?.epic_no}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">District</td>
                            <td class="text-dark text-bold">{{data?.district?.name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Constituency</td>
                            <td class="text-dark text-bold">{{data?.constituency?.name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Department</td>
                            <td class="text-dark text-bold">{{data?.department?.name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Trade</td>
                            <td class="text-dark text-bold">{{data?.trade?.name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Sub Trade</td>
                            <td class="text-dark text-bold">{{data?.sub_trade?.name || '--'}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Status</td>
                            <td class="text-dark text-bold">{{data?.current_status?.name || '--'}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><q-separator/></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-color text-md">Bank Account</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Name of Bank</td>
                            <td class="text-dark text-bold">{{data?.bank_account?.bank_name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Name of Branch</td>
                            <td class="text-dark text-bold">{{data?.bank_account?.branch_name}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Account No</td>
                            <td class="text-dark text-bold">{{data?.bank_account?.ac_no}}</td>
                        </tr>
                        <tr>
                            <td width="120px" class="text-dark">Account Holder</td>
                            <td class="text-dark text-bold">{{data?.bank_account?.ac_holder}}</td>
                        </tr>

                        <tr>
                            <td width="120px" class="text-dark">IFSC</td>
                            <td class="text-dark text-bold">{{data?.bank_account?.ifsc}}</td>
                        </tr>

                    </table>
                    <div v-if="received" class="flex q-gutter-sm q-mt-md rounded-borders print-hide">
<!--                        <DcForward v-if="dcForward" @onSuccess="$inertia.replace(route('application.received'))" :files="[data]"/>-->
<!--                        <PlanningForward v-if="planningForward" @onSuccess="$inertia.replace(route('application.received'))" :files="[data]"/>-->
<!--                        <OfficeForward v-if="officeForward" @onSuccess="$inertia.replace(route('application.received'))" :files="[data]"/>-->
<!--                        <ExecutiveForward v-if="executiveForward" @onSuccess="$inertia.replace(route('application.received'))" :files="[data]"/>-->

                        <q-btn v-if="forwardTo.find(item=>item==='dc')" @click="forward('dc')" label="Forward To DC Entry" color="accent"/>
                        <q-btn v-if="forwardTo.find(item=>item==='dc-verifier')" @click="forward('dc-verifier')" label="Forward To Verifier(DC Level)" color="accent"/>
                        <q-btn v-if="forwardTo.find(item=>item==='dc-approval')" @click="forward('dc-approval')" label="Forward To Approval(DC Level)" color="primary"/>
                        <q-btn v-if="forwardTo.find(item=>item==='planning')" @click="forward('planning')" label="Forward To Planning" color="accent"/>
                        <q-btn v-if="forwardTo.find(item=>item==='office')" @click="forward('office')" label="Forward To Task Group" color="accent"/>
                        <q-separator vertical/>
                        <q-btn :disable="!canSendBack" @click="sendBack" color="negative" outline label="Send Back"/>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 print-hide">
                <div class="left-bordered">
                    <q-expansion-item header-class="text-weight-medium text-lg" label="Activity Log" default-opened>
                        <q-timeline  color="secondary">

                            <q-timeline-entry
                                v-for="(audit,index) in audits"
                                :subtitle="formatDateTime(audit.created_at)"
                                side="left"
                                :key="index">
                                <template #title>
                                    <div class="text-uppercase text-color text-md ">{{audit?.event}}</div>
                                    <div class="text-color text-sm">Created By :{{audit?.user?.name}}</div>
                                </template>
                                <EditHistory :audit="audit" :bank_audit="bank_audit"/>
                            </q-timeline-entry>
                        </q-timeline>
                    </q-expansion-item>

                </div>
                <div class="left-bordered ">
                    <q-expansion-item header-class=" text-lg text-color" label="Movement History" default-opened>
                        <MovementHistory :file="data"/>
                    </q-expansion-item>
                </div>
            </div>
        </div>

        <q-dialog v-model="modal.dc">
            <DcForward :files="[data]" @onSuccess="$inertia.get('application.received')"/>
        </q-dialog>
        <q-dialog v-model="modal.verifier">
            <DCVerifierForward :files="[data]" @onSuccess="$inertia.get('application.received')"/>
        </q-dialog>
        <q-dialog v-model="modal.approval">
            <DCApprovalForward :files="[data]" @onSuccess="$inertia.get('application.received')"/>
        </q-dialog>
        <q-dialog v-model="modal.planning">
            <PlanningForward :files="[data]" @onSuccess="$inertia.get('application.received')"/>
        </q-dialog>

        <q-dialog v-model="modal.office">
            <OfficeForward :files="[data]" @onSuccess="$inertia.get('application.received')"/>
        </q-dialog>

        <table class="text-weight-medium full-width print-only bg-dark to_print">
            <tr>
                <td width="120px" class="text-dark">Head of Family</td>
                <td class="text-dark text-bold">{{data?.head_of_family}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Mobile</td>
                <td class="text-dark text-bold">{{data?.mobile}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Epic No</td>
                <td class="text-dark text-bold">{{data?.epic_no}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">District</td>
                <td class="text-dark text-bold">{{data?.district?.name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Constituency</td>
                <td class="text-dark text-bold">{{data?.constituency?.name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Department</td>
                <td class="text-dark text-bold">{{data?.department?.name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Trade</td>
                <td class="text-dark text-bold">{{data?.trade?.name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Sub Trade</td>
                <td class="text-dark text-bold">{{data?.sub_trade?.name || '--'}}</td>
            </tr>

            <tr>
                <td colspan="2"><q-separator/></td>
            </tr>
            <tr>
                <td colspan="2" class="text-color text-md">Bank Account</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Name of Bank</td>
                <td class="text-dark text-bold">{{data?.bank_account?.bank_name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Name of Branch</td>
                <td class="text-dark text-bold">{{data?.bank_account?.branch_name}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Account No</td>
                <td class="text-dark text-bold">{{data?.bank_account?.ac_no}}</td>
            </tr>
            <tr>
                <td width="120px" class="text-dark">Account Holder</td>
                <td class="text-dark text-bold">{{data?.bank_account?.ac_holder}}</td>
            </tr>

            <tr>
                <td width="120px" class="text-dark">IFSC</td>
                <td class="text-dark text-bold">{{data?.bank_account?.ifsc}}</td>
            </tr>

        </table>
    </div>
</template>
<script setup>
import useUtils from "@/Compositions/useUtils";
import {computed, reactive} from "vue";
import MovementHistory from "@/Components/MovementHistory.vue";
import {router} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import EditHistory from "@/Components/EditHistory.vue";
import PlanningForward from "@/Components/PlanningForward.vue";
import UpdateStatus from "@/Components/UpdateStatus.vue";
import DCVerifierForward from "@/Components/DCVerifierForward.vue";
import DCApprovalForward from "@/Components/DCApprovalForward.vue";
import DcForward from "@/Components/DcForward.vue";
import OfficeForward from "@/Components/OfficeForward.vue";

const props=defineProps({
    data:Object,
    audits:Array,
    bank_audit:Array,
    takeable:Boolean,
    pullable:Boolean,
    canEdit:Boolean,
    canDelete:Boolean,
    forwardTo:Array,
    canSendBack:Boolean,
    received:Boolean
})
const q = useQuasar();
const {formatDateTime} = useUtils();
const state=reactive({
    openPlanning:false
})
const modal=reactive({
    dc:false,
    verifier:false,
    approval:false,
    planning:false
})

const dcForward = computed(() => props.forwardTo.find(item=>item === 'dc'));
const officeForward = computed(() => props.forwardTo.find(item=>item === 'office'));
const planningForward = computed(() => props.forwardTo.find(item=>item === 'planning'));
const departmentForward = computed(() => props.forwardTo.find(item=>item === 'department'));
const executiveForward = computed(() => props.forwardTo.find(item=>item === 'executive'));
const take=()=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you really want to Take it?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.put(route('application.take',props.data.id),{
            preserveState: false,
            onStart:params => q.loading.show({message:'Taking application...'}),
            onFinish:params => q.loading.hide()
        })
    })
}

const handleDelete=()=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you really want to Delete?',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
        router.delete(route('application.destroy',props.data.id),{
            preserveState: false,
            onStart:params => q.loading.show({message:'Deleting...'}),
            onFinish:params => q.loading.hide()
        })
    })
}
const pullBack=()=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you really want to Pull Back?',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            router.delete(route('application.revert',props.data.id),{
                preserveState: false,
                onStart:params => q.loading.show({message:'Pull back...'}),
                onFinish:params => q.loading.hide()
            })
    })
}

const forward=role=>{
    switch (role){
        case 'dc':
            modal.dc = true;
            break;
        case 'dc-verifier':
            modal.verifier = true;
            break;
        case 'dc-approval':
            modal.approval = true;
            break;
        case 'planning':
            modal.planning = true;
            break;
        case 'office':
            modal.office = true;
            break;
    }
}
const onForwarded=item=>state.openPlanning = false;
const onStatusUpdated=item=>{
    console.log(item);
}
const handlePrint=item=>{
    window.print();
}

const sendBack=e=>{
    console.log(props.data);
    q.dialog({
        title:'Confirmation',
        message:`Do you really want to Send Back to ${props.data?.last_movement?.sender?.name}?`,
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
        router.post(route('application.send-back',props.data.id),{
            preserveState: false,
            onStart:params => q.loading.show({message:'Send back...'}),
            onFinish:params => q.loading.hide()
        })
    })
}

</script>
<style scoped>
.left-bordered{
    padding-left: 8px;
    border-color: rgba(0, 0, 0, 0.12);
    border-left-width: 1px;
    border-left-style: solid;
}

@media print {
    .to_print {
        width: 850px;
    }

    /* the rest of your styles here */
}
</style>
