import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TruthOrfalseComponent } from './truth-orfalse.component';

describe('TruthOrfalseComponent', () => {
  let component: TruthOrfalseComponent;
  let fixture: ComponentFixture<TruthOrfalseComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TruthOrfalseComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TruthOrfalseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
