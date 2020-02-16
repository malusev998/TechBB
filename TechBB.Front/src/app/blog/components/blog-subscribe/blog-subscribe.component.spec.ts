import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BlogSubscribeComponent } from './blog-subscribe.component';

describe('BlogSubscribeComponent', () => {
  let component: BlogSubscribeComponent;
  let fixture: ComponentFixture<BlogSubscribeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BlogSubscribeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BlogSubscribeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
