import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SharedResultComponent } from './shared-result.component';

describe('SharedResultComponent', () => {
  let component: SharedResultComponent;
  let fixture: ComponentFixture<SharedResultComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SharedResultComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SharedResultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
