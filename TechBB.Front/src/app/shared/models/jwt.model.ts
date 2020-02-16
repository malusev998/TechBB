import { User } from "./user.model";

export interface Jwt {
  user: User;
  token: string;
  type: string;
}
