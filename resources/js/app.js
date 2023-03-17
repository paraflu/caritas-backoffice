import "./bootstrap";
import "../css/app.css";

import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';


import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createI18n } from "vue-i18n";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";


import { defineRule } from "vee-validate";
import { required, email, min } from "@vee-validate/rules";

defineRule("required", required);
defineRule("email", email);
defineRule("min", min);

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
  setup({ el, App, props, plugin }) {

    const i18n = createI18n({
      legacy: false,
      locale: props.initialPage.props.locale, // user locale by props
      fallbackLocale: "it", // set fallback locale
      messages: props.initialPage.props.app.translations // set locale messages
    });

    return createApp({ render: () => h(App, props) })
      .use(plugin)
      // eslint-disable-next-line no-undef
      .use(ZiggyVue, Ziggy)
      .use(i18n)
      .use(VueSweetalert2)
      .mount(el);
  },
  progress: {
    color: "#4B5563"
  }
});
