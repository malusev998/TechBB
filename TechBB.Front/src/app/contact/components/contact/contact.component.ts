import { Component, OnInit } from "@angular/core";
import { TitleService } from "../../../shared/services/title.service";
import { Title } from "@angular/platform-browser";

@Component({
  selector: "app-contact",
  templateUrl: "./contact.component.html",
  styleUrls: ["./contact.component.scss"]
})
export class ContactComponent implements OnInit {
  public longitude: number = 51.678418;
  public latitude: number = 7.809007;

  constructor(private titleService: TitleService, private title: Title) {}

  ngOnInit(): void {
    this.title.setTitle("Contact Page (TechBB)");
    this.titleService.setTitle("TechBB Contact");
  }
}
