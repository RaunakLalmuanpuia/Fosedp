<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Form Eleven</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('form-eleven.index')"
                                  label="Form Five"/>
            </q-breadcrumbs>
        </div>
        <q-btn color="accent" @click="$inertia.get(route('form-eleven.create'))" label="Upload New"/>
    </div>
    <br/>
    <div class="column">
        <q-list>
            <q-item class="q-pl-none q-ml-none" v-for="(item,index) in props.list">
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
    </div>

</template>
<script setup>
import useUtils from "@/Compositions/useUtils";

const props=defineProps(['list'])
const {formatDateTime}=useUtils()
</script>
