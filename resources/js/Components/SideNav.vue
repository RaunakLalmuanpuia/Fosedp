<template>
    <div class="column q-gutter-sm q-pa-sm text-color text-weight-medium full-height">


<!--        <q-item v-if="isAdmin"-->
<!--                :active="route().current('form-five.all')"-->
<!--                class="q-mx-sm "-->
<!--                clickable-->
<!--                @click="e=>$inertia.get(route('form-five.all'))">-->
<!--            <q-item-section avatar>-->
<!--                <q-icon name="o_description"/>-->
<!--            </q-item-section>-->
<!--            <q-item-section>-->
<!--                <q-item-label class="text-weight-medium">Beneficiaries Register</q-item-label>-->
<!--                <q-item-label caption>Form 5(ii)</q-item-label>-->
<!--            </q-item-section>-->
<!--            <q-separator class="q-my-sm"/>-->
<!--        </q-item>-->

        <q-list>
            <div>
                <a :href="route('home')">
                    <q-img class="q-mb-md" src="/images/sedp.png" style="width: 80%"/>
                </a>
                <q-item class="q-mx-sm bg-secondary  text-primary"
                        clickable
                        style="border-radius: 12px"
                        @click="e=>$inertia.get(route('dashboard'))">
                    <q-item-section avatar>
                        <q-icon name="o_dashboard"/>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label class="text-bold">DASHBOARD</q-item-label>
                    </q-item-section>
                    <q-separator class="q-my-sm"/>
                </q-item>
            </div>

            <div>
                <q-separator class="q-mt-md"/>
            </div>
            <q-item v-if="isDepartment"
                    :active="route().current('task-group-user.index')"
                    class="q-mx-sm "
                    clickable
                    @click="e=>$inertia.get(route('task-group-user.index'))">
                <q-item-section avatar>
                    <q-icon name="o_people"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label class="text-weight-medium">Task Group User</q-item-label>
                </q-item-section>
                <q-separator class="q-my-sm"/>
            </q-item>

            <q-expansion-item default-opened group="nav" icon="feed" label="Application">
                <div class="nav-group">
                    <NavItem icon="fiber_manual_record" label="New Application" route="application.create"/>
                    <NavItem icon="fiber_manual_record" label="Incoming" route="application.incoming"/>
                    <NavItem icon="fiber_manual_record" label="Inbox" route="application.received"/>
                    <NavItem icon="fiber_manual_record" label="Outbox" route="application.outgoing"/>
                    <NavItem icon="fiber_manual_record" label="Applications" route="application.district"/>
                    <NavItem icon="fiber_manual_record" label="Excel Reports" route="application.excel-report"/>
                </div>
            </q-expansion-item>

            <q-expansion-item v-if="isDepartment"  group="nav" icon="o_article" label="Form upload">
                <div class="nav-group">
                    <NavItem icon="fiber_manual_record" label="Form 5(i)" route="form-upload-five-one.index" caption="Beneficiaries Register" />
                    <NavItem icon="fiber_manual_record" label="Form 5(ii)" route="form-upload-five-two.index" caption="Beneficiaries Register"/>
                    <NavItem icon="fiber_manual_record" label="Form 6" route="form-upload-six.index"   caption="Utilization Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 7" route="form-upload-seven.index" caption="Inspection Report"/>
                    <NavItem icon="fiber_manual_record" label="Form 8" route="form-upload-eight.index" caption="Completion Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 9" route="form-upload-nine.index"  caption="Closure Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 10" route="form-upload-ten.index"  caption="Recommendation"/>
                    <NavItem icon="fiber_manual_record" label="Form 11" route="form-upload-eleven.index" caption="Monitoring"/>
                </div>
            </q-expansion-item>

            <q-expansion-item v-if="isAdmin" group="nav" icon="o_monitor_heart" label="Uploaded Form">
                <div class="nav-group">
                    <NavItem icon="fiber_manual_record" label="Form 5(i)" route="form-upload-five-one.all" caption="Beneficiaries Register"/>
                    <NavItem icon="fiber_manual_record" label="Form 5(ii)" route="form-upload-five-two.all"  caption="Beneficiaries Register"/>
                    <NavItem icon="fiber_manual_record" label="Form 6" route="form-upload-six.all" caption="Utilization Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 7" route="form-upload-seven.all" caption="Inspection Report"/>
                    <NavItem icon="fiber_manual_record" label="Form 8" route="form-upload-eight.all"   caption="Completion Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 9" route="form-upload-nine.all"    caption="Closure Certificate"/>
                    <NavItem icon="fiber_manual_record" label="Form 10" route="form-upload-ten.all"    caption="Recommendation"/>
                    <NavItem icon="fiber_manual_record" label="Form 11" route="form-upload-eleven.all" caption="Monitoring"/>
                </div>
            </q-expansion-item>
            <q-expansion-item v-if="isAdmin" group="nav" icon="o_storage" label="Master Data">
                <div class="nav-group">
                    <NavItem icon="fiber_manual_record" label="Constituency" route="constituency.index"/>
                    <NavItem icon="fiber_manual_record" label="District" route="district.index"/>
                    <NavItem icon="fiber_manual_record" label="Trades" route="trade.index"/>
                </div>
            </q-expansion-item>

            <q-expansion-item v-if="isAdmin" group="nav" icon="o_settings" label="Administration">
                <div class="q-ml-lg nav-group">
                    <NavItem icon="fiber_manual_record" label="All Applications" route="application.index"/>
                    <NavItem icon="fiber_manual_record" label="Bank AV" route="bank.index"/>
                    <NavItem icon="fiber_manual_record" label="Notice" route="notice.index"/>
                    <NavItem icon="fiber_manual_record" label="Associated Users" route="associated-user.index"/>

                    <NavItem icon="fiber_manual_record" label="Departments" route="department.index"/>
                    <NavItem icon="fiber_manual_record" label="Users" route="user.index"/>

                    <!--                    <NavItem icon="fiber_manual_record" label="Appointments"/>-->
                </div>

            </q-expansion-item>
            <div>
                <q-item clickable
                        @click.stop="$inertia.replace(route('login.destroy'),{preserveState:false})">
                    <q-item-section avatar>
                        <q-icon color="negative" name="power_settings_new"/>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label class="text-negative">Logout</q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <slot name="miniBtn">

                        </slot>
                    </q-item-section>
                </q-item>

            </div>
        </q-list>


    </div>
</template>
<script setup>
import NavItem from "@/Components/NavItem.vue";
import {computed, onMounted} from "vue";
import {usePage} from "@inertiajs/vue3";

const isAdmin = computed(() => {
        return !!usePage().props?.roles?.find(role => role === 'admin' || role === 'planning')
    }
)
const isDepartment = computed(() => {
        return !!usePage().props?.roles?.find(role => role === 'department')
    }
)

</script>

<style scoped>
.nav-group {

    border-left-color: rgba(193, 192, 192, 0.3);
    border-left-width: 2px;
    border-left-style: solid;
    margin-left: 25px;
}
</style>


