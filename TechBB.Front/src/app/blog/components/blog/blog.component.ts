import { Component, OnInit } from "@angular/core";
import { TitleService } from "src/app/shared/services/title.service";

@Component({
  selector: "app-blog",
  templateUrl: "./blog.component.html",
  styleUrls: ["./blog.component.scss"]
})
export class BlogComponent implements OnInit {
  constructor(private titleService: TitleService) {}

  ngOnInit(): void {
    this.titleService.setTitle("Tech Blog");
  }
}
