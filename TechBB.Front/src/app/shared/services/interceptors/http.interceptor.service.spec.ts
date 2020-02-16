import { TestBed } from '@angular/core/testing';

import { Http.InterceptorService } from './http.interceptor.service';

describe('Http.InterceptorService', () => {
  let service: Http.InterceptorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Http.InterceptorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
