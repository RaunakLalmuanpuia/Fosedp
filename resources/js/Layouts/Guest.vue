<template>
    <q-layout view="hHh lpR fff">

        <q-header  class="bg-white text-primary text-weight-medium" height-hint="98">
            <q-toolbar class="flex container justify-between items-center q-py-md">
                    <q-img width="140px" src="/images/sedp.png" />

                    <q-img width="90px" src="/images/g20.png" />
            </q-toolbar>


        </q-header>

        <q-page-container style="background-color: #fafafa">
            <slot/>
        </q-page-container>
        <q-footer  class="bg-transparent text-dark q-mt-md">
            <div style="background-color: #eeeeee" >
                <div class="container flex justify-between items-center q-py-lg">
                    <div class="flex items-center">
                        <q-img width="50px" src="https://cdn.zeplin.io/63525893f4dc1713eac26ca1/assets/ce5fa60c-4a35-46e4-8ec4-9d7acd3ba0a9-optimized.png" />
                        <div class="q-ml-sm">
                            <p class="q-ma-none">Initiative of</p>
                            <p class="q-ma-none">Planning and Programme Implementation Department</p>
                            <p class="q-ma-none">Government of Mizoram</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <q-img width="60px" src="https://cdn.zeplin.io/63525893f4dc1713eac26ca1/assets/906e8422-02c8-47bb-8dce-82ac5e64f7e7.svg" />
                        <div class="q-ml-sm">
                            <p class="q-ma-none">Developed by</p>
                            <p class="q-ma-none">Mizoram State e-Governance Society</p>
                            <p class="q-ma-none">(A Government of Mizoram Undertaking)</p>
                        </div>
                    </div>
                </div>
            </div>

        </q-footer>
    </q-layout>
</template>
<script setup>
</script>
