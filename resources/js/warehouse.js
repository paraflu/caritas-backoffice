import { createApp } from 'vue';
import WarehouseList from './components/WarehouseList.vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
const app = createApp({
    components: { WarehouseList }
}).use(ZiggyVue, Ziggy)

app.component('warehouse-list', WarehouseList)
app.mount('#index');