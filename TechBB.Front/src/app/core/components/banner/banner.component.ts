import { Component, OnInit, OnDestroy } from "@angular/core";
import { TitleService } from "../../../shared/services/title.service";
@Component({
  selector: "app-banner",
  templateUrl: "./banner.component.html",
  styleUrls: ["./banner.component.scss"]
})
export class BannerComponent implements OnInit, OnDestroy {
  public title: string = "";
  public constructor(private titleService: TitleService) {}

  public ngOnInit(): void {
    this.titleService.getTitle(title => {
      this.title = title;
    });
  }

  public ngOnDestroy(): void {
    this.titleService.unsubscribe();
  }
}
