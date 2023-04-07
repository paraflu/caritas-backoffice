import Swal, { SweetAlertResult } from "sweetalert2";

type onConfirmFunction = (
  r: SweetAlertResult<any>
) => SweetAlertResult<any> | undefined;

export const deleteAlert = async ({
  title,
  text,
  onConfirm,
}: {
  title?: string;
  text: string;
  onConfirm?: Function;
}): Promise<SweetAlertResult<any> | undefined> => {
  const res = await Swal.fire({ title, text, icon: "question" });
  return onConfirm ? onConfirm(res) : res;
};
