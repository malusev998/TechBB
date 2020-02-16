import { User } from "./user.model";

export interface Category {
  id: number;
  name: string;
  number_of_posts: number;
  created_at: Date | string;
  user?: User | null | undefined;
}
