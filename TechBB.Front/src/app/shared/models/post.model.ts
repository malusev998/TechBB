import { Category } from "./category.model";
import { User } from "./user.model";

export interface Post {
  id: number;
  title: string;
  description: string;
  status: string;
  number_of_likes: number;
  number_of_comments: number;
  created_at: string | Date;
  updated_at: string | Date | null;
  time_ago: string;
  categories: Category[];
  user?: User | null | undefined;
}
