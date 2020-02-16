import { Component, OnInit } from "@angular/core";
import { Store, Select } from "@ngxs/store";
import { Observable } from "rxjs";
import { Post } from "src/app/shared/models/post.model";
import { GetPostsAction } from "src/app/blog/actions/get-posts.action";

@Component({
  selector: "app-blog-posts-container",
  templateUrl: "./blog-posts-container.component.html",
  styleUrls: ["./blog-posts-container.component.scss"]
})
export class BlogPostsContainerComponent implements OnInit {
  @Select(state => state.home.posts)
  public posts: Observable<Post[]>;

  constructor(private readonly store: Store) {}

  ngOnInit(): void {
    this.store.dispatch(new GetPostsAction(1, 4, null));
  }
}
