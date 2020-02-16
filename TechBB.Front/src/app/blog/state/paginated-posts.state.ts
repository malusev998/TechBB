import { PostsPaginationResponse, PaginatedPostsType } from "../types";
import { State, StateContext, Action } from "@ngxs/store";
import { PostsService } from "../../shared/services/posts.service";
import { PaginatedPostsAction } from "../actions/paginate-posts.action";
import { tap, map } from "rxjs/operators";
import { HttpResponse } from "@angular/common/http";
import { Injectable } from "@angular/core";

@State<PaginatedPostsType>({
  name: "blog",
  defaults: {
    posts: [],
    currentPage: 1,
    total: 0,
    lastPage: 1,
    perPage: 10
  }
})
@Injectable()
export class PaginatedPostsState {
  public constructor(private readonly postsService: PostsService) {}

  @Action(PaginatedPostsAction)
  public getPosts(
    context: StateContext<PaginatedPostsType>,
    action: PaginatedPostsAction
  ) {
    const state = context.getState();
    return this.postsService
      .getPosts(state.currentPage, state.perPage, null)
      .pipe(
        map((res: HttpResponse<PostsPaginationResponse>) => res.body),
        tap((data: PostsPaginationResponse) =>
          context.setState(this.formatPosts(state, data))
        )
      );
  }

  private formatPosts<State>(
    state: State,
    response: PostsPaginationResponse
  ): State {
    return {
      ...state,
      currentPage: response.current_page,
      lastPage: response.last_page,
      total: response.total,
      perPage: response.per_page,
      posts: response.data
    };
  }
}
