import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VerifyQuestionComponent } from './verify-question.component';

describe('VerifyQuestionComponent', () => {
  let component: VerifyQuestionComponent;
  let fixture: ComponentFixture<VerifyQuestionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VerifyQuestionComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VerifyQuestionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
