import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BlogPopularPostComponent } from './blog-popular-post.component';

describe('BlogPopularPostComponent', () => {
  let component: BlogPopularPostComponent;
  let fixture: ComponentFixture<BlogPopularPostComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BlogPopularPostComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BlogPopularPostComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
