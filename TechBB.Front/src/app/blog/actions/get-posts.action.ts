export class GetPostsAction {
  static readonly type = "[Possts] Get Posts";

  public constructor(
    public readonly page: number,
    public readonly perPage: number,
    public readonly category: null | number
  ) {}
}
