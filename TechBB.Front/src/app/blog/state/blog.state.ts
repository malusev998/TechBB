import { State, Action, StateContext } from "@ngxs/store";
import { Post } from "../../shared/models/post.model";
import { PostsService } from "../../shared/services/posts.service";
import { GetPostsAction } from "../actions/get-posts.action";
import { HttpResponse } from "@angular/common/http";
import { GetPopularPostsAction } from "../actions/get-popular-posts.action";

import { tap, map } from "rxjs/operators";
import { PostsPaginationResponse, BlogStateType } from "../types";
import { Injectable } from "@angular/core";

@State<BlogStateType>({
  name: "home",
  defaults: {
    posts: [],
    popularCategories: [],
    popularPosts: []
  }
})
@Injectable()
export class BlogState {
  public constructor(private readonly postService: PostsService) {}

  @Action(GetPostsAction)
  public getPosts(ctx: StateContext<BlogStateType>, action: GetPostsAction) {
    return this.postService
      .getPosts(action.page, action.perPage, action.category)
      .pipe(
        map((data: HttpResponse<PostsPaginationResponse>) => data.body.data),
        tap((posts: Post[]) => {
          ctx.setState({
            ...ctx.getState(),
            posts: posts
          });
        })
      );
  }

  @Action(GetPopularPostsAction)
  public getPopularPosts(
    context: StateContext<BlogStateType>,
    action: GetPopularPostsAction
  ) {
    return this.postService.getPopularPosts(action.count).pipe(
      map((data: HttpResponse<Post[]>) => data.body),
      tap((posts: Post[]) => {
        context.setState({
          ...context.getState(),
          popularPosts: posts
        });
      })
    );
  }

  public search() {}
}
