import { Login } from '../dto/login.dto';

export class LoginAction {
    public static readonly type: string = "[Auth] Login";
    public constructor(public readonly payload: Login) {}
}
