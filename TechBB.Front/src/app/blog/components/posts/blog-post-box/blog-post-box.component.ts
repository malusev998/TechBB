import { Component, OnInit, Input } from "@angular/core";
import { Post } from "src/app/shared/models/post.model";

@Component({
  selector: "app-blog-post-box",
  templateUrl: "./blog-post-box.component.html",
  styleUrls: ["./blog-post-box.component.scss"]
})
export class BlogPostBoxComponent implements OnInit {
  @Input()
  public post: Post;

  constructor() {}

  ngOnInit(): void {}
}
