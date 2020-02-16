import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { RouterModule, Routes } from "@angular/router";
import { ReactiveFormsModule } from "@angular/forms";
import { IndexComponent } from "./components/index/index.component";
import { BlogSubscribeComponent } from "./components/blog-subscribe/blog-subscribe.component";
import { BlogPopularCategoriesComponent } from "./components/blog-popular-categories/blog-popular-categories.component";
import { BlogPopularCategoryComponent } from "./components/blog-popular-category/blog-popular-category.component";
import { BlogPopularPostsComponent } from "./components/blog-popular-posts/blog-popular-posts.component";
import { BlogPopularPostComponent } from "./components/blog-popular-post/blog-popular-post.component";
import { BlogSearchComponent } from "./components/blog-search/blog-search.component";
import { BlogPostComponent } from "./components/posts/blog-post/blog-post.component";
import { BlogPostsContainerComponent } from "./components/posts/blog-posts-container/blog-posts-container.component";
import { BlogPostBoxComponent } from "./components/posts/blog-post-box/blog-post-box.component";
import { BlogComponent } from "./components/blog/blog.component";
import { SharedModule } from "../shared/shared.module";
import { NgBootstrapFormValidationModule } from "ng-bootstrap-form-validation";
import { AlertModule } from "ngx-bootstrap/alert";
import { SweetAlert2Module } from "@sweetalert2/ngx-sweetalert2";
import { NgxsModule } from "@ngxs/store";
import { BlogState } from "./state/blog.state";
import { PaginatedPostsState } from "./state/paginated-posts.state";

const routes: Routes = [
  {
    path: "",
    component: IndexComponent
  },
  {
    path: "blog",
    component: BlogComponent
  },
  {
    path: "blog/:id",
    component: BlogComponent
  }
];

@NgModule({
  declarations: [
    IndexComponent,
    BlogSubscribeComponent,
    BlogPopularCategoriesComponent,
    BlogPopularCategoryComponent,
    BlogPopularPostsComponent,
    BlogPopularPostComponent,
    BlogSearchComponent,
    BlogPostComponent,
    BlogPostsContainerComponent,
    BlogPostBoxComponent,
    BlogComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    NgBootstrapFormValidationModule,
    SharedModule,
    RouterModule.forChild(routes),
    AlertModule,
    SweetAlert2Module,
    NgxsModule.forFeature([BlogState, PaginatedPostsState])
  ],
  exports: [RouterModule]
})
export class BlogModule {}
