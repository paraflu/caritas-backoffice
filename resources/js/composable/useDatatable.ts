import { onMounted, Ref, ref } from "vue";
import $ from "jquery";
import { Api } from "datatables.net";

export interface Action {
  action?: string,
  id?: number,
  event?: Event
  dtInstance: Api<any> | null
}

export type ActionCallback = (action: Action) => void;

export function useDatatable(tableRef: Ref<HTMLTableElement | null>, callback?: ActionCallback) {

  const dtInstance = ref<Api<any> | null>(null);
  const onAction = ref<Action | null>(null);

  const handleActionButton = (event: JQuery.TriggeredEvent) => {
    const { action, id } = (event.currentTarget as HTMLButtonElement).dataset;
    onAction.value = {
      action,
      id: Number(id),
      event: event.originalEvent,
      dtInstance: dtInstance.value
    };
    callback?.(onAction.value);
  };

  onMounted(() => {
    dtInstance.value = (tableRef.value as any).dt;
    if (dtInstance.value) {
      $(dtInstance.value.table().body())
        .on("click", "button[data-action]", handleActionButton);
    }
  });


  return {
    onAction,
    redraw: () => dtInstance.value?.draw(),
    dtInstance
  };
}