import { State, Action, StateContext } from '@ngxs/store';
import { Post } from '../../shared/models/post.model';
import { PostsService } from '../../shared/services/posts.service';
import { GetPostsAction } from '../actions/get-posts.action';
import { HttpResponse } from '@angular/common/http';
import { GetPopularPostsAction } from '../actions/get-popular-posts.action';

import { tap, map } from 'rxjs/operators';
import { SetHasSubscribedAction } from '../actions/set-has-subscribed.action';
import { PostsPaginationResponse, BlogStateType } from '../types';
import { Injectable } from '@angular/core';
import { CategoryService } from 'src/app/shared/services/category.service';
import { GetPopularCategoriesAction } from '../actions/get-popular-categories.action';
import { Category } from 'src/app/shared/models/category.model';

@State<BlogStateType>({
  name: 'home',
  defaults: {
    posts: [],
    popularCategories: [],
    popularPosts: [],
    hasSubscribed: false
  }
})
@Injectable()
export class BlogState {
  public constructor(
    private readonly postService: PostsService,
    private readonly categoryService: CategoryService
  ) {
  }

  @Action(GetPostsAction)
  public getPosts( ctx: StateContext<BlogStateType>, action: GetPostsAction ) {
    return this.postService
      .getPosts(action.page, action.perPage, action.category)
      .pipe(
        map(( res: PostsPaginationResponse ) => res.data),
        tap(( posts: Post[] ) => {
          ctx.setState({
            ...ctx.getState(),
            posts
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
      tap(( posts: Post[] ) => {
        context.setState({
          ...context.getState(),
          popularPosts: posts
        });
      })
    );
  }

  @Action(GetPopularCategoriesAction)
  public getPopularCategories(
    context: StateContext<BlogStateType>,
    action: GetPopularCategoriesAction
  ) {
    return this.categoryService.getPopularCategories(action.count)
      .pipe(
        tap(( data: Category[] ) => {
          context.setState({
            ...context.getState(),
            popularCategories: data
          });
        })
      );
  }

  @Action(SetHasSubscribedAction)
  public setSubscribedAction( context: StateContext<BlogStateType>, action: SetHasSubscribedAction ) {
    const data = localStorage.getItem('hasSubscribed');

    if ( data ) {
      context.setState({
        ...context.getState(),
        hasSubscribed: true
      });
    } else {
      context.setState({
        ...context.getState(),
        hasSubscribed: false
      });
    }

  }

  public search() {
  }
}
