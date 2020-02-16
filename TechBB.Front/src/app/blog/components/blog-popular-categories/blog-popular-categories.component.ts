import { Component, OnInit } from "@angular/core";
import { Store, Select } from "@ngxs/store";
import { GetPopularCategoriesAction } from "../../actions/get-popular-categories.action";
import { Observable } from "rxjs";
import { Category } from "src/app/shared/models/category.model";

@Component({
  selector: "app-blog-popular-categories",
  templateUrl: "./blog-popular-categories.component.html",
  styleUrls: ["./blog-popular-categories.component.scss"]
})
export class BlogPopularCategoriesComponent implements OnInit {
  @Select(state => state.home.popularCategories)
  public categories: Observable<Category[]>;

  constructor(private readonly store: Store) {}

  ngOnInit(): void {
    this.store.dispatch(new GetPopularCategoriesAction(5));
  }
}
