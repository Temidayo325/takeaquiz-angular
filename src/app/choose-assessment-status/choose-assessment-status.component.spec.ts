import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChooseAssessmentStatusComponent } from './choose-assessment-status.component';

describe('ChooseAssessmentStatusComponent', () => {
  let component: ChooseAssessmentStatusComponent;
  let fixture: ComponentFixture<ChooseAssessmentStatusComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ChooseAssessmentStatusComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ChooseAssessmentStatusComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
