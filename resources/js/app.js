import "./bootstrap";
import "../css/app.css";

import "@fortawesome/fontawesome-free/scss/fontawesome.scss";
import "@fortawesome/fontawesome-free/scss/brands.scss";
import "@fortawesome/fontawesome-free/scss/regular.scss";
import "@fortawesome/fontawesome-free/scss/solid.scss";
import "@fortawesome/fontawesome-free/scss/v4-shims.scss";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createI18n } from "vue-i18n";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import { defineRule } from "vee-validate";
import { required, email, min } from "@vee-validate/rules";
import { plugin as pluginFormkit, defaultConfig } from "@formkit/vue";
import { generateClasses } from "@formkit/themes";
import { it } from "@formkit/i18n";
import config from "./formkit.config";

defineRule("required", required);
defineRule("email", email);
defineRule("min", min);

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const transpile = (translations) => {
  if (typeof translations === "string") {
    return translations.replace(/:(?<key>\w+)/g, "{$1}");
  }
  for (let tr in translations) {
    translations[tr] = transpile(translations[tr]);
  }
  return translations;
};

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    const i18n = createI18n({
      legacy: false,
      locale: "it" /* props.initialPage.props.locale */,
      fallbackLocale: "it", // set fallback locale
      messages: transpile(props.initialPage.props.app.translations), // set locale messages
    });

    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(i18n)
      .use(VueSweetalert2)
      .use(
        pluginFormkit,
        defaultConfig({
          locales: [it],
          locale: 'it',
          ...config
        })
      )
      .mount(el);

    //app.config.globalProperties.$route = route;
    return app;
  },
  progress: {
    color: "#4B5563",
  },
});
