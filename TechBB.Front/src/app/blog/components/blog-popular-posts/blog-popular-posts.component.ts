import { Component, OnInit } from "@angular/core";
import { Store, Select } from "@ngxs/store";
import { GetPopularPostsAction } from "../../actions/get-popular-posts.action";
import { Post } from "src/app/shared/models/post.model";
import { Observable } from "rxjs";

@Component({
  selector: "app-blog-popular-posts",
  templateUrl: "./blog-popular-posts.component.html",
  styleUrls: ["./blog-popular-posts.component.scss"]
})
export class BlogPopularPostsComponent implements OnInit {
  @Select(state => state.home.popularPosts)
  public posts: Observable<Post[]>;

  constructor(private readonly store: Store) {}

  ngOnInit(): void {
    this.store.dispatch(new GetPopularPostsAction(5));
  }
}
