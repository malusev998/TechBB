import { BrowserModule } from "@angular/platform-browser";
import { NgModule } from "@angular/core";
import { NgBootstrapFormValidationModule } from "ng-bootstrap-form-validation";
import { AlertModule } from "ngx-bootstrap/alert";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { ReactiveFormsModule } from "@angular/forms";
import { SweetAlert2Module } from "@sweetalert2/ngx-sweetalert2";

@NgModule({
  declarations: [AppComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    NgBootstrapFormValidationModule.forRoot(),
    AlertModule.forRoot(),
    SweetAlert2Module.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
