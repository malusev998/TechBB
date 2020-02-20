import { Component, OnInit, OnDestroy } from "@angular/core";
import { Observable } from "rxjs";
import { Select } from '@ngxs/store';

@Component({
  selector: "app-error",
  templateUrl: "./error.component.html",
  styleUrls: ["./error.component.scss"]
})
export class ErrorComponent implements OnInit, OnDestroy {

  @Select(state => state.auth.errors)
  public errors$: Observable<any | null>;


  public constructor() {}

  public ngOnInit(): void {}

  public ngOnDestroy(): void {

  }
}
