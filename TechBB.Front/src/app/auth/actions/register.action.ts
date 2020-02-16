import { Register } from "../dto/register.dto";

export class RegisterAction {
  public static readonly type: string = "[Auth] Register";
  public constructor(public readonly payload: Register) {}
}
