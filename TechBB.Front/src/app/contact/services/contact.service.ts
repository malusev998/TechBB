import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Contact } from "../dto/contact.dto";

@Injectable()
export class ContactService {
  constructor(private httpClient: HttpClient) {}

  public contact(data: Contact) {
    return this.httpClient.post('/contact', data);
  }

  public getSubjects() {
    return this.httpClient.get("/subjects");
  }
}
