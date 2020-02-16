import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { HttpClientModule, HTTP_INTERCEPTORS } from "@angular/common/http";
import { InterceptorService } from "./services/interceptors/http.interceptor.service";
import { SubscriptionService } from "./services/subscription.service";
import { PostsService } from './services/posts.service';

@NgModule({
  declarations: [],
  imports: [CommonModule, HttpClientModule],
  exports: [HttpClientModule],
  providers: [
    { provide: HTTP_INTERCEPTORS, multi: true, useClass: InterceptorService },
    SubscriptionService,
    InterceptorService,
    PostsService
  ]
})
export class SharedModule {}
