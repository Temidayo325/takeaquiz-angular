import { TestBed } from '@angular/core/testing';

import { PrepService } from './prep.service';

describe('PrepService', () => {
  let service: PrepService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PrepService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
