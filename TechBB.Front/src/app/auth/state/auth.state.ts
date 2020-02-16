import { LoginService } from "../services/login.service";
import { RegisterService } from "../services/register.service";
import { Injectable } from "@angular/core";
import { State, Action, StateContext } from "@ngxs/store";
import { AuthStateType } from "../types";
import { RegisterAction, LoginAction } from "../actions";

@State<AuthStateType>({
  name: "auth",
  defaults: {
    user: {
      name: "Dusan",
      surname: "Malusev",
      email: "dusan.998@outlook.com",
      role: "admin"
    }
  }
})
@Injectable()
export class AuthState {
  public constructor(
    private readonly loginService: LoginService,
    private readonly registerService: RegisterService
  ) {}

  @Action(RegisterAction)
  public register(
    context: StateContext<AuthStateType>,
    action: RegisterAction
  ) {}

  @Action(LoginAction)
  public login(context: StateContext<AuthStateType>, action: LoginAction) {}
}
