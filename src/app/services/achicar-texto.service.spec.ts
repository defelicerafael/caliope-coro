import { TestBed } from '@angular/core/testing';

import { AchicarTextoService } from './achicar-texto.service';

describe('AchicarTextoService', () => {
  let service: AchicarTextoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AchicarTextoService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
