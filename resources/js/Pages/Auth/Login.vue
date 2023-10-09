<template>
    <q-page>
        <div style="min-height: 980px" class="row bg-primary">
            <div class="col-xs-12 col-sm-7">
                <div class="fit flex justify-center items-center">
                    <q-img width="80%" src="/images/sedphome.png" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-5">
                <div class="fit flex justify-center items-center ">
                    <q-card class="login-card" flat>

                        <div v-if="authenticated" class="column q-gutter-sm">
                            <div class="full-width text-center">
                                <h6 class="text-lg q-ma-xs">Hello, <span class="text-primary">{{$page.props?.auth?.user?.name}} </span> </h6>
                                <p class="login-caption">Let's Get Started</p>
                                <q-btn icon-right="arrow_right" @click="$inertia.get(route('dashboard'))" label="Go to dashboard" color="primary" no-caps/>
                            </div>
                            <q-separator>

                            </q-separator>
                            <q-btn @click="$inertia.get(route('login.destroy'))" label="Sign out" flat no-caps/>
                        </div>
                        <q-form v-else class="column q-gutter-sm" @submit="submit">
                            <div class="full-width text-center">
                                <h6 class="login-title">LOGIN</h6>
                                <p class="login-caption">Let's Get Started</p>
                            </div>

                            <label class="text-weight-bold text-dark" for="userid">Email/Mobile</label>
                            <q-input id="userid" v-model="form.user_id"
                                     :error="!!form.errors?.user_id"
                                     :error-message="form.errors?.user_id"
                                     :rules="[
                                             val=>!!val || 'Mobile/Email is required'
                                         ]"
                                     no-error-icon
                                     placeholder="Email/Mobile"
                                     standout=" text-dark"
                            />
                            <label class="text-weight-bold text-dark" for="password">Password</label>
                            <q-input id="password" v-model="form.password"
                                     :rules="[
                                             val=>!!val || 'Password is required'
                                         ]"
                                     :type="localState.passwordType"
                                     no-error-icon
                                     standout=" text-dark"
                            >
                                <template #append>
                                    <q-btn v-if="localState.passwordType==='text'" flat
                                           icon="o_visibility" round @click="localState.passwordType='password'"/>
                                    <q-btn v-else flat icon="o_visibility_off" round
                                           @click="localState.passwordType='text'"/>
                                </template>
                            </q-input>
                            <q-btn style="height: 50px;border-radius: 15px" color="primary" label="Login" type="submit"/>
<!--                            <div class="flex justify-end">-->
<!--                                <q-item class="text-secondary" clickable>-->
<!--                                    <q-item-section>-->
<!--                                        <q-item-label>Forgot Password</q-item-label>-->
<!--                                    </q-item-section>-->
<!--                                </q-item>-->
<!--                            </div>-->
                        </q-form>
                    </q-card>

                </div>
            </div>
        </div>
        <div style="margin-top: -130px" class="mini-container bg-white">
            <q-list separator>
                <div class="full-width text-center">
                    <h6 class="login-title">NOTICE</h6>
                    <p class="login-caption">News, Events and Information Section</p>
                </div>
                <br/>
                <q-item clickable @click="openNotice(notice)" v-for="(notice,index) in notices" :key="index">
                    <q-item-section avatar>
                        <q-chip class="text-bold" :label="index+1" color="secondary" text-color="primary"/>
                    </q-item-section>
                    <q-item-section>
                        <q-item-label class="notice-title">{{notice.title}}</q-item-label>
                        <q-item-label caption>{{formatDate(notice.created_at)}}</q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </div>
        <br/>
        <br/>

        <q-dialog v-model="localState.open">
            <NotificationDetail :data="localState.selected"/>
        </q-dialog>
    </q-page>

</template>
<script setup>
import {reactive, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import HomeBanner from "@/Components/HomeBanner.vue";
import useUtils from "@/Compositions/useUtils";
import NotificationDetail from "@/Components/NotificationDetail.vue";

const props=defineProps(['notices','authenticated'])
const {formatDate}=useUtils()
const localState = reactive({
    passwordType: 'password',
    selected:null,
    open:false
})
const form = useForm({
    user_id: '',
    password: ''
})
const selected = ref(null);
const submit = e => {
    form.submit('post', route('login.store'), {replace: true})
}

const openNotice=notice=>{
    localState.selected=notice;
    localState.open = true;
}
</script>
<style>
.login-card{
    padding: 32px;
    border-radius: 32px;
}
.login-title{
    font-family: Poppins,serif;
    font-size: 31px;
    font-weight: bold;
    color: #1c61ea;
    margin: 0;
}
.login-caption{
    font-family: Poppins,serif;
    font-size: 12px;
    font-weight: 600;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    color: #4b4b4b;
}
.mini-container{
    max-width: 750px;
    margin-right: auto;
    margin-left:auto;
    padding: 32px;
    border-radius: 32px;
}
.notice-title{
    font-family: Poppins,serif;
    font-size: 18px;
    font-weight: bold;
    font-stretch: normal;
    line-height: normal;
    color: #4b4b4b;
}
</style>
