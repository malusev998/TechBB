import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Register } from "../dto/register.dto";

@Injectable({
  providedIn: "root"
})
export class RegisterService {
  public constructor(private httpClient: HttpClient) {}

  public register(data: Register) {
    return this.httpClient.post("/register", data);
  }
}
