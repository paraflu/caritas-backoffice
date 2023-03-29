import { AxiosError } from "axios";
import Swal from "sweetalert2";

export const reportError = async (error: AxiosError | Error | any) => {
    console.error('[reportError]', error);
    let message = error?.response?.data?.message ??
        error.message ?? error
    Swal.fire({ icon: 'error', text: message })
}