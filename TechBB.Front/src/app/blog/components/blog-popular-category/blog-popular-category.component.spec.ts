import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BlogPopularCategoryComponent } from './blog-popular-category.component';

describe('BlogPopularCategoryComponent', () => {
  let component: BlogPopularCategoryComponent;
  let fixture: ComponentFixture<BlogPopularCategoryComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BlogPopularCategoryComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BlogPopularCategoryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
