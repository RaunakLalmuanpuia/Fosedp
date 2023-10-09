<template>
    <q-item :active="isActive" dense clickable @click="navigate">
        <div class="q-ml-sm q-py-sm flex  q-gutter-sm nav-item">
            <q-icon style="margin-top: 4px" :color="!!isActive ?'primary':'default'" :name="icon" size="12px" />
            <div class="column q-ml-sm q-my-none ">
                <div class=" text-sm text-weight-medium">{{label}}</div>
                <div style="font-size: 9px" v-if="!!caption" class="text-caption text-weight-thin">{{caption}}</div>
            </div>
        </div>
    </q-item>
</template>
<script setup>
import {router, usePage} from '@inertiajs/vue3';
import {computed} from "vue";

const  props=defineProps(['icon','label','route','caption'])
const navigate=e=> router.get(route(props.route))

const isActive=computed(()=>usePage().props.current_route===props.route)
</script>
<style scoped>

</style>
