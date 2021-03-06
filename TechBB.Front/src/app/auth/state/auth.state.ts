import { ClearErrorsAction } from '../actions/clear-errors.action';
import { LoginService } from '../services/login.service';
import { RegisterService } from '../services/register.service';
import { Injectable } from '@angular/core';
import { State, Action, StateContext } from '@ngxs/store';
import { AuthStateType, AuthSuccessPayload } from '../types';
import {
  RegisterAction,
  LoginAction,
  LogoutAction,
  SetUserAction
} from '../actions';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Jwt } from 'src/app/shared/models/jwt.model';
import { tap, catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';

@State<AuthStateType>({
  name: 'auth',
  defaults: {
    errors: null,
    user: null
  }
})
@Injectable()
export class AuthState {
  public constructor(
    private readonly loginService: LoginService,
    private readonly registerService: RegisterService
  ) {
  }

  @Action(RegisterAction)
  public register(
    context: StateContext<AuthStateType>,
    action: RegisterAction
  ) {
  }

  @Action(LoginAction)
  public login( context: StateContext<AuthStateType>, action: LoginAction ) {
    return this.loginService.login(action.payload).subscribe(( data: any ) => {
      const jwt: Jwt = {
        token: data.token,
        type: data.type,
        user: data.payload
      };

      localStorage.setItem('token', JSON.stringify(jwt));
      context.dispatch(new SetUserAction());
    }, ( error ) => console.log(error));
  }

  @Action(LogoutAction)
  public logout( context: StateContext<AuthStateType>, action: LogoutAction ) {
    context.setState({ ...context.getState(), errors: null, user: null });
    localStorage.removeItem('token');
  }

  @Action(SetUserAction)
  public setUser( context: StateContext<AuthStateType>, action: SetUserAction ) {
    const helper: JwtHelperService = new JwtHelperService();
    const data = localStorage.getItem('token');

    if ( !data ) {
      context.setState({
        ...context.getState(),
        user: null,
        errors: null
      });
    } else {
      try {
        const jwt: Jwt = JSON.parse(data);

        const hasExipired = new Date() > helper.getTokenExpirationDate(jwt.token);

        if ( hasExipired ) {
          localStorage.removeItem('token');
          context.setState({ ...context.getState(), errors: null, user: null });
        } else {
          context.setState({ ...context.getState(), errors: null, user: jwt.user });
        }

      } catch ( error ) {
        localStorage.removeItem('token');
        context.setState({ ...context.getState(), errors: null, user: null });
      }
    }

  }

  @Action(ClearErrorsAction)
  public clearErrors( context: StateContext<AuthStateType>, action: ClearErrorsAction ) {
    context.setState({
      ...context.getState(),
      errors: null
    });
  }
}
