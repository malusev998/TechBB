import { Injectable } from "@angular/core";
import { BehaviorSubject, Subscription } from "rxjs";

@Injectable({
  providedIn: "root"
})
export class TitleService {
  private titleSubject: BehaviorSubject<string> = new BehaviorSubject("");

  private subscription: Subscription | null = null;

  public getTitle(callback: (title: string) => void) {
    this.subscription = this.titleSubject.subscribe(callback);
  }

  public setTitle(title: string) {
    this.titleSubject.next(title);
  }

  public unsubscribe() {
    if (this.subscription !== null) {
      this.subscription.unsubscribe();
    }
  }
}
