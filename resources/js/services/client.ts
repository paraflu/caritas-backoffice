import axios from "axios";

export const createClient = (baseURL: string) => {
    const token = document.head.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')
        ?.attributes['content'].value;

    return axios.create({
        baseURL,
        timeout: 1000,
        headers: { 'X-CSRF-TOKEN': token }
    });
}