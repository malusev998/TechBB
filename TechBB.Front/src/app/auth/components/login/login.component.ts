import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { Select, Store } from '@ngxs/store';
import { Observable, Subscription } from 'rxjs';
import { User } from '../../../shared/models/user.model';
import { TitleService } from '../../../shared/services/title.service';
import { LoginAction, SetUserAction } from '../../actions';
import { ClearErrorsAction } from '../../actions/clear-errors.action';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit, OnDestroy {

  public loginForm: FormGroup;

  public subscription: Subscription | null = null;

  @Select(state => state.auth.user)
  public user$: Observable<User | null>;
  @Select(state => state.auth.errors)
  public errors$: Observable<any>;

  public constructor(
    private readonly titleService: TitleService,
    private readonly title: Title,
    private readonly formBuilder: FormBuilder,
    private readonly router: Router,
    private readonly store: Store
  ) {
  }

  public ngOnInit(): void {

    this.errors$.subscribe(errors => console.log(errors));

    this.subscription = this.user$.subscribe(user => {
      if ( user ) {
        this.store.dispatch(new SetUserAction());
        this.router.navigateByUrl('/');
      }
    });
    this.loginForm = this.formBuilder.group({
      email: this.formBuilder.control('', [Validators.required, Validators.email]),
      password: this.formBuilder.control('', [Validators.required])
    });
    this.title.setTitle('Login (TechBB)');
    this.titleService.setTitle('Login Page');
  }

  public login(): void {
    this.store.dispatch(new LoginAction({
      email: this.email.value,
      password: this.password.value
    }));
  }


  public get email(): FormControl {
    return this.loginForm.get('email') as FormControl;
  }

  public get password(): FormControl {
    return this.loginForm.get('password') as FormControl;
  }

  public ngOnDestroy(): void {
    if ( this.subscription ) {
      this.subscription.unsubscribe();
    }
    this.store.dispatch(new ClearErrorsAction());
  }
}
