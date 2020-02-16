import { Component, OnInit, Input } from "@angular/core";
import { Post } from "src/app/shared/models/post.model";

@Component({
  selector: "app-blog-post",
  templateUrl: "./blog-post.component.html",
  styleUrls: ["./blog-post.component.scss"]
})
export class BlogPostComponent implements OnInit {
  @Input()
  public post: Post;

  constructor() {}

  ngOnInit(): void {
  }
}
