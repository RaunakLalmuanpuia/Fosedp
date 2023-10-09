<template>
    <q-layout view="LHh LpR lff">

        <q-header  class="bg-transparent text-dark print-hide">
            <q-toolbar class="my-toolbar" style="min-height: 65px">
                <q-btn dense flat round icon="sort" @click="toggleLeftDrawer" />

                <q-toolbar-title class="text-color text-weight-medium">
                    FOSEDP Management
                </q-toolbar-title>
                    <q-btn-dropdown class="text-bold" no-caps :label="'Hello '+user?.name"  dropdown-icon="perm_identity">

                        <q-list class="text-color">
                            <q-item v-close-popup clickable @click="$inertia.get(route('profile.index'))">
                                <q-item-section avatar style="min-width: 40px"><q-icon name="person"/> </q-item-section>
                                <q-item-section>
                                    <q-item-label>Profile</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item v-close-popup @click="logout" clickable>
                                <q-item-section avatar style="min-width: 40px"><q-icon name="logout"/> </q-item-section>
                                <q-item-section>
                                    <q-item-label>Logout</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-btn-dropdown>
            </q-toolbar>
        </q-header>

        <q-drawer class="bg-white print-hide"
                  width="260"
                  show-if-above
                  v-model="leftDrawerOpen"
                  :mini="miniState"
                  side="left" >
            <template v-slot:mini>
                <div class="column justify-center  text-color text-bold full-height" >

                    <div class="column q-gutter-sm">
                        <q-btn @click="$inertia.get(route('dashboard'))" flat
                               :color="route().current('dashboard') ? 'primary' :''" icon="o_dashboard"/>
                        <q-btn @click="$inertia.get(route('application.incoming'))"
                               :color="route().current('application.incoming') ? 'primary' :''"  flat icon="o_move_to_inbox"/>
                        <q-btn @click="$inertia.get(route('application.received'))"
                               :color="route().current('application.received') ? 'primary' :''"  flat icon="o_inbox"/>
                        <q-btn @click="logout" color="negative"  flat icon="o_power_settings_new"/>
                    </div>
                    <q-btn class="absolute-bottom" @click="miniState=false" flat round icon="chevron_right"/>
                </div>
            </template>
            <SideNav>
                <template #miniBtn>
                    <div class="flex justify-end">
                        <q-btn  @click.stop="miniState=true" flat round icon="chevron_left"/>
                    </div>

                </template>
            </SideNav>
        </q-drawer>

        <q-page-container class="bg-grey-2">
            <q-page padding>
                <br/>
                <div class="container q-pa-lg bg-white">
                    <slot>

                    </slot>
                </div>
            </q-page>

        </q-page-container>

        <q-footer  class="bg-transparent text-dark q-mt-md print-hide">
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
import {ref, watch, computed, onMounted} from 'vue'
import SideNav from "@/Components/SideNav.vue";
import {router, usePage} from "@inertiajs/vue3";
import {useQuasar} from "quasar";
import {useMasterData} from "@/Store/useMasterData";

const q = useQuasar();
const miniState = ref(false);
const leftDrawerOpen = ref(false)
const toggleLeftDrawer=()=> leftDrawerOpen.value = !leftDrawerOpen.value
const masterData = useMasterData();

const noti=computed(()=>usePage().props.notification)
const user=computed(()=>usePage().props.auth?.user)

const logout=e=>{
    router.get(route('login.destroy'),{},{replace:true});
}

onMounted(()=>{
    masterData.fetchData();
})
watch(noti,(newVal,oldVal)=>{
    if (newVal) {
        const {type, message} = newVal;
        q.notify({type,message})
    }
    console.log('notification',newVal);

},{immediate:true})

</script>
<style lang="sass" scoped>
.mini-slot
    transition: background-color .28s
    &:hover
        background-color: rgba(0, 0, 0, .04)

.mini-icon
    font-size: 1.718em
    padding: 2px 16px

    & + &
        margin-top: 18px
</style>
