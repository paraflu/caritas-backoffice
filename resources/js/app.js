import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createI18n } from 'vue-i18n';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// import 'vuetify/styles'
// import { createVuetify } from 'vuetify'
// import * as components from 'vuetify/components'
// import * as directives from 'vuetify/directives'
// import VeeValidate from 'vee-validate';
// import VueCurrencyInput from "vue-currency-input";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

        // const vuetify = createVuetify({
        //     theme: {
        //         defaultTheme: 'light'
        //     },
        //     components,
        //     directives,
        // })

        const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale, // user locale by props
            fallbackLocale: "it", // set fallback locale
            messages: props.initialPage.props.app.translations, // set locale messages
        });

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .use(VueSweetalert2)
            // .use(VueCurrencyInput)
            // .use(VeeValidate)
            // .use(vuetify)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
