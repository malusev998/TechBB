import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { DefaultComponent } from "./components/layouts/default/default.component";
import { RouterModule, Routes } from "@angular/router";
import { HeaderComponent } from "./components/header/header.component";
import { BannerComponent } from "./components/banner/banner.component";
import { FooterComponent } from "./components/footer/footer.component";
import { NavComponent } from "./components/nav/nav.component";
import { SharedModule } from "../shared/shared.module";

const routes: Routes = [
  {
    path: "",
    component: DefaultComponent,
    children: [
      {
        path: "",
        loadChildren: () =>
          import("../blog/blog.module").then(m => m.BlogModule)
      },
      {
        path: "auth",
        loadChildren: () =>
          import("../auth/auth.module").then(m => m.AuthModule)
      },
      {
        path: "contact",
        loadChildren: () =>
          import("../contact/contact.module").then(m => m.ContactModule)
      }
    ]
  }
];

@NgModule({
  declarations: [
    DefaultComponent,
    HeaderComponent,
    BannerComponent,
    FooterComponent,
    NavComponent
  ],
  imports: [CommonModule, SharedModule, RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CoreModule {}
