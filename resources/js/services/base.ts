import { createClient } from "./client";
import { AxiosInstance } from "axios";

export class BaseService {
  protected baseUrl: string;
  protected http: AxiosInstance;

  constructor(baseUrl?: string) {
    this.baseUrl = baseUrl ?? (window as any).baseUrl;
    this.http = createClient(this.baseUrl);
  }
}
