import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import {createInertiaApp, router} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Chart, BarController,BarElement,CategoryScale,LinearScale,LineController,PointElement,LineElement, ArcElement, Tooltip } from 'chart.js';
import {Dialog, Loading, Notify, Quasar} from 'quasar'
import quasarIconSet from 'quasar/icon-set/material-icons-outlined'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import 'quasar/src/css/index.sass'
import ApplicationLayout from '@/Layouts/ApplicationLayout.vue'
import Guest from '@/Layouts/Guest.vue'
import {createPinia} from "pinia";

Chart.register(PointElement,LineElement,BarController,LineController,CategoryScale,LinearScale,BarElement, ArcElement, Tooltip);


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'SEDP';
let lastRequestMethod = null

router.on('start', (event) => {
    lastRequestMethod = event.detail.visit.method
})

window.addEventListener('popstate', (event) => {
    if (lastRequestMethod !== 'get') {
        event.stopImmediatePropagation()
        window.location.href = event.state.url
    }
})
const pinia = createPinia()
createInertiaApp({
    title: (title) => `${title} ${appName}`,
    resolve: name => {
        console.log('name ',name)
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );

        page.then((module) => {
            module.default.layout = name.startsWith('Auth/') ?Guest: ApplicationLayout;
        });

        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(Quasar,{
                plugins:{
                    Notify,Dialog,Loading
                },
                config: {
                    notify: {
                        closeBtn:true
                    }
                },
                iconSet:quasarIconSet
            })
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#2a693c',
    },
});
