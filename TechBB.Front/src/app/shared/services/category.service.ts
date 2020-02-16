import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";

@Injectable()
export class CategoryService {
  public constructor(private readonly httpClient: HttpClient) {}

  public getCategories(page: number, perPage: number) {
    return this.httpClient.get("/categories", {
      params: {
        page: page.toString(),
        perPage: perPage.toString()
      }
    });
  }

  public getPopularCategories(count: number = 5) {
    return this.httpClient.get("/popular/categories", {
      params: { count: count.toString() }
    });
  }
}
