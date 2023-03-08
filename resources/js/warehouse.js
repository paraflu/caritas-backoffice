import { createApp } from 'vue';
import WarehouseList from './components/WarehouseList.vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { initI18n } from './createI18n';
const i18n = initI18n();
const app = createApp({
    components: { WarehouseList }
}).use(ZiggyVue, Ziggy)

app.use(i18n);
app.mount('#index');
