import { Component, OnInit } from "@angular/core";
import { Store } from "@ngxs/store";
import { SetUserAction } from "./auth/actions";

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.scss"]
})
export class AppComponent implements OnInit {
  public constructor(private readonly store: Store) {}

  public ngOnInit(): void {
    this.store.dispatch(new SetUserAction());
  }
}
