<template>
    <q-card style="width: 650px">
        <div class="flex justify-between items-center">
            <p class="text-h6 q-pa-md q-ma-none">Notification</p>
            <q-btn v-close-popup flat icon="close"/>
        </div>
        <div class="q-px-md">
            <div class="text-lg">{{data?.title}}</div>
            <br/>
            <div v-html="data?.body"/>
            <a v-if="!!data?.path" class="text-color text-underline" :href="data?.path">Download attachment</a>
        </div>
        <div class="q-pa-md flex">
            <q-btn v-close-popup color="negative" label="Close" outline/>
        </div>
    </q-card>
</template>
<script setup>
defineProps(['data'])

</script>
