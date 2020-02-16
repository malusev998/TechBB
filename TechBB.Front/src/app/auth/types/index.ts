import { User } from "src/app/shared/models/user.model";

export type AuthStateType = {
  user: User | null;
};
