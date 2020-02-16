import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BlogPopularPostsComponent } from './blog-popular-posts.component';

describe('BlogPopularPostsComponent', () => {
  let component: BlogPopularPostsComponent;
  let fixture: ComponentFixture<BlogPopularPostsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BlogPopularPostsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BlogPopularPostsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
