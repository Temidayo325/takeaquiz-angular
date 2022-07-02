import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CouseformComponent } from './couseform.component';

describe('CouseformComponent', () => {
  let component: CouseformComponent;
  let fixture: ComponentFixture<CouseformComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CouseformComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CouseformComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
