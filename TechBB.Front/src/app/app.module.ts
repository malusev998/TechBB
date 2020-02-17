import { BrowserModule } from "@angular/platform-browser";
import { NgModule } from "@angular/core";
import { AgmCoreModule } from "@agm/core";
import { NgBootstrapFormValidationModule } from "ng-bootstrap-form-validation";
import { AlertModule } from "ngx-bootstrap/alert";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { ReactiveFormsModule } from "@angular/forms";
import { SweetAlert2Module } from "@sweetalert2/ngx-sweetalert2";
import { NgxsModule } from "@ngxs/store";
import { environment } from "src/environments/environment";
import { AuthState } from "./auth/state/auth.state";
import { SharedModule } from "./shared/shared.module";

@NgModule({
  declarations: [AppComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    NgBootstrapFormValidationModule.forRoot(),
    AlertModule.forRoot(),
    SweetAlert2Module.forRoot(),
    SharedModule,
    NgxsModule.forRoot([AuthState], {
      developmentMode: !environment.production
    }),
    AgmCoreModule.forRoot({
      apiKey: environment.googleMaps
    })
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
