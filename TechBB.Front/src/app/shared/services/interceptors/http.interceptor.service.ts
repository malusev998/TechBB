import { Injectable } from '@angular/core';
import {
  HttpInterceptor,
  HttpRequest,
  HttpHandler,
  HttpEvent
} from '@angular/common/http';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Store } from '@ngxs/store';
import { Observable } from 'rxjs';
import { LogoutAction } from '../../../auth/actions';
import { Jwt } from '../../models/jwt.model';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class InterceptorService implements HttpInterceptor {
  private jwtHelper: JwtHelperService;

  public constructor(private readonly store: Store) {
    this.jwtHelper = new JwtHelperService();
  }

  intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const newReq = req.clone({ url: this.getUrl(req.urlWithParams) });

    if ( !newReq.headers.has('Content-Type') ) {
      newReq.headers.append('Content-Type', 'application/json');
    }

    const data = localStorage.getItem('token');

    if ( data ) {
      const token: Jwt = JSON.parse(data);
      const hasExipired =
        new Date() > this.jwtHelper.getTokenExpirationDate(token.token);

      if ( hasExipired ) {
        this.store.dispatch(new LogoutAction());
      } else {
        if ( !newReq.headers.has('Authorization') ) {
          newReq.headers.append(
            'Authorization',
            `${ token.type } ${ token.token }`
          );
        }
      }
    }

    return next.handle(newReq);
  }

  private getUrl( currentUrl: string ) {
    if ( currentUrl.match(/^https?:\/\//) ) {
      return currentUrl;
    } else {
      return `${ environment.api }${ currentUrl }`;
    }
  }
}
