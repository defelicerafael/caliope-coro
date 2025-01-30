import { TestBed } from '@angular/core/testing';

import { TitleToUrlServiceService } from './title-to-url-service.service';

describe('TitleToUrlServiceService', () => {
  let service: TitleToUrlServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TitleToUrlServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
