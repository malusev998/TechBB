import { Component, OnInit } from '@angular/core';
import { Select, Store } from '@ngxs/store';
import { User } from 'src/app/shared/models/user.model';
import { Observable, Subscription } from 'rxjs';
import { LogoutAction } from '../../../auth/actions';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit {

  public user: User | null = null;
  private subscription: Subscription;

  @Select(state => state.auth.user)
  public user$: Observable<User | null>;

  public constructor( private readonly store: Store ) { }

  ngOnInit(): void {
    this.subscription = this.user$.subscribe(user => this.user = user);
  }

  public logout(event) {
    event.preventDefault();

    this.store.dispatch(new LogoutAction());
  }
}
