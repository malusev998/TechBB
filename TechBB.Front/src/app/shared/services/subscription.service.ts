import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Subscription } from "../models/subscription.model";

@Injectable()
export class SubscriptionService {
  constructor(private httpClient: HttpClient) {}

  public subscribe(data: Subscription) {
    return this.httpClient.post("/subscribe", data);
  }
}
