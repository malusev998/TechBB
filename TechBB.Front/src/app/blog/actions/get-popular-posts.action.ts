export class GetPopularPostsAction {
  public static readonly type: string = "[Posts] Get Popular Posts";
  public constructor(public readonly count: number) {}
}
