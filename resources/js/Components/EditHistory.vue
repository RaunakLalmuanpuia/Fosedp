<template>
    <q-btn @click="state.open=true" color="dark" outline label="View Details" no-caps/>
    <q-dialog  v-model="state.open">
        <q-card style="width: 630px" flat>
            <div class="flex justify-between items-center">
                <p class="text-h6 q-ma-md">Edit History</p>
                <q-btn flat v-close-popup round class="q-pa-xs" icon="close"/>
            </div>
            <q-separator class="q-my-sm"/>
            <p class="text-h6 q-ml-md">Application</p>
            <div class="q-px-md">
                <div class="flex justify-between items-center">
                    <strong>Activity: <span>{{audit?.event}}</span></strong>
                    <strong>User: <span>{{audit?.user?.name}}</span></strong>
                </div>
            </div>
            <br/>

            <div class="q-px-md">
                <div v-for="(value, propertyName, index) in audit.new_values" :key="index">
                    <div class="flex justify-between items-center">
                        <strong>{{ propertyName }}:</strong>
                        <strong>{{getValue(propertyName,value)}}</strong>
                    </div>
                </div>
            </div>
            <q-separator class="q-my-sm"/>
            <p class="text-h6 q-ml-md">Bank Account</p>

            <div class="q-px-md">
                <div v-for="(value, index) in bank_audit" :key="index">
                    <div class="q-my-sm">
                        <div class="flex justify-between items-center">
                            <strong>Activity: <span>{{value?.event}}</span></strong>
                            <strong>User: <span>{{value?.user?.name}}</span></strong>
                        </div>
                    </div>
                    <div v-for="(value, propertyName, index) in value.new_values" class="flex justify-between items-center">
                        <strong>{{ propertyName.toString() }}:</strong>
                        <strong>{{value.toString()}}</strong>
                    </div>
                </div>
            </div>
            <div class="q-pa-md">
                <q-btn class="q-mt-md" outline v-close-popup label="Close" color="negative"/>
            </div>
        </q-card>
    </q-dialog>
</template>
<script setup>
import {reactive} from "vue";
import {useMasterData} from "@/Store/useMasterData";

const props=defineProps(['audit','event_name','bank_audit'])
const masterData = useMasterData();

const state=reactive({
    open:false
})

const getValue = (property, value)=>{
    if (property === 'district_id') {
        return  masterData.getDistrictName(value)
    }else if (property === 'constituency_id') {
        return  masterData.getConstituencyName(value)
    }
    else if (property === 'department_id') {
        return masterData.getDepartmentName(value)

    }else if (property === 'trade_id') {
        return masterData.getTradeName(value)
    }else if (property === 'sub_trade_id') {
        return masterData.getSubtradeName(value)
    }else{
        return value;
    }

}

</script>
