import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { ContactFormComponent } from "./components/contact-form/contact-form.component";
import { ContactComponent } from "./components/contact/contact.component";
import { RouterModule, Routes } from "@angular/router";
import { SharedModule } from "../shared/shared.module";
import { ContactService } from "./services/contact.service";
import { SweetAlert2Module } from "@sweetalert2/ngx-sweetalert2";
import { AgmCoreModule } from "@agm/core";
import { ReactiveFormsModule } from '@angular/forms';
import { NgBootstrapFormValidationModule } from 'ng-bootstrap-form-validation';

const routes: Routes = [
  {
    path: "",
    component: ContactComponent
  }
];

@NgModule({
  declarations: [ContactFormComponent, ContactComponent],
  imports: [
    CommonModule,
    RouterModule.forChild(routes),
    SharedModule,
    SweetAlert2Module,
    AgmCoreModule,
    ReactiveFormsModule,
    NgBootstrapFormValidationModule
  ],
  exports: [RouterModule],
  providers: [ContactService]
})
export class ContactModule {}
