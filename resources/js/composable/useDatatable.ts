import {onMounted, Ref, ref} from 'vue';
import $ from 'jquery';

export function useDatatable(tableRef: Ref<any|null>) {

    const onAction = ref<{action:string, id: string, event: Event}|null>(null);

    const handleActionButton = (event: MouseEvent) => {
        const {action, id} = event.currentTarget.dataset;
        onAction.value = {action, id, event};
      }

    onMounted(() =>{ 
        let dt = tableRef.value.dt;
        $(dt.table().body())
          .on('click', 'button[data-action]', handleActionButton);
    });

    const redraw = () =>     table.value.dt.draw();

    return {onAction, redraw};
}