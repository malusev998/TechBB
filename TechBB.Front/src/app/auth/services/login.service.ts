import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Login } from '../dto/login.dto';

@Injectable()
export class LoginService {
  constructor(private httpClient: HttpClient) { }

  public login(data: Login) {

  }
}
