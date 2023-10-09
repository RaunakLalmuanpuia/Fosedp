<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Form-5</p>
            <p class="text-caption">Form-5 (ii) Submitted by all departments</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('form-upload-five-two.all')"
                                  label="Form 5(ii) - Beneficiaries Register"/>
            </q-breadcrumbs>
        </div>

    </div>
    <br/>
    <q-select v-model="filter.selected"
              :options="departments"
              use-chips
              standout="bg-accent"
              multiple
              label="Filter By Departments"
              @update:model-value="doFilter"
    />
    <br/>
    <div class="column">
        <q-list>
            <q-item class="q-pl-none q-ml-none" v-for="(item,index) in props.list.data">
                <q-item-section avatar>
                    <q-chip square :label="index+1"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Uploaded By {{item?.user?.name}} for <span class="text-bold">{{item?.department?.name}}</span> </q-item-label>
                    <q-item-label caption>Uploaded At {{formatDateTime(item.created_at)}}</q-item-label>
                    <q-item-label caption>{{item?.remark}}</q-item-label>
                </q-item-section>
                <q-item-section side>
                    <q-btn :href="item?.fullPath" target="_blank" round icon="cloud_download"/>
                </q-item-section>
            </q-item>
        </q-list>
        <q-separator class="q-my-sm"/>
        <div class="flex q-gutter-sm">
            <q-btn color="accent" :disable="!Boolean(item?.prev_page_url)" @click="$inertia.get(item.prev_page_url)"  label="Prev"/>
            <q-btn color="accent" :disable="!Boolean(item?.next_page_url)" @click="$inertia.get(item.next_page_url)"  label="Next"/>
        </div>
    </div>

</template>
<script setup>
import useUtils from "@/Compositions/useUtils";
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";

const props=defineProps(['list','departments','filter'])
const {formatDateTime}=useUtils()
const filter=reactive({
    selected:props.filter
})

const doFilter=value=>{
    router.get(route('form-five-two.all'),{
        'departments':value.map(item=>item.value)
    })

}
</script>
