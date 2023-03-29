import route from 'ziggy-js';
import { createClient } from './client';
import { AxiosInstance } from 'axios';
import { WarehouseDetail } from '@/types/warehousedetail';

export class WarehouseService {

    private baseUrl: string;
    private http: AxiosInstance;

    constructor(baseUrl?: string) {
        this.baseUrl = baseUrl ?? (window as any).baseUrl;
        this.http = createClient(this.baseUrl);
    }

    async detail(warehouse_id: number, payload: object): Promise<object> {
        const { data } = await this.http.post(route('warehouse.detail.index', { warehouse: warehouse_id }), payload);
        return data;
    }

    async deleteDetail(warehouse_detail_id: number) {
        return await this.http.delete(route('warehouse.detail.destroy', [warehouse_detail_id]));
    }
}