import { Component, OnInit, Input } from "@angular/core";
import { Category } from "src/app/shared/models/category.model";

@Component({
  selector: "app-blog-popular-category",
  templateUrl: "./blog-popular-category.component.html",
  styleUrls: ["./blog-popular-category.component.scss"]
})
export class BlogPopularCategoryComponent implements OnInit {
  @Input()
  public category: Category;

  constructor() {}

  ngOnInit(): void {}
}
