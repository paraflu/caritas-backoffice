// import { route } from 'ziggy-js';
// import {createClient} from './client';
// import {AxiosInstance} from 'axios';

// export class WarehouseService {

//     private baseUrl:string;
//     private http: AxiosInstance;

//     constructor(baseUrl?:string) {
//         this.baseUrl = baseUrl ?? window.baseUrl;
//         this.http = createClient(this.baseUrl);
//     }

//     async deleteDetail(warehouse_detail_id: number) {
//         return await this.http.delete(route('wareouse_detail.delete', [warehouse_detail_id]));
//     }
// }