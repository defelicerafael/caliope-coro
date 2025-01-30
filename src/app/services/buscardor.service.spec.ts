import { TestBed } from '@angular/core/testing';

import { BuscardorService } from './buscardor.service';

describe('BuscardorService', () => {
  let service: BuscardorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BuscardorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
