import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BlogPopularCategoriesComponent } from './blog-popular-categories.component';

describe('BlogPopularCategoriesComponent', () => {
  let component: BlogPopularCategoriesComponent;
  let fixture: ComponentFixture<BlogPopularCategoriesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BlogPopularCategoriesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BlogPopularCategoriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
