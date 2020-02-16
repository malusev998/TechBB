export class GetPopularCategoriesAction {
  public static readonly type: string = "[Category] Get Popular Categories";

  public constructor(public readonly count: number) {}
}
