import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AssessmentTakersComponent } from './assessment-takers.component';

describe('AssessmentTakersComponent', () => {
  let component: AssessmentTakersComponent;
  let fixture: ComponentFixture<AssessmentTakersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AssessmentTakersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AssessmentTakersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
