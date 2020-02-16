import { Component, OnInit } from "@angular/core";
import { TitleService } from "src/app/shared/services/title.service";
import { Title } from "@angular/platform-browser";

@Component({
  selector: "app-index",
  templateUrl: "./index.component.html",
  styleUrls: ["./index.component.scss"]
})
export class IndexComponent implements OnInit {
  constructor(private titleSerivce: TitleService, private title: Title) {}

  ngOnInit(): void {
    this.title.setTitle("Technology Blog (TechBB)");
    this.titleSerivce.setTitle("Welcome to Technology blog (Tech BB)");
  }
}
