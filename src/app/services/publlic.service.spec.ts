import { TestBed } from '@angular/core/testing';

import { PubllicService } from './publlic.service';

describe('PubllicService', () => {
  let service: PubllicService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PubllicService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
