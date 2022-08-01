import { TestBed } from '@angular/core/testing';

import { TrueorfalseService } from './trueorfalse.service';

describe('TrueorfalseService', () => {
  let service: TrueorfalseService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TrueorfalseService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
