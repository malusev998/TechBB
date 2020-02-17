import { User } from "src/app/shared/models/user.model";

export type AuthStateType = {
  errors: { [key: string]: Array<string> } | null;
  user: User | null;
};
