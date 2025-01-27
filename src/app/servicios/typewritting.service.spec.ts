import { TestBed } from '@angular/core/testing';

import { TypewrittingService } from './typewritting.service';

describe('TypewrittingService', () => {
  let service: TypewrittingService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TypewrittingService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
