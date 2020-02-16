import { Injectable } from "@angular/core";
import { HttpClient, HttpParams } from "@angular/common/http";

@Injectable()
export class PostsService {
  constructor(private readonly httpClient: HttpClient) {}

  public getPosts(page: number, perPage: number, category: number | null) {
    let params = {
      page: page.toString(),
      perPage: perPage.toString()
    };

    if (category !== null) {
      params["category"] = category;
    }

    return this.httpClient.get("/posts", { params });
  }

  public getOne(id: number) {
    return this.httpClient.get(`/posts/${id}`);
  }

  public getPopularPosts(count: number) {
    return this.httpClient.get("/posts/popular", {
      params: { count: count.toString() }
    });
  }

  public search() {}

  public create() {}

  public update() {}

  public delete() {}
}
