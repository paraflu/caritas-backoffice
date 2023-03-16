export interface WarehouseDetail {
  id?: number;
  warehouse_id: number;
  product_id: number;
  quantity: number;
  origin: "caritas" | "donation";
  price: number;
}