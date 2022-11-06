import { TestBed } from '@angular/core/testing';

import { LoggeninUserGuard } from './loggenin-user.guard';

describe('LoggeninUserGuard', () => {
  let guard: LoggeninUserGuard;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    guard = TestBed.inject(LoggeninUserGuard);
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
