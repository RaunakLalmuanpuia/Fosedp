<template>
    <q-layout view="hHh lpR fFf">

        <q-header elevated class="bg-primary text-white" height-hint="98">
            <q-toolbar>
                <q-toolbar-title>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
                    </q-avatar>
                    Title
                </q-toolbar-title>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab to="/page1" label="Page One" />
                <q-route-tab to="/page2" label="Page Two" />
                <q-route-tab to="/page3" label="Page Three" />
            </q-tabs>
        </q-header>

        <q-page-container>
            <q-page>
                <div class="row q-col-gutter-md">
                    <div class="full-height col-xs-12 col-sm-7">img</div>
                    <div class="full-height col-xs-12 col-sm-5">
                        <q-card>
                            login
                        </q-card>
                    </div>
                </div>
            </q-page>
        </q-page-container>

    </q-layout>
</template>
