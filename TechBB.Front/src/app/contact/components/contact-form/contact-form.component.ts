import { Component, OnInit, OnDestroy } from "@angular/core";
import { ContactService } from "../../services/contact.service";
import {
  FormBuilder,
  FormGroup,
  FormControl,
  Validators
} from "@angular/forms";
import { Observable, Subscription } from "rxjs";
import { Contact } from "../../dto/contact.dto";

@Component({
  selector: "app-contact-form",
  templateUrl: "./contact-form.component.html",
  styleUrls: ["./contact-form.component.scss"]
})
export class ContactFormComponent implements OnInit, OnDestroy {
  public contactForm: FormGroup;

  private subscription: Subscription | null = null;

  public subjects$: Observable<any>;

  public constructor(
    private readonly contactService: ContactService,
    private readonly formBuilder: FormBuilder
  ) {}

  ngOnInit(): void {
    this.contactForm = this.formBuilder.group({
      name: this.formBuilder.control("", [
        Validators.required,
        Validators.minLength(1),
        Validators.maxLength(70)
      ]),
      surname: this.formBuilder.control("", [
        Validators.required,
        Validators.minLength(1),
        Validators.maxLength(70)
      ]),
      email: this.formBuilder.control("", [
        Validators.required,
        Validators.email,
        Validators.maxLength(150)
      ]),
      subject: this.formBuilder.control("", [Validators.required]),
      message: this.formBuilder.control("", [
        Validators.required,
        Validators.minLength(1),
        Validators.maxLength(500)
      ])
    });

    this.subjects$ = this.contactService.getSubjects();
  }

  private unsubscribe(): void {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }

  public submit(): void {
    this.unsubscribe();

    const contact: Contact = {
      name: this.name.value,
      surname: this.surname.value,
      email: this.email.value,
      message: this.message.value,
      subject: this.subject.value
    };

    this.subscription = this.contactService.contact(contact).subscribe(
      data => console.log(data),
      error => console.log(error)
    );
  }

  // Getters

  public get name(): FormControl {
    return this.contactForm.get("name") as FormControl;
  }
  public get surname(): FormControl {
    return this.contactForm.get("surname") as FormControl;
  }
  public get email(): FormControl {
    return this.contactForm.get("email") as FormControl;
  }
  public get subject(): FormControl {
    return this.contactForm.get("subject") as FormControl;
  }
  public get message(): FormControl {
    return this.contactForm.get("message") as FormControl;
  }

  public ngOnDestroy(): void {
    this.unsubscribe();
  }
}
