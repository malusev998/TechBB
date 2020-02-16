import { Injectable } from "@angular/core";
import { HttpClient, HttpParams } from "@angular/common/http";

@Injectable({
  providedIn: "root"
})
export class PostsService {
  constructor(private readonly httpClient: HttpClient) {}

  public getPosts(page: number, perPage: number, category: number) {
    const params = new HttpParams({
      fromObject: {
        page: page.toString(),
        perPage: perPage.toString(),
        category: category.toString()
      }
    });
    return this.httpClient.get("/posts", { params });
  }

  public getOne(id: number) {
    return this.httpClient.get(`/posts/${id}`);
  }

  public search() {}

  public create() {}

  public update() {}

  public delete() {}
}
