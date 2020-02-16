import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-blog-search",
  templateUrl: "./blog-search.component.html",
  styleUrls: ["./blog-search.component.scss"]
})
export class BlogSearchComponent implements OnInit {
  public isBlogPage: boolean = false;
  constructor(private router: Router) {}

  ngOnInit(): void {
    if (this.router.url === "/blog") {
      this.isBlogPage = true;
    }
  }
}
