<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Form 9</p>
            <p class="text-caption">(Completion Certificate)</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el :href="route('form-upload-nine.index')"
                                  label="Form 9"/>
            </q-breadcrumbs>
        </div>
        <q-btn color="accent" @click="$inertia.get(route('form-upload-nine.create'))" label="Upload New"/>
    </div>
    <br/>
    <div class="column">
        <q-list>
            <q-item class="q-pl-none q-ml-none" v-for="(item,index) in props.list">
                <q-item-section avatar>
                    <q-chip square :label="index+1"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Uploaded By <span class="text-bold">{{item?.user?.name}}</span>  for <span class="text-bold">{{item?.department?.name}}</span> </q-item-label>
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
