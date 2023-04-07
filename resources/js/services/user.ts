import route from "ziggy-js";
import { BaseService } from "./base";

export class UserService extends BaseService {
  async deleteUser(id: number): Promise<any> {
    return this.http.delete(route("user.destroy", id));
  }
}
