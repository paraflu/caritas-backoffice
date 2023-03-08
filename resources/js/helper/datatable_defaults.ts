import route from 'ziggy-js';
import { Config } from 'datatables.net';

export const createRequest = (url: string, options = {}): Config => {
    const token = (document.head.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).attributes['content'].value;
    return {
        serverSide: true,
        processing: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/it-IT.json'
        },
        ajax: {
            url,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
        },
        ...options
    };
}