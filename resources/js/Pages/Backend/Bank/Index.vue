<template>
    <div class="flex justify-between items-center text-color">
        <div>
            <p class="page-header">Bank Wise File</p>
            <p class="text-caption">(Bank wise file generated by you)</p>
            <q-breadcrumbs>
                <q-breadcrumbs-el :href="route('dashboard')" icon="o_dashboard" label="Dashboard"/>
                <q-breadcrumbs-el label="Bank Wise Files"/>
            </q-breadcrumbs>
        </div>
        <q-btn @click="$inertia.get(route('bank.create'))" color="accent" label="Generate Bank Wise File" no-caps/>
    </div>
    <br/>
    <div class="column">
        <q-list>
            <q-item class="q-pl-none q-ml-none" v-for="(item,index) in props.list">
                <q-item-section avatar>
                    <q-chip square :label="index+1"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>{{item?.title}}</q-item-label>
                    <q-item-label caption>Report Generated At {{formatDateTime(item.created_at)}} By {{item?.user?.name}}</q-item-label>
                    <q-item-label caption>Offset : {{item?.offset}} Limit : {{item?.limit}}</q-item-label>
                </q-item-section>
                <q-item-section side>
                  <q-btn-dropdown flat dropdown-icon="more_vert">
                      <q-list>
                          <q-item clickable target="_blank" :href="item?.inpFullPath">
                              <q-item-section>
                                  <q-item-label>Download INP File</q-item-label>
                              </q-item-section>
                          </q-item>
                          <q-item clickable target="_blank" :href="item?.inpResPath">
                              <q-item-section>
                                  <q-item-label>Download RES File</q-item-label>
                              </q-item-section>
                          </q-item>
                      </q-list>
                  </q-btn-dropdown>
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
