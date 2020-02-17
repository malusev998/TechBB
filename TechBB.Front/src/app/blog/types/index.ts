import { Post } from 'src/app/shared/models/post.model';
import { Category } from 'src/app/shared/models/category.model';

export interface PostsPaginationResponse {
  current_page: number;
  data: Post[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  next_page_url: string;
  per_page: number;
  total: number;
}

export interface PaginatedPostsType {
  posts: Post[];
  total: number;
  currentPage: number;
  lastPage: number;
  perPage: number;
}

export interface BlogStateType {
  posts: Post[];
  popularCategories: Category[];
  popularPosts: Post[];
  hasSubscribed: boolean;
}
