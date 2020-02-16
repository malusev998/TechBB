import { Component, OnInit, OnDestroy, ViewChild } from "@angular/core";
import { SubscriptionService } from "src/app/shared/services/subscription.service";
import {
  FormBuilder,
  Validators,
  FormGroup,
  FormControl
} from "@angular/forms";
import { Subscription } from "src/app/shared/models/subscription.model";
import { Subscription as RxJsSubscription } from "rxjs";
import { HttpErrorResponse, HttpResponse } from "@angular/common/http";
import { SwalComponent } from "@sweetalert2/ngx-sweetalert2";

@Component({
  selector: "app-blog-subscribe",
  templateUrl: "./blog-subscribe.component.html",
  styleUrls: ["./blog-subscribe.component.scss"]
})
export class BlogSubscribeComponent implements OnInit, OnDestroy {
  public subscriptionForm: FormGroup;
  public hasSubscribed: boolean = false;
  @ViewChild("message", { static: false }) private messageSwal: SwalComponent;

  private subscription: RxJsSubscription | null = null;

  constructor(
    private formBuidler: FormBuilder,
    private subscriptionService: SubscriptionService
  ) {}

  ngOnInit(): void {
    const isSubbed = localStorage.getItem("hasSubscribed");
    if (isSubbed) {
      this.hasSubscribed = true;
    }

    this.subscriptionForm = this.formBuidler.group({
      name: this.formBuidler.control("", {
        validators: [
          Validators.required,
          Validators.minLength(1),
          Validators.maxLength(70)
        ]
      }),
      email: this.formBuidler.control("", {
        validators: [
          Validators.required,
          Validators.email,
          Validators.maxLength(150)
        ]
      })
    });
  }

  public subscribe() {
    const subscription: Subscription = {
      name: this.name.value,
      email: this.email.value
    };

    this.unsubscribe();
    this.subscriptionService.subscribe(subscription).subscribe(
      (data: HttpResponse<any>) => {
        localStorage.setItem("hasSubscribed", JSON.stringify(true));
        this.messageSwal.icon = "success";
        this.messageSwal.title = "You have been added to the subscription list";
        this.messageSwal.fire();
      },
      (error: HttpErrorResponse) => {
        let message = "";
        switch (error.status) {
          case 400:
            message = "You already subscribed";
            // Already subscribed
            break;
          case 422:
            // Invalid data
            message = "Check your data please";
            break;
          case 500:
            // Server error
            message = "Server is not responding, please try again later";
            break;
          default:
            message = "An error has occured";
        }

        this.messageSwal.icon = "error";
        this.messageSwal.title = message;
        this.messageSwal.text = "Try again later, please";
        this.messageSwal.fire();
      }
    );
  }

  private get email(): FormControl {
    return this.subscriptionForm.get("email") as FormControl;
  }

  public get name(): FormControl {
    return this.subscriptionForm.get("name") as FormControl;
  }

  private unsubscribe(): void {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }

  public ngOnDestroy(): void {
    this.unsubscribe();
  }
}
