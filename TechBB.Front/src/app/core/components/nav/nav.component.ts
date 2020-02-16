import { Component, OnInit } from "@angular/core";
import { Select } from "@ngxs/store";
import { User } from "src/app/shared/models/user.model";
import { Observable } from "rxjs";

@Component({
  selector: "app-nav",
  templateUrl: "./nav.component.html",
  styleUrls: ["./nav.component.scss"]
})
export class NavComponent implements OnInit {
  @Select(state => state.auth.user)
  public user: Observable<User | null>;

  constructor() {}

  ngOnInit(): void {
    this.user.subscribe(user => console.log(user));
  }
}
