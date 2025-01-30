import { TestBed } from '@angular/core/testing';

import { BuscadorstorageService } from './buscadorstorage.service';

describe('BuscadorstorageService', () => {
  let service: BuscadorstorageService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(BuscadorstorageService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
