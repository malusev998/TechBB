import { Component, OnInit, Input } from "@angular/core";
import { Post } from "src/app/shared/models/post.model";

@Component({
  selector: "app-blog-popular-post",
  templateUrl: "./blog-popular-post.component.html",
  styleUrls: ["./blog-popular-post.component.scss"]
})
export class BlogPopularPostComponent implements OnInit {
  @Input()
  public post: Post;

  constructor() {}

  ngOnInit(): void {}
}
