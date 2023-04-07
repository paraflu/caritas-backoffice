import { onMounted, Ref, ref } from "vue";
import { Api } from "datatables.net";
import JQuery from "jquery";

export interface Action {
  action?: string;
  id?: string;
  event: Event | JQuery.Event;
  row?: any;
}

export type ActionCallback = (action: Action) => void;

export function useDatatable(
  tableRef: Ref<HTMLElement | null>,
  callback?: ActionCallback,
  eventsName: string[] = []
) {
  const onAction = ref<Action | null>(null);

  const dtInstance = ref<Api<any> | null>(null);

  const handleActionButton = (event: JQuery.ClickEvent, row: any) => {
    const { action, id } = (event.currentTarget as HTMLElement).dataset;
    onAction.value = { action, id, event, row };
    callback?.(onAction.value!);
  };

  const eventHanlder = (evtName: string, event: Event) => {
    callback?.({ event, action: evtName });
  };

  onMounted(() => {
    dtInstance.value = (tableRef.value as any).dt;
    if (dtInstance.value) {
      JQuery((dtInstance.value as any).table().body()).on(
        "click",
        "a[data-action],button[data-action]",
        function (e) {
          const row = dtInstance.value?.row(JQuery(this).closest("tr")).data();
          handleActionButton(e, row);
        }
      );
    }
    eventsName.forEach((evtName) =>
      dtInstance.value?.on(evtName, (e) => eventHanlder(evtName, e))
    );
  });

  const redraw = () => dtInstance.value?.draw();

  return { onAction, redraw, dtInstance };
}
