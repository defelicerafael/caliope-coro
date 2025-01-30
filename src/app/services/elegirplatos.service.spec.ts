import { TestBed } from '@angular/core/testing';

import { ElegirplatosService } from './elegirplatos.service';

describe('ElegirplatosService', () => {
  let service: ElegirplatosService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ElegirplatosService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
