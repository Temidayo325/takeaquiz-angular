import { TestBed,  } from '@angular/core/testing';

import { UserService } from './user.service';

describe('UserService', () => {
  let service: UserService;

  beforeEach(() => {
    TestBed.configureTestingModule({
          imports: [],
          providers: []
    });
    service = TestBed.inject(UserService);
  });

  it('should be created', () => {
       expect(service).toBeTruthy();
  });

  it('should have a baseUrl', () => {
       expect(service.baseUrl).toBe('https://quizly-api.luminaace.com/api/');
 })
});
