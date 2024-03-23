import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EssayComponentComponent } from './essay-component.component';

describe('EssayComponentComponent', () => {
  let component: EssayComponentComponent;
  let fixture: ComponentFixture<EssayComponentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EssayComponentComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(EssayComponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
